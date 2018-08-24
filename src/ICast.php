<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 26/07/18
 * Time: 8:14 PM
 */

namespace Dice\Types;


interface ICast
{
    /**
     * Convert the value to a scalar integer value
     * @return integer
     */
    public function toInt();

    /**
     * Convert the value to a scalar float value
     * @return float
     */
    public function toFloat();

    /**
     * Convert the value to an array (create an array with this element as a single element in the array)
     * @return array
     */
    public function toArray();

    /**
     * Convert the value to a scalar string value
     * @return string
     */
    public function toString();

}