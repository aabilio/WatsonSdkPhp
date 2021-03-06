<?php

namespace WatsonSdkPhp\Factories;

use WatsonSdkPhp\Factories\Conversation\V1\WatsonConversationServiceFactory;
use WatsonSdkPhp\Services\Conversation\V1\WatsonConversationService;

class WatsonFactory {

    /** @var array */
    private $services;

    /** @var null|string */
    private $username;
    /** @var null|string */
    private $password;

    /**
     * WatsonFactory constructor.
     *
     * @param null $username
     * @param null $password
     */
    public function __construct ($username = null, $password = null) {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Get username
     *
     * @return null|string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param null|string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get password
     *
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param null|string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Create Conversation Service
     *
     * @param null|string $workspaceId
     *
     * @return WatsonConversationService
     */
    public function createConversationServiceV1 ($workspaceId = null) {
        $conversationServiceV1Factory = new
            WatsonConversationServiceFactory($this->username, $this->password, $workspaceId);
        $service = $conversationServiceV1Factory->createConversationService();
        $this->services[] = $service;

        return $service;
    }

}