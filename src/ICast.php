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

}