<?php
/**
 * User: ProjectZHub
 * Date: 19.08.2016
 * Time: 18:18
 */

namespace Redpill;

/**
 * Class Request
 * @package Redpill
 */
class Request
{
    const GET = 'GET';
    const POST = 'POST';
    const HEAD = 'HEAD';
    const PUT = 'PUT';

    /**
     * @var Collection
     */
    public $headers;

    /**
     * @var Collection
     */
    public $params;

    /**
     * @var Collection
     */
    public $post;

    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    public $method;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->params = new Collection($_GET);
        $this->post = new Collection($_POST);
        $this->headers = new Collection(getallheaders());
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
        $this->path = $this->getRequestPath();
    }

    /**
     * Returns the request path
     */
    protected function getRequestPath()
    {
        $requestPath = $_SERVER['REQUEST_URI'];
        if (strpos($requestPath, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
            $requestPath = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $requestPath);
        }
        if (strpos($requestPath, basename($_SERVER['SCRIPT_NAME'])) === 1) {
            $requestPath = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $requestPath);
            $requestPath = '/' . ltrim($requestPath, '/');
        }
        if (strpos($requestPath, '/?') === 0) {
            $requestPath = str_replace('/?', '', $requestPath);
        }
        if (strpos($requestPath, '&') !== FALSE) {
            $requestPath = strstr($requestPath, '&', true);
        }
        if ($this->params->has($requestPath)) {
            $this->params->remove($requestPath);
        }
        return $requestPath;
    }
}