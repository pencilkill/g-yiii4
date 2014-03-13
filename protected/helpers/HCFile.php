<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
class HCFile{
	const MODE_BASE = 1024;
	/**
	 * Convert file size to bytes based on 1024
	 *
	 * @param $size, String, file size, it will not be converted if unit can not find
	 * @param $precision, Integer. precision, default as 2
	 * @return float
	 */
	public static function toBytes($size, $precision = 2){
		$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

		$va = rtrim(strtoupper($size), 'B') . 'B';

		if(preg_match('/([a-zA-Z]+)$/', $va, $matches) && ($pow = array_search($matches[1], $units)) !== false){
			$va = max(preg_replace('/' . $matches[1] . '$/', '', $va) + 0.0, 0.0);

			$va *= pow(self::MODE_BASE, $pow);
		}

		return round((float)$va, $precision);
	}

	/**
	 * Format file size which  based on 1024
	 *
	 * @param $size, file size
	 * @param $unit, target unit. default null. if $unit is null, the format will return when a value size bigger than 1.0(unit) automically.
	 * @param $precision, Integer. precision, default as 2
	 * @return String
	 */

	public static function formatBytes($size, $unit = NULL, $precision = 2){
		$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

		$unit = $unit ? strtoupper($unit) : NULL;

		if(empty($unit) || array_search($unit, $units) == false){
			$unit = null;
		}

		$va = self::toBytes($size, 6);

		foreach($units as $u){
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

		return rtrim($va, 'B') . 'B';
	}
}
?>