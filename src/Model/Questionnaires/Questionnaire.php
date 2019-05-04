<?php

namespace Esat\Model\Questionnaires;

use DateTime;
use Esat\Support\Model\BaseModel;
use Exception;

/**
 * Class Questionnaire
 * @package Esat\Model\Questionnaires
 */
class Questionnaire extends BaseModel
{
    /**
     * @var string
     */
    protected $questionnaire_id;

    /**
     * @var string
     */
    protected $template_questionnaire_id;

    /**
     * @var string
     */
    protected $owner_application_id;

    /**
     * @var string
     */
    protected $display_name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

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
    protected $desktop_collapsed;

    /**
     * @var int
     */
    protected $non_collapsed_questions_count;

    /**
     * @var string
     */
    protected $key_question_id;

    /**
     * @var bool
     */
    protected $credits_accountable;

    /**
     * @var string
     */
    protected $questionnaire_icon_url;

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
    public function getTemplateQuestionnaireId()
    {
        return $this->template_questionnaire_id;
    }

    /**
     * @param string $template_questionnaire_id
     *
     * @return $this
     */
    public function setTemplateQuestionnaireId(string $template_questionnaire_id)
    {
        $this->template_questionnaire_id = $template_questionnaire_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getOwnerApplicationId()
    {
        return $this->owner_application_id;
    }

    /**
     * @param string $owner_application_id
     *
     * @return $this
     */
    public function setOwnerApplicationId(string $owner_application_id)
    {
        $this->owner_application_id = $owner_application_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * @param string $display_name
     *
     * @return $this
     */
    public function setDisplayName(string $display_name)
    {
        $this->display_name = $display_name;

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
     * @return bool
     */
    public function isDesktopCollapsed()
    {
        return $this->desktop_collapsed;
    }

    /**
     * @param bool $desktop_collapsed
     *
     * @return $this
     */
    public function setDesktopCollapsed(bool $desktop_collapsed)
    {
        $this->desktop_collapsed = $desktop_collapsed;

        return $this;
    }

    /**
     * @return int
     */
    public function getNonCollapsedQuestionsCount()
    {
        return $this->non_collapsed_questions_count;
    }

    /**
     * @param int $non_collapsed_questions_count
     *
     * @return $this
     */
    public function setNonCollapsedQuestionsCount(int $non_collapsed_questions_count)
    {
        $this->non_collapsed_questions_count = $non_collapsed_questions_count;

        return $this;
    }

    /**
     * @return string
     */
    public function getKeyQuestionId()
    {
        return $this->key_question_id;
    }

    /**
     * @param string $key_question_id
     *
     * @return $this
     */
    public function setKeyQuestionId(string $key_question_id)
    {
        $this->key_question_id = $key_question_id;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCreditsAccountable()
    {
        return $this->credits_accountable;
    }

    /**
     * @param bool $credits_accountable
     *
     * @return $this
     */
    public function setCreditsAccountable(bool $credits_accountable)
    {
        $this->credits_accountable = $credits_accountable;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuestionnaireIconUrl()
    {
        return $this->questionnaire_icon_url;
    }

    /**
     * @param string $questionnaire_icon_url
     *
     * @return $this
     */
    public function setQuestionnaireIconUrl(string $questionnaire_icon_url)
    {
        $this->questionnaire_icon_url = $questionnaire_icon_url;

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
