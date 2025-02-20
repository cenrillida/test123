<?php

namespace TelegramBot\Mappers;

use TelegramBot\Commands\ActualComment;
use TelegramBot\Commands\Command;
use TelegramBot\Commands\News;
use TelegramBot\Commands\Start;
use TelegramBot\TelegramBot;

class CommandMapper {

    /** @var TelegramBot */
    private $telegramBot;
    /** @var Command[] */
    private $commandList;
    /** @var string[] */
    private $commandListDescription;

    /**
     * @param TelegramBot $telegramBot
     */
    public function __construct($telegramBot)
    {
        $this->telegramBot = $telegramBot;

        $this->commandList = array(
            "/start" => new Start($telegramBot),
            "/news" => new News($telegramBot),
            "/actual_comment" => new ActualComment($telegramBot)
        );

        $this->commandListDescription = array(
            array("command" => "/start", "description" => "�����"),
            array("command" => "/news", "description" => "�������� ��������� �������"),
            array("command" => "/actual_comment", "description" => "�������� ��������� ���������� �����������")
        );
    }

    /**
     * @param string $commandName
     * @return Command
     */
    public function getCommandByName($commandName) {
        return $this->commandList[$commandName];
    }

    /**
     * @return string[]
     */
    public function getCommandListDescription()
    {
        return $this->commandListDescription;
    }

}