<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 23/04/19
 * Time: 23:54
 */

namespace Miguelgm\TelegramBundle\Services;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class WeatherHelper
{
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function getForecastWeather($city)
    {
        if ($city) {
            // Language of data (try your own language here!):
            $lang = 'es';

            // Units (can be 'metric' or 'imperial' [default]):
            $units = 'metric';

            $weather = array();

            // Create OpenWeatherMap object.
            // Don't use caching (take a look into Examples/Cache.php to see how it works).
            try {
                $owm = new OpenWeatherMap($this->api);
                $weather = $owm->getWeather($city, $units, $lang);
            } catch (OWMException $e) {
                echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
            } catch (\Exception $e) {
                echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
            }

            return $weather;
        } else {
            return false;
        }


    }
}