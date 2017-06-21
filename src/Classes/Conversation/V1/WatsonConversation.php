<?php

namespace WatsonSdkPhp\Classes\Conversation\V1;

use WatsonSdkPhp\Exceptions\WatsonRequestException;
use WatsonSdkPhp\Services\Conversation\V1\WatsonConversationService;

class WatsonConversation {

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
    /** @var array */
    private $raw;

    /**
     * WatsonConversation constructor.
     *
     * @param array $data
     *
     */
    public function __construct ($data) {
        $this->textResponse = $data["output"]["text"];
        $this->intents = $data["intents"];
        $this->entities = $data["entities"];
        $this->context = $data["context"];
        $this->input = $data["input"];
        $this->output = $data["output"];
        $this->raw = $data;
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

    /**
     * Get conversation input
     * @return null|array
     */
    public function getInput () {
        return $this->input;
    }

    /**
     * Get conversation output
     *
     * @return null|array
     */
    public function getOutput () {
        return $this->output;
    }

    /**
     * Get conversation intent
     *
     * @return null|array
     */
    public function getIntents () {
        return $this->intents;
    }

    /**
     * Get conversation entities
     *
     * @return null|array
     */
    public function getEntities () {
        return $this->entities;
    }

    /**
     * Get conversation text response
     *
     * @return null|array
     */
    public function getTextResponse () {
        return $this->textResponse;
    }

    /**
     * Get raw response
     *
     * @return array
     */
    public function getRaw()
    {
        return $this->raw;
    }

}