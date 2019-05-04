<?php

namespace Esat\Model\Questionnaires\Instances;

use DateTime;
use Esat\Support\Model\BaseModel;
use Exception;

/**
 * Class Questionnaire
 * @package Esat\Model\Questionnaires\Instances
 */
class Questionnaire extends BaseModel
{
    /**
     * @var string
     */
    protected $instance_id;

    /**
     * @var string
     */
    protected $questionnaire_id;

    /**
     * @var string
     */
    protected $responder_id;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var int
     */
    protected $valid_days;

    /**
     * @var bool
     */
    protected $editable;

    /**
     * @var bool
     */
    protected $finalized;

    /**
     * @var string
     */
    protected $question_ids;

    /**
     * @var string
     */
    protected $created_time;

    /**
     * @var string
     */
    protected $updated_time;

    /**
     * @var string
     */
    protected $sent_time;

    /**
     * @var string
     */
    protected $delivered_time;

    /**
     * @var string
     */
    protected $viewed_time;

    /**
     * @var string
     */
    protected $submitted_time;

    /**
     * @var string
     */
    protected $completed_time;

    /**
     * @var string
     */
    protected $processed_time;

    /**
     * @var string
     */
    protected $flow_time;

    /**
     * @var string
     */
    protected $created_by;

    /**
     * @var string
     */
    protected $updated_by;

    /**
     * @var string
     */
    protected $collection_url;

    /**
     * @var string
     */
    protected $collection_url_short;

    /**
     * @var string
     */
    protected $collection_url_long;

    /**
     * @return string
     */
    public function getInstanceId()
    {
        return $this->instance_id;
    }

    /**
     * @param string $instance_id
     *
     * @return $this
     */
    public function setInstanceId(string $instance_id)
    {
        $this->instance_id = $instance_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuestionnaireId()
    {
        return $this->questionnaire_id;
    }

    /**
     * @param string $questionnaire_id
     *
     * @return $this
     */
    public function setQuestionnaireId(string $questionnaire_id)
    {
        $this->questionnaire_id = $questionnaire_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getResponderId()
    {
        return $this->responder_id;
    }

    /**
     * @param string $responder_id
     *
     * @return $this
     */
    public function setResponderId(string $responder_id)
    {
        $this->responder_id = $responder_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale(string $locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFinalized()
    {
        return $this->finalized;
    }

    /**
     * @param bool $finalized
     *
     * @return $this
     */
    public function setFinalized(bool $finalized)
    {
        $this->finalized = $finalized;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuestionIds()
    {
        return $this->question_ids;
    }

    /**
     * @param string $question_ids
     *
     * @return $this
     */
    public function setQuestionIds(string $question_ids)
    {
        $this->question_ids = $question_ids;

        return $this;
    }

    /**
     * @return array
     */
    public function getQuestionIdsAsArray()
    {
        $questionIdsArray = explode(',', $this->question_ids);

        return array_combine($questionIdsArray, $questionIdsArray);
    }

    /**
     * @return int
     */
    public function getValidDays()
    {
        return $this->valid_days;
    }

    /**
     * @param int $valid_days
     *
     * @return $this
     */
    public function setValidDays(int $valid_days)
    {
        $this->valid_days = $valid_days;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEditable()
    {
        return $this->editable;
    }

    /**
     * @param bool $editable
     *
     * @return $this
     */
    public function setEditable(bool $editable)
    {
        $this->editable = $editable;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedTime()
    {
        return $this->created_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getCreatedTimeAsDateTime()
    {
        return $this->getCreatedTime() ? new DateTime($this->getCreatedTime()) : null;
    }

    /**
     * @param string $created_time
     *
     * @return $this
     */
    public function setCreatedTime(string $created_time)
    {
        $this->created_time = $created_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedTime()
    {
        return $this->updated_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getUpdatedTimeAsDateTime()
    {
        return $this->getUpdatedTime() ? new DateTime($this->getUpdatedTime()) : null;
    }

    /**
     * @param string $updated_time
     *
     * @return $this
     */
    public function setUpdatedTime(string $updated_time)
    {
        $this->updated_time = $updated_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getSentTime()
    {
        return $this->sent_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getSentTimeAsDateTime()
    {
        return $this->getSentTime() ? new DateTime($this->getSentTime()) : null;
    }

    /**
     * @param string $sent_time
     *
     * @return $this
     */
    public function setSentTime(string $sent_time)
    {
        $this->sent_time = $sent_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeliveredTime()
    {
        return $this->delivered_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getDeliveredTimeAsDateTime()
    {
        return $this->getDeliveredTime() ? new DateTime($this->getDeliveredTime()) : null;
    }

    /**
     * @param string $delivered_time
     *
     * @return $this
     */
    public function setDeliveredTime(string $delivered_time)
    {
        $this->delivered_time = $delivered_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getViewedTime()
    {
        return $this->viewed_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getViewedTimeAsDateTime()
    {
        return $this->getViewedTime() ? new DateTime($this->getViewedTime()) : null;
    }

    /**
     * @param string $viewed_time
     *
     * @return $this
     */
    public function setViewedTime(string $viewed_time)
    {
        $this->viewed_time = $viewed_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubmittedTime()
    {
        return $this->submitted_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getSubmittedTimeAsDateTime()
    {
        return $this->getSubmittedTime() ? new DateTime($this->getSubmittedTime()) : null;
    }

    /**
     * @param string $submitted_time
     *
     * @return $this
     */
    public function setSubmittedTime(string $submitted_time)
    {
        $this->submitted_time = $submitted_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompletedTime()
    {
        return $this->completed_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getCompletedTimeAsDateTime()
    {
        return $this->getCompletedTime() ? new DateTime($this->getCompletedTime()) : null;
    }


    /**
     * @param string $completed_time
     *
     * @return $this
     */
    public function setCompletedTime(string $completed_time)
    {
        $this->completed_time = $completed_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getProcessedTime()
    {
        return $this->processed_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getProcessedTimeAsDateTime()
    {
        return $this->getProcessedTime() ? new DateTime($this->getProcessedTime()) : null;
    }

    /**
     * @param string $processed_time
     *
     * @return $this
     */
    public function setProcessedTime(string $processed_time)
    {
        $this->processed_time = $processed_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getFlowTime()
    {
        return $this->flow_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getFlowTimeAsDateTime()
    {
        return $this->getFlowTime() ? new DateTime($this->getFlowTime()) : null;
    }

    /**
     * @param string $flow_time
     *
     * @return $this
     */
    public function setFlowTime(string $flow_time)
    {
        $this->flow_time = $flow_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param string $created_by
     *
     * @return $this
     */
    public function setCreatedBy(string $created_by)
    {
        $this->created_by = $created_by;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * @param string $updated_by
     *
     * @return $this
     */
    public function setUpdatedBy(string $updated_by)
    {
        $this->updated_by = $updated_by;

        return $this;
    }

    /**
     * @return string
     */
    public function getCollectionUrl()
    {
        return $this->collection_url;
    }

    /**
     * @param string $collection_url
     *
     * @return $this
     */
    public function setCollectionUrl(string $collection_url)
    {
        $this->collection_url = $collection_url;

        return $this;
    }

    /**
     * @return string
     */
    public function getCollectionUrlShort()
    {
        return $this->collection_url_short;
    }

    /**
     * @param string $collection_url_short
     *
     * @return $this
     */
    public function setCollectionUrlShort(string $collection_url_short)
    {
        $this->collection_url_short = $collection_url_short;

        return $this;
    }

    /**
     * @return string
     */
    public function getCollectionUrlLong()
    {
        return $this->collection_url_long;
    }

    /**
     * @param string $collection_url_long
     *
     * @return $this
     */
    public function setCollectionUrlLong(string $collection_url_long)
    {
        $this->collection_url_long = $collection_url_long;

        return $this;
    }
}
