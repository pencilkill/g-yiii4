<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
class HCValidator {
	/**
	 *
	 * @param $email
	 * @param $separator
	 */
	public static function validEmail($email, $separator = ','){
		$email = trim($email);

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