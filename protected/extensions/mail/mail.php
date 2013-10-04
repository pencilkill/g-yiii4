<?php
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'PHPMailer.php';
/**
 *  Notice: the sender email host should be matched with the smtp host to avoid smtp host refusing
 *  Specified the Sender before using SetFrom method in this case please
 *  Reading SetFrom method to get more about Sender and Replyto proprities
 *
 * @author Sam@ozchamp.net
 * @example
 	$mail = Yii::app()->mail;
    $mail->SetFrom('user@server.com', 'name');
    $mail->AddReplyTo('reply@server.com', 'replyName');
    $mail->AddAddress('reciver@server.com', 'reciveName');
    $mail->Subject = 'mail subject';
    $mail->MsgHTML('<h1>This is a test!</h1>');
    $mail->Send();
 * @example
    $mail = Yii::app()->mail;
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
class Mail extends PHPMailer{
	public function init(){
		parent::init();

		//
		$this->UseSendmailOptions = false;
		//
		$this->CharSet = 'UTF-8';
		$this->IsSMTP();
		$this->SMTPAuth = true;
		$this->SMTPKeepAlive = true;
		//
		$this->Host = Yii::app()->config->get('mail_smtp_host');
		$this->Username = Yii::app()->config->get('mail_smtp_user');
		$this->Password = Yii::app()->config->get('mail_smtp_password');
		$this->Port = Yii::app()->config->get('mail_smtp_port');
		//
		$this->Sender = Yii::app()->config->get('mail_smtp_user');	// Specified Sender before using SetFrom()
		//...
		$this->IsHTML(true);
	}
}