<?php

namespace Dice\Types;


class Rational
{
    protected $numerator = 1;
    protected $denominator = 1;
    protected $floatValue = 1.0;
//    protected $computedFloatValue = 1.0;
    protected $continuedFraction = [
        'sign' => '+',
        'integer' => '1',
        'continued_fraction' => []
    ];


    public function __construct($numerator, $denominator)
    {
        $this->numerator = (int)$numerator;
        $this->denominator = (int)$denominator;
        $this->calculateFloat();
        // Since we got a rational number, the original float
    }

    public static function fromFloat($floatValue)
    {
        $rat = new static(1, 1);
        $rat->setFloatValue($floatValue);
        $rat->convertFloatToContinuedFraction();
        $rat->convertContinuedFractionToFloat();
        return $rat;
    }

    private function setFloatValue($floatValue)
    {
        $this->floatValue = (float)$floatValue;
    }

    public function __toString()
    {
        return $this->numerator . '/' . $this->denominator;
    }

    protected function calculateFloat()
    {
        $this->floatValue = (float)($this->numerator / $this->denominator);
    }

    public function getAsFloat()
    {
        return $this->floatValue;
    }

    protected function convertFloatToContinuedFraction()
    {
        // Make a copy
        $flt = $this->floatValue;
        // Set number of fractions to which the float is to be dis-integrated (this affects precision of conversion)
        $loop_max = 20;
        // Set the number of digits after decimal within the loop (8 should be good)
        $loop_float_precision = 16;

        // Get the integer part and sign
        $sign = $flt > 0 ? '+' : '';

        $intPart = abs((int)$flt);
        $decPart = abs($flt) - abs($intPart);

        // Continued fraction array should contain arrays of 2 elements => [numerator, denominator]
        $cfArray = [];

        if ($decPart != 0) {
            for ($i = 0; $i < $loop_max; $i++) {
                // Round it off first
                $decPart = round($decPart, $loop_float_precision);
                // Count the number of digits after decimal
                $decSplit = explode('.', (string)$decPart);

                $currDenominator = $decSplit[1];

                if ((int)$currDenominator == 0) {
                    // Protect from division by zero
                    break;
                }

                $currNumerator = str_pad('1', strlen($currDenominator) + 1, '0');
                $currFloat = $currNumerator / $currDenominator;
                $cfArray[] = [1, (int)$currFloat];
                $decPart = $currFloat - (int)$currFloat;
            }
        }

        $this->continuedFraction = [
            'sign' => $sign,
            'integer' => $intPart,
            'continued_fraction' => $cfArray
        ];
    }

    protected function convertContinuedFractionToFloat()
    {
        // Make a copy
        /** @var array $cf */
        $cf = $this->continuedFraction;

        $cfArray = array_reverse($cf['continued_fraction']);

        $last_fraction = [];

        if (!empty($cfArray)) {
            for ($i = 0; $i < (count($cfArray) - 1); $i++) {
                $resultingFraction = self::addFractions($cfArray[$i], [$cfArray[$i + 1][1], 1]);
                $cfArray[$i + 1] = [$resultingFraction[1], $resultingFraction[0]];
                $last_fraction = [$resultingFraction[1], $resultingFraction[0]];
            }
        }

        $resultingFraction = self::addFractions($last_fraction, [$cf['integer'], 1]);

        $this->numerator = $resultingFraction[0];
        $this->denominator = $resultingFraction[1];
        return $resultingFraction;
    }

    // NOTE: Make it protected later on
    protected static function addFractions($firstFraction, $secondFraction)
    {
        $val = [
            ($firstFraction[0] * $secondFraction[1]) + ($secondFraction[0] * $firstFraction[1]), // Numerator
            ($firstFraction[1] * $secondFraction[1]) // Denominator
        ];

        return $val;
    }
}

$rat = Rational::fromFloat(5.234);
echo $rat;
