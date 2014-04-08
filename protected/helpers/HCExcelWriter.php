<?php
/**
 * Excel export class

 * @author Sam,sam@ozchamp.net
 *
 */
class HCExcelWriter
{

	private $_excel;
	//
	public $version;

	public function __construct($version = 'Excel5'){
        $this->version = in_array($version, array('Excel5', 'Excel2007')) ? $version : 'Excel5';

        Yii::import('frontend.extensions.Excel.PHPExcel.Writer.IWriter');
        Yii::import('frontend.extensions.Excel.PHPExcel.Writer.' . $this->version);
        Yii::import('frontend.extensions.Excel.PHPExcel');
        Yii::import('frontend.extensions.Excel.PHPExcel.IOFactory');

        $this->_excel = new PHPExcel();
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
			$this->_excel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($col_header_index).$row_header_index, $val);
			$col_header_index++;
		}
		// Data
		$row_index = $row_start + (int)(!empty($header));
		foreach($data as $row){
			$col_index = $col_start;
			foreach ($row as $val){
				$this->_excel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($col_index).$row_index, $val);
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
       	$name = rawurlencode($filename);

       	$writer = "PHPExcel_Writer_{$this->version}";
       	$obj_writer = new $writer($this->_excel);

       	header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
       	header('Content-Description: File Transfer');
    	header('Content-type: application/force-download');
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