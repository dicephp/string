<?php

namespace Dice\Types;

/**
 * Bln: A near-natural Boolean Implementation
 *
 * @property-read string activeValue Returns the active value of the object
 * @property-read string originalValue The original value with which the object was created
 */
class Bln implements ICast
{
    /** @var int Original value with which the class was created */
    protected $originalValue;

    /** @var int Active value, used for chaining */
    protected $activeValue;

    /** @var array The list of values that can be considered true */
    protected $trueValues = [true, 1, 't', 'true' ];

    /** @var array The list of values that can be considered true false */
    protected $falseValues = [false, 0, 'f', 'false' ];

    /** @var integer How should this boolean represent the value */
    protected $representation;

    /** @var bool Allow null to be a valid value for boolean? */
    protected $sqlMode;

    // Constants to denote representation of the value when outputting
    const TRUE_FALSE_BOOLEAN = 0;
    const ONE_ZERO_INTEGER = 1;
    const T_F_STRING = 2;
    const TRUE_FALSE_STRING = 3;

    /**
     * Bln constructor
     *
     * @param mixed $origValue Original value with which the object is to be constructed
     * @param int $representation The representation in which the object should operate
     * @param bool $sqlMode Should the boolean value be allowed to contain Null values?
     * @param array $trueValues Array of values which can be accepted as 'true'
     * @param array $falseValues Array of values which can be accepted as 'false'
     * @throws \Exception
     */
    public function __construct($origValue, $representation = 0, $sqlMode = false, $trueValues = [], $falseValues = [])
    {
        if(!$sqlMode && $origValue === null) {
            throw new \Exception('Cannot create a Bln object with null value and sqlMode set to false');
        }

        // If there are additional values which are in trueValues and falseValues, check for duplicates and set them
        if (count($trueValues) > 0 || count($falseValues) > 0) {

            // Compound values cannot be used for truthy and falsy values
            foreach ($trueValues as $trueValue) {
                if(is_array($trueValue)) {
                    throw new \Exception('Array found inside $trueValues. Compound types not allowed in $trueValues.');
                }
                if(is_object($trueValue)){
                    throw new \Exception('Object found inside $trueValues. Compound types not allowed in $trueValues.');
                }
            }

            foreach ($falseValues as $falseValue) {
                if(is_array($falseValue)) {
                    throw new \Exception('Array found inside $falseValues. Compound types not allowed in $falseValues.');
                }
                if(is_object($falseValue)){
                    throw new \Exception('Object found inside $falseValues. Compound types not allowed in $falseValues.');
                }
            }

            $trueValues = array_unique($trueValues);
            $falseValues = array_unique($falseValues);
            $intersection = array_intersect($trueValues,$falseValues);

            if (count($intersection) > 0) {
                throw new \Exception('Same values found in both $trueValues and $falseValues: ' . implode(',', $intersection));
            }

            $this->trueValues = array_merge($this->trueValues, $trueValues);
            $this->falseValues = array_merge($this->falseValues, $falseValues);
        }

        // See if the representation was specified and if the value matches

        $this->originalValue = $origValue;
        $this->activeValue = $this->castFromValues($origValue);

        if($this->activeValue === null) {
            throw new \Exception(
                "Cannot determine truthiness or falsiness of the value.\nPlease check input and $trueValues and $falseValues supplied."
            );
        }

        $this->representation = $representation;
        $this->sqlMode = $sqlMode;
    }

    /**
     * Static form of constructor
     *
     * @param mixed $origValue Original value with which the object is to be constructed
     * @param int $representation The representation in which the object should operate
     * @param bool $sqlMode Should the boolean value be allowed to contain Null values?
     * @param array $trueValues Array of values which can be accepted as 'true'
     * @param array $falseValues Array of values which can be accepted as 'false'
     *
     * @return Bln
     * @throws \Exception
     */
    public static function create($origValue, $representation, $sqlMode, $trueValues, $falseValues)
    {
        $bln = new static($origValue, $representation, $sqlMode, $trueValues, $falseValues);
        return $bln;
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

    /**
     * Returns the boolean cast of the value supplied. Returns null when it cannot determine.
     *
     * @param mixed $val Value to check
     * @return bool|null Null means function cannot determine truthiness or falsiness of $val
     */
    protected function castFromValues($val)
    {
        if(array_search($val, $this->trueValues, true) !== false) {
            // Value found in the trueValues array!
            return true;
        }

        if(array_search($val, $this->falseValues, true) !== false) {
            // Value found in the falseValues array!
            return false;
        }

        // If we are here then the value was neither found in trueValues, nor in falseValues
        return null;
    }
}
