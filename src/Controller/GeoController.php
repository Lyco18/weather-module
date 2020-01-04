<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Model\Coordinates;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 *
 * Geo Controller for weather report
 *
 */
class GeoController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : object
    {
        //get page
        $page = $this->di->get("page");
        //name="ip"
        if ($this->di->request->getGet("submit")) {
            $search = $this->di->request->getGet("search");
        } else {
            $search = $this->di->request->getServer("REMOTE_ADDR");
        }

        if (filter_var($search, FILTER_VALIDATE_IP)) {
            $valid = "IP";
            $ipverify = $this->di->get("ipverify");
            $validator = new \Anax\Model\IpValidator((array)$ipverify);
            $res = $validator->getIp($search);

            $lat = $res["lat"];
            $long = $res["long"];
        } else {
            $coordinatesObj = $this->di->get("coordinates");
            $coordinates = new \Anax\Model\Coordinates($coordinatesObj);
            $cord = $coordinates->getCoordinates($search);
            $valid = $cord["valid"];

            $lat = $cord["lat"];
            $long = $cord["long"];
        }

        $weather = $this->di->get("weather-module");
        $geo = new \Anax\Model\GeoTag($weather);

        $when = "";
        $weather = array();
        $temp = array();
        $time = array();

        if ($this->di->request->getGet("when")) {
            $when = $this->di->request->getGet("when");
            if ($when == "past") {
                $res = $geo->getWeatherMultiCurl("past", $lat, $long);
                // $time = $res[0]["currently"]["time"];
                $amount = count($res);

                for ($i = 0; $i < $amount; $i++) {
                    $time[] = (date('Y-m-d', $res[$i]["currently"]["time"]));
                    $weather[] = $res[$i]["currently"]["summary"];
                    $temp[] = round($res[$i]["currently"]["temperature"], 1);
                }
            } else {
                $res = $geo->getWeatherMultiCurl("future", $lat, $long);
                $amount = count($res);

                for ($i = 0; $i < $amount; $i++) {
                    $time[] = (date('Y-m-d', $res[$i]["currently"]["time"]));
                    $weather[] = $res[$i]["currently"]["summary"];
                    $temp[] = round($res[$i]["currently"]["temperature"], 1);
                }
            }
        }

        $data = [
            "search" => $search,
            "valid" => $valid,
            "lat" => $lat,
            "long" => $long,
            "time" => $time,
            "weather" => $weather,
            "temp" => $temp,
            "when" => $when
        ];

        $page->add("geoTag/main", $data);
        return $page->render();
    }
}
