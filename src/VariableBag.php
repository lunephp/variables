<?php


namespace Lune\Variables;


class VariableBag
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
}