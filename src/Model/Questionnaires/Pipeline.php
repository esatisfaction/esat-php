<?php

namespace Esat\Model\Questionnaires;

use DateTime;
use Esat\Support\Model\BaseModel;
use Exception;

/**
 * Class Pipeline
 * @package Esat\Model\Questionnaires
 */
class Pipeline extends BaseModel
{
    /**
     * @var string
     */
    protected $pipeline_id;

    /**
     * @var string
     */
    protected $template_pipeline_id;

    /**
     * @var string
     */
    protected $questionnaire_id;

    /**
     * @var string
     */
    protected $channel_id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var int
     */
    protected $delay_cap_minutes;

    /**
     * @var int
     */
    protected $delay_cap_hours;

    /**
     * @var int
     */
    protected $delay_cap_days;

    /**
     * @var int
     */
    protected $frequency_cap_minutes;

    /**
     * @var int
     */
    protected $frequency_cap_hours;

    /**
     * @var int
     */
    protected $frequency_cap_days;

    /**
     * @var string
     */
    protected $message_subject;

    /**
     * @var string
     */
    protected $message_body;

    /**
     * @var string
     */
    protected $start_time;

    /**
     * @var string
     */
    protected $end_time;

    /**
     * @var string
     */
    protected $dispatch_start_time;

    /**
     * @var string
     */
    protected $dispatch_end_time;

    /**
     * @var int
     */
    protected $max_retry_attempts;

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
    protected $created_by;

    /**
     * @var string
     */
    protected $updated_by;

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
    public function getTemplatePipelineId()
    {
        return $this->template_pipeline_id;
    }

    /**
     * @param string $template_pipeline_id
     *
     * @return $this
     */
    public function setTemplatePipelineId(string $template_pipeline_id)
    {
        $this->template_pipeline_id = $template_pipeline_id;

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
    public function getChannelId()
    {
        return $this->channel_id;
    }

    /**
     * @param string $channel_id
     *
     * @return $this
     */
    public function setChannelId(string $channel_id)
    {
        $this->channel_id = $channel_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

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
     * @return int
     */
    public function getDelayCapMinutes()
    {
        return $this->delay_cap_minutes;
    }

    /**
     * @param int $delay_cap_minutes
     *
     * @return $this
     */
    public function setDelayCapMinutes(int $delay_cap_minutes)
    {
        $this->delay_cap_minutes = $delay_cap_minutes;

        return $this;
    }

    /**
     * @return int
     */
    public function getDelayCapHours()
    {
        return $this->delay_cap_hours;
    }

    /**
     * @param int $delay_cap_hours
     *
     * @return $this
     */
    public function setDelayCapHours(int $delay_cap_hours)
    {
        $this->delay_cap_hours = $delay_cap_hours;

        return $this;
    }

    /**
     * @return int
     */
    public function getDelayCapDays()
    {
        return $this->delay_cap_days;
    }

    /**
     * @param int $delay_cap_days
     *
     * @return $this
     */
    public function setDelayCapDays(int $delay_cap_days)
    {
        $this->delay_cap_days = $delay_cap_days;

        return $this;
    }

    /**
     * @return int
     */
    public function getFrequencyCapMinutes()
    {
        return $this->frequency_cap_minutes;
    }

    /**
     * @param int $frequency_cap_minutes
     *
     * @return $this
     */
    public function setFrequencyCapMinutes(int $frequency_cap_minutes)
    {
        $this->frequency_cap_minutes = $frequency_cap_minutes;

        return $this;
    }

    /**
     * @return int
     */
    public function getFrequencyCapHours()
    {
        return $this->frequency_cap_hours;
    }

    /**
     * @param int $frequency_cap_hours
     *
     * @return $this
     */
    public function setFrequencyCapHours(int $frequency_cap_hours)
    {
        $this->frequency_cap_hours = $frequency_cap_hours;

        return $this;
    }

    /**
     * @return int
     */
    public function getFrequencyCapDays()
    {
        return $this->frequency_cap_days;
    }

    /**
     * @param int $frequency_cap_days
     *
     * @return $this
     */
    public function setFrequencyCapDays(int $frequency_cap_days)
    {
        $this->frequency_cap_days = $frequency_cap_days;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessageSubject()
    {
        return $this->message_subject;
    }

    /**
     * @param string $message_subject
     *
     * @return $this
     */
    public function setMessageSubject(string $message_subject)
    {
        $this->message_subject = $message_subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessageBody()
    {
        return $this->message_body;
    }

    /**
     * @param string $message_body
     *
     * @return $this
     */
    public function setMessageBody(string $message_body)
    {
        $this->message_body = $message_body;

        return $this;
    }

    /**
     * @return string
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getStartTimeAsDateTime()
    {
        return $this->getStartTime() ? new DateTime($this->getStartTime()) : null;
    }

    /**
     * @param string $start_time
     *
     * @return $this
     */
    public function setStartTime(string $start_time)
    {
        $this->start_time = $start_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getEndTimeAsDateTime()
    {
        return $this->getEndTime() ? new DateTime($this->getEndTime()) : null;
    }

    /**
     * @param string $end_time
     *
     * @return $this
     */
    public function setEndTime(string $end_time)
    {
        $this->end_time = $end_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getDispatchStartTime()
    {
        return $this->dispatch_start_time;
    }

    /**
     * @param string $dispatch_start_time
     *
     * @return $this
     */
    public function setDispatchStartTime(string $dispatch_start_time)
    {
        $this->dispatch_start_time = $dispatch_start_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getDispatchEndTime()
    {
        return $this->dispatch_end_time;
    }

    /**
     * @param string $dispatch_end_time
     *
     * @return $this
     */
    public function setDispatchEndTime(string $dispatch_end_time)
    {
        $this->dispatch_end_time = $dispatch_end_time;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxRetryAttempts()
    {
        return $this->max_retry_attempts;
    }

    /**
     * @param int $max_retry_attempts
     *
     * @return $this
     */
    public function setMaxRetryAttempts(int $max_retry_attempts)
    {
        $this->max_retry_attempts = $max_retry_attempts;

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
