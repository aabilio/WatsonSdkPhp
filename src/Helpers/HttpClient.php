<?php

namespace WatsonSdkPhp\Helpers;

use WatsonSdkPhp\Exceptions\WatsonRequestException;
use WatsonSdkPhp\Interfaces\HttpClientInterface;

class HttpClient implements HttpClientInterface {

    /** @constant string */
    const CONTENT_TYPE_JSON = "application/json";

    /** @var null|string */
    private $credentials;
    /** @var string */
    private $username;
    /** @var string */
    private $password;

	public function __construct ($username = null, $password = null) {
	    $this->username = $username;
	    $this->password = $password;
	    $this->credentials = $username.":".$password;
    }

    /**
     * Build default headers
     *
     * @param null $headers
     *
     * @return array|null
     */
    private function buildDefaultHeaders ($headers = null, $contentType = null) {
	    $headers = (isset($headers)) ? $headers : array();
	    if (isset($contentType)) {
	        $headers["Content-Type"] = $contentType;
        }

        return $headers;
    }

    /**
     * Build default options
     *
     * @param null $options
     *
     * @return array|null
     */
    private function buildDefaultOptions ($options = null) {
        $options = (isset($options)) ? $options : array('auth' => null);
        $options['auth'] = (isset($options['auth'])) ? $options['auth'] : array($this->username, $this->password);

        return $options;
    }

    /**
     * {@inheritdoc}
     */
	public function get ($url, $headers = null, $options = null) {
	    $headers = $this->buildDefaultHeaders($headers);
	    $options = $this->buildDefaultOptions($options);
		$request = \Requests::get($url, $headers, $options);
		$response = json_decode($request->body, true);

		if (!$request->success) {
		    throw new WatsonRequestException($response["error"], $request->status_code);
        }

		return $response;
	}

    /**
     * {@inheritdoc}
     */
    public function post ($url, $data = null, $headers = null, $options = null) {
        $headers = $this->buildDefaultHeaders($headers, self::CONTENT_TYPE_JSON);
        $options = $this->buildDefaultOptions($options);

        $request = \Requests::post($url, $headers, json_encode($data), $options);
        $response = json_decode($request->body, true);

        if (!$request->success) {
            throw new WatsonRequestException($response["error"], $request->status_code);
        }

        return $response;
    }


}