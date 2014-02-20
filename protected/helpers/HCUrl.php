<?php
/**
 *
 * @author Sam@ozchamp.net
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
            '=' => '_',
            '+' => '.'
        );

        return strtr(base64_encode(serialize($data)),$arr);
    }

    /**
	 * mixed url, may be using for download url
	 * @param $array
	 * @return Array
	 */
    public static function decode($string)
    {
        $arr = array(
            '_' => '=',
            '.' => '+'
        );

        return unserialize(base64_decode(strtr($string,$arr)));
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
}
?>