<?php

define("ROOT", dirname(dirname(__FILE__)));
//include_once ROOT . "/vendor/autoload.php";
include_once ROOT . "/app/Application.php";
include_once ROOT . "/app/Controllers/AdvisingController.php";

class AdvisingControllerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        @session_start();
        date_default_timezone_set("America/Chicago");
    }

    public function testGetAdvisingInfoAction() {

        //Case 1: Bachelor
        $_SESSION['email'] = 'st1@gmail.com';
        $advisingController = new AdvisingController();
        $res = $advisingController->getAdvisingInfoAction();
        self::assertEquals(0, $res['error']);

        //Case 2: Master
        $_SESSION['email'] = 'zhouxu.long@mavs.uta.edu';
        $advisingController = new AdvisingController();
        $res = $advisingController->getAdvisingInfoAction();
        self::assertEquals(0, $res['error']);

        //Case 3: Doctor
        $_SESSION['email'] = 'st2@gmail.com';
        $advisingController = new AdvisingController();
        $res = $advisingController->getAdvisingInfoAction();
        self::assertEquals(0, $res['error']);

        //Case 4: With an advisor name
        $_SESSION['email'] = 'zhouxu.long@mavs.uta.edu';
        $_REQUEST['pName'] = 'Lin Gao';
        $advisingController = new AdvisingController();
        $res = $advisingController->getAdvisingInfoAction();
        self::assertEquals(0, $res['error']);






        $_SESSION['role'] = 'student';
        $_REQUEST['id1'] = '0';
        $_REQUEST['pname'] = 'Lin Gao';
        $advisingController = new AdvisingController();
        $res = $advisingController->scheduleAction();
        self::assertEquals(0, $res['error']);



        $_REQUEST['nc'] = 'advising';
        $_REQUEST['na'] = 'getAdvisingInfo';
        $_SERVER['HTTP_HOST'] = "";
        $_SERVER['REQUEST_URI'] = 'http://localhost/MavAppoint/?c=YWR2aXNpbmc=&a=Z2V0QWR2aXNpbmdJbmZv';
        $advisingController = new AdvisingController();
        $res = $advisingController->successAction();
        self::assertEquals(0, $res['error']);
    }

    protected function tearDown()
    {
        @session_destroy();
    }
}