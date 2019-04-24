<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 24/04/19
 * Time: 0:00
 */

namespace Miguelgm\TelegramBundle\BotCommands;


use CR\Api;
use CR\CRCache;
use CR\CRUtils;
use CR\Exceptions\CRSDKException;
use http\Exception;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InputMedia\InputMediaPhoto;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Request;

class PlayerCommand extends UserCommand
{
    protected $name = 'player';
    protected $description = 'Te indica el información de un jugador de Clash Royale.';
    protected $usage = '/player <id>';
    protected $version = '0.0.1';


    /**
     * {@inheritdoc}
     */
    public function execute()
    {

        /** @var Message $message */
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $text = "";

        $option = trim($message->getText(true));

        if ($option) {
            $token = $this->telegram->container->getParameter('cr_api');
            try{
                $api = new Api($token);
                $player = $api->getPlayer(array($option));

                if ($player) {
                    $text .= "Nombre: " . $player["name"] . "\n";
                    $text .= "Trofeos actuales: " . $player["trophies"] . "\n";
                    $text .= "Arena: " . $player["arena"]->getName() . "\n";
                    $text .= "Clan: " . $player["clan"]->getName() . "\n";
                    $text .= "Partidas totales: " . $player["games"]->getTotal() . "\n";
                    $text .= "Partidas ganadas: " . $player["games"]->getWins() . ". " . ($player["games"]->getWinsPercent()*100) . "%\n";
                    $text .= "Partidas perdidas: " . $player["games"]->getLosses() . ". " . ($player["games"]->getLossesPercent()*100) . "%\n";
                    $text .= "Partidas empatadas: " . $player["games"]->getDraws() . ". " . ($player["games"]->getDrawsPercent()*100) . "%\n";

                    $deckArray = array();
                    foreach ($player["currentDeck"] as $index => $item) {
                        $inputMedia = new InputMediaPhoto();
                        $inputMedia->setMedia(Request::sendMediaGroup($item));
                        $deckArray[$index] = $inputMedia;
                    }

                } else {
                    $text = 'No se ha encontrado ningún jugador con ese ID.';
                }
            } catch (CRSDKException $e) {
            }
        } else {
            $text = 'Formato del comando incorrecto, mire la ayuda con el comando /help';
        }

        $data = [];
        $data['chat_id'] = $chat_id;
        $data['text'] = $text;
        $data['media'] = json_encode($deckArray, JSON_FORCE_OBJECT);
        $data['parse_mode'] = "Markdown";

        Request::sendMessage($data);
        return Request::sendMediaGroup($data);
    }
}