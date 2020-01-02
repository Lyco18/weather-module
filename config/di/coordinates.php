<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "coordinates" => [
            // Is the service shared, true or false
            // Optional, default is true
            "shared" => true,

            // Is the service activated by default, true or false
            // Optional, default is false
            "active" => false,

            // Callback executed when service is activated
            // Create the service, load its configuration (if any)
            // and set it up.
            "callback" => function () {
                $cfg = $this->get("configuration");
                $config = $cfg->load("api.php");
                $coordinates = new \Anax\Model\Coordinates($config["config"]["opencage"]);
                return $coordinates;
            }
        ],
    ],
];
