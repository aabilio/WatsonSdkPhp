<?php

namespace WatsonSdkPhp\Sdk;

use WatsonSdkPhp\Exceptions\WatsonGeneralException;
use WatsonSdkPhp\Helpers\HttpClient;

class WatsonSdk {
	
    /**
     * Base url for the service
     * 
     * @var string
     */
    protected $url;
    /**
     * HTTP Client to make remote request
     * 
     * @var HttpClient
     */
    protected $httpClient;
    /**
     * API version
     * 
     * @var string
     */
    protected $version;
    /**
     * API Date version
     *
     * @var string
     */
    protected $dateVersion;
    /**
     * Api service username
     *
     * @var string
     */
    protected $username;
    /**
     * Api service password
     *
     * @var string
     */
    protected $password;
    /**
     * The base service constructor
     *
     * @param $username string The service api username
     * @param $password string The service api password
     */
    public function __construct($username = null, $password = null)
    {
        if (!$this->validateUserAndPassword($username, $password)) {
            throw new WatsonGeneralException("Bad username or password format");
        }

        $this->setUsername($username);
        $this->setPassword($password);
        $this->httpClient = new HttpClient($username, $password);
    }
    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * {@inheritdoc}
     */
    public function buildUrl ($endpoint = "/", $parameters = array()) {
        if ($this->url === null) {
            throw new WatsonGeneralException("Not url endpoint");
        }
        if ($this->version === null) {
            throw new WatsonGeneralException("Not API Version");
        }
        if ($this->dateVersion === null) {
            throw new WatsonGeneralException("Not date Version");
        }

        $this->url = (substr($this->url, -1) != '/') ? $this->url.'/': $this->url;
        // $this->version = (substr($this->version, -1) != '/') ? $this->version.'/': $this->version;
        $parameters["version"] = $this->dateVersion;

        return $this->url.$this->version.$endpoint.'?'.$this->paramsToQueryString($parameters);
    }

    /**
     * Convert associative array to a query string
     *
     * @param array $parameters
     *
     * @return string
     */
    private function paramsToQueryString ($parameters = null) {
        if (!isset($parameters) || count($parameters) === 0) { return ''; }

        $ret = ''; $first = true;
        foreach ($parameters as $key => $value) {
            $ret .= (($first) ? '' : '&').$key.'='.$value;
            $first = false;
        }

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        return $this->version;
    }
    /**
     * {@inheritdoc}
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getDateVersion()
    {
        return $this->dateVersion;
    }
    /**
     * {@inheritdoc}
     */
    public function setDateVersion($dateVersion)
    {
        $this->dateVersion = $dateVersion;
        return $this;
    }
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Validate username and password. This to not validate the remote user and password,
     * just if is provided and is in the correct type
     *
     * @param string $username
     * @param string $password
     *
     * @return boolean
     */
    private function validateUserAndPassword ($username = null, $password = null) {
        if (!isset($username) || !isset($password)) {
            return false;
        }

        return true;
    }

}