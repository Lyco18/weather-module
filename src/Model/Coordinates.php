<?php
namespace Anax\Model;

class Coordinates
{
    private $config;
    /**
     * Constructor, allow for $di to be injected.
     *
     * @param Array $config for api key
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getCoordinates(String $search) : array
    {
        $key = $this->config;

        if (is_string($search)) {
            $details = json_decode(file_get_contents("https://api.opencagedata.com/geocode/v1/json?q=$search&key={$key}"));
            $results = $details->results;
            if (isset($results[0]->geometry)) {
                $valid = "Valid";
                $lat = $results[0]->geometry->lat;
                $long = $results[0]->geometry->lng;
            } else {
                $valid = "Not valid, showing Gold Coast instead";
                $lat = -28.016666;
                $long = 153.399994;
            }
            return [
                "valid" => $valid,
                "lat" => $lat,
                "long" => $long
            ];
        }
    }
}
