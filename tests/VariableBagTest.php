<?php


namespace Lune\Variables\Tests;

use Lune\Variables\VariableBag;
use PHPUnit_Framework_TestCase;

class VariableBagTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function canSetSingle()
    {
        $vars = new VariableBag();
        $vars->set("test", "ok");
        $this->assertTrue($vars->has("test"));
        $this->assertFalse($vars->has("not_set"));
    }

    /**
     * @test
     */
    public function canSetArray()
    {
        $vars = new VariableBag();
        $vars->set(["test" => "ok", "test_2" => "ok"]);
        $this->assertTrue($vars->has("test"));
        $this->assertTrue($vars->has("test_2"));
        $this->assertFalse($vars->has("not_set"));
    }

    /**
     * @test
     */
    public function canGet()
    {
        $vars = new VariableBag(["test" => "ok"]);
        $this->assertEquals($vars->get("test"), "ok");
    }

    /**
     * @test
     */
    public function canGetDefault()
    {
        $vars = new VariableBag(["test" => "ok"]);
        $this->assertEquals($vars->get("test"), "ok");
        $this->assertNull($vars->get("not_set"));
        $this->assertEquals($vars->get("not_set", "fallback"), "fallback");
    }

    /**
     * @test
     */
    public function canUnsetSingle()
    {
        $vars = new VariableBag(["test" => "ok"]);
        $vars->remove("test");
        $this->assertFalse($vars->has("test"));
    }

    /**
     * @test
     */
    public function canUnsetArray()
    {
        $vars = new VariableBag(["test" => "ok", "test_2" => "ok"]);
        $vars->remove(["test", "test_2"]);
        $this->assertFalse($vars->has("test"));
        $this->assertFalse($vars->has("test_2"));
    }

    /**
     * @test
     */
    public function canExport()
    {
        $vars = new VariableBag(["test" => "ok"]);
        $array = $vars->all();

        $this->assertArrayHasKey('test', $vars->all());
    }

    /**
     * @test
     */
    public function canApplyDefaults()
    {
        $vars = new VariableBag();
        $this->assertNull($vars->get('test'));
        $vars->applyDefaults(['test' => 'ok']);
        $this->assertEquals($vars->get('test'), 'ok');
    }


}