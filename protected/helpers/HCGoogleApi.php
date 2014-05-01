<?php
/**
 *
 * @author Sam <mail.song.de.qiang@gmail.com>
 *
 */
class HCGoogleApi{
	const API_KEY = '';
	//
	const URL_TRANSLATE = 'http://translate.google.cn/translate_a/t';

	/**
	 *
	 * @param String $text
	 * @param String $tl, source language code
	 * @param String $sl, target language code
	 * @param Array $option, extra option, e.g. ie(input encode), oe(output encode)
	 * @return mixed
	 */
	public static function translate($text, $tl, $sl = null , $option = array()){
		$uri = array_merge(array(
			'client' => 't',
			'hl' => 'zh-CN',
			'ie' => 'UTF-8',     // input    encode
			'oe' => 'UTF-8',     // output   encode
		),array(
			'text' => $text,
			'sl' => $sl,	// source language
			'tl' => $tl,	// target language
		), $option);

		$url = self::URL_TRANSLATE;

		$amp = strpos($url, '?') === false ? '?' : '&';

		$url .= $amp . http_build_query($uri);

		$response = file_get_contents($url);

		$result = '';

		if(preg_match('/\s*\[\[\[\s*"(.*?)"\s*,\s*"/', $response, $results)){
			list($text, $result) = $results;
		}

		return $result;
	}
}
