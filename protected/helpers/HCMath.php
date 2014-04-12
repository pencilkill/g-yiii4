<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
/**
 * @example
	$color=array('紅','綠','藍');
	$size=array('M','L','X','XXL');
	$tax=array('自付','代付');
	$method=array('快遞','平郵');

	$permutation=HCMath::permutation(array($color, $size, $tax, $method));

	echo sizeof($permutation) . ' elements <hr/>';

	foreach($permutation as $val){
		echo implode('_',$val),'<br/>';
	}

	echo '<br/>';
	echo '<hr/>';
	echo '<hr/>';
	echo '<hr/>';

	$selector=array('紅', 'M', '自付', '快遞');

	$combination=HCMath::combination('紅', 'M', '自付', '快遞');

	echo sizeof($combination) . ' elements <hr/>';

	foreach($combination as $val){
		echo implode('_',$val),'<br/>';
	}
*/
class HCMath{

	private static function _combine($base, &$result, $swap = array()){
		if(empty($base)){
			$result[] = $swap;
		}else{
			for($i = sizeof($base) - 1; $i >= 0; --$i) {
				$_base = $base;
				$_swap = $swap;

				list($item) = array_splice($_base, $i, 1);

				array_unshift($_swap, $item);

				self::_combine($_base, $result, $_swap);
			}
		}
	}

	public static function combination(){
		$base = func_num_args()==1 ? func_get_arg(0) : func_get_args();
		$result = array();

		self::_combine($base, $result);

		return $result;
	}

	private static function _permutate($base, &$result, $swap = array(), $offset = 0){
		if(empty($base[$offset]) || !is_array($base[$offset])){
			$result[] = $base;
		}else{
			foreach($base[$offset] as $k=>$v) {
				$swap[$offset] = $base[$offset][$k];

				if($offset == sizeof($base) - 1){
					array_push($result,array_merge($swap));
				}else{
					self::_permutate($base, $result, $swap, $offset + 1);
				}
			}
		}
	}

	public static function permutation() {
		$base = func_num_args()==1 ? func_get_arg(0) : func_get_args();
		$result = array();

		self::_permutate($base, $result);

		return $result;
	}
}
?>