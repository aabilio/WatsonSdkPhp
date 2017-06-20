<?php

namespace WatsonSdkPhp\Sdk\Services\Conversation\V1;

use WatsonSdkPhp\Exceptions\WatsonGeneralException;
use WatsonSdkPhp\Exceptions\WatsonRequestException;
use WatsonSdkPhp\Sdk\Classes\Conversation\V1\WatsonConversation;
use WatsonSdkPhp\Sdk\WatsonSdk;

class WatsonConversationService extends WatsonSdk {
    /**
     * Base url for the service
     *
     * @var string
     */
    protected $url = "https://gateway.watsonplatform.net/conversation/api/";
    /**
     * API service version
     *
     * @var string
     */
    protected $version = 'v1';
    /**
     * API Date service version
     *
     * @var string
     */
    protected $dateVersion = '2017-05-26';
    /**
     * Watson conversation workspace id
     * @var null|string
     */
    private $workspaceId = null;

    private static $endpoints = array(
        "GET_WORKSPACE" => "/workspaces/{workspaceId}",
        "MESSAGE" => "/workspaces/{workspaceId}/message"
    );

    /**
     * Watson WatsonConversation constructor
     *
     * @param $username string The service api username
     * @param $password string The service api password
     */
    public function __construct($username = null, $password = null, $workspaceId = null) {
        parent::__construct($username, $password);

        if (!$this->validateWorkspaceId($workspaceId)) {
            throw new WatsonGeneralException("Invalid workspace id");
        }

        $this->workspaceId = $workspaceId;

    }

    /**
     * Build method endpoint
     *
     * @param string $methodName
     * @param array $parameters
     *
     * @return string
     */
    public function getMethodUrl ($methodName, $parameters = null) {
        if (!array_key_exists($methodName, self::$endpoints)) {
            throw new WatsonGeneralException("Invalid method name");
        }

        $method = self::$endpoints[$methodName];
        $parameters = (isset($parameters) && is_array($parameters)) ? $parameters : array();

        foreach ($parameters as $parameterKey => $parameterValue) {
            $method = str_replace("{" . $parameterKey . "}", $parameterValue, $method);
        }

        return $method;
    }

    /**
     * Remote workspace id validation
     *
     * @param string $workspaceId
     *
     * @return boolean
     */
    public function validateWorkspaceId ($workspaceId = null) {
        $endpoint = $this->getMethodUrl("GET_WORKSPACE", array("workspaceId" => $workspaceId));
        $url = $this->buildUrl($endpoint);

        try {
            $this->httpClient->get($url);
            return true;
        } catch (WatsonRequestException $exception) {
            return false;
        }
    }

    /**
     * Build watson message
     *
     * @param string $message
     * @param null|array $context
     *
     * @return array
     */
    public function buildMessage ($message, $context = null) {
        $msg = array(
            "input" => array(
                "text" => $message
            )
        );

        if (isset($context)) {
            $msg["context"] = $context;
        }

        return $msg;
    }

    /**
     * Send Message to Watson conversation workspace
     *
     * @param string $message
     * @param null|array $context
     *
     * @return array
     * @throws WatsonRequestException
     */
    public function sendMessage ($message, $context = null) {
        $endpoint = $this->getMethodUrl("MESSAGE", array("workspaceId" => $this->workspaceId));
        $url = $this->buildUrl($endpoint);
        $data = $this->buildMessage($message, $context);

        return $this->httpClient->post($url, $data);
    }

    /**
     * Factory function to create different Watson conversations with managed context
     *
     * @return WatsonConversation
     */
    public function createConversation () {
        return new WatsonConversation($this);
    }
}