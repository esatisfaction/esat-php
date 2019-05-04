<?php

namespace Esat\Services\Questionnaires;

use Esat\Model\Questionnaires\Questionnaire as QuestionnaireModel;
use Esat\Model\Questionnaires\QuestionnairePager;
use Esat\Support\Helpers\UriHelper;
use Esat\Support\Model\BaseModel;
use Esat\Support\Model\Propel\FilterCriteria;
use Esat\Support\Model\Propel\OrderCriteria;
use Esat\Support\Model\Propel\Pagination;
use Esat\Support\Services\HttpService;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Questionnaire
 * @package Esat\Services\Questionnaires
 */
class Questionnaire extends HttpService
{
    /**
     * @param string $questionnaireId
     * @param array  $parameters
     * @param array  $responseFields
     *
     * @return bool
     * @throws Exception
     */
    public function load($questionnaireId, $parameters = [], $responseFields = [])
    {
        // Send api request
        $response = $this->sendApiRequest(Request::METHOD_GET, $this->getUri($questionnaireId), $headers = [], $parameters, $multipart = [], $responseFields);
        if ($response->getStatusCode() == Response::HTTP_OK) {
            // Set model from response
            $this->setModelFromResponse($response);

            return true;
        }

        return false;
    }

    /**
     * @param FilterCriteria $filterBy
     * @param OrderCriteria  $orderBy
     * @param Pagination     $pagination
     * @param array          $responseFields
     *
     * @return QuestionnairePager|null
     * @throws Exception
     */
    public function getList(FilterCriteria $filterBy = null, OrderCriteria $orderBy = null, Pagination $pagination = null, $responseFields = [])
    {
        // Prepare parameters
        $parameters = array_merge(
            $filterBy ? $filterBy->toParameterArray() : [],
            $orderBy ? $orderBy->toParameterArray() : [],
            $pagination ? $pagination->toParameterArray() : []
        );

        // Send api request
        $response = $this->sendApiRequest(Request::METHOD_GET, $this->getUri(), $headers = [], $parameters, $multipart = [], $responseFields);
        if ($response->getStatusCode() == Response::HTTP_OK) {
            // Get response as array
            $responseContent = $this->getResponseAsArray($response);

            // Load pager response model
            $pagerModel = new QuestionnairePager($responseContent);
            foreach ($pagerModel->getResults() as $item) {
                $pagerModel->addQuestionnaire(new QuestionnaireModel($item));
            }

            return $pagerModel;
        }

        return null;
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
    private function getUri($questionnaireId = '')
    {
        $arguments = [
            'questionnaire_id' => $questionnaireId,
        ];

        return UriHelper::get('/q/questionnaire/{questionnaire_id}', $arguments);
    }
}
