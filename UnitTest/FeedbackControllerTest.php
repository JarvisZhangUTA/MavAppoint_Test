<?php

/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/7/23 0023
 * Time: 20:37
 */
define("ROOT", dirname(dirname(__FILE__)));
include_once ROOT . "/vendor/autoload.php";
include_once ROOT . "/app/Application.php";
include_once ROOT . "/app/Controllers/FeedbackController.php";

class FeedbackControllerTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        @session_start();
    }

    public function testGetFeedbackAdvisorAction(){
        $feedbackController = new FeedbackController();
        $res = $feedbackController->getFeedbackAdvisorAction();
        self::assertEquals(1, $res['error']);

        $_SESSION['email'] = 'st1@uta.edu';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->getFeedbackAdvisorAction();
        self::assertEquals(0, $res['error']);
    }

    protected function tearDown()
    {
        @session_destroy();
    }
}