<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 23/04/19
 * Time: 23:50
 */

namespace Miguelgm\TelegramBundle\BotCommands;


use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Request;
use Symfony\Bundle\SecurityBundle\Tests\Functional\UserPasswordEncoderCommandTest;

class MiChatCommand extends UserCommand
{

    protected $name = 'michat';
    protected $description = 'Te indica el Chat en el que estás ahora mismo.';
    protected $usage = '/michat';
    protected $version = '0.0.1';
    /**#@-*/

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var Message $message */
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $text = "Este es el ID del chat donde estás: ".(string) $chat_id;

        $data = [];
        $data['chat_id'] = $chat_id;
        $data['text'] = $text;
        $data['parse_mode'] = "Markdown";

        return Request::sendMessage($data);
    }

}