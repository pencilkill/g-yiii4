<?php
/**
 * DbMessageCommand class file.
*
* @author Alexander Kochetov <creocoder@gmail.com>
* @link https://github.com/creocoder/yii-dbmessage-command
* @copyright Copyright &copy; 2012 Alexander Kochetov
* @license https://github.com/creocoder/yii-dbmessage-command/blob/master/LICENSE
*/

/**
 * DbMessageCommand extracts messages to be translated from source files.
* The extracted messages are saved to database.
*
* @version 0.03
* @author Alexander Kochetov <creocoder@gmail.com>
*/
Yii::import('system.cli.commands.MessageCommand');

class DbMessageCommand extends MessageCommand
{
	public function getHelp()
	{
		return <<<EOD
USAGE
  yiic dbmessage <config-file>

DESCRIPTION
  This command searches for messages to be translated in the specified
  source files and save them into database.

PARAMETERS
 * config-file: required, the path of the configuration file. You can find
   an example in framework/messages/config.php.

   The file can be placed anywhere and must be a valid PHP script which
   returns an array of name-value pairs. Each name-value pair represents
   a configuration option.

   The following options are available:

   - sourcePath: string, root directory of all source files.
   - connectionID: string the ID of the database connection application
     component. Defaults to 'db'.
   - sourceMessageTable: string the name of the source message table.
     Defaults to 'SourceMessage'.
   - fileTypes: array, a list of file extensions (e.g. 'php', 'xml').
     Only the files whose extension name can be found in this list
     will be processed. If empty, all files will be processed.
   - exclude: array, a list of directory and file exclusions. Each
     exclusion can be either a name or a path. If a file or directory name
     or path matches the exclusion, it will not be copied. For example,
     an exclusion of '.svn' will exclude all files and directories whose
     name is '.svn'. And an exclusion of '/a/b' will exclude file or
     directory 'sourcePath/a/b'.
   - translator: the name of the function for translating messages.
     Defaults to 'Yii::t'. This is used as a mark to find messages to be
     translated. Accepts both string for single function name or array for
     multiple function names.
   - removeOld: if message no longer needs translation it will be removed,
     instead of being enclosed between a pair of '@@' marks.

EOD;
	}

	/**
	 * Execute the action.
	 * @param array command line parameters specific for this command
	 */
	public function run($args)
	{
		if(!isset($args[0]))
			$this->usageError('the configuration file is not specified.');

		if(!is_file($args[0]))
			$this->usageError("the configuration file {$args[0]} does not exist.");

		$config=require_once($args[0]);
		$translator='Yii::t';
		extract($config);

		if(!isset($sourcePath))
			$this->usageError('The configuration file must specify "sourcePath".');

		if(!is_dir($sourcePath))
			$this->usageError("The source path $sourcePath is not a valid directory.");

		$dbConnection=Yii::app()->getComponent(isset($connectionID) ? $connectionID : 'db');

		if(!$dbConnection instanceof CDbConnection)
			$this->usageError('The "connectionID" must refer to a valid database application component.');

		if(!isset($sourceMessageTable))
			$sourceMessageTable='SourceMessage';

		if(!isset($removeOld))
			$removeOld=false;

		$options=array();

		if(isset($fileTypes))
			$options['fileTypes']=$fileTypes;

		if(isset($exclude))
			$options['exclude']=$exclude;

		$files=CFileHelper::findFiles(realpath($sourcePath),$options);

		$messages=array();

		foreach($files as $file)
			$messages=array_merge_recursive($messages,$this->extractMessages($file,$translator));

		$this->saveMessagesToDb($messages,$dbConnection,$sourceMessageTable,$removeOld);
	}

	protected function saveMessagesToDb($messages,$dbConnection,$sourceMessageTable,$removeOld)
	{
		$command=$dbConnection->createCommand()
		->select(array('id','category','message'))
		->from($sourceMessageTable);

		$current=array();

		foreach($command->queryAll() as $row)
			$current[$row['category']][$row['id']]=$row['message'];

		$new=array();
		$obsoleted=array();

		foreach($messages as $category=>$msgs)
		{
			$msgs=array_unique($msgs);

			if(isset($current[$category]))
			{
				$new[$category]=array_diff($msgs,$current[$category]);
				$obsoleted=array_diff($current[$category],$msgs);
			}
			else
				$new[$category]=$msgs;
		}

		foreach(array_diff(array_keys($current),array_keys($messages)) as $category)
			$obsoleted+=$current[$category];

		if(!$removeOld)
		{
			foreach($obsoleted as $pk=>$m)
			{
				if(substr($m,0,2)==='@@' && substr($m,-2)==='@@')
					unset($obsoleted[$pk]);
			}
		}

		$obsoleted=array_keys($obsoleted);
		echo "Inserting new messages...";
		$savedFlag=false;

		foreach($new as $category=>$msgs)
		{
			foreach($msgs as $m)
			{
				$savedFlag=true;

				$dbConnection->createCommand()
				->insert($sourceMessageTable,array('category'=>$category,'message'=>$m));
			}
		}

		echo $savedFlag ? "saved.\n" : "nothing new...skipped.\n";
		echo $removeOld ? "Deleting obsoleted messages..." : "Updating obsoleted messages...";

		if(empty($obsoleted))
			echo "nothing obsoleted...skipped.\n";
		else
		{
			if($removeOld)
			{
				$dbConnection->createCommand()
				->delete($sourceMessageTable,array('in','id',$obsoleted));

				echo "deleted.\n";
			}
			else
			{
				$dbConnection->createCommand()
				->update($sourceMessageTable,array('message'=>new CDbExpression("CONCAT('@@',message,'@@')")),
					array('in','id',$obsoleted));

				echo "updated.\n";
			}
		}
	}
}