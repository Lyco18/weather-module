<?php

namespace Anax\Model;

class IpValidator
{
    /**
     *
     * Returns Array[valid, ip, ipv, domain], get used at view.
     *
     */
    public function toJson($ip) : array
    {
        $apiKey = require "../config/api.php";

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $valid = "true";
        } else {
            $valid = "false";
        }

        if ($valid == "true") {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ipv = "Ipv4";
            } else {
                $ipv = "Ipv6";
            }

            $domain = gethostbyaddr($ip);
            $details = json_decode(file_get_contents("http://api.ipstack.com/{$ip}?access_key={$apiKey["ipstack"]["key"]}"));

            $lat = $details->latitude;
            $long = $details->longitude;
            $country = $details->country_name;
            $region = $details->region_name;
            $city = $details->city;

            return [
                "valid" => $valid,
                "ip" => $ip,
                "ipv" => $ipv,
                "domain" => $domain,
                "lat" => $lat,
                "long" => $long,
                "country" => $country,
                "region" => $region,
                "city" => $city
            ];

        } else {
            return [
                "valid" => "Not Valid IP",
                "ip" => null,
                "ipv" => null,
                "domain" => null,
                "lat" => null,
                "long" => null,
                "country" => null,
                "region" => null,
                "city" => null
            ];
        }
    }
}
