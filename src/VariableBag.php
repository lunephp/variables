<?php


namespace Lune\Variables;

use ArrayIterator;
use Traversable;

class VariableBag implements VariableBagInterface
{
    private $vars = [];

    public function __construct(array $variables = [])
    {
        $this->set($variables);
    }

    public function set($name, $value = null)
    {
        if ($name instanceof VariableBag) {
            $this->set($name->all());
        }
        if (is_array($name)) {
            foreach ($name as $sub_name => $sub_value) {
                $this->set($sub_name, $sub_value);
            }
        } else {
            $this->vars[$name] = $value;
        }
    }

    public function has($name):bool
    {
        return array_key_exists($name, $this->vars);
    }

    public function get($name, $default = null)
    {
        return $this->has($name) ? $this->vars[$name] : $default;
    }

    public function remove($name)
    {
        foreach ((array)$name as $sub_name) {
            if ($this->has($sub_name)) {
                unset($this->vars[$sub_name]);
            }
        }
    }

    public function all():array
    {
        return $this->vars;
    }

    /**
     * Applies default values
     *
     * @param array $defaults
     */
    public function applyDefaults(array $defaults = [])
    {
        array_map(function ($key) use ($defaults) {
            $this->set($key, $this->get($key, $defaults[$key]));
        }, array_keys($defaults));
    }


    public function extract($keys = [], $filtered = true):array
    {
        $out = [];

        array_map(function ($key) use (&$out) {
            $out[$key] = $this->get($key);
        }, $keys);

        if ($filtered) {
            $out = array_filter($out);
        }
        return $out;
    }

    public function getOneOf($name, $allowed = [], $default = null)
    {
        $value = $this->get($name);
        return in_array($value, $allowed) ? $value : $default;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->vars);
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->vars);
    }
}