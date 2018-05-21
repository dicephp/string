<?php

namespace Dice\Types ;

/**
* Integ: A near-natural Ruby-like Integer Implementation
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
	public function __construct(int $origValue)
	{
		$this->originalValue = $origValue;
		$this->activeValue = $origValue;
	}

    /**
     * Static form of constructor
     * @param int $origValue
     * @return Integ
     */
	public static function create(int $origValue) {
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

	public function toDecimal() {}
	public function toDouble() {}
	public function toFloat() {}
	public function toRational() {}
	public function toHex() {}
	public function toBinary() {}
	public function toOctal() {}
	public function digits() {}
}
