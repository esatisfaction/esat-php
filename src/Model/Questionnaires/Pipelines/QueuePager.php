<?php

namespace Esat\Model\Questionnaires\Pipelines;

use Esat\Support\Model\Propel\Pager;

/**
 * Class QueuePager
 * @package Esat\Model\Questionnaires\Pipelines
 */
class QueuePager extends Pager
{
    /**
     * @var Queue[]
     */
    protected $queue = [];

    /**
     * @param Queue $queue
     */
    public function addQueueItem(Queue $queue)
    {
        $this->queue[] = $queue;
    }

    /**
     * @return Queue[]
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param Queue[] $queue
     *
     * @return $this
     */
    public function setQueue(array $queue)
    {
        $this->queue = $queue;

        return $this;
    }
}
