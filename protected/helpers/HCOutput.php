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
	public static function file($url, $name=NULL){
		$file = HCUrl::decode($url);
       	$name = $name ? HCUrl::decode($name) : HCString::random(10);
        $ext = strtolower(strrchr($name, '.'))==strtolower(strrchr($file, '.')) ? '' : strtolower(strrchr($file, '.'));
        $name = $name.$ext;


       	$ua = $_SERVER['HTTP_USER_AGENT'];
       	$uname = rawurlencode($name);

        header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
       	header('Content-Description: File Transfer');
    	header('Content-type: application/force-download');
    	header('Content-type: application/octet-stream');
    	if (preg_match('/MSIE/', $ua)) {
    		header('Content-Disposition: attachment; filename="' . $uname . '"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $name . '"');
		} else {
			header('Content-Disposition: attachment; filename="' . $name . '"');
		}
        header('Content-Length: '.filesize($file));

        readfile($file);

        return true;
	}
	/**
	 * content
	 * @param $content
	 * @param $name
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
    	if (preg_match('/MSIE/', $ua)) {
    		header('Content-Disposition: attachment; filename="' . $uname . '"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $name . '"');
		} else {
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
}
?>