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
        $obj = new Integ(12345.6789);
        $this->assertSame(5, $obj->length(), "Integer Length failed");

        $this->assertSame(5, $obj->length(), "Integer Length failed");
    }
}
