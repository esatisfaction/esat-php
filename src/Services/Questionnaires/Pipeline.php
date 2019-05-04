<?php

namespace Esat\Services\Questionnaires;

use Esat\Model\Questionnaires\Pipeline as PipelineModel;
use Esat\Support\Helpers\UriHelper;
use Esat\Support\Model\BaseModel;
use Esat\Support\Services\HttpService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Pipeline
 * @package Esat\Services\Questionnaires
 */
class Pipeline extends HttpService
{
    /**
     * @param string $questionnaireId
     * @param string $pipelineId
     * @param array  $responseFields
     *
     * @return bool
     * @throws Exception
     */
    public function load($questionnaireId, $pipelineId, $responseFields = [])
    {
        // Send api request
        $response = $this->sendApiRequest(Request::METHOD_GET, $this->getUri($questionnaireId, $pipelineId), $headers = [], $parameters = [], $multipart = [], $responseFields);
        if ($response->getStatusCode() == Response::HTTP_OK) {
            // Set model from response
            $this->setModelFromResponse($response);

            return true;
        }

        return false;
    }

    /**
     * @param string $questionnaireId
     * @param array  $responseFields
     *
     * @return PipelineModel[]
     * @throws Exception
     */
    public function getList($questionnaireId, $responseFields = [])
    {
        // Send api request
        $response = $this->sendApiRequest(Request::METHOD_GET, $this->getUri($questionnaireId), $headers = [], $parameters = [], $multipart = [], $responseFields);
        if ($response->getStatusCode() == Response::HTTP_OK) {
            // Get response as array
            $responseContent = $this->getResponseAsArray($response);

            // Load array from response
            $modelArray = [];
            foreach ($responseContent as $item) {
                $modelArray[] = (new PipelineModel())->loadFromArray($item);
            }

            return $modelArray;
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function initModel()
    {
        $this->model = new PipelineModel();
    }

    /**
     * @return PipelineModel|BaseModel
     */
    public function getPipeline()
    {
        return $this->getModel();
    }

    /**
     * @param string $questionnaireId
     * @param string $pipelineId
     *
     * @return string
     */
    private function getUri($questionnaireId, $pipelineId = '')
    {
        $parameters = [
            'questionnaire_id' => $questionnaireId,
            'pipeline_id' => $pipelineId,
        ];

        return UriHelper::get('/q/questionnaire/{questionnaire_id}/pipeline/{pipeline_id}', $parameters);
    }
}
