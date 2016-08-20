<?php
/**
 * User: ProjectZHub
 * Date: 19.08.2016
 * Time: 18:16
 */

namespace Redpill;

/**
 * Class Router
 * @package Redpill
 */
class Router
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var Collection
     */
    protected $params;

    public function __construct($path)
    {
        $this->path = $path;
        $this->params = new Collection([]);
    }

    /**
     * @param $rule
     * @return bool
     */
    public function match($rule)
    {
        if ($rule == $this->path) {
            return true;
        }
        $ruleParts = explode('/', $rule);
        $pathParts = explode('/', $this->path);
        if (count($ruleParts) !== count($pathParts)) {
            return false;
        }
        foreach ($ruleParts as $idx => $part) {
            if (strpos($part, ':') === 0 && !empty($pathParts[$idx])) {
                $param = ltrim($part, ':');
                $this->params->set($param, $pathParts[$idx]);
            } else if ($part != $pathParts[$idx]) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return Collection
     */
    public function getParams()
    {
        return $this->params;
    }
}