<?php

use PHPUnit\Framework\TestCase;
use Dice\Types\Str;

class StrTest extends TestCase
{
    /**
     *
     */
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

        $this->assertSame('LAHSUAK VAHBIAV', $obj->reverse()->activeText, "reverse failed");

        $obj->reset()->trim();
        $this->assertSame(true, $obj->startsWith('Vai'), "startsWith failed");
        $this->assertSame(false, $obj->startsWith('vai'), "startsWith 2 failed");
        $this->assertSame(true, $obj->startsWith(''), "startsWith 3 failed");
        $this->assertSame(false, $obj->startsWith(' '), "startsWith 4 failed");
        $this->assertSame(false, $obj->startsWith('Vaibhav Kaushal1'), "startsWith 5 failed");

        $this->assertSame(false, $obj->endsWith(' '), "endsWith failed");
        $this->assertSame(true, $obj->endsWith(''), "endsWith 2 failed");
        $this->assertSame(true, $obj->endsWith('shal'), "endsWith 3 failed");
        $this->assertSame(false, $obj->endsWith('shal '), "endsWith 4 failed");
        $this->assertSame(false, $obj->endsWith('1Vaibhav Kaushal'), "endsWith 5 failed");

        $this->assertSame(true, $obj->contains(' '), "contains failed");
        $this->assertSame(true, $obj->contains('Vaibhav'), "contains 2 failed");
        $this->assertSame(false, $obj->contains('vaibhav'), "contains 3 failed");
        $this->assertSame(true, $obj->contains('av Kau'), "contains 4 failed");
        $this->assertSame(true, $obj->contains('al'), "contains 5 failed");

        $this->assertSame(true, $obj->isEqualTo('Vaibhav Kaushal'), "isEqualTo failed");
        $this->assertSame(false, $obj->isEqualTo('vaibhav kaushal'), "isEqualTo 2 failed");

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

        $obj->reset()->trim();
        $this->assertSame(['V', 'a', 'i', 'b', 'h', 'a', 'v', ' ', 'K', 'a', 'u', 's', 'h', 'a', 'l'], $obj->chars(),
            "chars failed");
        $this->assertSame(['Vaibhav', 'Kaushal'], $obj->explode(' '), "toInt failed");
        $this->assertSame(['V', 'ibh', 'v K', 'ush', 'l'], $obj->split('a'), "toInt failed");

        // =============== TEST Casts ==============
        $obj = new Str('123');
        $this->assertSame(123, $obj->toInt(), "toInt failed");
        $obj = new Str('123.123');
        $this->assertSame(123.123, $obj->toFloat(), "toFloat failed");
        $obj = new Str('123.0');
        $this->assertSame(123.0, $obj->toFloat(), "toFloat 2 failed");
        $this->assertSame(['123.0'], $obj->toArray(), 'toArray failed');

        // =============== TEST Miscellaneous Methods ==============
        // wrapWith
        $obj = new Str('test string');
        $this->assertSame('"test string"', '' . $obj->wrapWith() . '', "wrapWith failed");
        $this->assertSame('/"test string"/', $obj->wrapWith('/')->activeText, "wrapWith 2 failed");
        $this->assertSame('[/"test string"/]', $obj->wrapWith('[', ']')->activeText, "wrapWith 3 failed");

        // empty or not
        $obj = new Str('test string');
        $this->assertSame(false, $obj->isEmpty(), "empty failed");
        $obj = new Str('');
        $this->assertSame(true, $obj->isEmpty(), "empty 2 failed");

        // Truncate
        $obj = new Str('test string');
        $this->assertSame('test', $obj->truncate(4, false)->activeText);
        $obj->reset();
        $this->assertSame('test...', $obj->truncate(7)->activeText);

        // Included In
        $obj = new Str('test string');
        $this->assertSame(true, $obj->includedIn(['test string']));
        $this->assertSame(true, $obj->includedIn(['first string', 'test string']));
        $this->assertSame(true, $obj->includedIn(['first string', 'test string', 'last string']));
        $this->assertSame(false, $obj->includedIn(['first string', 'Not test string', 'last string']));
        $this->assertSame(false, $obj->includedIn(['first string', 'Not test string']));
        $this->assertSame(false, $obj->includedIn(['Not test string']));
    }
}
