<?php

namespace WatsonSdkPhp\Tests;

use PHPUnit_Framework_TestCase;
use WatsonSdkPhp\Exceptions\WatsonGeneralException;
use WatsonSdkPhp\Exceptions\WatsonRequestException;
use WatsonSdkPhp\Sdk\Services\Conversation\V1\WatsonConversationService;
use WatsonSdkPhp\Sdk\Classes\Conversation\V1\WatsonConversation;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class GenericTest extends PHPUnit_Framework_TestCase {

    // To test you need to set here a valid credentials

	/** @var null|WatsonConversationService */
	protected $conversationService;
	/** @var null|WatsonConversation */
    protected $conversation;
    /** @var null|array */
    protected $settings;

    protected function setUp () {
        $this->settings = $this->getConfiguration();
        if (!isset($this->settings)) {
            echo "Need a settings.ini on test directory with the 'watson_username', 'watson_password' and" .
                "'watson_workspace_id'";
            exit(1);
        }

		$this->conversationService = new WatsonConversationService(
            $this->settings["watson_username"],
            $this->settings["watson_password"],
            $this->settings["watson_workspace_id"]
        );
		$this->conversation = $this->conversationService->createConversation();
	}

	private function getConfiguration () {
        try {
            $settings = parse_ini_file("settings.ini");
        } catch (\Exception $exception) {
            $settings = null;
        }

        return (
            !isset($settings) ||
            !array_key_exists("watson_username", $settings) ||
            !array_key_exists("watson_password", $settings) ||
            !array_key_exists("watson_workspace_id", $settings)
        ) ? null : $settings;
    }

    public function testGeneric () {
        //
    }

    public function testConversationClass () {
        $this->conversation->say("Hi!", array("name" => "Abilio"));
        $this->conversation->say("aabilio");
        $this->assertEquals(
            "Cuándo naciste",
            $this->conversation->getTextResponse()[0]
        );
    }

	public function testConversationWorkspaceExistence () {
        $this->assertTrue($this->conversationService->validateWorkspaceId($this->settings["watson_workspace_id"]));
    }

    public function testConversationSuccessOnGetMethodUrl () {
        $this->assertEquals(
            "/workspaces/".$this->settings["watson_workspace_id"],
            $this->conversationService->getMethodUrl("GET_WORKSPACE", array(
                "workspaceId" => $this->settings["watson_workspace_id"]
            ))
        );
    }

    public function testConversationErrorOnGetMethodUrl () {
        $this->setExpectedException(WatsonGeneralException::class, "Invalid method name");
        $this->conversationService->getMethodUrl("GET_WORLD");
    }

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

    public function testConversationMessageEndpoint () {
        try {
            $response = $this->conversationService->sendMessage("Hi!");
            $this->assertArrayHasKey("input", $response);
        } catch (WatsonRequestException $exception) {
            $this->fail($exception->getMessage());
        }
    }
}