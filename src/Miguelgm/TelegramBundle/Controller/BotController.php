<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 23/04/19
 * Time: 21:30
 */

namespace Miguelgm\TelegramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Longman\TelegramBot\Exception\TelegramException;
use Miguelgm\TelegramBundle\Model\BotTelegram;


class BotController extends Controller
{
    public function tryBotAction(Request $request)
    {
        $API_KEY = $this->getParameter('telegram_api_key');

        if ($request->get('code') != $API_KEY) {
            return new JsonResponse("Access Denied");
        }

        $BOT_NAME = $this->getParameter('telegram_bot_name');
        try {
            // Create Telegram API object
            $dir_bots = $this->getParameter('kernel.root_dir') . '/../src/Miguelgm/TelegramBundle/BotCommands';
            $telegram = new BotTelegram($API_KEY, $BOT_NAME, $dir_bots, $this->container);
        } catch (TelegramException $e) {

        }

        $chatId = $request->get('chatId');
        $text = $request->get('text');

        if (true) {
            $customInput = array(
                'update_id' => 87842865,
                'message' => array(
                    "message_id" => 100,
                    'from' => array(
                        'id' => $chatId,
                        'first_name' => 'MiguelGM',
                        'last_name' => 'MiguelGM',
                        'username' => '@swallows'
                    ),
                    'chat' => array(
                        'id' => $chatId,
                        'first_name' => 'MiguelGM',
                        'last_name' => 'MiguelGM',
                        'username' => '@miguelgm',
                        'type' => 'private'
                    ),
                    'date' => 1476179342,
                    'text' => $text
                )
            );

            $telegram->setCustomInput(json_encode($customInput));

            // Handle telegram webhook request
            $result = $telegram->handle();

            return new JsonResponse($result);
        }
        return new JsonResponse("Access Denied");
    }

    public function webhookAction($code)
    {
        $API_KEY = $this->getParameter('telegram_api_key');
        if ($code != $API_KEY) {
            die("Auth");
        }
        $BOT_NAME = $this->getParameter('telegram_bot_name');
        try {
            // Create Telegram API object
            $dir_bots = $this->getParameter('kernel.root_dir') . '/../src/Miguelgm/TelegramBundle/BotCommands';
            $telegram = new BotTelegram($API_KEY, $BOT_NAME, $dir_bots, $this->container);

            // Handle telegram webhook request
            $telegram->handle();
        } catch (TelegramException $e) {
            /** @var Logger $telegramLogger */
            $telegramLogger = $this->get("monolog.logger.telegram");
            $telegramLogger->info("Ha ocurrido un error: " . $e->getMessage());
        }

        return new JsonResponse([
            'ok' => true
        ]);
    }

    public function clearAction($code)
    {
        return new JsonResponse([
            'ok' => true
        ]);
    }
}