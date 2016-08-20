<?php
/**
 * User: ProjectZHub
 * Date: 20.08.2016
 * Time: 13:41
 */

namespace Redpill;


class Session extends Collection
{
    public function set($name, $value)
    {
        parent::set($name, $value);
        $_SESSION[$name] = $value;
    }
}