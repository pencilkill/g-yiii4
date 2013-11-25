<?php
/**
 *
 * @author Sam@ozchamp.net
 * This class manage to generate translation file based on 'yiic message ...' console command
 */
class HCMessage{
	public static function message($config, $configRuntimeFile = null){
		if($configRuntimeFile === null){
			$configRuntimeFile = rtrim($config['messagePath'], '/\\') . DIRECTORY_SEPARATOR . 'config.rumtime.php';
		}

		$content = '<?php' . "\n" . 'return ' . strtr(var_export($config, true), array("\r" => '')) . ';';

		file_put_contents($configRuntimeFile, $content);

		// Command
		$runner = new CConsoleCommandRunner();

		$runner->addCommands(Yii::getPathOfAlias('system.cli.commands'));

		$args = array('yiic', 'message', $configRuntimeFile);
		ob_start();

		$runner->run($args);

		$message_logs = ob_get_clean();

		return $message_logs;
	}
}
?>