<?php

namespace Esat\Services\Questionnaires\Pipelines;

use Esat\Model\Questionnaires\Pipelines\Queue as QueueModel;
use Esat\Services\Service_TestCase;
use Exception;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Monolog\Logger;
use PHPUnit\Framework\AssertionFailedError;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class QueueTest
 * @package Esat\Services\Questionnaires\Pipelines
 */
class QueueTest extends Service_TestCase
{
    /**
     * @var Queue
     */
    protected $service;

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();

        // Setup service
        $this->service = new Queue($this->getEsat(), new Logger('esat.sdk'), $this->getMockHttpClient());
    }

    /**
     * @covers \Esat\Services\Questionnaires\Pipelines\Queue::create
     * @covers \Esat\Services\Questionnaires\Pipelines\Queue::load
     * @covers \Esat\Services\Questionnaires\Pipelines\Queue::update
     * @covers \Esat\Services\Questionnaires\Pipelines\Queue::delete
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws AssertionFailedError
     * @throws ReflectionException
     */
    public function testEverything()
    {
        // Init
        $questionnaireId = substr(md5(rand()), 20);
        $pipelineId = substr(md5(rand()), 20);
        $itemId = substr(md5(rand()), 20);
        $model = new QueueModel();
        $model->setQuestionnaireId($questionnaireId);
        $model->setPipelineId($pipelineId);
        $model->setItemId($itemId);

        // Set model for create
        $model->setResponderChannelIdentifier('test@test.com');

        // Create
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_CREATED, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->create($questionnaireId, $pipelineId, $model->toArray()));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'POST', sprintf('/q/questionnaire/%s/pipeline/%s/queue/item', $questionnaireId, $pipelineId));

        // Load
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_OK, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->load($itemId));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'GET', sprintf('/q/queue/item/%s', $itemId));
        $this->assertEquals($model->toArray(), $this->service->getQueueItem()->toArray());

        // Set model for update
        $model->setResponderChannelIdentifier('test3@test.com');

        // Update
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_OK, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->update($model->toArray()));
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'PATCH', sprintf('/q/queue/item/%s', $itemId));
        $this->assertEquals($model->toArray(), $this->service->getQueueItem()->toArray());

        // Delete
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_NO_CONTENT, [], json_encode($model->toArray())));
        $this->assertTrue($this->service->delete());
        $this->assertRequest($this->service->getHttpClient()->getCurrentRequest(), 'DELETE', sprintf('/q/queue/item/%s', $itemId));
    }
}
