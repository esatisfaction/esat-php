<?php

namespace Esat\Support\Services;

use Esat\Esat;
use Esat\Http\HttpClientInterface;
use Esat\Support\Cache\PermanentCache;
use Esat\Support\Cache\StaticRuntimeCache;
use Esat\Support\Config\Configuration;
use Esat\Support\Helpers\LoggerHelper;
use Esat\Support\Helpers\UuidHelper;
use Esat\Support\Model\BaseModel;
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Monolog\Logger;
use Panda\Support\Helpers\ArrayHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

/**
 * Class ModelService
 * @package Esat\Support\Services
 */
abstract class HttpService extends ModelService
{
    const RESPONSE_FIELDS_LEVEL_1 = '*';
    const RESPONSE_FIELDS_LEVEL_2 = '**';
    const RESPONSE_FIELDS_LEVEL_3 = '***';

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var ResponseInterface
     */
    protected $lastResponse;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var string
     */
    protected static $processId;

    /**
     * @var bool
     */
    protected $cacheEnabled = true;

    /**
     * @var CacheInterface
     */
    protected static $cache;

    /**
     * @var bool
     */
    protected $permanentCache = false;

    /**
     * HttpService constructor.
     *
     * @param Esat                $esat
     * @param LoggerInterface     $logger
     * @param HttpClientInterface $httpClient
     * @param CacheInterface      $cache
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Esat $esat, LoggerInterface $logger, HttpClientInterface $httpClient, CacheInterface $cache = null)
    {
        parent::__construct($esat, $logger);
        $this->config = new Configuration($esat);
        $this->httpClient = $httpClient;
        self::$cache = $cache ?? self::$cache ?? new StaticRuntimeCache();
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $headers
     * @param array  $parameters
     * @param array  $multipart
     * @param array  $responseFields
     *
     * @return ResponseInterface
     * @throws \InvalidArgumentException
     */
    protected function sendApiRequest($method, $uri, $headers = [], $parameters = [], $multipart = [], $responseFields = [])
    {
        try {
            // Add domain and version to uri
            $serviceUri = $this->getApiUri($uri);

            // Check for cache
            if ($method == Request::METHOD_GET
                && $this->isCacheEnabled()
                && !empty($this->getFromCache($serviceUri))
            ) {
                $response = $this->getFromCache($serviceUri);
            } else {
                // Add response fields
                $parameters = $this->addResponseFields($parameters, $responseFields);

                // Log and send request
                $this->getLogger()->debug(sprintf('%s: %s - %s', $this->getProcessId(), $method, $serviceUri));
                $response = $this->httpClient->send($method, $serviceUri, $headers, $parameters, $multipart);
            }

            // Set last response
            $this->setLastResponse($response);

            // Update cache
            if ($method == Request::METHOD_GET) {
                $this->addToCache($serviceUri, $response);
                $this->setCacheEnabled(true);
            } else {
                $this->setCacheEnabled(false);
            }

            // Rewind response to set it available for reading
            $this->getLastResponse()->getBody()->rewind();
        } catch (ServerException $ex) {
            /**
             * The Client will throw a ServerException.
             * if the response has status code 5xx.
             * We log all these errors to keep track.
             */
            LoggerHelper::logThrowable($this->getLogger(), $ex, $level = Logger::ERROR, $logTrace = true);

            // Return the normal response
            $this->setLastResponse($ex->getResponse());
        } catch (ClientException $ex) {
            /**
             * The Client will throw a ClientException
             * if the response has status code 4xx.
             * We do not log these errors because they are human-generated.
             */

            // Return the normal response
            $this->setLastResponse($ex->getResponse());
        } catch (RuntimeException $e) {
        }

        // Set response and return it
        return $this->getLastResponse();
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    protected function getApiUri($uri)
    {
        $baseUri = $this->getConfig()->get('api.base_uri');
        $version = $this->getConfig()->get('api.version');

        return $baseUri . '/' . ($version ? 'v' . $version . '/' : '') . trim($uri, '/');
    }

    /**
     * @param ResponseInterface $response
     * @param BaseModel         $model
     * @param string|null       $subField
     * @param bool              $clearModel
     * @param bool              $saveResponse
     *
     * @return bool
     * @throws Exception
     */
    protected function setModelFromResponse(ResponseInterface $response, &$model = null, $subField = null, $clearModel = false, $saveResponse = true)
    {
        try {
            // Normalize model
            $model = $model ?: $this->getModel();

            // Clear model if necessary
            if ($clearModel || empty($model)) {
                $this->clearModel();
                $this->initModel();
                $model = $this->getModel();
            }

            // Decode response
            $responseContent = $this->getResponseAsArray($response, $saveResponse);

            // Get sub-field, if given
            if (!empty($subField)) {
                $responseContent = ArrayHelper::get($responseContent, $subField, [], true);
            }

            // Load model from response
            if ($responseContent && is_array($responseContent)) {
                $model->loadFromArray($responseContent);

                return true;
            }

            throw new Exception('Unable to read the response for loading in the model.');
        } catch (Throwable $ex) {
            throw new Exception('An error occurred while setting the model from the given response.', 0, $ex);
        }
    }

    /**
     * @param ResponseInterface $response
     * @param bool              $save
     *
     * @return array
     * @throws Exception
     */
    protected function getResponseAsArray(ResponseInterface $response, $save = true)
    {
        try {
            if ($save) {
                $this->setLastResponse($response);
            }

            // Rewind stream to make sure that response contents are available for read
            $response->getBody()->rewind();
            $contents = $response->getBody()->getContents();

            // Rewind the body again to allow future reads
            $response->getBody()->rewind();

            // Decode contents
            return json_decode($contents, true);
        } catch (RuntimeException $ex) {
            throw new Exception('The given response does not have the proper format.', 0, $ex);
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @return string
     * @throws Exception
     */
    public function getErrorFromLastResponse(ResponseInterface $response = null)
    {
        // Normalize response
        $response = $response ?: $this->getLastResponse();

        // Decode response body
        $responseBody = json_decode($response->getBody()->getContents(), true);

        // Return message or error
        return $responseBody['error'] ?: $responseBody['message'];
    }

    /**
     * @param array $parameters
     * @param array $fields
     *
     * @return array
     */
    private function addResponseFields($parameters = [], $fields = [])
    {
        // Normalize parameters
        $parameters = $parameters ?: [];

        // Add response fields
        if (!is_null($fields)) {
            $parameters['fields'] = $this->getResponseFields($fields);
        }

        // Return new parameters
        return $parameters;
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    protected function getResponseFields($fields = [])
    {
        return $fields ?: [self::RESPONSE_FIELDS_LEVEL_1];
    }

    /**
     * @return ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @param ResponseInterface $lastResponse
     *
     * @return $this
     */
    public function setLastResponse(ResponseInterface $lastResponse)
    {
        $this->lastResponse = $lastResponse;

        return $this;
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     * @throws UnsatisfiedDependencyException
     */
    public function getProcessId()
    {
        return self::$processId = self::$processId ?: UuidHelper::create();
    }

    /**
     * @return bool
     */
    public function isCacheEnabled()
    {
        return $this->cacheEnabled;
    }

    /**
     * @param bool $cacheEnabled
     *
     * @return $this
     */
    public function setCacheEnabled(bool $cacheEnabled)
    {
        $this->cacheEnabled = $cacheEnabled;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return ResponseInterface
     * @throws \InvalidArgumentException
     */
    public function getFromCache($key)
    {
        try {
            // Normalize cache key
            $key = $this->normalizeCacheKey($key);

            // Check for permanent cache
            if (self::getCache() instanceof PermanentCache) {
                /** @var PermanentCache $cache */
                $cache = self::getCache();
                $cache->setPermanent($this->isPermanentCache());
            }

            // Get response from cache
            return $this->getResponseFromArray(self::getCache()->get($key, []));
        } catch (InvalidArgumentException $exx) {
            return null;
        }
    }

    /**
     * @param string            $key
     * @param ResponseInterface $response
     *
     * @return $this
     */
    public function addToCache($key, $response)
    {
        try {
            // Normalize cache key
            $key = $this->normalizeCacheKey($key);

            // Check for permanent cache
            if (self::getCache() instanceof PermanentCache) {
                /** @var PermanentCache $cache */
                $cache = self::getCache();
                $cache->setPermanent($this->isPermanentCache());
            }

            self::getCache()->set($key, $this->getResponseToArray($response));
        } catch (InvalidArgumentException $exx) {
        } catch (RuntimeException $exx) {
        }

        return $this;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     * @throws RuntimeException
     */
    private function getResponseToArray($response)
    {
        return [
            'status_code' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'body_contents' => $response->getBody()->getContents(),
        ];
    }

    /**
     * @param array $array
     *
     * @return ResponseInterface
     * @throws \InvalidArgumentException
     */
    private function getResponseFromArray($array)
    {
        if (empty($array)) {
            return null;
        }

        return new GuzzleResponse($array['status_code'], $array['headers'], $array['body_contents']);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function normalizeCacheKey($key)
    {
        $key = str_replace('/', '_', $key);
        $key = str_replace(':', '_', $key);
        $key = str_replace('@', '_', $key);

        return $key;
    }

    /**
     * @return CacheInterface
     */
    public static function getCache()
    {
        return self::$cache;
    }

    /**
     * @param CacheInterface $cache
     */
    public static function setCache(CacheInterface $cache)
    {
        self::$cache = $cache;
    }

    /**
     * @return bool
     */
    public function isPermanentCache()
    {
        return $this->permanentCache;
    }

    /**
     * @param bool $permanentCache
     *
     * @return $this
     */
    public function setPermanentCache(bool $permanentCache)
    {
        $this->permanentCache = $permanentCache;

        return $this;
    }
}
