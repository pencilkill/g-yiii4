<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
class HCString {

    /**
     * Rand making string from specified characters
     * @param $length
     * @return String
     */

    public static function random($length)
    {
        $chars = '';

        // remove o,0,1,l
        $charSet = 'abcdefghijkmnpqrstuvwxyz-ABCDEFGHIJKLMNPQRSTUVWXYZ_23456789';

        $charSetSize = strlen($charsSet) - 1;

        for ($i = 0; $i < $length; $i++) {
            $chars .= $charSet[rand(0, $charSetSize)];
        }

        return $chars;
    }

    /**
     * utf8 strrev, compatiable Chinese
     * @param $str
     * @return String
     */

    public static function utf8_strrev($string)
    {
        preg_match_all('/./us', $string, $matches);

        return implode('', array_reverse($matches[0]));
    }

    /**
     * Actually, Chinese compatiple
     *
     * @param $string
     * @param $length
     */

    public static function utf8_substr($string, $length)
    {
		$stringSize = strlen($string);

		if($length < $stringSize){
			for($i=0; $i<$length; $i++){
				$temp_str = substr($string,0,1);

				if(ord($temp_str) > 127){
					if($i <= $length-3)
					{
						$new_str[] = substr($string,0,3);

						$string = substr($string,3);

						$i += 2;
					}
				}else{
					$new_str[] = substr($string,0,1);

					$string = substr($string,1);
				}
			}

			return implode($new_str) . ' ... ';
		}else{
			return $string;
		}
    }
}
?>