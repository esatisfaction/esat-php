<?php

namespace Esat\Model\Questionnaires\Pipelines;

use DateTime;
use Esat\Support\Model\BaseModel;
use Exception;

/**
 * Class Queue
 * @package Esat\Model\Questionnaires\Pipelines
 */
class Queue extends BaseModel
{
    /**
     * @var string
     */
    protected $item_id;

    /**
     * @var string
     */
    protected $previous_item_id;

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
    protected $responder_channel_identifier;

    /**
     * @var string
     */
    protected $questionnaire_instance_id;

    /**
     * @var string
     */
    protected $previous_questionnaire_instance_id;

    /**
     * @var int
     */
    protected $status_id;

    /**
     * @var string
     */
    protected $pipeline_id;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $send_time;

    /**
     * @var string
     */
    protected $dispatched_time;

    /**
     * @var string
     */
    protected $result;

    /**
     * @var int
     */
    protected $retry_attempts;

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
    protected $anonymized_time;

    /**
     * @var string
     */
    protected $created_by;

    /**
     * @var string
     */
    protected $updated_by;

    /**
     * @return string
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param string $item_id
     *
     * @return $this
     */
    public function setItemId(string $item_id)
    {
        $this->item_id = $item_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPreviousItemId()
    {
        return $this->previous_item_id;
    }

    /**
     * @param string $previous_item_id
     *
     * @return $this
     */
    public function setPreviousItemId(string $previous_item_id)
    {
        $this->previous_item_id = $previous_item_id;

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
    public function getResponderChannelIdentifier()
    {
        return $this->responder_channel_identifier;
    }

    /**
     * @param string $responder_channel_identifier
     *
     * @return $this
     */
    public function setResponderChannelIdentifier(string $responder_channel_identifier)
    {
        $this->responder_channel_identifier = $responder_channel_identifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuestionnaireInstanceId()
    {
        return $this->questionnaire_instance_id;
    }

    /**
     * @param string $questionnaire_instance_id
     *
     * @return $this
     */
    public function setQuestionnaireInstanceId(string $questionnaire_instance_id)
    {
        $this->questionnaire_instance_id = $questionnaire_instance_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPreviousQuestionnaireInstanceId()
    {
        return $this->previous_questionnaire_instance_id;
    }

    /**
     * @param string $previous_questionnaire_instance_id
     *
     * @return $this
     */
    public function setPreviousQuestionnaireInstanceId(string $previous_questionnaire_instance_id)
    {
        $this->previous_questionnaire_instance_id = $previous_questionnaire_instance_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * @param int $status_id
     *
     * @return $this
     */
    public function setStatusId(int $status_id)
    {
        $this->status_id = $status_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPipelineId()
    {
        return $this->pipeline_id;
    }

    /**
     * @param string $pipeline_id
     *
     * @return $this
     */
    public function setPipelineId(string $pipeline_id)
    {
        $this->pipeline_id = $pipeline_id;

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
     * @return string
     */
    public function getSendTime()
    {
        return $this->send_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getSendTimeAsDateTime()
    {
        return $this->getSendTime() ? new DateTime($this->getSendTime()) : null;
    }

    /**
     * @param string $send_time
     *
     * @return $this
     */
    public function setSendTime(string $send_time)
    {
        $this->send_time = $send_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getDispatchedTime()
    {
        return $this->dispatched_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getDispatchedTimeAsDateTime()
    {
        return $this->getDispatchedTime() ? new DateTime($this->getDispatchedTime()) : null;
    }

    /**
     * @param string $dispatched_time
     *
     * @return $this
     */
    public function setDispatchedTime(string $dispatched_time)
    {
        $this->dispatched_time = $dispatched_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     *
     * @return $this
     */
    public function setResult(string $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return int
     */
    public function getRetryAttempts()
    {
        return $this->retry_attempts;
    }

    /**
     * @param int $retry_attempts
     *
     * @return $this
     */
    public function setRetryAttempts(int $retry_attempts)
    {
        $this->retry_attempts = $retry_attempts;

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
    public function getAnonymizedTime()
    {
        return $this->anonymized_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getAnonymizedTimeAsDateTime()
    {
        return $this->getAnonymizedTime() ? new DateTime($this->getAnonymizedTime()) : null;
    }

    /**
     * @param string $anonymized_time
     *
     * @return $this
     */
    public function setAnonymizedTime(string $anonymized_time)
    {
        $this->anonymized_time = $anonymized_time;

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
}
