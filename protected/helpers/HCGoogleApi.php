<?php
/**
 *
 * @author Sam <mail.song.de.qiang@gmail.com>
 *
 */
class HCGoogleApi{
	//
	const API_KEY = 'AIzaSyD2d-HWDJ5CxW0ZMvW-avIwVesXjIaLL-M';
	// Translation does not require api, it is based on google web translation
	const URL_TRANSLATE = 'http://translate.google.cn/translate_a/t';
	// Url shorten, more about url shorten can be found at https://developers.google.com/url-shortener/v1/getting_started
	const URL_SHORTEN = 'https://www.googleapis.com/urlshortener/v1/url';

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

	/**
	 *
	 * @param String $url
	 * @param String $apiKey
	 * @return Ambigous <NULL, string, mixed>
	 */
	public static function shorten($url, $apiKey = self::API_KEY){
		$uri = array(
			'key' => $apiKey,
		);
		$apiUrl = self::URL_SHORTEN;
		$amp = strpos($apiUrl, '?') == 0 ? '?' : '&';
		$apiUrl .= $amp . http_build_query($uri);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("longUrl"=>$url)));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);

		$result = null;
		if($response = json_decode($response, true)){
			$result = isset($response['id']) ? $response['id'] : '';
		}

		return $result;
	}

	/**
	 *
	 * @param String $url
	 * @param String $apiKey
	 * @return Ambigous <NULL, string, mixed>
	 */
	public static function expand($url, $apiKey = self::API_KEY){
		$uri = array(
			'key' => $apiKey,
			'shortUrl' => $url,
		);
		$apiUrl = self::URL_SHORTEN;
		$amp = strpos($apiUrl, '?') == 0 ? '?' : '&';
		$apiUrl .= $amp . http_build_query($uri);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);

		$result = null;
		if($response = json_decode($response, true)){
			$result = isset($response['longUrl']) ? $response['longUrl'] : '';
		}

		return $result;
	}
}
