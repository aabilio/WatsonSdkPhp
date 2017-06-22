<?php

namespace WatsonSdkPhp\Factories\Conversation\V1;

use WatsonSdkPhp\Exceptions\WatsonRequestException;
use WatsonSdkPhp\Services\Conversation\V1\WatsonConversationService;

class WatsonConversationServiceFactory {

    /** @var array */
    private $services;

    /** @var null|string */
    private $username;
    /** @var null|string */
    private $password;
    /** @var null|string */
    private $workspaceId;

    /**
     * WatsonConversationServiceFactory constructor.
     *
     * @param null $username
     * @param null $password
     * @param null $workspaceId
     */
    public function __construct ($username = null, $password = null, $workspaceId = null) {
        $this->username = $username;
        $this->password = $password;
        $this->workspaceId = $workspaceId;
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
     * Get workspace id
     *
     * @return null|string
     */
    public function getWorkspaceId()
    {
        return $this->workspaceId;
    }

    /**
     * Set workspace id
     *
     * @param null|string $workspaceId
     */
    public function setWorkspaceId($workspaceId)
    {
        $this->workspaceId = $workspaceId;
    }

    /**
     * Create conversation service
     *
     * @return WatsonConversationService
     */
    public function createConversationService () {
        $conversationService = new WatsonConversationService($this->username, $this->password, $this->workspaceId);
        $this->services[] = $conversationService;

        return $conversationService;
    }

}