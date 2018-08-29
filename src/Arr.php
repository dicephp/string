<?php

namespace Dice\Types;

/**
 * Arr: A near-natural Ruby-like Array Implementation
 */
class Arr implements \ArrayAccess
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
     * @var bool Should all elements in the array be of the same type?
     */
    protected $isStrict = false;

    /**
     * @var string If the strict mode is set to true, then this string contains the type!
     */
    protected $strictTypeName = 'builtIn:string';

    /**
     * Arr constructor.
     * @param mixed $origValue Original value with which the object is to be constructed
     * @param bool $isStrict Should the values of this array be of the same type?
     */
    public function __construct($origValue, bool $isStrict = false)
    {
        $this->originalValue = $origValue;
        $this->activeValue = $origValue;

        // If strict mode, detect type and set it
        if ($isStrict) {
            $this->isStrict = true;
        }
    }

    /**
     * Static form of constructor
     * @param array $origValue
     * @return Arr
     */
    public static function create($origValue)
    {
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
    public function count()
    {
        return count($this->activeValue);
    }

    /**
     * Puts an item at the end of the array for numeric indexes.
     *
     * Use addIndexedItem method to add an item with an index.
     *
     * @param mixed $item Item to be pushed to the array
     */
    public function append($item)
    {
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
    public function prepend($item)
    {
        if (is_resource($item)) {
            throw new Exception\InvalidTypeException('You cannot add a resource to an array.');
        }

        if (is_array($item)) {
            throw new Exception\InvalidTypeException('You cannot prepend an array to an array as of now.');
        }

        array_unshift($this->activeValue, $item);
    }

    /**
     * Returns the JSON representation of the original data
     *
     * @return Str
     */
    public function jsonEncode()
    {
        return json_encode($this->activeValue);
    }

    /**
     * @param string $index The array index to be used when setting the item
     * @param mixed $item Item to be pushed to the array
     */
    public function addIndexedItem($index, $item)
    {
        $this->activeValue[$index] = $item;
    }

    // ====================================================================
    // IMPLEMENTATION OF ArrayAccess INTERFACE METHODS
    // ====================================================================
    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->activeValue[] = $value;
        } else {
            $this->activeValue[$offset] = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return isset($this->activeValue[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        unset($this->activeValue[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        $valToProcess = null;
        if (isset($this->activeValue[$offset])) {
            // Value for given offset is there
            $valToProcess = $this->activeValue[$offset];
        }

        if (is_array($valToProcess)) {
            $valToProcess = Arr::create($valToProcess);
        }

        // Value for given offset is NOT there
        return $valToProcess;
    }
    // ====================================================================
    // NOTE: IMPLEMENTATION OF ArrayAccess INTERFACE METHODS ENDS HERE
    // ====================================================================

    // ====================================================================
    //                           PRIVATE METHODS
    // ====================================================================

    private function detectType()
    {

        // TODO: Complete the logic

        if (is_string($this->activeValue)) {
            $this->strictTypeName = 'builtIn:string';

            if (is_callable($this->activeValue)) {
                $this->strictTypeName = 'custom:callable';
            }
        } elseif (is_numeric($this->activeValue) && is_int($this->activeValue)) {
            $this->strictTypeName = 'builtIn:integer';
        } elseif (is_numeric($this->activeValue) && is_float($this->activeValue)) {
            // Double and Float are same in PHP
            $this->strictTypeName = 'builtIn:float';
        } elseif (is_bool($this->activeValue)) {
            $this->strictTypeName = 'builtIn:boolean';
        } elseif (is_array($this->activeValue)) {
            $this->strictTypeName = 'builtIn:array';
        } elseif (is_callable($this->activeValue) && get_class($this->activeValue) == 'Closure') {
            $this->strictTypeName = 'custom:closure';
        } elseif (is_callable($this->activeValue) && get_class($this->activeValue) == 'Closure') {
            $this->strictTypeName = 'custom:closure';
        }
    }
}
