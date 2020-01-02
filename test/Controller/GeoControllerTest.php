<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
/**
 * Test the SampleController.
 */
class GeoControllerTest extends TestCase
{
    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $controller = new GeoController();
        $controller->setDI($di);

        //test controller index action IP address
        $this->di->get("request")->setGet("search", "8.8.8.8");
        $this->di->get("request")->setGet("when", "past");
        $this->di->get("request")->setGet("submit", "Check Weather");
        $res = $controller->indexAction();

        // assertions
        $this->assertIsObject($res);
    }
}
