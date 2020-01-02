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
        if (isset($_GET['submit'])) {
            $search = $this->di->request->getGet("search");
        } else {
            $search = $this->di->request->getServer("REMOTE_ADDR");
        }

        if (filter_var($search, FILTER_VALIDATE_IP)) {
            $valid = "IP";
            $validator = new \Anax\Model\IpValidator;
            $res = $validator->toJson($search);

            $lat = $res["lat"];
            $long = $res["long"];
        } else {
            $coordinates = new \Anax\Model\Coordinates;
            $cord = $coordinates->getCoordinates($search);
            $valid = $cord["valid"];

            $lat = $cord["lat"];
            $long = $cord["long"];
        }

        $geo = new \Anax\Model\GeoTag;

        $when = "";
        $weather = array();
        $temp = array();
        $time = array();

        if (isset($_GET["when"])) {
            $when = $_GET["when"];
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
