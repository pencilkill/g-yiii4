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
    public static function encode($array)
    {
        $arr = array(
            '=' => '_',
            '+' => '.'
        );

        return strtr(base64_encode(serialize($array)),$arr);
    }

    /**
	 * mixed url, may be using for download url
	 * @param $array
	 * @return Array
	 */
    public static function decode($array)
    {
        $arr = array(
            '_' => '=',
            '.' => '+'
        );

        return unserialize(base64_decode(strtr($array,$arr)));
    }

    /**
     *
     * reject keys
     *
     * @param $filterKeys
     * @return Array, query array filtered
     */

	public static function filter($filter = array(), $url = null){
		$queryString = html_entity_decode(urldecode($url === null ? Yii::app()->request->queryString : $url));

		parse_str($queryString, $params);

		$params = array_diff_key($params, array_flip($filter));

		return $params;
	}
}
?>