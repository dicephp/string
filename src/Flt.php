<?php

namespace Dice\Types;

/**
 * Flt: A near-natural Ruby-like Float/Double Implementation
 *
 * @property-read string activeValue Returns the active value of the object
 * @property-read string originalValue The original value with which the object was created
 */
class Flt implements ICast
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
     * Flt constructor.
     * @param int $origValue Original value with which the object is to be constructed
     */
    public function __construct($origValue)
    {
        $this->originalValue = $origValue;
        $this->activeValue = (float)$origValue;
    }

    /**
     * Static form of constructor
     * @param int $origValue
     * @return Flt
     */
    public static function create(int $origValue)
    {
        $flt = new static($origValue);
        return $flt;
    }

    /**
     * String representation of the object
     *
     * @return String returns the active text
     */
    public function __toString()
    {
        return (string)$this->activeValue;
    }

    /**
     * Returns the length of the float's sting representation
     * @return int Length of the float as string
     */
    public function length()
    {
        return strlen((string)$this->activeValue);
    }

    /**
     * Returns the float/decimal representation (usually, should append '.0' at the end)
     *
     * @return float
     */
    public function toDecimal()
    {
        return $this->toFloat();
    }

    /**
     * Returns the double/decimal representation (usually, should append '.0' at the end)
     *
     * @return float
     */
    public function toDouble()
    {
        return (double)$this->activeValue;
    }

    /**
     * Returns the rational representation of the integer.
     * Just adds "/1" to the string representation
     *
     * @return string
     */
    public function toRational()
    {
        $strObj = $this->toString();
        $strObj->append('/1');
        return $strObj->toString();
    }

    /**
     * Returns the digits in the float representation of this float value
     *
     * @return integer[]
     */
    public function digits()
    {
        return str_split((string)$this->activeValue);
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
     * Convert the value to a Str representation of the integer
     * @return Str
     */
    public function toString()
    {
        return new Str($this->activeValue);
    }
}
