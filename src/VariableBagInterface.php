<?php


namespace Lune\Variables;

use ArrayAccess;
use Countable;
use IteratorAggregate;

interface VariableBagInterface extends ArrayAccess, Countable, IteratorAggregate
{

    public function set($name, $value = null);

    public function has($name):bool;

    public function get($name, $default = null);

    public function remove($name);

    public function all():array;
}