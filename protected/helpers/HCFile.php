<?php
/**
 *
 * @author Sam <mail.song.de.qiang@gmail.com>
 *
 */
class HCFile{
	const MODE_BASE = 1024;
	public static $allowUnits = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

	/**
	 * Normalize unit
	 *
	 * @param $size, mixed
	 * @return string
	 */
	protected static function normalize($size){
		return rtrim(strtoupper($size), 'B') . 'B';
	}
	/**
	 * Convert file size to bytes based on 1024
	 *
	 * @param $size, String, file size, it will not be converted if unit can not find
	 * @param $precision, Integer. precision, default as 2
	 * @return float
	 */
	public static function toBytes($size, $precision = 2){
		$va = self::normalize($size);

		if(preg_match('/([a-zA-Z]+)$/', $va, $matches) && ($pow = array_search($matches[1], self::$allowUnits)) !== false){
			$va = max(preg_replace('/' . $matches[1] . '$/', '', $va) + 0.0, 0.0);

			$va *= pow(self::MODE_BASE, $pow);
		}

		return round((float)$va, $precision);
	}

	/**
	 * Format file size which  based on 1024
	 *
	 * @param $size, file size
	 * @param $unit, target unit. default null. if $unit is null, the format will return when a value size smaller than 1024 automically.
	 * @param $precision, Integer. precision, default as 2
	 * @return String
	 */

	public static function formatBytes($size, $unit = NULL, $precision = 2){
		$unit = $unit ? strtoupper($unit) : NULL;

		if(empty($unit) || array_search($unit, self::$allowUnits) == false){
			$unit = null;
		}

		$va = self::toBytes($size, 6);

		foreach(self::$allowUnits as $u){
			if($unit){
				if($u == $unit){
					$va = round($va, $precision) . $u;

					break;
				}
			}else if($va < self::MODE_BASE){
				$va = round($va, $precision) . $u;

				break;
			}

			$va /= 1024;
		}

		return self::normalize($va);
	}
}
?>