<?php

use PHPUnit\Framework\TestCase;
use Dice\Types\Str;

class StrTest extends TestCase
{
    public function testMethods()
    {
        $obj = new Str(" Vaibhav Kaushal ");
        // =============== TEST Basics ==============
        $this->assertSame(17, $obj->length(), "Length failed");
        $this->assertSame(" Vaibhav Kaushal ", "" . $obj . "", "Automatic Casting failed");
        $this->assertSame("Vaibhav Kaushal", (string)$obj->trim(), "Trimming failed");
        $this->assertSame(15, $obj->length(), "Length after trimming failed");
        $this->assertSame(' Vaibhav Kaushal ', $obj->reset()->activeText, "Reset failed");
        $this->assertSame('Vaibhav Kaushal ', $obj->ltrim()->activeText, "ltrim failed");
        $this->assertSame('Vaibhav Kaushal', $obj->rtrim()->activeText, "rtrim failed");
        $this->assertSame('vAIBHAV kAUSHAL', $obj->toggleCase()->activeText, "toggleCase failed");
        $this->assertSame('Vaibhav Kaushal', $obj->toggleCase()->activeText, "toggleCase 2 failed");
        $this->assertSame('vaibhav kaushal', $obj->downCase()->activeText, "downcase failed");
        $this->assertSame('VAIBHAV KAUSHAL', $obj->upCase()->activeText, "upCase failed");
        $obj->reset();
        $this->assertSame(' Vaibhav Kaushal ', $obj->activeText, "reset failed");
        $this->assertSame('vaibhav kaushal', $obj->reset()->trim()->upCase()->downCase()->activeText,
            "Chaining reset->trim->upcase->downcase failed");

        $this->assertSame('Actually, Vaibhav Kaushal ', $obj->reset()->prepend('Actually,')->activeText,
            "prepend failed");
        $this->assertSame('Actually, Vaibhav Kaushal is just another developer.',
            $obj->append('is just another developer.')->activeText, "append failed");

        // =============== TEST Justifications ==============
        $obj->reset();
        $this->assertSame(' Vaibhav Kaushal 12345678', $obj->lJust(25, '1234567890')->activeText, "lJust failed");
        $obj->reset()->trim();
        $this->assertSame('Vaibhav Kaushal1234567890', $obj->lJust(25, '1234567890')->activeText, "lJust run 2 failed");
        $obj->reset()->trim();
        $this->assertSame('Vaibhav Kaushal12345678901234567890123456789012345',
            $obj->lJust(50, '1234567890')->activeText, "lJust run 3 failed");
        $obj->reset()->trim();
        $this->assertSame('Vaibhav Kaushal                                   ', $obj->lJust(50, ' ')->activeText,
            "lJust run 4 failed");
        // --------------------------------------------------
        $obj->reset();
        $this->assertSame('12345678 Vaibhav Kaushal ', $obj->rJust(25, '1234567890')->activeText, "rJust failed");
        $obj->reset()->trim();
        $this->assertSame('1234567890Vaibhav Kaushal', $obj->rJust(25, '1234567890')->activeText, "rJust run 2 failed");
        $obj->reset()->trim();
        $this->assertSame('12345678901234567890123456789012345Vaibhav Kaushal',
            $obj->rJust(50, '1234567890')->activeText, "rJust run 3 failed");
        $obj->reset()->trim();
        $this->assertSame('                                   Vaibhav Kaushal', $obj->rJust(50, ' ')->activeText,
            "rJust run 4 failed");

        // =============== TEST Casts ==============
        $obj = new Str('123');
        $this->assertSame(123, $obj->toInt(), "toInt failed");
        $obj = new Str('123.123');
        $this->assertSame(123.123, $obj->toFloat(), "toFloat failed");
        $obj = new Str('123.0');
        $this->assertSame(123.0, $obj->toFloat(), "toFloat 2 failed");

        // =============== TEST Miscellaneous Methods ==============
        // wrapWith
        $obj = new Str('test string');
        $this->assertSame('"test string"', '' . $obj->wrapWith() . '', "wrapWith failed");
        $this->assertSame('/"test string"/', $obj->wrapWith('/')->activeText, "wrapWith 2 failed");
        $this->assertSame('[/"test string"/]', $obj->wrapWith('[', ']')->activeText, "wrapWith 3 failed");


    }
}
