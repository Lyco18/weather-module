<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "ipverify" => [
            // Is the service shared, true or false
            // Optional, default is true
            "shared" => true,

            // Callback executed when service is activated
            // Create the service, load its configuration (if any)
            // and set it up.
            "callback" => function () {
                $cfg = $this->get("configuration");
                $config = $cfg->load("api.php");
                $res = new \Anax\Model\IpValidator($config["config"]["ipstack"]["key"]);
                return $res;
            }
        ],
    ],
];
