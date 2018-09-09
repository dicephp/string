<?php
/**
 * Abstract class to represent Constants used in this project
 */

namespace Dice\Types;

/**
 * Class Constants
 * @package Dice\Types
 */
abstract class Constants {
    /* Constants for Data types */

    // PHP Built-In
    const Integer = 'Integ';
    const Float = 'Flt';
    const String = 'Str';
    const Bool = 'Bln';

    const Array = 'Arr';
    const Object = 'Obj';
    const Resource = 'Rsc';

    // The following types are listed only for the sake of consistency in detecting types
    const TypeCallable = 'callable';
    const TypeClosure = 'closure';

    /**
     * Constants constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        throw new \Exception('Cannot instantiate Constants class. All memebers are public static');
    }
}