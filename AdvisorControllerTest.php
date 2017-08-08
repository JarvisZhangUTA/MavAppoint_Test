<?php
define("ROOT", dirname(dirname(__FILE__)));
include_once ROOT . "/vendor/autoload.php";
include_once ROOT . "/app/Application.php";
include_once ROOT . "/app/Controllers/AdvisorController.php";


class AdvisorControllerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        @session_start();
    }

    public function test__construct_TestCase1(){
        $advisorController = new AdvisorController();
        self::assertEquals(array(), $_SESSION);
    }

    public function testShowScheduleAction_TestCase1()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $advisorController = new AdvisorController();
        $res = $advisorController->showScheduleAction();
        self::assertEquals(0, $res['error']);
    }

    public function testAddTimeSlotAction_TestCase1()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['opendate'] = '2017-08-10';
        $_POST['starttime'] = '07:00';
        $_POST['endtime'] = '09:00';
        $_POST['repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->addTimeSlotAction();

        self::assertEquals(0, $res['error']);
    }


    public function testAddTimeSlotAction_TestCase2()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['opendate'] = '2017-08-10';
        $_POST['starttime'] = '';
        $_POST['endtime'] = '09:00';
        $_POST['repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->addTimeSlotAction();
        self::assertEquals(1, $res['error']);
    }
    public function testAddTimeSlotAction_TestCase3()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['opendate'] = '2017-08-10';
        $_POST['starttime'] = '07:00';
        $_POST['endtime'] = '';
        $_POST['repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->addTimeSlotAction();
        self::assertEquals(1, $res['error']);
    }
    public function testAddTimeSlotAction_TestCase4()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['opendate'] = '';
        $_POST['starttime'] = '07:00';
        $_POST['endtime'] = '09:00';
        $_POST['repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->addTimeSlotAction();
        self::assertEquals(1, $res['error']);
    }
    public function testAddTimeSlotAction_TestCase5()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['opendate'] = '2017-08-10';
        $_POST['starttime'] = '11:00';
        $_POST['endtime'] = '09:00';
        $_POST['repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->addTimeSlotAction();
        self::assertEquals(1, $res['error']);
    }
    public function testAddTimeSlotAction_TestCase6()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['opendate'] = '2017-08-01';
        $_POST['starttime'] = '07:00';
        $_POST['endtime'] = '09:00';
        $_POST['repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->addTimeSlotAction();
        self::assertEquals(1, $res['error']);
    }
    public function testAddTimeSlotAction_TestCase7()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['opendate'] = '2017-08-11';
        $_POST['starttime'] = '07:00';
        $_POST['endtime'] = '09:00';
        $_POST['repeat'] = 1;
        $advisorController = new AdvisorController();
        $res = $advisorController->addTimeSlotAction();
        self::assertEquals(0, $res['error']);
    }
    public function testAddTimeSlotAction_TestCase8()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '1030';
        $_POST['opendate'] = '2017-08-10';
        $_POST['starttime'] = '07:00';
        $_POST['endtime'] = '09:00';
        $_POST['repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->addTimeSlotAction();
        self::assertEquals(1, $res['error']);
    }
    public function testAddTimeSlotAction_TestCase9()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['opendate'] = '2017-08-17';
        $_POST['starttime'] = '07:00';
        $_POST['endtime'] = '09:00';
        $_POST['repeat'] = '1';
        $advisorController = new AdvisorController();
        $res = $advisorController->addTimeSlotAction();
        self::assertEquals(0, $res['error']);
    }

    public function testDeleteTimeSlotAction_TestCase1()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['StartTime2'] = '07:00';
        $_POST['EndTime2'] = '09:00';
        $_POST['Date'] = '2017-08-10';
        $_POST['delete_reason'] = 'test';
        $_POST['delete_repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->deleteTimeSlotAction();

        self::assertEquals(0, $res['error']);
    }
    public function testDeleteTimeSlotAction_TestCase2()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['StartTime2'] = '07:00:00';
        $_POST['EndTime2'] = '09:00:00';
        $_POST['Date'] = '2017-08-17';
        $_POST['delete_reason'] = 'test';
        $_POST['delete_repeat'] = 1;
        $advisorController = new AdvisorController();
        $res = $advisorController->deleteTimeSlotAction();

        self::assertEquals(0, $res['error']);
    }

    public function testDeleteTimeSlotAction_TestCase3()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['StartTime2'] = '';
        $_POST['EndTime2'] = '09:00';
        $_POST['Date'] = '2017-08-11';
        $_POST['delete_reason'] = 'test';
        $_POST['delete_repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->deleteTimeSlotAction();

        self::assertEquals(1, $res['error']);
    }
    public function testDeleteTimeSlotAction_TestCase4()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['StartTime2'] = '07:00';
        $_POST['EndTime2'] = '09:00';
        $_POST['Date'] = '2017-08-11';
        $_POST['delete_reason'] = '';
        $_POST['delete_repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->deleteTimeSlotAction();

        self::assertEquals(1, $res['error']);
    }
    public function testDeleteTimeSlotAction_TestCase5()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['StartTime2'] = '07:00';
        $_POST['EndTime2'] = '09:00';
        $_POST['Date'] = '2017-08-11';
        $_POST['delete_reason'] = 'test';
        $_POST['delete_repeat'] = 1;
        $advisorController = new AdvisorController();
        $res = $advisorController->deleteTimeSlotAction();

        self::assertEquals(0, $res['error']);
    }

    public function testDeleteTimeSlotAction_TestCase6()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['StartTime2'] = '07:00';
        $_POST['EndTime2'] = '09:00';
        $_POST['Date'] = '2017-08-15';
        $_POST['delete_reason'] = 'test';
        $_POST['delete_repeat'] = 0;
        $advisorController = new AdvisorController();
        $res = $advisorController->deleteTimeSlotAction();

        self::assertEquals(0, $res['error']);
    }


    public function testGetStartAndEndTimeOfOriginalTimeSlotAction_TestCase1()
    {
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $_SESSION['uid'] = '103';
        $_POST['subStartTime'] = '07:10:00';
        $_POST['subEndTime'] = '07:20:00';
        $_POST['date'] = '2017-08-22';
        $advisorController = new AdvisorController();
        $res = $advisorController->getStartAndEndTimeOfOriginalTimeSlotAction();

        self::assertEquals(0, $res['error']);
    }

    public function testSuccessAction_TestCase1()
    {
        $_REQUEST['nc'] = "ControllerName";
        $_REQUEST['na'] = "ActionName";
        $_SERVER['REQUEST_URI'] = "http://mavappoint3.sites.dev/MavAppoint/?c=controller=&a=action";
        $_SERVER['HTTP_HOST'] = "";
        $advisorController = new AdvisorController();
        $res = $advisorController->successAction();
        self::assertEquals(0, $res['error']);
    }


    protected function tearDown()
    {
        @session_destroy();
    }
}