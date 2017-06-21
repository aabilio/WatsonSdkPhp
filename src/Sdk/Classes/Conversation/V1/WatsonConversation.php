<?php

namespace WatsonSdkPhp\Sdk\Classes\Conversation\V1;

use WatsonSdkPhp\Exceptions\WatsonRequestException;
use WatsonSdkPhp\Sdk\Services\Conversation\V1\WatsonConversationService;

class WatsonConversation {

    /** @var WatsonConversationService */
    private $conversationService;
    /** @var array */
    private $context;
    /** @var array */
    private $textResponse;
    /** @var array */
    private $intents;
    /** @var array */
    private $entities;
    /** @var array */
    private $input;
    /** @var array */
    private $output;

    public function __construct (WatsonConversationService $conversationService) {
        $this->conversationService = $conversationService;
    }

    /**
     * Get context
     *
     * @return null|array
     */
    public function getContext () {
        return $this->context;
    }

    /**
     * Set context
     *
     * @param null|array $context
     *
     * @return $this
     */
    public function setContext ($context = null) {
        $this->context = $context;
        return $this;
    }

    public function getInput () {
        return $this->input;
    }
    public function getOutput () {
        return $this->output;
    }
    public function getIntents () {
        return $this->intents;
    }
    public function getEntities () {
        return $this->entities;
    }
    public function getTextResponse () {
        return $this->textResponse;
    }

    /**
     * Talk to Watson using the context
     *
     * @param string $message
     * @param null|array $context
     *
     * @return array
     * @throws WatsonRequestException
     */
    public function say ($message, $context = null) {
        if (isset($context)) {
            $this->context = $context;
        }

        $response = $this->conversationService->sendMessage($message, $this->context);
        $this->textResponse = $response["output"]["text"];
        $this->intents = $response["intents"];
        $this->entities = $response["entities"];
        $this->context = $response["context"];
        $this->input = $response["input"];
        $this->output = $response["output"];

        return $response;
    }

    /**
     * Init Watson Conversation.
     * It seems that IBM do not provide a simple way to start the conversation with the bot,
     * so here we send an empty message to start the conversation. At the same time it can
     * be used to set the initial context for the conversation.
     *
     * @param null|array $context
     *
     * @return array
     * @throws WatsonRequestException
     */
    public function initConversation ($context) {
        if (isset($context)) { $this->context = $context; }
        return $this->say("", $context);
    }


}