<?php
namespace Anax\Model;

class GeoTag
{

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     *
     * @param $when -> 7 days in future, or 30 days in the past, $lat -> Latitude, $long -> Longitude
     * @return array of weather using file_get_contents()
     *
     */
    public function getWeather($when, $lat, $long) : array
    {
        $now = time();
        $dates = array();
        $weather = array();
        $temp = array();
        $time = array();

        if ($when == "past") {
            for ($i = 0; $i < 30; $i++) {
                // 24h = 86400 unix time
                $now -= 86400;
                $dates[] = $now;
            }
        } else {
            for ($i = 0; $i < 7; $i++) {
                // 24h = 86400 unix time
                $now += 86400;
                $dates[] = $now;
            }
        }

        for ($i = 0; $i < count($dates); $i++) {
            $details =      json_decode(file_get_contents("https://api.darksky.net/forecast/{$this->config}/{$lat},{$long},{$dates[$i]}?lang=sv&units=si"));

            $time[] = $details->currently->time;
            $weather[] = $details->currently->summary;
            $temp[] = $details->currently->temperature;
        }

        return [
            "time" => $time,
            "weather" => $weather,
            "temp" => $temp,
        ];
    }


    /**
     *
     * @param $id -> time id of weather 7 days in future,
     * @param $lat -> Latitude,
     * @param $long -> Longitude,
     * @return array of weather using multicurl
     *
     */
    public function getWeatherMultiCurl($when, $lat, $long) : array
    {
        $dates = [];
        $now = time();

        if ($when == "past") {
            for ($i = 0; $i < 30; $i++) {
                // 24h = 86400 unix time
                $now -= 86400;
                $dates[] = $now;
            }
        } else {
            for ($i = 0; $i < 7; $i++) {
                // 24h = 86400 unix time
                $now += 86400;
                $dates[] = $now;
            }
        }

        $url = "https://api.darksky.net/forecast/{$this->config->config}/{$lat},{$long}";

        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];

        $mh = curl_multi_init();
        $chAll = [];
        foreach ($dates as $day) {
            $ch = curl_init("$url,{$day}?lang=sv&units=si");
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $chAll[] = $ch;
        }

        // execute all queries simultaneously and countinue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);

        // Close handle
        foreach ($chAll as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);

        //req are done, access results
        $response = [];
        foreach ($chAll as $ch) {
            $data = curl_multi_getcontent($ch);
            $response[] = json_decode($data, true);

            // $weather[] = $response->currently->summary;
            // $temp[] = $response->currently->temperature;
        }
        return $response;
    }
}
