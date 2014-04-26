<?php
/**
 *
 * @author @author Sam <mail.song.de.qiang@gmail.com> <mail.song.de.qiang@gmail.com>
 *
 */
class HCUrl {
	/**
	 * mixed url, may be using for download url
	 * @param $array
	 * @return String
	 */
    public static function encode($data)
    {
    	$arr = array(
    		'+' => '-',
    		'/' => '_',
    	);

        return rtrim(strtr(base64_encode(gzcompress(serialize($data))), $arr), '=');
    }

    /**
	 * mixed url, may be using for download url
	 * @param $array
	 * @return Array
	 */
    public static function decode($string)
    {
        $arr = array(
            '-' => '+',
            '_' => '/'
        );

        return unserialize(gzuncompress(base64_decode(str_pad(strtr($string, $arr), strlen($string) % 4, '=', STR_PAD_RIGHT))));
    }

    /**
     *
     * reject keys
     *
     * @param $filterKeys
     * @return Array, query array filtered
     */
	public static function filter($filter = array(), $url = null){
		$query = html_entity_decode(urldecode($url === null ? Yii::app()->request->queryString : $url));

		parse_str($query, $params);

		$params = array_diff_key($params, array_flip($filter));

		return $params;
	}
	/**
	 * Trim the base url to get the relative url based on webroot
	 */
	public static function trim($src){
		if(($baseUrl = Yii::app()->getBaseUrl(true)) && strpos($src, Yii::app()->getBaseUrl(true)) === 0){
			$src = substr($src, strlen($baseUrl));
		}else if(($baseUrl = Yii::app()->getBaseUrl(false)) && strpos($src, Yii::app()->getBaseUrl(true)) === 0){
			$src = substr($src, strlen($baseUrl));
		}

		return $src;
	}
}
?>