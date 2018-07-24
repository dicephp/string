<?php

namespace Dice\Types ;

/**
* Arr: A near-natural Ruby-like Array Implementation
*/
class Arr
{
	/**
	 * @var array Original value with which the class was created
	 */
	protected $originalValue;

    /**
     * @var int Active value, used for chaining
     */
	protected $activeValue;

    /**
     * Arr constructor.
     * @param mixed $origValue Original value with which the object is to be constructed
     */
	public function __construct($origValue)
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
	    $arr = new Arr($origValue);
	    return $arr;
    }

    /**
     * String representation of the array (converted to JSON)
     * @return String returns the active text
     */
	public function __toString()
	{
		return json_encode($this->activeValue);
	}

    /**
     * Alias of the count function
     */
	public function length()
	{
		return $this->count();
	}

    /**
     * @return int Number of items in the array
     */
	public function count() {
        return count($this->activeValue);
    }

    /**
     * Puts an item at the end of the array for numeric indexes.
     *
     * Use addIndexedItem method to add an item with an index.
     *
     * @param mixed $item Item to be pushed to the array
     */
    public function append($item) {
	    array_push($this->activeValue, $item);
    }

    /**
     * Puts an item at the end of the array for numeric indexes.
     *
     * Use addIndexedItem method to add an item with an index.
     *
     * @param mixed $item Item to be pushed to the array
     * @throws Exception\InvalidTypeException
     */
    public function prepend($item) {
        if (is_resource($item)) {
            throw new Exception\InvalidTypeException('You cannot add a resource to an array.');
        }

        if (is_array($item)) {
            throw new Exception\InvalidTypeException('You cannot prepend an array to an array as of now.');
        }

        array_unshift($this->activeValue, $item);
    }

    /**
     * @param string $index The array index to be used when setting the item
     * @param mixed $item Item to be pushed to the array
     */
    public function addIndexedItem($index, $item) {
        $this->activeValue[$index] = $item;
    }

}
