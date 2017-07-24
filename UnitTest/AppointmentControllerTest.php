<?php

/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/7/21 0021
 * Time: 16:00
 */
define("ROOT", dirname(dirname(__FILE__)));
include_once ROOT . "/vendor/autoload.php";
include_once ROOT . "/app/Application.php";
include_once ROOT . "/app/Controllers/AppointmentController.php";

class AppointmentControllerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        @session_start();
    }

    public function testShowAppointmentAction()
    {
        //Case1
        $_SESSION['role'] = 'student';
        $_SESSION['email'] = 'st1@uta.edu';
        $appointmentController = new AppointmentController();
        $res = $appointmentController->showAppointmentAction();
        self::assertEquals(0, $res['error']);

        //Case1
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $appointmentController = new AppointmentController();
        $res = $appointmentController->showAppointmentAction();
        self::assertEquals(0, $res['error']);

        //Case1
        $_SESSION['role'] = 'admin';
        $_SESSION['email'] = 'admin@uta.edu';
        $appointmentController = new AppointmentController();
        $res = $appointmentController->showAppointmentAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_SESSION['role'] = '';
        $_SESSION['email'] = 'test@uta.edu';
        $appointmentController = new AppointmentController();
        $res = $appointmentController->showAppointmentAction();
        self::assertEquals(1, $res['error']);

        //Case4
        $_SESSION['role'] = '';
        $_SESSION['email'] = '111111';
        $appointmentController = new AppointmentController();
        $res = $appointmentController->showAppointmentAction();
        self::assertEquals(1, $res['error']);
    }

    public function testMakeAppointmentAction(){
        $_SESSION['role'] = 'student';
        $_SESSION['email'] = 'st1@uta.edu';
        $_REQUEST["phoneNumber"] = "6822486367";
        $_REQUEST["email"] = "st1@uta.edu";
        $_REQUEST["description"] = "";

        //Case1
        $_REQUEST["studentId"] = "11111111";
        $_REQUEST['appointmentType'] = "Other";
        $_REQUEST['pName'] = "Lin Gao";
        $_REQUEST['start'] = "Tue Feb 20 2018 04:40:00 GMT+0000";
        $_REQUEST['duration'] = "10";
        $appointmentController = new AppointmentController();
        $res = $appointmentController->makeAppointmentAction();
        self::assertEquals(1, $res['error']);

        //Case2
        $_REQUEST["studentId"] = "1001455617";
        $_REQUEST['appointmentType'] = "Other";
        $_REQUEST['pName'] = "Lin Gao";
        $_REQUEST['start'] = "Tue Feb 20 2018 04:90:00 GMT+0000";
        $_REQUEST['duration'] = "10";
        $appointmentController = new AppointmentController();
        $res = $appointmentController->makeAppointmentAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_REQUEST["studentId"] = "1001455617";
        $_REQUEST['appointmentType'] = "abc";
        $_REQUEST['pName'] = "Lin Gao";
        $_REQUEST['start'] = "Tue Feb 20 2018 04:20:00 GMT+0000";
        $_REQUEST['duration'] = "10";
        $appointmentController = new AppointmentController();
        $res = $appointmentController->makeAppointmentAction();
        self::assertEquals(1, $res['error']);

        //Case4
        $_REQUEST["studentId"] = "1001455617";
        $_REQUEST['appointmentType'] = "Add Course";
        $_REQUEST['pName'] = "Lin Gao";
        $_REQUEST['start'] = "Tue Feb 20 2018 04:20:00 GMT+0000";
        $_REQUEST['duration'] = "10";
        $appointmentController = new AppointmentController();
        $res = $appointmentController->makeAppointmentAction();
        self::assertEquals(0, $res['error']);
    }

    public function testCancelAppointmentAction(){
        $_SESSION['role'] = 'student';
        $_SESSION['email'] = 'st1@uta.edu';
        $_REQUEST['cancellationReason'] = 'Reason';

        //Case1
        $_REQUEST["appointmentId"] = "962";
        $appointmentController = new AppointmentController();
        $res = $appointmentController->cancelAppointmentAction();
        self::assertEquals(0, $res['error']);

        //Case2
        $_REQUEST["appointmentId"] = "1";
        $appointmentController = new AppointmentController();
        $res = $appointmentController->cancelAppointmentAction();
        self::assertEquals(1, $res['error']);
    }

    public function testShowCanceledAppointmentAction(){
        //Case1
        $_SESSION['role'] = 'student';
        $_SESSION['email'] = 'st1@uta.edu';
        $appointmentController = new AppointmentController();
        $res = $appointmentController->showAppointmentAction();
        self::assertEquals(0, $res['error']);

        //Case1
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $appointmentController = new AppointmentController();
        $res = $appointmentController->showCanceledAppointmentAction();
        self::assertEquals(0, $res['error']);

        //Case1
        $_SESSION['role'] = 'admin';
        $_SESSION['email'] = 'admin@uta.edu';
        $appointmentController = new AppointmentController();
        $res = $appointmentController->showCanceledAppointmentAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_SESSION['role'] = '';
        $_SESSION['email'] = 'test@uta.edu';
        $appointmentController = new AppointmentController();
        $res = $appointmentController->showCanceledAppointmentAction();
        self::assertEquals(1, $res['error']);

        //Case4
        $_SESSION['role'] = '';
        $_SESSION['email'] = '111111';
        $appointmentController = new AppointmentController();
        $res = $appointmentController->showCanceledAppointmentAction();
        self::assertEquals(1, $res['error']);
    }

    protected function tearDown()
    {
        @session_destroy();
    }
}