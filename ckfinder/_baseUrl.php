<?php
class _baseUrl{
	const BASE_DIR = '../';
	const DEFAULT_PROTOCOL = 'http';

	public static function dir($baseDir = NULL){
		if($baseDir === false){
			return '';
		}else{
			return $baseDir = rtrim(strtr(realpath($baseDir ? $baseDir : __DIR__ . '/' . self::BASE_DIR), array('\\'=>'/','\/'=>'/')), '/') . '/';
		}
	}

	public static function url($baseDir = NULL, $protocol = NULL){
		if($baseDir === false){
			return '';
		}else{
			$baseDir = self::dir($baseDir);

			$baseUrl = strtr('//' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'], array(strtr($_SERVER['SCRIPT_FILENAME'], array($baseDir=>''))=>''));;

			if($protocol === NULL) $protocol = self::DEFAULT_PROTOCOL;

			$colon = $protocol ? ':' : '';

			return $protocol . $colon . $baseUrl;
		}
	}
}