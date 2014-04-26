<?php
/**
 *
 * @author Sam <mail.song.de.qiang@gmail.com>
 *
 */
class HCObject {
	public static function toArray($object){
		$result = array();

		$object = is_object($object) ? get_object_vars($object) : $object;
		foreach ($object as $key => $val) {
			$val = (is_array($val) || is_object($val)) ? self::toArray($val) : $val;

			$result[$key] = $val;
		}

		return $result;
	}
}