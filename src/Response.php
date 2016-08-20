<?php
/**
 * User: ProjectZHub
 * Date: 19.08.2016
 * Time: 18:19
 */

namespace Redpill;

/**
 * Class Response
 * @package Redpill
 */
class Response
{

    /**
     * @var array
     */
    public $headers = [];

    /**
     * @var string
     */
    public $body;

    /**
     * @var int
     */
    public $status;

    public function redirect($path)
    {
        header("Location: $path");
        exit;
    }

}