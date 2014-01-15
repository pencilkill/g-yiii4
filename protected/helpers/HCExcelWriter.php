<?php
/**
 * Excel export class

 * @author Sam,sam@ozchamp.net
 *
 */
class HCExcelWriter
{

	public $version;
	public $phpexcel;

	public function __construct($version = 'Excel5'){
        $this->version = in_array($version, array('Excel5', 'Excel2007')) ? $version : 'Excel5';

        Yii::import('frontend.extensions.PHPExcel.Writer.IWriter');
        Yii::import('frontend.extensions.PHPExcel.Writer.' . $this->version);
        Yii::import('frontend.extensions.PHPExcel');
        Yii::import('frontend.extensions.PHPExcel.IOFactory');

        $this->phpexcel = new PHPExcel();
	}
	/**
	 * Setting excel data, the data should be convertted to target charset before setted as data
	 * @param $header, Array, header should be an one dimension array, it can be a zero size array
	 * @param $data, Array, data should be a two dimension array.
	 * @param $col_start, Integer, the column start index where header and data writer from, default as 1
	 * @param $row_start, Integer, the row start index where header writer from, default as 1
	 */
	public function setData($header = array(), $data = array(array()), $col_start =0, $row_start= 1){
		// Header
		$col_header_index = $col_start;
		$row_header_index = $row_start;
		foreach($header as $val){
			$this->phpexcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($col_header_index).$row_header_index, $val);
			$col_header_index++;
		}
		// Data
		$row_index = $row_start + (int)(!empty($header));
		foreach($data as $row){
			$col_index = $col_start;
			foreach ($row as $val){
				$this->phpexcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($col_index).$row_index, $val);
				$col_index++;
			}
			$row_index++;
		}
	}
	/**
	 * Download current excel data file
	 * It will fix the file extension dynamic
	 * @param $filename, String, dafault setting time() as name if it is empty
	 */
	public function download($filename = ''){
		$ext = $this->version == 'Excel5' ? 'xls' : 'xlsx';

		$filename = $filename ? (strpos($filename, '.') ? $filename : $filename.'.'.$ext) : (time().'.'.$ext);

		$fa = explode('.', $filename);
		if(end($fa) != $ext){
			array_pop($fa);
			$filename = implode('.', $fa).'.'.$ext;
		}

		$ua = $_SERVER["HTTP_USER_AGENT"];
       	$name = strtr(urlencode($filename), array('+'=>'%20'));

       	$writer = "PHPExcel_Writer_{$this->version}";
       	$obj_writer = new $writer($this->phpexcel);

       	header("Content-type:application/vnd.ms-excel");
    	if (preg_match("/MSIE/", $ua)) {
    		header('Content-Disposition: attachment; filename="' . $name . '"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
		} else {
			header('Content-Disposition: attachment; filename="' . $filename . '"');
		}

		$obj_writer->save('php://output');
	}
}
?>