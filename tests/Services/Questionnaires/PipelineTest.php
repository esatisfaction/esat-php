<?php

namespace Esat\Services\Questionnaires;

use Esat\Model\Questionnaires\Pipeline as PipelineModel;
use Esat\Services\Service_TestCase;
use Exception;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Monolog\Logger;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class PipelineTest
 * @package Esat\Services\Questionnaires
 */
class PipelineTest extends Service_TestCase
{
    /**
     * @var Pipeline
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
        $this->service = new Pipeline($this->getEsat(), new Logger('esat.sdk'), $this->getMockHttpClient());
    }

    /**
     * @covers \Esat\Services\Questionnaires\Pipeline::load
     * @covers \Esat\Services\Questionnaires\Pipeline::getList
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws AssertionFailedError
     */
    public function testEverything()
    {
        // Init variables for testing
        $questionnaireId = substr(md5(rand()), 20);
        $pipelineId = substr(md5(rand()), 20);

        // Init
        $model = new PipelineModel();
        $model->setQuestionnaireId($questionnaireId);
        $model->setPipelineId($pipelineId);
        $model->setTemplatePipelineId(substr(md5(rand()), 20));

        // Load
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_OK, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->load($questionnaireId, $pipelineId));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'GET', sprintf('/q/questionnaire/%s/pipeline/%s', $questionnaireId, $pipelineId));
        $this->assertEquals($model->toArray(), $this->service->getPipeline()->toArray());

        // Get list
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_OK, [], json_encode($model->toArray())));
        $this->assertNotEmpty($this->service->getList($questionnaireId));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'GET', sprintf('/q/questionnaire/%s/pipeline', $questionnaireId));
    }
}
