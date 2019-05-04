<?php

namespace Esat\Services\Questionnaires\Pipelines;

use Esat\Model\Questionnaires\Pipelines\Queue as QueueModel;
use Esat\Support\Helpers\UriHelper;
use Esat\Support\Model\BaseModel;
use Esat\Support\Services\HttpService;
use Exception;
use InvalidArgumentException;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Queue
 * @package Esat\Services\Questionnaires\Pipelines
 */
class Queue extends HttpService
{
    /**
     * @param string $itemId
     * @param array  $responseFields
     *
     * @return bool
     * @throws Exception
     */
    public function load($itemId, $responseFields = [])
    {
        // Send api request
        $response = $this->sendApiRequest(Request::METHOD_GET, $this->getUri($itemId), $headers = [], $parameters = [], $multipart = [], $responseFields);
        if ($response->getStatusCode() == Response::HTTP_OK) {
            // Set model from response
            $this->setModelFromResponse($response);

            return true;
        }

        return false;
    }

    /**
     * @param string $questionnaireId
     * @param string $pipelineId
     * @param array  $parameters
     * @param array  $responseFields
     *
     * @return bool
     * @throws Exception
     * @throws ReflectionException
     */
    public function create($questionnaireId, $pipelineId, $parameters = [], $responseFields = [])
    {
        // Update model to send to api
        $this->initModelWithParameters($parameters, __FUNCTION__);

        // Send api request
        $response = $this->sendApiRequest(Request::METHOD_POST, $this->getUriWithQuestionnaireAndPipeline($questionnaireId, $pipelineId), $headers = [], $parameters, $multipart = [], $responseFields);
        if ($response->getStatusCode() == Response::HTTP_CREATED) {
            // Set model from response
            $this->setModelFromResponse($response);

            return true;
        }

        return false;
    }

    /**
     * @param array $parameters
     * @param array $responseFields
     *
     * @return bool
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function update($parameters = [], $responseFields = [])
    {
        // Update model to send to api
        $this->updateModelWithParameters($parameters, __FUNCTION__);

        // Send api request
        $response = $this->sendApiRequest(Request::METHOD_PATCH, $this->getUri($this->getQueueItem()->getItemId()), $headers = [], $parameters, $multipart = [], $responseFields);
        if ($response->getStatusCode() == Response::HTTP_OK) {
            // Set model from response
            $this->setModelFromResponse($response);

            return true;
        }

        return false;
    }

    /**
     * @return bool
     * @throws InvalidArgumentException
     */
    public function delete()
    {
        // Check model
        $this->checkModel(__FUNCTION__);

        // Send api request
        $response = $this->sendApiRequest(Request::METHOD_DELETE, $this->getUri($this->getQueueItem()->getItemId()));
        if ($response->getStatusCode() == Response::HTTP_NO_CONTENT) {
            // Clear model
            $this->clearModel();

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function initModel()
    {
        $this->model = new QueueModel();
    }

    /**
     * @return QueueModel|BaseModel
     */
    public function getQueueItem()
    {
        return $this->getModel();
    }

    /**
     * @param string $questionnaireId
     * @param string $pipelineId
     * @param string $itemId
     *
     * @return string
     */
    private function getUriWithQuestionnaireAndPipeline($questionnaireId, $pipelineId, $itemId = '')
    {
        $parameters = [
            'questionnaire_id' => $questionnaireId,
            'pipeline_id' => $pipelineId,
            'item_id' => $itemId,
        ];

        return UriHelper::get('/q/questionnaire/{questionnaire_id}/pipeline/{pipeline_id}/queue/item/{item_id}', $parameters);
    }

    /**
     * @param string $itemId
     *
     * @return string
     */
    private function getUri($itemId)
    {
        $parameters = [
            'item_id' => $itemId,
        ];

        return UriHelper::get('/q/queue/item/{item_id}', $parameters);
    }
}
