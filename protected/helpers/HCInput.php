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
	 * @param string $to_encoding, mb_convert_encoding to charset for field
	 * @param string $from_encoding, mb_convert_encoding from charset for field
	 * @return multitype:multitype:string
	 */
	public static function fgetcsv($filename, $locale = 'zh_TW', $to_encoding = 'UTF-8', $from_encoding = 'UTF-8,BIG5,GBK')
	{
		setlocale(LC_ALL, $locale);

		$result=array();

		$index = 1;

		if(($fp = fopen($filename, 'r')) !== false)
		{
			while(($row = fgetcsv($fp)) !== false)
			{
				$_row=array();

				for ($i = 0, $n = sizeof($row); $i < $n; $i++)
				{
					if($index === 1)
					{
						$header[] = mb_convert_encoding($row[$i], $to_encoding, $from_encoding);
					}
					else
					{
						foreach ($header as $k=>$v)
						{
							if($k == $i)
							{

								$row[$i]=  mb_convert_encoding($row[$i], $to_encoding, $from_encoding);

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

		//reset locale
		setlocale(LC_ALL, NULL);

		return $result;
	}
}
?>