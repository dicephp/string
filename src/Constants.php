<?php
/**
 * Abstract class to represent Constants used in this project
 */

namespace Dice\Types;

abstract class Constants {
    /* Constants for Data types */

    const Array = 'Arr';
    const Integer = 'Integ';
    const String = 'Str';

    /**
     * Constants constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        throw new \Exception('Cannot instantiate Constants class. All memebers are public static');
    }
}