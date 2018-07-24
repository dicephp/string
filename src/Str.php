<?php

namespace Dice\Types;

/**
 * Str: A near-natural Ruby-like String Implementation
 */
class Str
{
    /**
     * @var String Original text with which the class was created
     */
    protected $originalText;

    /**
     * @var String Active value, used for chaining
     */
    protected $activeText;

    /**
     * Str constructor.
     * @param String $origText Original text with which the object is to be constructed
     */
    public function __construct($origText)
    {
        $this->originalText = $origText;
        $this->activeText = $origText;
    }

    /**
     * Static form of constructor
     * @param String $origText
     * @return Str
     */
    public static function create($origText)
    {
        $str = new Str($origText);
        return $str;
    }

    /**
     * String representation of the object
     * @return String returns the active text
     */
    public function __toString()
    {
        return $this->activeText;
    }

    /**
     * @return int Length of the string
     */
    public function length()
    {
        return strlen($this->activeText);
    }

    /**
     * Runs `ltrim()` on the string
     * @return $this
     */
    public function ltrim()
    {
        $this->activeText = ltrim($this->activeText);
        return $this;
    }

    /**
     * Runs `rtrim()` on the string
     * @return $this
     */
    public function rtrim()
    {
        $this->activeText = rtrim($this->activeText);
        return $this;
    }

    /**
     * Runs `trim()` on the string
     * @return $this
     */
    public function trim()
    {
        $this->activeText = trim($this->activeText);
        return $this;
    }

    /**
     * Alias of `trim()` without the optional character_mask argument
     * @return Str
     */
    public function strip()
    {
        // This is only a wrapper method
        return $this->trim();
    }

    /**
     * Returns lines in the string (split by "\n")
     * @return array Lines in the string
     */
    public function lines()
    {
        return explode("\n", $this->activeText);
    }

    /**
     * Resets the active text to the original text which was used when creating this String object
     * @return $this
     */
    public function reset()
    {
        $this->activeText = $this->originalText;
        return $this;
    }

    /**
     * Converts all characters in to lower case
     * @return $this
     */
    public function downcase()
    {
        $this->activeText = strtolower($this->activeText);
        return $this;
    }

    /**
     * Converts all characters in to upper case
     * @return $this
     */
    public function upcase()
    {
        $this->activeText = strtoupper($this->activeText);
        return $this;
    }

    /**
     * Swaps the case of alphabetic characters
     * @return $this
     */
    public function togglecase()
    {
        $strAsArray = str_split($this->activeText);
        $outputArray = [];
        foreach ($strAsArray as $char) {
            if (ctype_lower($char)) {
                $outputArray[] = strtoupper($char);
            } elseif (ctype_upper($char)) {
                $outputArray[] = strtolower($char);
            } else {
                $outputArray[] = $char;
            }
        }

        $this->activeText = implode('', $outputArray);
        return $this;
    }

    /**
     * Returns the entire string as an array of individual characters
     * @return array
     */
    public function chars()
    {
        return str_split($this->activeText);
    }

    /**
     * Alias of `explode()`
     * @param $delimiter
     * @return array
     */
    public function split($delimiter)
    {
        return $this->explode($delimiter);
    }

    /**
     * Splits the string into array of strings by delimiter
     * @param String $delimiter Delimiter against which array creation happens
     * @return array
     */
    public function explode($delimiter)
    {
        return explode((String)$delimiter, $this->activeText);
    }

    /**
     * Appends another string to the existing one
     * @param String $stringToAppend
     * @return Str
     */
    public function append($stringToAppend)
    {
        $this->activeText .= $stringToAppend;
        return $this;
    }

    /**
     * Prepends another string to the existing one
     * @param String $stringToPrepend
     * @return Str
     */
    public function prepend($stringToPrepend)
    {
        $this->activeText = (String)$stringToPrepend . $this->activeText;
        return $this;
    }

    /**
     * Returns substring using the substr method
     * @param int $start
     * @param int $length
     * @return bool|string
     */
    public function substr(int $start, int $length = null)
    {
        return substr($this->activeText, $start, $length);
    }

    /**
     * Tells whether or not the string is empty
     * @param bool $trimStringFirst perform a trim on the string first
     * @return bool
     */
    public function isEmpty($trimStringFirst = false)
    {
        $text = $this->activeText;
        if ($trimStringFirst) {
            $text = trim($text);
        }

        if ($text == '') {
            return true;
        }
        return false;
    }

    /**
     * Returns if String contains a given substring
     * @param String $needle
     * @return bool
     */
    public function contains($needle)
    {
        if (strpos($this->activeText, (String)$needle) !== false) {
            return true;
        }
        return false;
    }

    /**
     * Checks whether a given string starts with another (sub)string
     *
     * @param string $needle string to search
     *
     * @return bool
     */
    public function startsWith($needle)
    {
        // If the length of needle is greater than the length of this string, then return false
        if (strlen($needle) > strlen($this->activeText)) {
            // To suppress the error in strpos function below
            return false;
        }
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($this->activeText, $needle, -strlen($this->activeText)) !== false;
    }

    /**
     * Checks whether a given string ends with another (sub)string
     *
     * @param string $needle String to search
     *
     * @return bool
     */
    public function endsWith($needle)
    {
        // If the length of needle is greater than the length of this string, then return false
        if (strlen($needle) > strlen($this->activeText)) {
            // To suppress the error in strpos function below
            return false;
        }
        // search forward starting from end minus needle length characters
        return $needle === "" || strpos($this->activeText, $needle,
                strlen($this->activeText) - strlen($needle)) !== false;
    }

    /**
     * Compares and tells if this string is equal in length and content
     * @param $stringToCompare String which is to be compared
     * @return bool
     */
    public function isEqualTo($stringToCompare)
    {
        if ($this->activeText === (String)$stringToCompare) {
            return true;
        }
        return false;
    }

    /**
     * Reverses the string and stores it
     * @return Str
     */
    public function reverse()
    {
        $this->activeText = strrev($this->activeText);
        return $this;
    }

    /**
     * Justifies string to left with optional padding (default is space) to its right
     * @param int $finalLength Final length of the string needed after justification
     * @param string $strPadding Repeating padding string to be applied to the right (default = ' ')
     * @return Str
     */
    public function lJust($finalLength, $strPadding = ' ')
    {
        // If the final length is not more than the existing length, do nothing
        if ((int)$finalLength <= 0 || $this->length() >= $finalLength) {
            return $this;
        }

        // Calculate the difference between requested length and current length
        // and then iterate padding string just enough number of times, with the last one
        // optionally being a substring (from the beginning) of the Padding string
        $lenDiff = $finalLength - $this->length();

        while ($lenDiff > strlen($strPadding)) {
            $this->activeText .= $strPadding;
            $lenDiff = $finalLength - $this->length();
        }

        $this->activeText = $this->activeText . (substr($strPadding, 0, ($finalLength - strlen($this->activeText))));
        return $this;
    }

    /**
     * Justifies string to left with optional padding (default is space) to its right
     * @param int $finalLength Final length of the string needed after justification
     * @param string $strPadding Repeating padding string to be applied to the left (default = ' ')
     * @return Str
     */
    public function rJust($finalLength, $strPadding = ' ')
    {
        // If the final length is not more than the existing length, do nothing
        if ((int)$finalLength <= 0 || $this->length() >= $finalLength) {
            return $this;
        }

        // Calculate the difference between requested length and current length
        // and then iterate padding string just enough number of times, with the last one
        // optionally being a substring (from the beginning) of the Padding string
        $lenDiff = $finalLength - $this->length();

        $strToAdd = '';

        while ($lenDiff > strlen($strPadding)) {
            $strToAdd = $strPadding . $strToAdd;
            $lenDiff = $finalLength - ($this->length() + strlen($strToAdd));
        }

        $this->activeText = $strToAdd . (substr($strPadding, 0,
                ($finalLength - (strlen($this->activeText) + strlen($strToAdd))))) . $this->activeText;

        return $this;
    }

    /**
     * Returns the first character of the string
     * @return string
     */
    public function getFirstCharacter()
    {
        if ($this->length() > 0) {
            return $this->chars()[0];
        }

        return '';
    }

    /**
     * Returns the last character of the string
     * @return string
     */
    public function getLastCharacter()
    {
        $len = $this->length();
        if ($len > 0) {
            return $this->chars()[$len - 1];
        }

        return '';
    }

    public function partition()
    {
    }

    public function slice()
    {
    }

    public function squeeze()
    {
    }

    public function truncate()
    {
    }

    public function xmlEscape()
    {
    }

    public function getLongestCommonSubsequenceWith($otherString)
    {
    }

    /**
     * Base 64 Encoding with optional URL Safe encoding
     *
     * @param bool $urlSafe Should we remove non URL Safe characters?
     */
    public function base64Encode($urlSafe = false)
    {
        $s = base64_encode($this->activeText);

        if ($urlSafe) {
            $s = str_replace('+', '-', $s);
            $s = str_replace('/', '_', $s);
            $s = str_replace('=', '', $s);
        }

        $this->activeText = $s;
    }

    /**
     * Base 64 Decoding with optional URL Safe decoding
     *
     * @param bool $urlSafe Should we remove non URL Safe characters with correct base64 ones?
     */
    public function base64Decode($urlSafe = false)
    {
        $s = $this->activeText;

        if ($urlSafe) {
            $s = str_replace('_', '/', $s);
            $s = str_replace('-', '+', $s);
        }

        $this->activeText = base64_decode($s);
    }

    public function getAsSlug()
    {
    }

    public function removeAccents()
    {
    }

    public function isUtf8()
    {
    }

    /**
     * Magic method for retrieving original or active string
     * @param $name
     * @return String
     * @throws \Exception
     */
    public function __get($name)
    {
        switch ($name) {
            case 'originalString':
                return $this->originalText;
            case 'activeString':
                return $this->activeText;
            default:
                throw new \Exception('Invalid property requested', 1);
        }
    }

}

