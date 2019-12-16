<?php
namespace Anax\Model;

class Coordinates
{
    public function getCoordinates(String $search) : array
    {
        $apiKeyOpenCage = require "../config/apiKey.php";

        if (is_string($search)) {
            $details = json_decode(file_get_contents("https://api.opencagedata.com/geocode/v1/json?q=$search&key={$apiKeyOpenCage["opencage"]["key"]}"));
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
