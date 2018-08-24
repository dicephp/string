<?php

namespace Dice\Types;

/**
 * Integ: A near-natural Ruby-like Integer Implementation
 *
 *
 * @property-read string activeValue Returns the active value of the object
 * @property-read string originalValue The original value with which the object was created
 */
class Integ
{
    /**
     * @var int Original value with which the class was created
     */
    protected $originalValue;

    /**
     * @var int Active value, used for chaining
     */
    protected $activeValue;

    /**
     * Integ constructor.
     * @param int $origValue Original value with which the object is to be constructed
     */
    public function __construct($origValue)
    {
        $this->originalValue = $origValue;
        $this->activeValue = (int)$origValue;
    }

    /**
     * Static form of constructor
     * @param int $origValue
     * @return Integ
     */
    public static function create(int $origValue)
    {
        $str = new Integ($origValue);
        return $str;
    }

    /**
     * String representation of the object
     * @return String returns the active text
     */
    public function __toString()
    {
        return (string)$this->activeValue;
    }

    /**
     * @return int Length of the string
     */
    public function length()
    {
        return strlen((string)$this->activeValue);
    }

    public function toDecimal()
    {
        return $this->toFloat();
    }

    public function toDouble()
    {
    }

    public function toRational()
    {
    }

    public function toHex()
    {
    }

    public function toBinary()
    {
    }

    public function toOctal()
    {
    }

    public function digits()
    {
    }

    /**
     * Magic method for retrieving original or active string
     * @param $name
     * @return String
     * @throws \Exception
     */
    public function __get($name)
    {
        switch ($name) {
            case 'originalValue':
                return $this->originalValue;
            case 'activeValue':
                return $this->activeValue;
            default:
                throw new \Exception('Invalid property requested', 1);
        }
    }

    /**
     * Convert the string to a scalar integer value
     * @return integer
     */
    public function toInt()
    {
        return (int)$this->activeValue;
    }

    /**
     * Convert the string to a scalar float value
     * @return float
     */
    public function toFloat()
    {
        return (float)$this->activeValue;
    }

    /**
     * Puts the integer in an array and returns the array
     * @return array
     */
    public function toArray()
    {
        return [$this->activeValue];
    }

    /**
     * Convert the value to a scalar string value
     * @return string
     */
    public function toString()
    {
        return (string)$this->activeValue;
    }
}
