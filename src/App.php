<?php
/**
 * User: ProjectZHub
 * Date: 19.08.2016
 * Time: 18:13
 */

namespace Redpill;

/**
 * Class App
 * @package Redpill
 */
class App
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var Router
     */
    public $router;

    /**
     * @var Session
     */
    public $session;

    /**
     * @var Collection
     */
    public $config;

    /**
     * @var array
     */
    protected $handlers = [];

    /**
     * @var array
     */
    protected $middleware = [];


    /**
     * @param $app
     * @return App
     */
    public static function create(&$app)
    {
        $app = new App();
        return $app;
    }

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request->path);
        $this->middleware = ['404' => function ($params, $app) {
            $app->response->body = '404 not found';
        }];
        $this->session = new Session(isset($_SESSION) ? $_SESSION : []);
        $this->config = new Collection([]);
    }

    /**
     * @param $name
     * @param array $args
     */
    public function __call($name, $args = [])
    {
        if (in_array($name, ['get', 'post', 'put', 'head', 'delete'])) {
            $this->handlers[] = [$name, $args];
        }
        if ($name == 'use') {
            $this->middleware[$args[0]] = $args[1];
        }
    }

    /**
     * Match requests and output the response body
     */
    public function run()
    {
        $app = $this;
        $handlerToRun = [$this->middleware['404'], [new Collection([]), $app]];
        foreach ($this->handlers as $handler) {
            list($name, $args) = $handler;
            if (strtoupper($name) == $this->request->method && $this->router->match($args[0])) {
                $func = array_pop($args);
                $middleware = isset($args[1]) ? $args[1] : [];
                $handlerToRun = [$func, array($this->router->getParams(), $app), $middleware];
            }
        }
        $runHandler = !empty($handlerToRun);
        if ($runHandler && !empty($handlerToRun[2])) {
            foreach ($handlerToRun[2] as $name => $params) {
                if ($runHandler) {
                    $runHandler = call_user_func_array($this->middleware[$name], array_merge([$params], [$app]));
                } else {
                    break;
                }
            }
        }
        if ($runHandler) {
            call_user_func_array($handlerToRun[0], $handlerToRun[1]);
        }
        echo $app->response->body;
    }

    /**
     * Redirects to one of the paths added to the router
     * @param string $path
     */
    public function redirect($path)
    {
        $url = $this->getBaseUrl() . ltrim($path, '/');
        $this->response->redirect($url);
    }

    /**
     * Returns the base url with separator for routing
     *
     * @return string
     */
    public function getBaseUrl()
    {
        $sep = $this->config->has('url_rewrite') ? '/' : '?/';
        return $this->request->getBaseUrl() . $sep;
    }

}