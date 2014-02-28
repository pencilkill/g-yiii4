<?php


class ContactController extends GxController {

	public function actions()
	{
		return array(
		// captcha action renders the CAPTCHA image displayed on the contact page

			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'testLimit'=>1,
		),

		);
	}

	public function filters()
	{
		return array(
            'accessControl',
		);
	}

	public function accessRules()
    {
        return array(
            array('allow',
            ),
        );
    }

	public function actionIndex() {
		$model=new Contact;

		$this->performAjaxValidation($model);

		if(isset($_POST['Contact']))
		{
			$model->attributes=$_POST['Contact'];
			if($model->validate())
			{
				$model->save(false);

				$subject = Yii::app()->name . ' - ' . Yii::t('app', 'Contact Us');

				$label = (object)$model->attributeLabels();
				$e = (object)$model->attributes;

				$e->sex = $e->sex ? Yii::t('app', 'Male') : Yii::t('app', 'Female');
				$e->message = nl2br($e->message);

				$body = $this->renderPartial('mail', array('label' => $label, 'e' => $e), true);

				$body = $this->renderPartial('//layouts/mail', array('subject' => $subject, 'body' => $body), true);

				$mail = new Mail;
				$mail->SetFrom($model->email, $model->firstname .' '. $model->lastname);
			    $mail->AddReplyTo($model->email, $model->firstname .' '. $model->lastname);
			    $mail->AddAddresses(Yii::app()->config->get('mail_email_contact'));
			    $mail->Subject = $subject;
			    $mail->MsgHTML($body);
			    $mail->Send();

			    if($mail->isError()){
			    	//var_dump($mail->ErrorInfo);
			    }

				Yii::app()->user->setFlash('contact', Yii::t('m/contact','Thank you for contacting us. We will respond to you as soon as possible.'));

				$this->refresh();
			}
		}

		$this->render('index',array('model'=>$model));
	}



}