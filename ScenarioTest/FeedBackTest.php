<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/3/27
 * Time: 14:10
 */

class FeedBackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;

    private $testTitle;
    private $testContent;
    private $testErrorTitle;
    private $testErrorContent;

    protected $loginUrl = 'https://cse-devel.uta.edu/MavAppoint2/?c=bG9naW4=';

    public function setUp()
    {
        $this->webDriver = RemoteWebDriver::create('http://localhost:9515', DesiredCapabilities::chrome());

        $this->testTitle = "Feedback Title ".time();
        $this->testContent = "Feedback Content ".time();
        $this->testErrorTitle =  'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $this->testErrorContent =  'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
            .'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
    }

    public function testSubmitFeedback()
    {
        $this->webDriver->get($this->loginUrl);

        $emailField = $this->webDriver->findElement(WebDriverBy::id('email'));
        $emailField->click();
        $this->webDriver->getKeyboard()->sendKeys('zhangjw.uta@gmail.com');

        $passwordField = $this->webDriver->findElement(WebDriverBy::id('password'));
        $passwordField->click();
        $this->webDriver->getKeyboard()->sendKeys('password');

        $signField = $this->webDriver->findElement(WebDriverBy::id('signIn'));
        $signField->click();

        $this->assertEquals("https://cse-devel.uta.edu/MavAppoint2/?c=aW5kZXg=", $this->webDriver->getCurrentURL());

        $feedbackBtn = $this->webDriver->findElement(WebDriverBy::id('btn_feedback'));
        $feedbackBtn->click();

        $feedbackTypeSelector = new WebDriverSelect(
            $this->webDriver->findElement(WebDriverBy::id('drp_feedback_type')));
        $feedbackTypeSelector->selectByIndex(1);

        $feedbackAdvisorSelector = new WebDriverSelect(
            $this->webDriver->findElement(WebDriverBy::id('drp_feedback_advisor')));
        $feedbackAdvisorSelector->selectByIndex(3);

        //Case1
        $submitBtn = $this->webDriver->findElement(WebDriverBy::id('button_feedback_submit'));
        $submitBtn->click();

        $resultField = $this->webDriver->findElement(WebDriverBy::id('feedback_loading_text'));
        $this->assertEquals("Title or content cannot be null", $resultField->getText());

        //Case2
        $titleField = $this->webDriver->findElement(WebDriverBy::id('feedback_title'));
        $titleField->click();
        $this->webDriver->getKeyboard()->sendKeys($this->testTitle);

        $commentField = $this->webDriver->findElement(WebDriverBy::id('feedback_comment'));
        $commentField->click();
        $this->webDriver->getKeyboard()->sendKeys($this->testContent);

        $submitBtn->click();

        sleep(2);
        $this->assertEquals("Success", $resultField->getText());

        //$this->webDriver->findElement(WebDriverBy::id('button_feedback_cancel'))->click();
        //$this->webDriver->findElement(WebDriverBy::id('a_setting'))->click();
        //$this->webDriver->findElement(WebDriverBy::id('a_logout'))->click();
    }

    public function testResponseFeedback()
    {
        $this->webDriver->get($this->loginUrl);

        $emailField = $this->webDriver->findElement(WebDriverBy::id('email'));
        $emailField->click();
        $this->webDriver->getKeyboard()->sendKeys('ad3@uta.edu');

        $passwordField = $this->webDriver->findElement(WebDriverBy::id('password'));
        $passwordField->click();
        $this->webDriver->getKeyboard()->sendKeys('password');

        $signField = $this->webDriver->findElement(WebDriverBy::id('signIn'));
        $signField->click();

        $this->assertEquals("https://cse-devel.uta.edu/MavAppoint2/?c=aW5kZXg=", $this->webDriver->getCurrentURL());

        $feedbackBtn = $this->webDriver->findElement(WebDriverBy::linkText("Feedback"));
        $feedbackBtn->click();

        $feedbackReplyBtn = $this->webDriver->findElement(WebDriverBy::id('feedback_reply_button0'));
        $feedbackReplyBtn->click();

        //Case1
        /*$submitBtn = $this->webDriver->findElement(WebDriverBy::id('button_feedback_reply_submit'));
        $submitBtn->click();
        $resultField = $this->webDriver->findElement(WebDriverBy::id('feedback_reply_loading_text'));
        $this->assertEquals("Title or content cannot be null", $resultField->getText());*/

        //Case2
        $replyField = $this->webDriver->findElement(WebDriverBy::id('feedback_reply_comment'));
        $replyField->click();
        $this->webDriver->getKeyboard()->sendKeys('Reply contnet');

        $submitBtn = $this->webDriver->findElement(WebDriverBy::id('button_feedback_reply_submit'));
        $submitBtn->click();

        sleep(4);

        $resultField = $this->webDriver->findElement(WebDriverBy::id('feedback_reply_loading_text'));
        $this->assertEquals("Success", $resultField->getText());

        //$this->webDriver->findElement(WebDriverBy::id('button_feedback_reply_cancel'))->click();
    }

    public function tearDown()
    {
        $this->webDriver->close();
    }
}
