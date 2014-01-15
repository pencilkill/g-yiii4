<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
class HCOutput {
	/**
	 * download
	 * @param $url
	 * @param $name
	 */
	public static function download($url, $name=null){
		$url = HCUrl::decode($url);
       	$name = $name ? HCUrl::decode($name) : HCSting::random(10);
        $ext = strtolower(strrchr($name,'.'))==strtolower(strrchr($url,'.')) ? '' : strtolower(strrchr($url,'.'));
        $name = $name.$ext;


       	$ua = $_SERVER['HTTP_USER_AGENT'];
       	$filename = strtr(urlencode($name), array('+'=>'%20'));

    	header('Content-type:application');
    	if (preg_match('/MSIE/', $ua)) {
    		header('Content-Disposition: attachment; filename="' . $filename . '"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $name . '"');
		} else {
			header('Content-Disposition: attachment; filename="' . $name . '"');
		}

    	readfile($url);

    	exit();
	}
}
?>