<?php

namespace Esat\Services\Questionnaires\Instances;

use DateInterval;
use DateTime;
use Esat\Model\Questionnaires\Instances\Questionnaire as QuestionnaireModel;
use Esat\Services\Service_TestCase;
use GuzzleHttp\Psr7\Response;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class QuestionnaireTest
 * @package Esat\Services\Questionnaires\Instances
 */
class QuestionnaireTest extends Service_TestCase
{
    /**
     * @var Questionnaire
     */
    protected $service;

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function setUp()
    {
        parent::setUp();

        // Setup service
        $this->service = new Questionnaire($this->getEsat(), new Logger('esat.sdk'), $this->getMockHttpClient());
    }

    /**
     * @covers \Esat\Services\Questionnaires\Instances\Questionnaire::create
     * @covers \Esat\Services\Questionnaires\Instances\Questionnaire::load
     * @covers \Esat\Services\Questionnaires\Instances\Questionnaire::update
     * @covers \Esat\Services\Questionnaires\Instances\Questionnaire::delete
     *
     * @throws \Exception
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    public function testEverything()
    {
        // Init
        $instanceId = substr(md5(rand()), 20);
        $questionnaireId = substr(md5(rand()), 20);
        $model = new QuestionnaireModel();
        $model->setInstanceId($instanceId);
        $model->setQuestionnaireId($questionnaireId);

        // Set model for create
        $model->setCreatedTime((new DateTime())->format(DateTime::ATOM));
        $model->setSentTime((new DateTime())->format(DateTime::ATOM));

        // Setup questionnaire metadata values
        $questionnaireMetadataValues = [
            'created_date' => '6-9-18',
            substr(md5(rand()), 20) => '6-9-19',
        ];
        $arguments = $model->toArray();
        $arguments['metadata'] = $questionnaireMetadataValues;

        // Create
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_CREATED, [], json_encode($arguments)));
        $this->assertTrue($this->service->create($questionnaireId, $model->toArray(), $questionnaireMetadataValues));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'POST', sprintf('/q/questionnaire/%s/instance', $questionnaireId));

        // Load
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_OK, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->load($instanceId));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'GET', sprintf('/q/instance/%s', $instanceId));
        $this->assertEquals($model->toArray(), $this->service->getQuestionnaire()->toArray());

        // Set model for update
        $model->setCreatedTime((new DateTime())->add(new DateInterval('P1Y'))->format(DateTime::ATOM));
        $model->setSentTime((new DateTime())->add(new DateInterval('P1Y'))->format(DateTime::ATOM));

        // Update
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_OK, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->update($model->toArray()));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'PATCH', sprintf('/q/instance/%s', $instanceId));
        $this->assertEquals($model->toArray(), $this->service->getQuestionnaire()->toArray());

        // Delete
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_NO_CONTENT, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->delete());
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'DELETE', sprintf('/q/instance/%s', $instanceId));

        $model = new QuestionnaireModel();
        $model->setInstanceId($instanceId);
        $model->setQuestionnaireId($questionnaireId);

        // Set model for create
        $model->setCreatedTime((new DateTime())->format(DateTime::ATOM));
        $model->setSentTime((new DateTime())->format(DateTime::ATOM));

        // Create
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_CREATED, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->create($questionnaireId, $model->toArray()));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'POST', sprintf('/q/questionnaire/%s/instance', $questionnaireId));

        // Load
        $this->service->setCacheEnabled(false);
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_OK, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->load($instanceId));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'GET', sprintf('/q/instance/%s', $instanceId));
        $this->assertEquals($model->toArray(), $this->service->getQuestionnaire()->toArray());
    }
}
