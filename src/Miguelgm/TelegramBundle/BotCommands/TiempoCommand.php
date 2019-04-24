<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 23/04/19
 * Time: 23:52
 */

namespace Miguelgm\TelegramBundle\BotCommands;


use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Request;
use Symfony\Bundle\SecurityBundle\Tests\Functional\UserPasswordEncoderCommandTest;

use Miguelgm\TelegramBundle\Services\WeatherHelper;

class TiempoCommand extends UserCommand
{
    protected $name = 'tiempo';
    protected $description = 'Te indicaré la previsión metereológica para el dia de hoy.';
    protected $usage = '/tiempo <nombreCiudad>';
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
        $option = trim($message->getText(true));

        /** @var WeatherHelper $weatherHelper */
        $weatherHelper = $this->telegram->container->get('weather_helper');

        $photo = '';

        if ($option) {
            $forecastWeather = $weatherHelper->getForecastWeather($option);
            if ($forecastWeather) {
                if ($forecastWeather->city->country == "ES") {
                    $country = "España";
                } else {
                    $country = $forecastWeather->city->country;
                }
                $city = $forecastWeather->city->name . ", " . $country;
                $forecast = $forecastWeather->weather->description;
                $acTemp = $forecastWeather->temperature->now;
                $maxTemp = $forecastWeather->temperature->max;
                $minTemp = $forecastWeather->temperature->min;
                $humidity = $forecastWeather->humidity;
                $pressure = $forecastWeather->pressure;
                $windSpeed = $forecastWeather->wind->speed;
                $windDirection = $forecastWeather->wind->direction;
                $clouds = $forecastWeather->clouds;
                $precipitation = $forecastWeather->precipitation;

                $actuallyTemperature = str_replace('&deg;C', "℃", $acTemp);
                $maxTemperature = str_replace('&deg;C', "℃", $maxTemp);
                $minTemperature = str_replace('&deg;C', "℃", $minTemp);


                $iconForecast = "";

                switch ($forecast) {
                    case "cielo claro";
                        $photo = 'https://cdn.pixabay.com/photo/2016/01/02/00/42/cloud-1117279_960_720.jpg';
                        $iconForecast = " \xE2\x98\x80 ";
                        break;
                    case "lluvia ligera";
                        $photo = 'https://cdn.pixabay.com/photo/2013/06/18/14/25/light-rain-139977_960_720.jpg';
                        $iconForecast = " \xE2\x98\x94 ";
                        break;
                    case "niebla";
                        $photo = 'https://cdn.pixabay.com/photo/2017/01/16/19/40/mountains-1985027_960_720.jpg';
                        $iconForecast = " \xF0\x9F\x8C\x80 ";
                        break;
                    case "nubes rotas";
                        $photo = 'https://cdn.pixabay.com/photo/2018/06/15/06/52/clouds-3476252_960_720.jpg';
                        $iconForecast = " \xE2\x98\x81 ";
                        break;
                    case "algo de nubes";
                        $photo = 'https://cdn.pixabay.com/photo/2014/11/16/15/15/field-533541_960_720.jpg';
                        $iconForecast = " \xE2\x9B\x85 ";
                        break;
                    case "nubes";
                        $photo = 'https://cdn.pixabay.com/photo/2014/08/09/15/45/sky-414198_960_720.jpg';
                        $iconForecast = " \xE2\x98\x81 ";
                        break;
                }

                $text = "Previsión meteorológica para * \n \n" ;
                $text .= " \xF0\x9F\x97\xBC " .$city . "* \xF0\x9F\x97\xBC \n" . "\n";
                $text .= " *Previsión* \xE2\x96\xB6 " . $forecast .  $iconForecast . "\n \n";
                $text .= " *TempActual* \xE2\x96\xB6 " . $actuallyTemperature . " \xF0\x9F\x94\xB8 \n \n";
                $text .= " *TempMax* \xE2\x96\xB6 " . $maxTemperature . " \xF0\x9F\x94\xBA \n \n";
                $text .= " *TempMin* \xE2\x96\xB6 " . $minTemperature . " \xF0\x9F\x94\xBB \n \n";
                $text .= " *Humedad* \xE2\x96\xB6 " . $humidity . " \xF0\x9F\x92\xA7 \n \n";
                $text .= " *Presión* \xE2\x96\xB6 " . $pressure . " \xF0\x9F\x8C\x80 \n \n";
                $text .= " *Viento* \xE2\x96\xB6 " . $windSpeed . " \xF0\x9F\x92\xA8 \n \n";
                $text .= " *Dirección* \xE2\x96\xB6 " . $windDirection . " \xF0\x9F\x94\x83 \n \n";
                $text .= " *Nubes* \xE2\x96\xB6 " . $clouds . " \xE2\x98\x81 \n \n";
            } else {
                $text = 'La ciudad introducida no existe, pruebe de nuevo con una ciudad válida.';
            }
        } else {
            $text = 'Formato del comando incorrecto, mire la ayuda con el comando /help';
        }

        $data = array(
            'chat_id' => $chat_id,
            'photo' => $photo,
            'text' => $text,
            'parse_mode' => "Markdown"
        );

        Request::sendMessage($data);
        return Request::sendPhoto($data);
    }
}