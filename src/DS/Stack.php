<?php
/**
 * Stack Data Structure. Uses Arrays internally.
 *
 * Also, the typing is strict in that it only accepts Dice\Types to be used for the stack.
 * Data type is automatically inferred and cannot be changed.
 */

namespace Dice\Types\DS;

use \Dice\Types\Exception\InvalidTypeException;
use \Dice\Types as Types;

class Stack
{
    /**
     * The array using which the operations will be carried
     *
     * @var \Dice\Types\Arr
     */
    protected $stack;

    /** @var String One of the types (constants representation) */
    protected $elementType;

    /**
     * Stack constructor.
     * @param \Dice\Types\Integ|\Dice\Types\Str $firstItem First item in the stack
     *
     * @throws InvalidTypeException
     */
    public function __construct($firstItem)
    {
        if (is_null($firstItem)) {
            throw new InvalidTypeException('Cannot construct a stack with null item');
        }

        if ($firstItem instanceof Types\Arr) {
            throw new InvalidTypeException('Cannot construct a stack of arrays');
        } elseif ($firstItem instanceof Types\Str) {
            $this->elementType = Types\Constants::String;
        } elseif ($firstItem instanceof Types\Integ) {
            $this->elementType = Types\Constants::Integer;
        } else {
            throw new InvalidTypeException('Cannot recognize the data type. Please use any of the Dice\Types to construct the stack');
        }

        $this->stack = new Types\Arr($firstItem);
    }

    protected function validateType($item)
    {
        if (!is_object($item)) {
            // We do not accept non-objects anyway
            return false;
        }

        $klass = get_class($item);

        switch ($klass) {
            case 'Dice\Types\Arr':
            case 'Dice\Types\Integ':
            case 'Dice\Types\Str':
                return true;
            default:
                // We do not accept non-dice types
                return false;
        }
    }
}