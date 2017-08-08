<?php

define("ROOT", dirname(dirname(__FILE__)));
include_once ROOT . "/vendor/autoload.php";
include_once ROOT . "/app/Application.php";
include_once ROOT . "/app/Controllers/CustomizeSettingController.php";
include_once ROOT . "/app/Models/db/DatabaseManager.php";

class CustomizeSettingControllerTest extends \PHPUnit_Framework_TestCase
{
    public $randStr1 = "FKGKLMESFIHMRCXQWOJOOSUOOCRWHVSFGMBYIDTKZNUGO";
    public $randStr2 = "SIKZHYSADJFPNTPSEYWVGXYSSHHVMVRVPGZUVRPQCPIYD";
    public $randStr3 = "SIKZHYSADJFPNTPSEYWVGXYSSHHVMVRVPGZUVRPQCPIYDSIKZHYSADJFPNTPSEYWVGXYSSHHVMVRVPGZUVRPQCPIYDSIKZHYSADJFPNTPSEYWVGXYSSHHVMVRVPGZUVRPQCPIYD";

    protected function setUp()
    {
        $_SERVER['REQUEST_URI'] = "/MavAppoint_test/";
        $_SERVER['HTTP_HOST'] = "localhost";

        @session_start();
    }

    public function testShowAppointmentTypeAction(){
        //Case1
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $controller = new CustomizeSettingController();
        $res = $controller->showAppointmentTypeAction();
        self::assertEquals(0, $res['error']);

        //Case1
        $_SESSION['role'] = 'student';
        $_SESSION['email'] = 'st1@uta.edu';
        $_SESSION['uid'] = '414';
        $controller = new CustomizeSettingController();
        $res = $controller->showAppointmentTypeAction();
        self::assertEquals(0, $res['error']);

        //Case2
        $_SESSION['role'] = 'admin';
        $_SESSION['email'] = 'admin@uta.edu';
        $_SESSION['uid'] = '65';
        $controller = new CustomizeSettingController();
        $res = $controller->showAppointmentTypeAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_SESSION['role'] = '';
        $_SESSION['email'] = '111111';
        $_SESSION['uid'] = '65';
        $controller = new CustomizeSettingController();
        $res = $controller->showAppointmentTypeAction();
        self::assertEquals(1, $res['error']);

        //Case4
        $_SESSION['role'] = '';
        $_SESSION['email'] = 'test@uta.edu';
        $_SESSION['uid'] = '65';
        $controller = new CustomizeSettingController();
        $res = $controller->showAppointmentTypeAction();
        self::assertEquals(1, $res['error']);
    }

    public function testCutOffTimeAction(){
        //Case1
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_REQUEST['cutOffTime'] = '1';
        $controller = new CustomizeSettingController();
        $res = $controller->cutOffTimeAction();
        self::assertEquals(0, $res['error']);

        //Case2
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_REQUEST['cutOffTime'] = '-1';
        $controller = new CustomizeSettingController();
        $res = $controller->cutOffTimeAction();
        self::assertEquals(1, $res['error']);
    }

    public function testSetEmailNotificationsAction(){
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';

        $controller = new CustomizeSettingController();

        //Case1
        $_REQUEST['notify'] = 'no';
        $res = $controller->setEmailNotificationsAction();
        self::assertEquals(0, $res['error']);

        //Case2
        $_REQUEST['notify'] = 'no';
        $res = $controller->setEmailNotificationsAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_REQUEST['notify'] = 'yes';
        $res = $controller->setEmailNotificationsAction();
        self::assertEquals(0, $res['error']);
    }

    public function testAddTypeAndDurationAction(){

        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';

        $controller = new CustomizeSettingController();

        //Case1
        $_REQUEST['apptypes'] = $this->randStr1;
        $_REQUEST['minutes'] = 10;
        $res = $controller->addTypeAndDurationAction();
        self::assertEquals(0, $res['error']);

        //Case2
        $_REQUEST['apptypes'] = $this->randStr2;
        $_REQUEST['minutes'] = -1;
        $res = $controller->addTypeAndDurationAction();
        self::assertEquals(1, $res['error']);

        //Case2
        $_REQUEST['apptypes'] = $this->randStr2;
        $_REQUEST['minutes'] = 100000;
        $res = $controller->addTypeAndDurationAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_REQUEST['apptypes'] = $this->randStr3;
        $_REQUEST['minutes'] = 10;
        $res = $controller->addTypeAndDurationAction();
        self::assertEquals(1, $res['error']);

        //Case4
        $_REQUEST['apptypes'] = $this->randStr3;
        $_REQUEST['minutes'] = -1;
        $res = $controller->addTypeAndDurationAction();
        self::assertEquals(1, $res['error']);
    }

    public function testChangeTypeAndDurationAction(){
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';

        $controller = new CustomizeSettingController();

        //Case1
        $_REQUEST['apptypes'] = "Other";
        $_REQUEST['minutes'] = mt_rand(0, 1000);
        $res = $controller->changeTypeAndDurationAction();
        self::assertEquals(0, $res['error']);

        //Case2
        $_REQUEST['apptypes'] = "Other";
        $_REQUEST['minutes'] = -1;
        $res = $controller->changeTypeAndDurationAction();
        self::assertEquals(1, $res['error']);

        //Case2
        $_REQUEST['apptypes'] = "Other";
        $_REQUEST['minutes'] = 100000;
        $res = $controller->changeTypeAndDurationAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_REQUEST['apptypes'] = "";
        $_REQUEST['minutes'] = 10;
        $res = $controller->changeTypeAndDurationAction();
        self::assertEquals(1, $res['error']);

        //Case4
        $_REQUEST['apptypes'] = "";
        $_REQUEST['minutes'] = -1;
        $res = $controller->changeTypeAndDurationAction();
        self::assertEquals(1, $res['error']);
    }

    public function testDeleteTypeAndDurationAction(){
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';

        $controller = new CustomizeSettingController();

        //Case1
        $_REQUEST['apptypes'] = $this->randStr1;
        $_REQUEST['minutes'] = 10;
        $res = $controller->deleteTypeAndDurationAction();
        self::assertEquals(0, $res['error']);

        //Case2
        $_REQUEST['apptypes'] = $this->randStr1;
        $_REQUEST['minutes'] = -1;
        $res = $controller->deleteTypeAndDurationAction();
        self::assertEquals(1, $res['error']);

        //Case2
        $_REQUEST['apptypes'] = $this->randStr2;
        $_REQUEST['minutes'] = 100000;
        $res = $controller->deleteTypeAndDurationAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_REQUEST['apptypes'] = "";
        $_REQUEST['minutes'] = 10;
        $res = $controller->deleteTypeAndDurationAction();
        self::assertEquals(1, $res['error']);

        //Case4
        $_REQUEST['apptypes'] = "";
        $_REQUEST['minutes'] = -1;
        $res = $controller->deleteTypeAndDurationAction();
        self::assertEquals(1, $res['error']);
    }

    public function testSuccessAction(){
        $controller = new CustomizeSettingController();
        $res = $controller->successAction();
        self::assertEquals(0, $res['error']);
    }

    protected function tearDown()
    {
        @session_destroy();
    }
}