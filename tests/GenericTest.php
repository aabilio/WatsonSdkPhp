<?php

namespace WatsonSdkPhp\Tests;

use PHPUnit_Framework_TestCase;
use WatsonSdkPhp\Exceptions\WatsonGeneralException;
use WatsonSdkPhp\Exceptions\WatsonRequestException;
use WatsonSdkPhp\Factories\WatsonFactory;
use WatsonSdkPhp\Services\Conversation\V1\WatsonConversationService;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class GenericTest extends PHPUnit_Framework_TestCase {

    /** @var null|WatsonConversationService */
	protected $conversationService;
    /** @var boolean */
    protected $settingsSuccess;
    /** @var null|array */
    protected $settings;

    protected function setUp () {
        list($this->settingsSuccess, $this->settings) = $this->settings = $this->getConfiguration();

        $watsonFactory = new WatsonFactory($this->settings["watson_username"], $this->settings["watson_password"]);
        if ($this->settingsSuccess) {
            $this->conversationService = $watsonFactory
                ->createConversationServiceV1($this->settings["watson_workspace_id"]);
        } else {
            $this->conversationService = new
                WatsonConversationService($this->settings["watson_username"], $this->settings["watson_password"]);
        }
	}

    /**
     * Get the configuration from settings.ini file or set generic invalid credentials
     *
     * @return array ($success, $settings)
     */
	private function getConfiguration () {
        $success = true;
        $settings = array(
            "watson_username" => "X",
            "watson_password" => "Y",
            "watson_workspace_id" => "Z"
        );
        try {
            $settings = parse_ini_file("settings.ini");
        } catch (\Exception $exception) {
            $success = false;
        }

        return array($success, $settings);
    }

    /**
     * Test validateWorkspaceId method from Watson Conversation Service
     */
	public function testConversationWorkspaceExistence () {
        if ($this->settingsSuccess) {
            $this->assertTrue($this->conversationService->validateWorkspaceId($this->settings["watson_workspace_id"]));
        } else {
            $this->assertFalse($this->conversationService->validateWorkspaceId($this->settings["watson_workspace_id"]));
        }
    }

    /**
     * Test success call to getMethodUrl method from Watson Conversation Service
     */
    public function testConversationSuccessOnGetMethodUrl () {
        $this->assertEquals(
            "/workspaces/".$this->settings["watson_workspace_id"],
            $this->conversationService->getMethodUrl("GET_WORKSPACE", array(
                "workspaceId" => $this->settings["watson_workspace_id"]
            ))
        );
    }

    /**
     * Test fail call to getMethodUrl method from Watson Conversation Service
     */
    public function testConversationErrorOnGetMethodUrl () {
        $this->setExpectedException(WatsonGeneralException::class, "Invalid method name");
        $this->conversationService->getMethodUrl("GET_WORLD");
    }

    /**
     * Test buildMessage method from Watson Conversation Service with and without context as a paramenter
     */
    public function testConversationBuildMessage () {
        $textMessage = "Hi!";
        $context = array("a" => "b");
        $msgWithoutContext = array("input" => array("text" => $textMessage));
        $msgWithContext = array("input" => array("text" => $textMessage), "context" => $context);

        $this->assertEquals(
            $msgWithoutContext,
            $this->conversationService->buildMessage($textMessage)
        );
        $this->assertEquals(
            $msgWithContext,
            $this->conversationService->buildMessage($textMessage, $context)
        );
    }

    /**
     * Test sendMessage method from Watson Conversation Service
     */
    public function testConversationMessageEndpoint () {
        if ($this->settingsSuccess) {
            try {
                $conversation = $this->conversationService->sendMessage("Hi!");
                $this->assertArrayHasKey("input", $conversation->getRaw());
            } catch (WatsonRequestException $exception) {
                $this->fail($exception->getMessage());
            }
        } else {
            $this->setExpectedException(WatsonRequestException::class);
            $conversation = $this->conversationService->sendMessage("Hi!");
        }
    }
}