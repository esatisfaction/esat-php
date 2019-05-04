<?php

namespace Esat\Services\Questionnaires;

use Esat\Model\Questionnaires\Questionnaire as QuestionnaireModel;
use Esat\Services\Service_TestCase;
use Exception;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Monolog\Logger;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class QuestionnaireTest
 * @package Esat\Services\Questionnaires
 */
class QuestionnaireTest extends Service_TestCase
{
    /**
     * @var Questionnaire
     */
    protected $service;

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException
     */
    public function setUp()
    {
        parent::setUp();

        // Setup service
        $this->service = new Questionnaire($this->getEsat(), new Logger('esat.sdk'), $this->getMockHttpClient());
    }

    /**
     * @covers \Esat\Services\Questionnaires\Questionnaire::load
     * @covers \Esat\Services\Questionnaires\Questionnaire::getList
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws AssertionFailedError
     */
    public function testEverything()
    {
        // Init
        $model = new QuestionnaireModel();
        $model->setQuestionnaireId(substr(md5(rand()), 20));
        $model->setTemplateQuestionnaireId(substr(md5(rand()), 20));

        // Set model for create
        $model->setTitle('Questionnaire 1');
        $model->setDescription('Description');

        // Load
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_OK, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->load($model->getQuestionnaireId()));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'GET', sprintf('/q/questionnaire/%s', $this->service->getQuestionnaire()->getQuestionnaireId()));
        $this->assertEquals($model->toArray(), $this->service->getQuestionnaire()->toArray());

        // Get list
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_OK, [], json_encode($model->toArray())));
        $this->assertNotEmpty($this->service->getList());
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'GET', sprintf('/q/questionnaire'));
    }
}
