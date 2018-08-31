<?php

namespace Dice\Types;

/**
 * Class to Represent the rational number types (containing a numerator and a denominator)
 */
class Rational implements ICast
{
    // Safe values by default
    /**
     * @var int The Numerator of the rational number
     */
    protected $numerator = 1;
    /**
     * @var int The Denominator of the rational number
     */
    protected $denominator = 1;
    /**
     * @var float The float value to which this rational number corresponds
     */
    protected $floatValue = 1.0;
    /**
     * Continued Fraction (https://en.wikipedia.org/wiki/Continued_fraction) of the float value
     *
     * The representation contains three elements:
     * sign: Whether the number is positive or negative
     * integer: The integer part for the value (e.g. if float value is 4.6426 then this field will have `4`)
     * continued_fraction: The Continued fraction representation as an array
     *                      Each array in this array is in format [numerator,denominator] format
     * @var array The continued fraction representation of the value.
     */
    protected $continuedFraction = [
        'sign' => '+',
        'integer' => '1',
        'continued_fraction' => []
    ];

    /**
     * Rational constructor.
     * @param int $numerator
     * @param int $denominator
     */
    public function __construct($numerator, $denominator)
    {
        $this->numerator = (int)$numerator;
        $this->denominator = (int)$denominator;
        $this->calculateFloat();
        // Since we got a rational number, the original float
    }

    /**
     * Create a new Rational value from a float value
     *
     * @param $floatValue Float value from which the rational has to be constructed
     * @return Rational
     */
    public static function fromFloat($floatValue)
    {
        $rat = new static(1, 1);
        $rat->setFloatValue($floatValue);
        $rat->convertFloatToContinuedFraction();
        $rat->convertContinuedFractionToFloat();
        return $rat;
    }

    /**
     * Alias of the `fromFloat` method
     *
     * @param $doubleValue
     * @return Rational
     */
    public static function fromDouble($doubleValue) {
        return self::fromFloat($doubleValue);
    }

    /**
     * String representation of this rational number in `numerator/denominator` format
     *
     * @return string
     */
    public function __toString()
    {
        return $this->numerator . '/' . $this->denominator;
    }

    /**
     * Calculates and stores the float value for the rational
     */
    protected function calculateFloat()
    {
        $this->floatValue = (float)($this->numerator / $this->denominator);
    }

    /**
     * Converts the Float value to continued fraction representation and stores it internally
     *
     * @throws \Exception
     */
    protected function convertFloatToContinuedFraction()
    {
        // Ensure that the denominator is not zero
        if($this->floatValue === (float)0) {
            $this->numerator = 0;
            $this->denominator = 1;
            $this->continuedFraction = [
                'sign' => '+',
                'integer' => 0,
                'continued_fraction' => []
            ];

            return;
        } elseif ($this->denominator == 0) {
            throw new \Exception('Denominator was 0. Cannot process');
        } else {
            // if the decimal part was 0
            $sign = $this->floatValue > 0 ? '+' : '-';
            $decSplit = explode('.', (string)$this->floatValue);
            if(!isset($decSplit[1]) || (int)$decSplit[1] === 0) {
                $this->numerator = (int)$decSplit[0];
                $this->continuedFraction = [
                    'sign' => $sign,
                    'integer' => abs($decSplit[0]),
                    'continued_fraction' => []
                ];
                return;
            }
        }

        // Make a copy
        $flt = $this->floatValue;
        // Set number of fractions to which the float is to be dis-integrated (this affects precision of conversion)
        $loop_max = 20;
        // Set the number of digits after decimal within the loop (8 should be good)
        $loop_float_precision = 16;

        // Get the integer part and sign
        $sign = $flt > 0 ? '+' : '-';

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

    /**
     * Converts the internally stored continued fraction representation, converts it to float and stores it internally
     *
     * @throws \Exception
     */
    protected function convertContinuedFractionToFloat()
    {
        // Make a copy
        /** @var array $cf */
        $cf = $this->continuedFraction;

        $cfArray = array_reverse($cf['continued_fraction']);

        if (!empty($cfArray)) {
            $last_fraction = [];

            for ($i = 0; $i < (count($cfArray) - 1); $i++) {
                $resultingFraction = self::addFractions($cfArray[$i], [$cfArray[$i + 1][1], 1]);
                $cfArray[$i + 1] = [$resultingFraction[1], $resultingFraction[0]];
                $last_fraction = [$resultingFraction[1], $resultingFraction[0]];
            }

            $resultingFraction = self::addFractions($last_fraction, [$cf['integer'], 1]);

            $this->numerator = (int)($this->continuedFraction['sign'] . $resultingFraction[0]);
            $this->denominator = $resultingFraction[1];
        } else {
            // Continued Fractions array is empty. So it was an integer!
            $this->numerator = (int)($this->continuedFraction['sign'] . $this->continuedFraction['integer']);
            $this->denominator = 1;
        }
    }

    /**
     * Adds two fractions and returns the result
     *
     * @param array $firstFraction First fraction in the [numerator,denominator] format
     * @param array $secondFraction Second fraction in the [numerator,denominator] format
     * @return array Resulting fraction in the [numerator,denominator] format
     */
    protected static function addFractions($firstFraction, $secondFraction)
    {
        $val = [
            ($firstFraction[0] * $secondFraction[1]) + ($secondFraction[0] * $firstFraction[1]), // Numerator
            ($firstFraction[1] * $secondFraction[1]) // Denominator
        ];

        return $val;
    }

    /**
     * Sets the float value directly for the object.
     * Since such an operation is potentially harmful, even when the class is extended, this method is private
     * NOTE: This method does not alter other values.
     *
     * @param $floatValue
     */
    private function setFloatValue($floatValue)
    {
        $this->floatValue = (float)$floatValue;
    }

    /**
     * Convert the value to a scalar integer value
     * @return integer
     */
    public function toInt()
    {
        return (int)$this->floatValue;
    }

    /**
     * Convert the value to a scalar float value
     * @return float
     */
    public function toFloat()
    {
        return $this->floatValue;
    }

    /**
     * Convert the value to an array (create an array with this element as a single element in the array)
     * @return array
     */
    public function toArray()
    {
        return [(string)$this];
    }

    /**
     * Convert the value to a scalar string value
     * @return string
     */
    public function toString()
    {
        return (string)$this;
    }
}
