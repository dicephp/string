<?php

use PHPUnit\Framework\TestCase;
use Dice\Types\Integ;

/**
 * Class IntegTest test for methods in the Integ class
 */
class IntegTest extends TestCase
{
    /**
     * Test all the methods in the Str class
     */
    public function testIntegMethods()
    {
        $obj = new Integ(52345.6789);
        $this->assertSame(5, $obj->length(), "Integer Length failed");

        $this->assertSame(52345.0, $obj->toDecimal(), "toDecimal failed");
        $this->assertSame(52345.0, $obj->toDouble(), "toDouble failed");

        $this->assertSame('cc79', $obj->toHex(), "toHex failed");
        $this->assertSame('cc79', $obj->toHex(false), "toHex 2 failed");
        $this->assertSame('CC79', $obj->toHex(true), "toHex 3 failed");

        $this->assertSame('1100110001111001', $obj->toBinary(), "toBinary failed");
        $this->assertSame('146171', $obj->toOctal(), "toOctal failed");
    }
}
