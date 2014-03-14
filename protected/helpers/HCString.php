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

    /**
     *
     * @param string $str
     * @return Ambigous <string, mixed>
     */

    public static function singular(string $str)
    {
    	$result = strval($str);

    	$singular_rules = array(
    		'/(matr)ices$/'         => '\1ix',
    		'/(vert|ind)ices$/'     => '\1ex',
    		'/^(ox)en/'             => '\1',
    		'/(alias)es$/'          => '\1',
    		'/([octop|vir])i$/'     => '\1us',
    		'/(cris|ax|test)es$/'   => '\1is',
    		'/(shoe)s$/'            => '\1',
    		'/(o)es$/'              => '\1',
    		'/(bus|campus)es$/'     => '\1',
    		'/([m|l])ice$/'         => '\1ouse',
    		'/(x|ch|ss|sh)es$/'     => '\1',
    		'/(m)ovies$/'           => '\1\2ovie',
    		'/(s)eries$/'           => '\1\2eries',
    		'/([^aeiouy]|qu)ies$/'  => '\1y',
    		'/([lr])ves$/'          => '\1f',
    		'/(tive)s$/'            => '\1',
    		'/(hive)s$/'            => '\1',
    		'/([^f])ves$/'          => '\1fe',
    		'/(^analy)ses$/'        => '\1sis',
    		'/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/' => '\1\2sis',
    		'/([ti])a$/'            => '\1um',
    		'/(p)eople$/'           => '\1\2erson',
    		'/(m)en$/'              => '\1an',
    		'/(s)tatuses$/'         => '\1\2tatus',
    		'/(c)hildren$/'         => '\1\2hild',
    		'/(n)ews$/'             => '\1\2ews',
    		'/([^u])s$/'            => '\1',
    	);

    	foreach ($singular_rules as $rule => $replacement)
    	{
    		if (preg_match($rule, $result))
    		{
    			$result = preg_replace($rule, $replacement, $result);
    			break;
    		}
    	}

    	return $result;
    }

    /**
     *
     * @param string $str
     * @param bool $force
     * @return Ambigous <string, mixed>
     */
    public static function plural(string $str, bool $force = FALSE)
    {
    	$result = strval($str);

    	$plural_rules = array(
    		'/^(ox)$/'                 => '\1\2en',     // ox
    		'/([m|l])ouse$/'           => '\1ice',      // mouse, louse
    		'/(matr|vert|ind)ix|ex$/'  => '\1ices',     // matrix, vertex, index
    		'/(x|ch|ss|sh)$/'          => '\1es',       // search, switch, fix, box, process, address
    		'/([^aeiouy]|qu)y$/'       => '\1ies',      // query, ability, agency
    		'/(hive)$/'                => '\1s',        // archive, hive
    		'/(?:([^f])fe|([lr])f)$/'  => '\1\2ves',    // half, safe, wife
    		'/sis$/'                   => 'ses',        // basis, diagnosis
    		'/([ti])um$/'              => '\1a',        // datum, medium
    		'/(p)erson$/'              => '\1eople',    // person, salesperson
    		'/(m)an$/'                 => '\1en',       // man, woman, spokesman
    		'/(c)hild$/'               => '\1hildren',  // child
    		'/(buffal|tomat)o$/'       => '\1\2oes',    // buffalo, tomato
    		'/(bu|campu)s$/'           => '\1\2ses',    // bus, campus
    		'/(alias|status|virus)/'   => '\1es',       // alias
    		'/(octop)us$/'             => '\1i',        // octopus
    		'/(ax|cris|test)is$/'      => '\1es',       // axis, crisis
    		'/s$/'                     => 's',          // no change (compatibility)
    		'/$/'                      => 's',
    	);

    	foreach ($plural_rules as $rule => $replacement)
    	{
    		if (preg_match($rule, $result))
    		{
    			$result = preg_replace($rule, $replacement, $result);
    			break;
    		}
    	}

    	return $result;
    }

    /**
     *
     * @param string $str
     * @return string
     */
    public static function camelize(string $str)
    {
    	$str = 'x'.strtolower(trim($str));
    	$str = ucwords(preg_replace('/[\s_]+/', ' ', $str));
    	return substr(str_replace(' ', '', $str), 1);
    }

    /**
     *
     * @param string $str
     * @return mixed
     */
    public static function underscore(string $str)
    {
    	return preg_replace('/[\s]+/', '_', strtolower(trim($str)));
    }

    /**
     *
     * @param string $str
     * @return string
     */
    public static function humanize(string $str)
    {
    	return ucwords(preg_replace('/[_]+/', ' ', strtolower(trim($str))));
    }
}
?>