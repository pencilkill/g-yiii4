<?php

/**
 *
 * @author Sam <mail.song.de.qiang@gmail.com>
 *
 */
class HCOutput{

	/**
	 * file
	 *
	 * @param $url, String, file path encode from HCUrl::encode()
	 * @param $name, download file name
	 */
	public static function file($url, $name = NULL){
		$file = HCUrl::decode($url);
		$name = $name ? HCUrl::decode($name) : HCString::random(10);
		$ext = strtolower(strrchr($name, '.')) == strtolower(strrchr($file, '.')) ? '' : strtolower(strrchr($file, '.'));
		$name = $name . $ext;

		$ua = $_SERVER['HTTP_USER_AGENT'];
		$uname = rawurlencode($name);

		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Description: File Transfer');
		header('Content-type: application/force-download');
		header('Content-type: application/octet-stream');
		if(preg_match('/MSIE/', $ua)){
			header('Content-Disposition: attachment; filename="' . $uname . '"');
		}else if(preg_match("/Firefox/", $ua)){
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $name . '"');
		}else{
			header('Content-Disposition: attachment; filename="' . $name . '"');
		}
		//
		$seek = 0;
		$size = filesize($file);

		if(isset($_SERVER['HTTP_RANGE']) && ($_SERVER['HTTP_RANGE'] != "") && preg_match("/^bytes=([0-9]+)-$/i", $_SERVER['HTTP_RANGE'], $matches) && ($matches[1] < $size)){
			$seek = $matches[1];
		}

		$fp = fopen($file, 'rb');
		if(($seek--) > 0){
			fseek($fp, $seek);
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: " . ($size - $seek));
			header("Content-Ranges: bytes" . $seek . "-" . ($size - 1) . "/" . $size);
		}else{
			header("Content-Length: $size");
			Header("Accept-Ranges: bytes");
		}

		fpassthru($fp);

		fclose($fp);

		return true;
	}

	/**
	 * content
	 *
	 * @param $content, String
	 * @param $name, download file name
	 */
	public static function content($content, $name){
		$ua = $_SERVER['HTTP_USER_AGENT'];
		$uname = rawurlencode($name);

		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Description: File Transfer');
		header('Content-type: application/force-download');
		header('Content-type: application/octet-stream');
		if(preg_match('/MSIE/', $ua)){
			header('Content-Disposition: attachment; filename="' . $uname . '"');
		}else if(preg_match("/Firefox/", $ua)){
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $name . '"');
		}else{
			header('Content-Disposition: attachment; filename="' . $name . '"');
		}

		ob_start();
		$fp = fopen('php://output', 'w');
		fwrite($fp, $content);
		fclose($fp);
		header('Content-Length: ' . ob_get_length());
		ob_end_flush();

		return true;
	}

	/**
	 * CSV(Comma Separated Values)
	 * The output file support : MS-excel(directly), OpenOffice(charset UTF-8)
	 *
	 * @param $data, Array
	 * @param $name, download file name
	 */
	public static function CSV($data, $name){
		$ua = $_SERVER['HTTP_USER_AGENT'];
		$uname = rawurlencode($name);

		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Description: File Transfer');
		header('Content-type: application/force-download');
		header('Content-type: application/octet-stream');
		if(preg_match('/MSIE/', $ua)){
			header('Content-Disposition: attachment; filename="' . $uname . '"');
		}else if(preg_match("/Firefox/", $ua)){
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $name . '"');
		}else{
			header('Content-Disposition: attachment; filename="' . $name . '"');
		}

		ob_start();
		$fp = fopen('php://output', 'w');
		fwrite($fp, "\xEF\xBB\xBF"); // BOM, required for charset UTF-8
		fputcsv($fp, $data);
		fclose($fp);
		header('Content-Length: ' . ob_get_length());
		ob_end_flush();

		return true;
	}
}
?>