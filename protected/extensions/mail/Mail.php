<?php
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
class Mail{
	public static function instance(){
		require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'PHPMailer.php';

		$_PHPMailer = new PHPMailer;

		//
		$_PHPMailer->UseSendmailOptions = false;
		//
		$_PHPMailer->CharSet = 'UTF-8';
		$_PHPMailer->IsSMTP();
		$_PHPMailer->SMTPAuth = true;
		$_PHPMailer->SMTPKeepAlive = true;
		//
		$_PHPMailer->Host = Yii::app()->config->get('mail_smtp_host');
		$_PHPMailer->Username = Yii::app()->config->get('mail_smtp_user');
		$_PHPMailer->Password = Yii::app()->config->get('mail_smtp_password');
		$_PHPMailer->Port = Yii::app()->config->get('mail_smtp_port');
		//
		$_PHPMailer->Sender = Yii::app()->config->get('mail_smtp_user');	// Specified Sender before using SetFrom()
		//...
		$_PHPMailer->IsHTML(true);

		return $_PHPMailer;
	}
}