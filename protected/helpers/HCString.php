<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
class HCString {
	// plural set
	private static $plural = array(
		'/(quiz)$/i'               => "$1zes",
		'/^(ox)$/i'                => "$1en",
		'/([m|l])ouse$/i'          => "$1ice",
		'/(matr|vert|ind)ix|ex$/i' => "$1ices",
		'/(x|ch|ss|sh)$/i'         => "$1es",
		'/([^aeiouy]|qu)y$/i'      => "$1ies",
		'/(hive)$/i'               => "$1s",
		'/(?:([^f])fe|([lr])f)$/i' => "$1$2ves",
		'/(shea|lea|loa|thie)f$/i' => "$1ves",
		'/sis$/i'                  => "ses",
		'/([ti])um$/i'             => "$1a",
		'/(tomat|potat|ech|her|vet)o$/i'=> "$1oes",
		'/(bu)s$/i'                => "$1ses",
		'/(alias)$/i'              => "$1es",
		'/(octop)us$/i'            => "$1i",
		'/(ax|test)is$/i'          => "$1es",
		'/(us)$/i'                 => "$1es",
		'/s$/i'                    => "s",
		'/$/'                      => "s",
	);

	// singular set
	private static $singular = array(
		'/(quiz)zes$/i'             => "$1",
		'/(matr)ices$/i'            => "$1ix",
		'/(vert|ind)ices$/i'        => "$1ex",
		'/^(ox)en$/i'               => "$1",
		'/(alias)es$/i'             => "$1",
		'/(octop|vir)i$/i'          => "$1us",
		'/(cris|ax|test)es$/i'      => "$1is",
		'/(shoe)s$/i'               => "$1",
		'/(o)es$/i'                 => "$1",
		'/(bus)es$/i'               => "$1",
		'/([m|l])ice$/i'            => "$1ouse",
		'/(x|ch|ss|sh)es$/i'        => "$1",
		'/(m)ovies$/i'              => "$1ovie",
		'/(s)eries$/i'              => "$1eries",
		'/([^aeiouy]|qu)ies$/i'     => "$1y",
		'/([lr])ves$/i'             => "$1f",
		'/(tive)s$/i'               => "$1",
		'/(hive)s$/i'               => "$1",
		'/(li|wi|kni)ves$/i'        => "$1fe",
		'/(shea|loa|lea|thie)ves$/i'=> "$1f",
		'/(^analy)ses$/i'           => "$1sis",
		'/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i'  => "$1$2sis",
		'/([ti])a$/i'               => "$1um",
		'/(n)ews$/i'                => "$1ews",
		'/(h|bl)ouses$/i'           => "$1ouse",
		'/(corpse)s$/i'             => "$1",
		'/(us)es$/i'                => "$1",
		'/(us|ss)$/i'               => "$1",
		'/s$/i'                     => "",
	);

	// irregular set
	private static $irregular = array(
		'move'   => 'moves',
		'foot'   => 'feet',
		'goose'  => 'geese',
		'sex'    => 'sexes',
		'child'  => 'children',
		'man'    => 'men',
		'tooth'  => 'teeth',
		'person' => 'people',
	);

	// uncountable set
	private static $uncountable = array(
		'sheep',
		'fish',
		'deer',
		'series',
		'species',
		'money',
		'rice',
		'information',
		'equipment',
	);

    /**
     * Rand making string from specified characters
     * @param $length
     * @return string
     */

    public static function random($length)
    {
        $string = '';

        // Remove 0, 1, o, l, O, I
        $characters = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';

        $range = strlen($characters) - 1;

        for($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, $range)];
        }

        return $string;
    }

    /**
     * Actually, Chinese compatiple
     *
     * @param $string
     * @param $length
     * @return string
     */

    public static function substr($string, $length)
    {
		$stringSize = strlen($string);

		if($length < $stringSize){
			for($i=0; $i < $length; $i++){
				$temp_str = substr($string, 0, 1);

				if(ord($temp_str) > 127){
					if($i <= $length - 3)
					{
						$new_str[] = substr($string, 0, 3);

						$string = substr($string, 3);

						$i += 2;
					}
				}else{
					$new_str[] = substr($string, 0, 1);

					$string = substr($string, 1);
				}
			}

			return implode($new_str) . ' &hellip; ';
		}else{
			return $string;
		}
    }

    /**
     *
     * @param string $string
     * @return string
     */

    public static function singularize(string $string)
	{
		$string = strval($string);

		if(in_array(strtolower($string), self::$uncountable)){
			return $string;
		}

		foreach(self::$irregular as $result => $pattern)
		{
			$pattern = '/' . $pattern . '$/i';

			if(preg_match($pattern, $string)){
				return preg_replace($pattern, $result, $string);
			}
		}

		foreach(self::$singular as $pattern => $result)
		{
			if(preg_match($pattern, $string)){
				return preg_replace($pattern, $result, $string);
			}
		}

		return $string;
	}

    /**
     *
     * @param string $string
     * @return string
     */
	public static function pluralize(string $string)
	{
		$string = strval($string);

		if(in_array(strtolower($string), self::$uncountable)){
			return $string;
		}

		foreach(self::$irregular as $pattern => $result)
		{
			$pattern = '/' . $pattern . '$/i';

			if(preg_match($pattern, $string)){
				return preg_replace($pattern, $result, $string);
			}
		}

		foreach(self::$plural as $pattern => $result)
		{
			if(preg_match($pattern, $string)){
				return preg_replace($pattern, $result, $string);
			}
		}

		return $string;
	}

    /**
     *
     * @param string $string
     * @return string
     */
    public static function camelize(string $string)
    {
    	$string = 'x'.strtolower(trim($string));
    	$string = ucwords(preg_replace('/[\s_]+/', ' ', $string));
    	return substr(str_replace(' ', '', $string), 1);
    }

    /**
     *
     * @param string $string
     * @return string
     */
    public static function underscore(string $string)
    {
    	return preg_replace('/[\s]+/', '_', strtolower(trim($string)));
    }

    /**
     *
     * @param string $string
     * @return string
     */
    public static function humanize(string $string)
    {
    	return ucwords(preg_replace('/[_]+/', ' ', strtolower(trim($string))));
    }
}
?>