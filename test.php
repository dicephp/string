<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 07/09/18
 * Time: 3:02 PM
 */

require_once 'vendor/autoload.php';

/*/

$arr = new \Dice\Types\Arr(new \Dice\Types\Str('abc'), true);

//$arr[] = 1.2;

$arr[] = new \Dice\Types\Str('xyz');
//$arr[] = 'abcd';

foreach ($arr as $item) {
    echo $item . '<br/>';
}

echo ":{$arr[2]}";
var_dump($arr);

//*/

$flt = new \Dice\Types\Flt(2.4);
echo $flt->toRational();
var_dump($flt->digits());
