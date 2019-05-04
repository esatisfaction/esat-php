<?php

namespace Esat\Model\Questionnaires;

use Esat\Support\Model\Propel\Pager;

/**
 * Class QuestionnairePager
 * @package Esat\Model\Questionnaires
 */
class QuestionnairePager extends Pager
{
    /**
     * @var Questionnaire[]
     */
    protected $questionnaires = [];

    /**
     * @param Questionnaire $questionnaire
     */
    public function addQuestionnaire(Questionnaire $questionnaire)
    {
        $this->questionnaires[] = $questionnaire;
    }

    /**
     * @return Questionnaire[]
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }

    /**
     * @param Questionnaire[] $questionnaires
     *
     * @return $this
     */
    public function setQuestionnaires(array $questionnaires)
    {
        $this->questionnaires = $questionnaires;

        return $this;
    }
}
