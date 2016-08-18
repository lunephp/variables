<?php


namespace Lune\Variables\Tests;


use Lune\Variables\HasVariablesTrait;
use Lune\Variables\VariableBag;
use PHPUnit_Framework_TestCase;

class HasVariablesTest extends PHPUnit_Framework_TestCase
{
    use HasVariablesTrait;

    public function testCreateBag()
    {
        //automatic
        $this->assertInstanceOf(VariableBag::class, $this->getVariables());

        //from null
        $this->setVariables(null);
        $this->assertInstanceOf(VariableBag::class, $this->getVariables());

        //from array
        $this->setVariables(['test' => 'ok']);

        $this->assertInstanceOf(VariableBag::class, $this->getVariables());
        //from VariableBag
        $this->setVariables(new VariableBag(['test'=>'ok']));
        $this->assertInstanceOf(VariableBag::class, $this->getVariables());

    }
}