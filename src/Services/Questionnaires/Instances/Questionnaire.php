<?php

namespace Esat\Services\Questionnaires\Instances;

use Esat\Model\Questionnaires\Instances\Questionnaire as QuestionnaireModel;
use Esat\Support\Helpers\UriHelper;
use Esat\Support\Model\BaseModel;
use Esat\Support\Services\HttpService;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Questionnaire
 * @package Esat\Services\Questionnaires\Instances
 */
class Questionnaire extends HttpService
{
    /**
     * @param string $instanceId
     * @param array  $parameters
     * @param array  $responseFields
     *
     * @return bool
     * @throws Exception
     */
    public function load($instanceId, $parameters = [], $responseFields = [])
    {
        // Send api request
        $response = $this->sendApiRequest(Request::METHOD_GET, $this->getUri($instanceId), $headers = [], $parameters, $multipart = [], $responseFields);
        if ($response->getStatusCode() == Response::HTTP_OK) {
            // Set model from response
            $this->setModelFromResponse($response);

            return true;
        }

        return false;
    }

    /**
     * @param string $questionnaireId
     * @param array  $parameters
     * @param array  $questionnaireMetadata
     * @param array  $responderMetadata
     * @param array  $responseFields
     *
     * @return bool
     * @throws Exception
     */
    public function create($questionnaireId, $parameters = [], $questionnaireMetadata = [], $responderMetadata = [], $responseFields = [])
    {
        // Update model to send to api
        $this->initModelWithParameters($parameters, __FUNCTION__);
        $parameters['metadata'] = [
            'questionnaire' => $questionnaireMetadata,
            'responder' => $responderMetadata,
        ];

        // Send api request
        $response = $this->sendApiRequest(Request::METHOD_POST, $this->getUriWithQuestionnaireId($questionnaireId), $headers = [], $parameters, $multipart = [], $responseFields);
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
        $response = $this->sendApiRequest(Request::METHOD_PATCH, $this->getUri($this->getQuestionnaire()->getInstanceId()), $headers = [], $parameters, $multipart = [], $responseFields);
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
        $response = $this->sendApiRequest(Request::METHOD_DELETE, $this->getUri($this->getQuestionnaire()->getInstanceId()));
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
        $this->model = new QuestionnaireModel();
    }

    /**
     * @return QuestionnaireModel|BaseModel
     */
    public function getQuestionnaire()
    {
        return $this->getModel();
    }

    /**
     * @param string $questionnaireId
     *
     * @return string
     */
    private function getUriWithQuestionnaireId($questionnaireId)
    {
        $parameters = [
            'questionnaire_id' => $questionnaireId,
        ];

        return UriHelper::get('/q/questionnaire/{questionnaire_id}/instance', $parameters);
    }

    /**
     * @param string $instanceId
     *
     * @return string
     */
    private function getUri($instanceId = '')
    {
        $parameters = [
            'instance_id' => $instanceId,
        ];

        return UriHelper::get('/q/instance/{instance_id}', $parameters);
    }
}
