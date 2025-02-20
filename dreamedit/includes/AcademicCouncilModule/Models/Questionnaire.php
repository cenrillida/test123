<?php

namespace AcademicCouncilModule\Models;

class Questionnaire {

    /** @var int */
    private $id;
    /** @var Member[] */
    private $members;
    /** @var string */
    private $name;
    /** @var string */
    private $dtStart;
    /** @var string */
    private $dtEnd;
    /** @var string */
    private $orderDate;
    /** @var string */
    private $orderNumber;
    /** @var string */
    private $questionnaireDate;
    /** @var string */
    private $questionnaireQuestion;
    /** @var bool */
    private $secret;
    /** @var string */
    private $protocolNumber;
    /** @var string */
    private $questionnaireFio;
    /** @var string */
    private $questionnairePosition;
    /** @var string */
    private $questionnaireMembersCount;

    /**
     * AcademicCouncilQuestionnaire constructor.
     * @param int $id
     * @param Member[] $members
     * @param string $name
     * @param string $dtStart
     * @param string $dtEnd
     * @param string $orderDate
     * @param string $orderNumber
     * @param string $questionnaireDate
     * @param string $questionnaireQuestion
     * @param bool $secret
     * @param string $protocolNumber
     * @param string $questionnaireFio
     * @param string $questionnairePosition
     * @param string $questionnaireMembersCount
     */
    public function __construct($id, array $members, $name, $dtStart, $dtEnd, $orderDate, $orderNumber, $questionnaireDate, $questionnaireQuestion, $secret, $protocolNumber, $questionnaireFio, $questionnairePosition, $questionnaireMembersCount)
    {
        $this->id = $id;
        $this->members = $members;
        $this->name = $name;
        $this->dtStart = $dtStart;
        $this->dtEnd = $dtEnd;
        $this->orderDate = $orderDate;
        $this->orderNumber = $orderNumber;
        $this->questionnaireDate = $questionnaireDate;
        $this->questionnaireQuestion = $questionnaireQuestion;
        $this->secret = $secret;
        $this->protocolNumber = $protocolNumber;
        $this->questionnaireFio = $questionnaireFio;
        $this->questionnairePosition = $questionnairePosition;
        $this->questionnaireMembersCount = $questionnaireMembersCount;
    }

    /**
     * @return Member[]
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDtEnd()
    {
        return $this->dtEnd;
    }

    /**
     * @return string
     */
    public function getDtStart()
    {
        return $this->dtStart;
    }

    /**
     * @return string
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @return string
     */
    public function getQuestionnaireDate()
    {
        return $this->questionnaireDate;
    }

    /**
     * @return string
     */
    public function getQuestionnaireQuestion()
    {
        return $this->questionnaireQuestion;
    }

    /**
     * @return bool
     */
    public function isSecret()
    {
        return $this->secret;
    }

    /**
     * @return string
     */
    public function getProtocolNumber()
    {
        return $this->protocolNumber;
    }

    /**
     * @return string
     */
    public function getQuestionnaireFio()
    {
        return $this->questionnaireFio;
    }

    /**
     * @return string
     */
    public function getQuestionnairePosition()
    {
        return $this->questionnairePosition;
    }

    /**
     * @return string
     */
    public function getQuestionnaireMembersCount()
    {
        return $this->questionnaireMembersCount;
    }

}