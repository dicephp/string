<?php

/**
* Str: A near-natural Ruby-like String Implementation
*/
class Str
{
	/**
	 * @var String Original text with which the class was created
	 */
	protected $originalText;

	protected $activeText;

    /**
     * Str constructor.
     * @param String $origText Original text with which the object is to be constructed
     */
	public function __construct(String $origText)
	{
		$this->originalText = $origText;
		$this->activeText = $origText;
	}

    /**
     * Static form of constructor
     * @param String $origText
     * @return Str
     */
	public static function create(String $origText) {
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
	public function strip() {
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
    public function explode($delimiter) {
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
        if(strlen($needle) > strlen($this->activeText)){
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
        if(strlen($needle) > strlen($this->activeText)){
            // To suppress the error in strpos function below
            return false;
        }
        // search forward starting from end minus needle length characters
        return $needle === "" || strpos($this->activeText, $needle, strlen($this->activeText) - strlen($needle)) !== false;
    }

    public function isEqualTo()
    {

    }
    public function reverse() {}
    public function lJust() {}
    public function rJust() {}
    public function partition() {}
    public function slice() {}
    public function squeeze() {}

}

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


echo "\n";
