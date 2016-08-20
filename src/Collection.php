<?php
/**
 * User: ProjectZHub
 * Date: 19.08.2016
 * Time: 18:20
 */

namespace Redpill;

/**
 * Class Collection
 * @package Redpill
 */
class Collection
{
    /**
     * @var array
     */
    protected $collection = [];

    /**
     * Collection constructor.
     * @param array $collection
     */
    public function __construct($collection = []) {
        $this->collection = $collection;
    }

    /**
     * Checks if array key value exists
     *
     * @param string $name
     */
    public function has($name) {
        return array_key_exists($name, $this->collection);
    }

    /**
     * Returns the value stored
     *
     * @param string $name
     * @return mixed
     */
    public function get($name) {
        if ($this->has($name)) {
            return $this->collection[$name];
        }
        return null;
    }

    /**
     * Sets or adds a value
     *
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value) {
        $this->collection[$name] = $value;
    }

    /**
     * Removes a value from an array
     *
     * @param $name
     */
    public function remove($name) {
        if ($this->has($name)) {
            unset($this->collection[$name]);
        }
    }
}