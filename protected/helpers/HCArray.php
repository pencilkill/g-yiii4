<?php
/**
 * Array helper class.
 *
 * $Id: arr.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class HCArray {

	/**
	 * Return a callback array from a string, eg: limit[10,20] would become
	 * array('limit', array('10', '20'))
	 *
	 * @param   string  callback string
	 * @return  array
	 */
	public static function callback_string($str)
	{
		// command[param,param]
		if (preg_match('/([^\[]*+)\[(.+)\]/', (string) $str, $match))
		{
			// command
			$command = $match[1];

			// param,param
			$params = preg_split('/(?<!\\\\),/', $match[2]);
			$params = str_replace('\,', ',', $params);
		}
		else
		{
			// command
			$command = $str;

			// No params
			$params = NULL;
		}

		return array($command, $params);
	}

	/**
	 * Rotates a 2D array clockwise.
	 * Example, turns a 2x3 array into a 3x2 array.
	 *
	 * @param   array    array to rotate
	 * @param   boolean  keep the keys in the final rotated array. the sub arrays of the source array need to have the same key values.
	 *                   if your subkeys might not match, you need to pass FALSE here!
	 * @return  array
	 */
	public static function rotate($source_array, $keep_keys = TRUE)
	{
		$new_array = array();
		foreach ($source_array as $key => $value)
		{
			$value = ($keep_keys === TRUE) ? $value : array_values($value);
			foreach ($value as $k => $v)
			{
				$new_array[$k][$key] = $v;
			}
		}

		return $new_array;
	}

	/**
	 * Removes a key from an array and returns the value.
	 *
	 * @param   string  key to return
	 * @param   array   array to work on
	 * @return  mixed   value of the requested array key
	 */
	public static function remove($key, & $array)
	{
		if ( ! array_key_exists($key, $array))
		return NULL;

		$val = $array[$key];
		unset($array[$key]);

		return $val;
	}


	/**
	 * Extract one or more keys from an array. Each key given after the first
	 * argument (the array) will be extracted. Keys that do not exist in the
	 * search array will be NULL in the extracted data.
	 *
	 * @param   array   array to search
	 * @param   string  key name
	 * @return  array
	 */
	public static function extract(array $search, $keys)
	{
		// Get the keys, removing the $search array
		$keys = array_slice(func_get_args(), 1);

		$found = array();
		foreach ($keys as $key)
		{
			if (isset($search[$key]))
			{
				$found[$key] = $search[$key];
			}
			else
			{
				$found[$key] = NULL;
			}
		}

		return $found;
	}

	/**
	 * Because PHP does not have this function.
	 *
	 * @param   array   array to unshift
	 * @param   string  key to unshift
	 * @param   mixed   value to unshift
	 * @return  array
	 */
	public static function unshift_assoc( array & $array, $key, $val)
	{
		$array = array_reverse($array, TRUE);
		$array[$key] = $val;
		$array = array_reverse($array, TRUE);

		return $array;
	}

	/**
	 * Because PHP does not have this function, and array_walk_recursive creates
	 * references in arrays and is not truly recursive.
	 *
	 * @param   mixed  callback to apply to each member of the array
	 * @param   array  array to map to
	 * @return  array
	 */
	public static function map_recursive($callback, array $array)
	{
		foreach ($array as $key => $val)
		{
			// Map the callback to the key
			$array[$key] = is_array($val) ? self::map_recursive($callback, $val) : call_user_func($callback, $val);
		}

		return $array;
	}

	/**
	 * Binary search algorithm.
	 *
	 * @param   mixed    the value to search for
	 * @param   array    an array of values to search in
	 * @param   boolean  return false, or the nearest value
	 * @param   mixed    sort the array before searching it
	 * @return  integer
	 */
	public static function binary_search($needle, $haystack, $nearest = FALSE, $sort = FALSE)
	{
		if ($sort === TRUE)
		{
			sort($haystack);
		}

		$high = count($haystack);
		$low = 0;

		while ($high - $low > 1)
		{
			$probe = ($high + $low) / 2;
			if ($haystack[$probe] < $needle)
			{
				$low = $probe;
			}
			else
			{
				$high = $probe;
			}
		}

		if ($high == count($haystack) || $haystack[$high] != $needle)
		{
			if ($nearest === FALSE)
			return FALSE;

			// return the nearest value
			$high_distance = $haystack[ceil($low)] - $needle;
			$low_distance = $needle - $haystack[floor($low)];

			return ($high_distance >= $low_distance) ? $haystack[ceil($low)] : $haystack[floor($low)];
		}

		return $high;
	}

	/**
	 * Emulates array_merge_recursive, but appends numeric keys and replaces
	 * associative keys, instead of appending all keys.
	 *
	 * @param   array  any number of arrays
	 * @return  array
	 */
	public static function merge()
	{
		$total = func_num_args();

		$result = array();
		for ($i = 0; $i < $total; $i++)
		{
			foreach (func_get_arg($i) as $key => $val)
			{
				if (isset($result[$key]))
				{
					if (is_array($val))
					{
						// Arrays are merged recursively
						$result[$key] = self::merge($result[$key], $val);
					}
					elseif (is_int($key))
					{
						// Indexed arrays are appended
						array_push($result, $val);
					}
					else
					{
						// Associative arrays are replaced
						$result[$key] = $val;
					}
				}
				else
				{
					// New values are added
					$result[$key] = $val;
				}
			}
		}

		return $result;
	}

	/**
	 * Overwrites an array with values from input array(s).
	 * Non-existing keys will not be appended!
	 *
	 * @param   array   key array
	 * @param   array   input array(s) that will overwrite key array values
	 * @return  array
	 */
	public static function overwrite($array1)
	{
		foreach (array_slice(func_get_args(), 1) as $array2)
		{
			foreach ($array2 as $key => $value)
			{
				if (array_key_exists($key, $array1))
				{
					$array1[$key] = $value;
				}
			}
		}

		return $array1;
	}

	/**
	 * Fill an array with a range of numbers.
	 *
	 * @param   integer  stepping
	 * @param   integer  ending number
	 * @return  array
	 */
	public static function range($step = 10, $max = 100)
	{
		if ($step < 1)
		return array();

		$array = array();
		for ($i = $step; $i <= $max; $i += $step)
		{
			$array[$i] = $i;
		}

		return $array;
	}

	/**
	 * Recursively convert an array to an object.
	 *
	 * @param   array   array to convert
	 * @return  object
	 */
	public static function to_object(array $array, $class = 'stdClass')
	{
		$object = new $class;

		foreach ($array as $key => $value)
		{
			if (is_array($value))
			{
				// Convert the array to an object
				$value = self::to_object($value, $class);
			}

			// Add the value to the object
			$object->{$key} = $value;
		}

		return $object;
	}

	public static function sortNestedArray(&$array, $sort) {
		$sort($array);

		foreach ($array as $key=>$val) {
			if (is_array($array[$key])) {
				self::sortNestedArray($array[$key], $sort);
			}
		}
	}

	/**
	 * Returns the values from a single column of the input array, identified by
	 * the $columnKey.
	 *
	 * Optionally, you may provide an $indexKey to index the values in the returned
	 * array by the values from the $indexKey column in the input array.
	 *
	 * @param array $input A multi-dimensional array (record set) from which to pull
	 *                     a column of values.
	 * @param mixed $columnKey The column of values to return. This value may be the
	 *                         integer key of the column you wish to retrieve, or it
	 *                         may be the string key name for an associative array.
	 * @param mixed $indexKey (Optional.) The column to use as the index/keys for
	 *                        the returned array. This value may be the integer key
	 *                        of the column, or it may be the string key name.
	 * @return array
	 */
	public static function pluck(array $array = NULL, $columnKey = NULL, $indexKey = NULL)
	{
		// Using func_get_args() in order to check for proper number of
		// parameters and trigger errors exactly as the built-in array_column()
		// does in PHP 5.5.
		$args = func_num_args();
		$params = func_get_args();

		if ($args < 2) {
			trigger_error(__METHOD__ . '() expects at least 2 parameters, ' . $args . ' given', E_USER_WARNING);
			return null;
		}

		if (!is_array($params[0])) {
			trigger_error(__METHOD__ . '() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
			return null;
		}

		if (!is_int($params[1])
		&& !is_float($params[1])
		&& !is_string($params[1])
		&& $params[1] !== null
		&& !(is_object($params[1]) && method_exists($params[1], '__toString'))
		) {
			trigger_error(__METHOD__ . '(): The column key should be either a string or an integer', E_USER_WARNING);
			return false;
		}

		if (isset($params[2])
		&& !is_int($params[2])
		&& !is_float($params[2])
		&& !is_string($params[2])
		&& !(is_object($params[2]) && method_exists($params[2], '__toString'))
		) {
			trigger_error(__METHOD__ . '(): The index key should be either a string or an integer', E_USER_WARNING);
			return false;
		}

		$params[1] = ($params[1] !== null) ? (string) $params[1] : null;

		if (isset($params[2])) {
			if (is_float($params[2]) || is_int($params[2])) {
				$params[2] = (int) $params[2];
			} else {
				$params[2] = (string) $params[2];
			}
		}

		$result = array();

		foreach ($params[0] as $row) {

			$key = $value = null;
			$keySet = $valueSet = false;

			if ($params[2] !== null && array_key_exists($params[2], $row)) {
				$keySet = true;
				$key = (string) $row[$params[2]];
			}

			if ($params[1] === null) {
				$valueSet = true;
				$value = $row;
			} elseif (is_array($row) && array_key_exists($params[1], $row)) {
				$valueSet = true;
				$value = $row[$params[1]];
			}

			if ($valueSet) {
				if ($keySet) {
					$result[$key] = $value;
				} else {
					$result[] = $value;
				}
			}

		}

		return $result;
	}

	/**
	 * @author Sam@ozchamp.net
	 *
	 * Get list of all values from a multidimentional array
	 * Using array_walk_recursive cause RecursiveArrayIterator will miss object element
	 *
	 * @param array $array Multidimensional array to extract values from
	 * @return array
	 */
	public static function values(array $array)
	{
		$args = func_num_args();
		$params = func_get_args();

		if ($args < 1) {
			trigger_error(__METHOD__. '() expects at least 1 parameter, ' . $args . ' given', E_USER_WARNING);
			return false;
		}

		if (!is_array($params[0])) {
			trigger_error(__METHOD__. '() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
			return false;
		}

		$result = array();

		array_walk_recursive($params[0], function($val, $key) use(&$result){$result[] = $val;});

		return $result;
	}

	/**
	 * @author Sam@ozchamp.net
	 *
	 * @param $array
	 * @param $maxDepth
	 * @param $leftSymbol
	 * @param $rightSymbol
	 * @param $prefix
	 *
	 * @example
	 	$_POST['example'][2][7]['c'] = 'lemon';
		$_POST['example'][2][7]['a'] = 'lemon1';
		$_POST['example'][3][7]['b'] = 'lemon2';
		$_POST['example'][3][7]['d'] = 'lemon3';
		print_r(flatten($_POST['example']));
	 *
	 */
	public static function flatten(array $array = NULL, string $leftSymbol = NULL, string $rightSymbol = NULL, string $prefix = NULL){
		$args = func_num_args();
		$params = func_get_args();

		if ($args < 1) {
			trigger_error(__METHOD__ . '() expects at least 1 parameter, ' . $args . ' given', E_USER_WARNING);
			return false;
		}

		if (!is_array($params[0])) {
			trigger_error(__METHOD__ . '() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
			return false;
		}


		if(!isset($params[1]) || is_null($params[1])){
			$params[1] = '[';
		}else{
			$params[1] = (string)$params[1];
		}

		if(!isset($params[2]) || is_null($params[2])){
			$params[2] = ']';
		}else{
			$params[2] = (string)$params[2];
		}

		if(!isset($params[3]) || is_null($params[3])){
			$params[3] = '';
		}else{
			$params[3] = (string)$params[3];
		}

		return self::_flatten($params[0], $params[1], $params[2], $params[3]);
	}
	//
	private static function _flatten(array $array, $leftSymbol = '[', $rightSymbol = ']', $prefix = ''){
		$results = array();

	     foreach ($array as $key => $value)
	     {
	         if(is_array($value)){
	             $results = array_merge($results, self::_flatten($value, $leftSymbol, $rightSymbol, $prefix . $leftSymbol . $key . $rightSymbol));
	         }else{
	         	 // keep last key
	             $results[$prefix][$key] = $value;
	         }
	     }

	     return $results;
	}
	/**
	 * Array differ associate recursive
	 *
	 * @param $array1, Array
	 * @param $array2, Array
	 */
	public static function diff_assoc(array $array1, array $array2) {
		$args = func_num_args();
		$params = func_get_args();

		if ($args < 2) {
			trigger_error(__METHOD__ . '() expects at least 2 parameter, ' . $args . ' given', E_USER_WARNING);
			return false;
		}

		if (!is_array($params[0])) {
			trigger_error(__METHOD__ . '() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
			return false;
		}

		if (!is_array($params[1])) {
			trigger_error(__METHOD__ . '() expects parameter 2 to be array, ' . gettype($params[1]) . ' given', E_USER_WARNING);
			return false;
		}

	    return self::_diff_assoc($params[0], $params[1]);
	}
	//
	private static function _diff_assoc(array $array1, array $array2) {
		$difference=array();
	    foreach($array1 as $key => $value) {
	        if(is_array($value)) {
	            if(!isset($array2[$key]) || !is_array($array2[$key])) {
	                $difference[$key] = $value;
	            } else {
	                $new_diff = self::_diff_assoc($value, $array2[$key]);

	                if(!empty($new_diff)){
	                    $difference[$key] = $new_diff;
	                }
	            }
	        } else if(!array_key_exists($key,$array2) || $array2[$key] !== $value ) {
	            $difference[$key] = $value;
	        }
	    }

	    return $difference;
	}
	/**
	 * preserve key quick sort, default sort ASC
	 * @param array $array
	 */
	public static function quickSort(array $array){
	    if(sizeof($array) <= 1){
	    	return $array;
	    }

	    $_key = key($array);

	    $left = $right = array();
	    foreach($array as $key => $val){
	    	$array[$key] < $array[$_key] ? ($left[$key] = $val) : ($right[$key] = $val);
	    }

	    $left = self::quickSort($left);
	    $right = self::quickSort($right);

	    return array_merge($left, array($_key => $array[$_key]), $right);
	}
} // End arr