<?php
/**
 *
 * @author Sam@ozchamp.net
 *
 */
class HCInput {
	/**
	 * fgetcsv, Compatible Chinese
	 *
	 * @param string $filename
	 * @param string $locale, setlocale for csv file
	 * @param string $to, mb_convert_encoding to charset for field
	 * @param string $from, mb_convert_encoding from charset for field
	 * @return multitype:multitype:string
	 */
	public static function fgetcsv($filename, $locale = 'en_US.UTF-8', $to = 'UTF-8', $from = 'UTF-8,BIG5,GBK')
	{
		setlocale(LC_ALL, 'en_US.UTF-8');

		$result=array();

		$index = 1;

		if(($fp = fopen($filename, 'r')) !== false)
		{
			while(($row = self::_fgetcsv($fp)) !== false)
			{
				$_row=array();

				for ($i = 0, $n = sizeof($row); $i < $n; $i++)
				{
					if($index === 1)
					{
						$header[] = $row[$i];
					}
					else
					{
						foreach ($header as $k=>$v)
						{
							if($k == $i)
							{

								$row[$i]=  mb_convert_encoding($row[$i],'UTF-8','UTF-8,GBK,BIG5');	// origin encoding : GBK
								//$row[$i]=  mb_convert_encoding($row[$i],'UTF-8','UTF-8,BIG5,GBK');	// origin encoding : BIG5

								/*
								 * Column callback
								*/

								//
								$_row[$v]=$row[$i];
					 	}
						}

						/*
						 * Row callback
						*/

					}

				}

				if(!empty($_row))
				{
					$result[] = $_row;
				}

				$index++;

			}
			fclose($fp);
		}

		return $result;
	}
}
?>