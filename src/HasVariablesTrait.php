<?php


namespace Lune\Variables;


use Lune\Variables\Exception\ConversionFailedException;

trait HasVariablesTrait
{
    private $variables;

    private function convertToVariables($input):VariableBag
    {
        if ($input instanceof VariableBag) {
            return $input;
        }
        if (is_null($input)) {
            return new VariableBag();
        }
        if (is_array($input)) {
            return new VariableBag($input);
        }

        throw new ConversionFailedException($input);
    }

    public function setVariables($variables)
    {
        $this->variables = $this->convertToVariables(variables);
    }


    public function getVariables():VariableBag
    {
        if (is_null($this->variables)) {
            $this->variables = new VariableBag();
        }
        return $this->variables;
    }



}