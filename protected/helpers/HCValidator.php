<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
class HCValidator {
	/**
	 * Validate multiple email by a specified separator
	 *
	 * @param $email, mixed, String or Array
	 * @param $required, Bool, whether the email is required
	 * @param $separator, Char, email separator for argument 0 if it is string
	 */
	public static function email($email, $required = true, $separator = ','){
		$email = is_array($email) ? $email : (is_string($email) ? explode($separator, trim($email)) : array());

		if(empty($email) && $required){
			return false;
		}

		$valid = true;

		foreach (explode($separator, $email) as $val){
			if(!($val && filter_var($val, FILTER_VALIDATE_EMAIL))){
				$valid = false;

				break;
			}
		}

		return $valid;
	}
}
?>