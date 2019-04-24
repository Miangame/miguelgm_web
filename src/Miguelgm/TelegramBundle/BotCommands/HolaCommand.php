<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 23/04/19
 * Time: 23:16
 */

namespace Miguelgm\TelegramBundle\BotCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Request;

class HolaCommand extends UserCommand
{
    protected $name = 'hola';
    protected $description = 'Di hola, respondo adios';
    protected $usage = '/hola';
    protected $version = '1.0.0';

    public function execute()
    {
        /** @var Message $message */
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $data = [];
        $data['chat_id'] = $chat_id;
        $data['text'] = "Más vale ego que técnica xd";

        return Request::sendMessage($data);
    }
}