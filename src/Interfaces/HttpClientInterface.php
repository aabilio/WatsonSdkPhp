<?php

namespace WatsonSdkPhp\Interfaces;

use WatsonSdkPhp\Exceptions\WatsonRequestException;

interface HttpClientInterface {
    /**
     * Make HTTP Get Request
     *
     * @param string $url
     * @param null|array $headers
     * @param null|array $options
     *
     * @return array (json_decode the response body)
     * @throws WatsonRequestException if request was not success
     */
    public function get ($url, $headers = null, $options = null);

    /**
     * Make HTTP Post Request
     *
     * @param string $url
     * @param null|array $data
     * @param null|array $headers
     * @param null|array $options
     *
     * @return array (json_decode the response body)
     * @throws WatsonRequestException if the request was not success
     */
    public function post ($url, $data = null, $headers = null, $options = null);
}
