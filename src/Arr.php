<?php

namespace Dice\Types;

/**
 * Arr: A near-natural Array Implementation
 */
class Arr extends \ArrayIterator
{
    /** @var array Original value with which the class was created */
    protected $originalValue;

    /** @var int Active value, used for chaining */
    protected $activeValue;

    /** @var bool Should all elements in the array be of the same type? */
    protected $isStrict = false;

    /** @var string If the strict mode is set to true, then this string contains the type! */
    protected $strictTypeName = 'builtIn:string';

    /** @var mixed Return this value when an offset is not found */
    protected $returnValueOnKeyNotFound = null;

    // ========== PROPERTIES FOR INTERFACES ==========
    /** @var int Internal position for Seekable interface */
    private $position;

    /**
     * Arr constructor.
     * @param mixed $origValue Original value with which the object is to be constructed
     * @param bool $isStrict Should the values of this array be of the same type?
     * @param null|mixed $returnValueOnKeyNotFound Return this type of value if index for the array is not found
     * @throws \Exception
     */
    public function __construct($origValue, bool $isStrict = false, $returnValueOnKeyNotFound = null)
    {
        // If strict mode, detect type and set it
        if ($isStrict) {
            $this->isStrict = true;
            $this->strictTypeName = $this->detectType($origValue);

            if ($this->strictTypeName == Constants::Array && count($origValue) > 1 && $this->strictTypeCheckForArrayElements($origValue) == false) {
                // Array types are not strictly the same
                throw new \Exception('Cannot construct a new ' . get_class($this) . ' using an array containing different types of elements');
            }
        }

        $this->originalValue = $origValue;

        if ($this->detectType($origValue) != Constants::Array) {
            $this->activeValue = [$origValue];
        } else {
            $this->activeValue = $origValue;
        }

        $this->returnValueOnKeyNotFound = $returnValueOnKeyNotFound;
    }

    /**
     * Static form of constructor
     *
     * @param array $origValue
     * @return Arr
     * @throws \Exception
     */
    public static function create($origValue)
    {
        try {
            $arr = new Arr($origValue);
        } catch (\Exception $exception) {
            throw new $exception;
        }
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
    // NOTE: IMPLEMENTATION OF ArrayAccess INTERFACE METHODS
    // ====================================================================
    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if ($this->isStrict && $this->detectType($value) != $this->strictTypeName) {
            throw new \Exception('Cannot set value of type ' . $this->detectType($value) . ' on an Arr object with strict type ' . $this->strictTypeName);
        }

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
        $valToProcess = $this->returnValueOnKeyNotFound;
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
    // NOTE: IMPLEMENTATION OF Countable INTERFACE METHODS
    // ====================================================================

    /**
     * @return int Number of items in the array
     */
    public function count()
    {
        return count($this->activeValue);
    }

    // ====================================================================
    // NOTE: IMPLEMENTATION OF Countable INTERFACE METHODS ENDS HERE
    // ====================================================================

    // ====================================================================
    // NOTE: IMPLEMENTATION OF Seekable INTERFACE METHODS
    // ====================================================================

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->activeValue[$this->position];
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return isset($this->activeValue[$this->position]);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @inheritdoc
     */
    public function seek($position)
    {
        if (!isset($this->activeValue[$position])) {
            throw new \OutOfBoundsException("invalid seek position ($position)");
        }

        $this->position = $position;
    }

    // ====================================================================
    // NOTE: IMPLEMENTATION OF Seekable INTERFACE METHODS ENDS HERE
    // ====================================================================

    // ====================================================================
    // NOTE: IMPLEMENTATION OF Countable INTERFACE METHODS
    // ====================================================================

    /**
     * @inheritdoc
     */
    public function serialize()
    {
        return serialize($this->activeValue);
    }

    /**
     * @inheritdoc
     */
    public function unserialize($serialized)
    {
        $this->activeValue = unserialize($serialized);
    }

    // ====================================================================
    // NOTE: IMPLEMENTATION OF INTERFACE METHODS ENDS HERE
    // ====================================================================

    // ====================================================================
    //                           PRIVATE METHODS
    // ====================================================================

    /**
     * Returns the type of a value as detected
     *
     * @param mixed $val Value to be checked
     * @return string The type (from the constants class)
     */
    private function detectType($val)
    {

        // TODO: Complete the logic

        if (is_string($val)) {
            if (is_callable($val)) {
                return (Constants::TypeCallable);
            }

            return (Constants::String);
        } elseif (is_numeric($val) && is_int($val)) {
            return (Constants::Integer);
        } elseif (is_numeric($val) && is_float($val)) {
            // Double and Float are same in PHP
            return (Constants::Float);
        } elseif (is_bool($val)) {
            return (Constants::Bool);
        } elseif (is_array($val)) {
            return (Constants::Array);
        } elseif (is_callable($val) && get_class($val) == 'Closure') {
            return (Constants::TypeClosure);
        } else {
            // It must be an object
            return ('Class:' . get_class($val));
        }
    }

    /**
     * Performs the type check on all elements of an array and tells if all the elements of the array are of same type
     *
     * @param array $arr The array to test
     * @return bool Whether all types were same or not
     */
    private function strictTypeCheckForArrayElements(array $arr)
    {
        $firstType = null;

        foreach ($arr as $item) {
            if ($firstType == null) {
                $firstType = $this->detectType($item);
            } else {
                if ($firstType != $this->detectType($item)) {
                    return false;
                }
            }
        }

        return true;
    }
}
