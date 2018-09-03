<?php

use PHPUnit\Framework\TestCase;
use Dice\Types\Rational;

/**
 * Class RationalTest test for methods in the Rational class
 */
class RationalTest extends TestCase
{
    /**
     * Test all the methods in the Rational class
     */
    public function testRationalMethods()
    {
        $obj = Rational::fromFloat(4.4624);
        $this->assertSame('2789/625', $obj->toString(), "fromFloat for positive float failed");
        $obj = Rational::fromFloat(-4.4624);
        $this->assertSame('-2789/625', $obj->toString(), "fromFloat for negative float failed");

        $obj = Rational::fromFloat(5);
        $this->assertSame('5/1', $obj->toString(), "fromFloat for positive integer failed");
        $obj = Rational::fromFloat(-5);
        $this->assertSame('-5/1', $obj->toString(), "fromFloat for negative integer failed");

        $obj = new Rational(2345, 4395);
        $this->assertSame('2345/4395', $obj->toString(), "toString failed");
        $this->assertSame('0.53356086461889', (string)$obj->toFloat(), "toFloat for less than 0 failed");

        $obj = Rational::fromFloat($obj->toFloat());
        $this->assertSame(0.5335608646188851, $obj->toFloat(), "toFloat reconversion failed");
        $this->assertSame('469/879', $obj->toString(), "toFloat reconversion 2 failed");

        $obj = Rational::fromFloat(4.02);
        $this->assertSame('2345/4395', $obj->toString(), "toString failed");
        $this->assertSame('0.53356086461889', (string)$obj->toFloat(), "toFloat for less than 0 failed");
    }
}
