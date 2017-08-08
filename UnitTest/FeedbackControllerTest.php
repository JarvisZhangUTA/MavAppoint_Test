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
include_once ROOT . "/app/Models/db/DatabaseManager.php";

class FeedbackControllerTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        @session_start();
    }

    public function testGetFeedbackAdvisorAction(){
        $_SERVER['REQUEST_URI'] = "/MavAppoint_test/";
        $_SERVER['HTTP_HOST'] = "localhost";

        $feedbackController = new FeedbackController();
        $res = $feedbackController->getFeedbackAdvisorAction();
        self::assertEquals(1, $res['error']);

        $_SESSION['email'] = 'st1@uta.edu';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->getFeedbackAdvisorAction();
        self::assertEquals(0, $res['error']);
    }

    public function testGetFeedbackAction(){
        $_SERVER['REQUEST_URI'] = "/MavAppoint_test/";
        $_SERVER['HTTP_HOST'] = "localhost";

        //Case1
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad1@uta.edu';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->getFeedbackAction();
        self::assertEquals(0, $res['error']);

        //Case1
        $_SESSION['role'] = 'admin';
        $_SESSION['email'] = 'admin@uta.edu';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->getFeedbackAction();
        self::assertEquals(0, $res['error']);

        //Case2
        $_SESSION['role'] = 'student';
        $_SESSION['email'] = 'st1@uta.edu';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->getFeedbackAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_SESSION['role'] = '';
        $_SESSION['email'] = '111111';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->getFeedbackAction();
        self::assertEquals(1, $res['error']);
    }

    public function testAddFeedbackAction(){
        //Case1
        $_SESSION['uid'] = '414';
        $_REQUEST['tid'] = '103';
        $_REQUEST['type'] = 'advisor';
        $_REQUEST['title'] = 'title';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->addFeedbackAction();
        self::assertEquals(0, $res['error']);

        $_SESSION['uid'] = '414';
        $_REQUEST['tid'] = '200';
        $_REQUEST['type'] = 'system';
        $_REQUEST['title'] = 'title';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->addFeedbackAction();
        self::assertEquals(0, $res['error']);

        //Case2
        $_SESSION['uid'] = '414';
        $_REQUEST['tid'] = '';
        $_REQUEST['type'] = 'system';
        $_REQUEST['title'] = 'title';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->addFeedbackAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_SESSION['uid'] = '';
        $_REQUEST['tid'] = '103';
        $_REQUEST['type'] = 'advisor';
        $_REQUEST['title'] = 'title';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->addFeedbackAction();
        self::assertEquals(1, $res['error']);

        //Case4
        $_SESSION['uid'] = '414';
        $_REQUEST['tid'] = '103';
        $_REQUEST['type'] = 'advisor';
        $_REQUEST['title'] = '';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->addFeedbackAction();
        self::assertEquals(1, $res['error']);

        //Case5
        $_SESSION['uid'] = '414';
        $_REQUEST['tid'] = '103';
        $_REQUEST['type'] = 'advisor';
        $_REQUEST['title'] = 'title';
        $_REQUEST['content'] = '';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->addFeedbackAction();
        self::assertEquals(1, $res['error']);

        //Case6
        $_SESSION['uid'] = '414';
        $_REQUEST['tid'] = '103';
        $_REQUEST['type'] = 'advisor';
        $_REQUEST['title'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->addFeedbackAction();
        self::assertEquals(1, $res['error']);
    }

    public function testReplyFeedbackAction(){
        $databaseManager = new DatabaseManager();
        $databaseManager->updateFeedBack('1',0);
        $databaseManager->updateFeedBack('2',0);

        //Case2
        $_REQUEST['fid'] = '2';
        $_REQUEST['uid'] = '';
        $_SESSION['role'] = '';
        $_SESSION['email'] = '';

        $_REQUEST['title'] = 'title';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->replyFeedbackAction();
        self::assertEquals(1, $res['error']);

        //Case2
        $_REQUEST['fid'] = '2';
        $_REQUEST['uid'] = '103';
        $_SESSION['role'] = 'asd';
        $_SESSION['email'] = 'asd';

        $_REQUEST['title'] = 'title';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->replyFeedbackAction();
        self::assertEquals(1, $res['error']);

        //Case1
        $_REQUEST['fid'] = '1';
        $_REQUEST['uid'] = '300';
        $_SESSION['role'] = 'admin';

        $_REQUEST['title'] = 'title';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->replyFeedbackAction();
        self::assertEquals(0, $res['error']);

        //Case1
        $_REQUEST['fid'] = '2';
        $_REQUEST['uid'] = '103';
        $_SESSION['role'] = 'advisor';
        $_SESSION['email'] = 'ad3@uta.edu';

        $_REQUEST['title'] = 'title';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->replyFeedbackAction();
        self::assertEquals(0, $res['error']);

        //Case3
        $_REQUEST['title'] = '';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->replyFeedbackAction();
        self::assertEquals(1, $res['error']);

        //Case4
        $_REQUEST['title'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $_REQUEST['content'] = 'content';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->replyFeedbackAction();
        self::assertEquals(1, $res['error']);

        //Case3
        $_REQUEST['title'] = 'title';
        $_REQUEST['content'] = '';
        $feedbackController = new FeedbackController();
        $res = $feedbackController->replyFeedbackAction();
        self::assertEquals(1, $res['error']);
    }

    protected function tearDown()
    {
        @session_destroy();
    }
}