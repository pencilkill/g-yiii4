<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
class HCOutput {
	/**
	 * file
	 * @param $url
	 * @param $name
	 */
	public static function file($url, $name=null){
		$file = HCUrl::decode($url);
       	$name = $name ? HCUrl::decode($name) : HCString::random(10);
        $ext = strtolower(strrchr($name, '.'))==strtolower(strrchr($file, '.')) ? '' : strtolower(strrchr($file, '.'));
        $name = $name.$ext;


       	$ua = $_SERVER['HTTP_USER_AGENT'];
       	$uname = rawurldecode($name);

       	header('Content-Description: File Transfer');
    	header('Content-type: application/octet-stream');
    	if (preg_match('/MSIE/', $ua)) {
    		header('Content-Disposition: attachment; filename="' . $uname . '"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $name . '"');
		} else {
			header('Content-Disposition: attachment; filename="' . $name . '"');
		}
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: '.filesize($file));

        @readfile($file);

    	exit();
	}
	/**
	 * content
	 * @param $content
	 * @param $name
	 */
	public static function content($content, $name){
       	$ua = $_SERVER['HTTP_USER_AGENT'];
       	$uname = rawurldecode($name);

       	header('Content-Description: File Transfer');
    	header('Content-type: application/octet-stream');
    	if (preg_match('/MSIE/', $ua)) {
    		header('Content-Disposition: attachment; filename="' . $uname . '"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $name . '"');
		} else {
			header('Content-Disposition: attachment; filename="' . $name . '"');
		}
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');

        ob_start();
    	$fp = fopen('php://output', 'w');
    	fwrite($fp, $content);
    	fclose($fp);
        header('Content-Length: ' . ob_get_length());
        ob_end_flush();

    	exit();
	}
}
?>