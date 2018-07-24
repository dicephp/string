<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 24/07/18
 * Time: 4:37 PM
 */

use \Dice\Types\Str;

$obj = new Str(" Vaibhav Kaushal ");
echo "\nlength: " . $obj->length();
echo "\nstring cast: '" . $obj . "'";
echo "\ntrim: '" . $obj->trim() . "'";;
echo "\nlength after trimming: " . $obj->length();
echo "\nbefore reset: '" . $obj . "'";
echo "\ncalling reset: '" . $obj->reset() . "'";
echo "\ntrimming again: '" . $obj->trim() . "'";
echo "\ntoggle case: '" . $obj->togglecase() . "'";
echo "\ntoggle case again: '" . $obj->togglecase() . "'";
echo "\ndowncasing: '" . $obj->downcase() . "'";
echo "\nupcasing: '" . $obj->upcase() . "'";
echo "\ncalling reset: '" . $obj->reset() . "'";
echo "\ncalling chain (trim-upcase-togglecase): '" . $obj->trim()->upcase()->togglecase() . "'";

echo "\n============";
echo "\ncalling trim again: '" . $obj->trim() . "'";
echo "\ncalling append: '" . $obj->append(' is a good boy') . "'";
echo "\ncalling prepend: '" . $obj->prepend('Actually, ') . "'";

echo "\n============";
echo "\ncalling reset: '" . $obj->reset() . "'";
echo "\ncalling ljust: '" . $obj->lJust(25, '1234567890') . "'";
$obj->reset();
echo "\ncalling rjust: '" . $obj->rJust(25, '1234567890') . "'";

echo "\n";