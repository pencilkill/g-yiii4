<?php
/**
 *  Notice: the sender email host should be matched with the smtp host to avoid smtp host refusing
 *  Specified the Sender before using SetFrom method in this case please
 *  Reading SetFrom method to get more about Sender and Replyto proprities
 *
 * @author Sam@ozchamp.net
 * @example
 	$mail = new Mail;
    $mail->SetFrom('user@server.com', 'name');
    $mail->AddReplyTo('reply@server.com', 'replyName');
    $mail->AddAddress('reciver@server.com', 'reciveName');
    //$mail->AddAddresses('reciver0@server.com, reciver1@server.com');
    $mail->Subject = 'mail subject';
    $mail->MsgHTML('<h1>This is a test!</h1>');
    $mail->Send();
 * @example
    $mail = new Mail;
    $mail->SetFrom('user@server.com', 'name');
    $mail->AddReplyTo('reply@server.com', 'replyName');
    $mail->AddAddress('reciver@server.com', 'reciveName');
    $mail->Subject = 'mail subject';
    $mail->AltBody    = 'To view the message, please use an HTML compatible email viewer!';
    $mail->MsgHTML('<h1>This is a test!</h1>');
    $mail->AddAttachment('images/attachment.gif');
    $mail->Send();
    if($mail->IsError()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    // not required
    $mail->ClearAddresses();
    $mail->ClearReplyTos();
    $mail->ClearAttachments();
 */
class Mail{
	private $_PHPMailer;

	public function __construct($config = array()){
		require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'PHPMailer.php';

		$_config = array(
			'UseSendmailOptions' => false,
			'CharSet' => 'UTF-8',
			'SMTPAuth' => true,
			'SMTPKeepAlive' => true,
			'Host' => Yii::app()->config->get('mail_smtp_host'),
			'Username' => Yii::app()->config->get('mail_smtp_user'),
			'Password' => Yii::app()->config->get('mail_smtp_password'),
			'Port' => Yii::app()->config->get('mail_smtp_port'),
			'Sender' => Yii::app()->config->get('mail_smtp_user'),
		);

		$config = array_merge_recursive($_config, $config);

		$_PHPMailer = new PHPMailer;

		$ref = new ReflectionClass($_PHPMailer);

		foreach($config as $name => $value){
			if($ref->hasProperty($name) && $ref->getProperty($name)->isPublic()){
				$_PHPMailer->{$name} = $value;
			}
		}

		$_PHPMailer->IsSMTP();

		$_PHPMailer->IsHTML(true);

		$this->_PHPMailer = $_PHPMailer;
	}

	public function __get($name){
		return $this->_PHPMailer->{$name};
	}

	public function __set($name, $value){
		$this->_PHPMailer->{$name} = $value;
	}
	/**
	 * Without filter
	 *
	 * @param $method
	 * @param $args
	 */
	public function __call($method, $args){
		$class = $this->_PHPMailer;

		if(method_exists($this, $method)){
			$class = $this;
		}

		$ref = new ReflectionMethod($class, $method);

		return $ref->invokeArgs($class, $args);
	}

	/**
	 * Add multiple addresses
	 *
	 * @param $addresses, mixed. It should be array or string. e.g. array('a@b.com' => 'a', 'c@d.com'); e.g. 'a@b.com, c@d.com';
	 * @param $delimiter, string. Address separator for $addresses while the $addresses is a string. Default as comma.
	 */

	public function AddAddresses($addresses, $delimiter = ','){
		$addresses = is_array($addresses) ? $addresses : explode($delimiter, $addresses);

		if($addresses){
			foreach($addresses as $key => $val){
				$address = $key;
				$name = $val;

				if(is_numeric($key)){
					$address = $val;
					$name = '';		// PHPMailer default value
				}

				if(trim($address)){
					$this->_PHPMailer->AddAddress($address, $name);
				}
			}
		}
	}
}