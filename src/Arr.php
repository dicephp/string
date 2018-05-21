<?php

namespace Dice\Types ;

/**
* Arr: A near-natural Ruby-like Array Implementation
*/
class Arr
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
     * @param String $origValue Original value with which the object is to be constructed
     */
	public function __construct(String $origValue)
	{
		$this->originalValue = $origValue;
		$this->activeValue = $origValue;
	}

    /**
     * Static form of constructor
     * @param array $origValue
     * @return Arr
     */
	public static function create($origValue) {
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



}
