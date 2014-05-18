<?php
/**
 *
 * @author Sam <mail.song.de.qiang@gmail.com>
 *
 */
class HCSinaApi{
	// weibo apikey
	const API_KEY = '3752406443';
	//
	const URL_SHORT = 'http://api.t.sina.com.cn/short_url/shorten.json';
	const URL_LONG = 'http://api.t.sina.com.cn/short_url/expand.json';

	public static function shorten($url){
		$uri = array(
			'source' => self::API_KEY,
			'url_long' => $url,
		);
		$apiUrl =  self::URL_SHORT;
		$amp = strpos($apiUrl, '?') === false ? '?' : '&';
		$apiUrl .= $amp . http_build_query($uri);
		//
		$response = file_get_contents($apiUrl);
		//
		$url = '';
		if($json = json_decode($response)){
			$url = $json[0]->url_short;
		}

		return $url;
	}

	public static function expand($url){
		$uri = array(
			'source' => self::API_KEY,
			'url_short' => $url,
		);
		$apiUrl =  self::URL_SHORT;
		$amp = strpos($apiUrl, '?') === false ? '?' : '&';
		$apiUrl .= $amp . http_build_query($uri);
		//
		$response = file_get_contents($apiUrl);
		//
		$url = '';
		if($json = json_decode($response)){
			$url = $json[0]->url_long;
		}

		return $url;
	}
}