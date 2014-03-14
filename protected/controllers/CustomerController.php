<?php


class CustomerController extends GxController {

	public function actions(){
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				//'backend'=>'',
				//'fontFile'=>'',
				//'foreColor'=>'',
				'offset'=>0,
				'transparent'=>false,
				'padding'=>2,
				'height'=>50,
				'width'=>120,
				'minLength'=>5,
				'maxLength'=>5,
				'testLimit'=>1,
			),
		);
	}

	public function filters() {
		return array(
			'accessControl',
		);
	}
	// filter will break if rule is matched, the order of rules is very important in this case
	public function accessRules() {
		return array(
			array('allow',
				'actions'=>array('captcha', 'activate', 'login'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('register'),
				'users'=>array('?'),
			),
			array('allow',
				'actions'=>array('profile', 'logout'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
				/*
				'deniedCallback' => function(){
					throw new CHttpException(404, Yii::t('yii', 'Your request is not valid.'));
				},
				*/
			),
		);
	}

	public function actionRegister(){
		$model = new Customer;

		$this->performAjaxValidation($model);

		// collect user input data
		if(isset($_POST['Customer']))
		{
			$model->setAttributes($_POST['Customer']);

			// activated
			$model->activated = 0;

			// status
			$model->status = 1;

			// token
			$token = Customer::token();

			$model->token = $token;

			// group
			$model->customer_group_id = 0;

			$group = CustomerGroup::model()->find();

			if(!empty($group->customer_group_id)){
				$model->customer_group_id = $group->customer_group_id;
			}

			if($model->validate()){
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);

					$transaction->commit();

					// send check mail
					$message = Yii::t('app', '<br/>Welcome to <a href="{baseUrl}">{app}</a>.<br/><br/>Now, you can activate your account by clicking the following link:<br/><br/><a href="{link}">{link}</a><br/><br/>', array(
						'{baseUrl}' => Yii::app()->getBaseUrl(true),
						'{app}' => Yii::app()->name,
						'{link}' => Yii::app()->createAbsoluteUrl('customer/activate', array('id' => $model->customer_id, 'token' => $model->token)),
					));

					$subject = Yii::app()->name . '-' . Yii::t('app', 'Register');

					$body = $this->renderPartial('//mail/register', array('message' => $message), true);

					$body = $this->renderPartial('//layouts/mail', array('subject' => $subject, 'body' => $body), true);

					$mail = new Mail;
					$mail->SetFrom(Yii::app()->config->get('mail_smtp_user'), Yii::app()->name);
				    $mail->AddReplyTo(Yii::app()->config->get('mail_smtp_user'), Yii::app()->name);
				    $mail->AddAddresses($model->username);	// username == email
				    $mail->Subject = $subject;
				    $mail->MsgHTML($body);
				    $mail->Send();

				    if($mail->isError()){
				    	//var_dump($mail->ErrorInfo);
				    }

					Yii::app()->user->setFlash('success', Yii::t('app', 'Please check your email: {email} to activate your account before login', array(
						'{email}' => $model->username,
					)));

					$this->redirect(array('site/message'));
				}catch(CDbException $e){
                    $transaction->rollback();

                    Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
                }
			}
		}

		$this->render('register',array('model'=>$model));
	}

	public function actionActivate($id, $token){
		// force logout
		Yii::app()->user->logout();

		$model = $this->loadModel($id, 'Customer');

		if($model->activated){
			Yii::app()->user->setFlash('success', Yii::t('app', 'Your account: {username} had been activated already, please do not request this page algain!', array(
				'{username}' => $model->username,
			)));
		}else if($model->token && ($model->token == $token)){
			$model->token = Customer::token();

			$model->activated = 1;

			$model->save(false);

			Yii::app()->user->setFlash('success', Yii::t('app', 'Your account: {username} has been activated successfully !', array(
				'{username}' => $model->username,
			)));
		}else{
			Yii::app()->user->setFlash('warning', Yii::t('app', 'Sorry, failed to activate your account! Contact us if you have any question.'));
		}

		$this->render('activate',array('model'=>$model));
	}

	public function actionLogin(){
		$model=new LoginForm;

		$this->performAjaxValidation($model, 'login-form');

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->setAttributes($_POST['LoginForm']);
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionProfile(){
		$id = Yii::app()->user->id;

		$model = $this->loadModel($id, 'Customer');

		$this->performAjaxValidation($model);

		// collect user input data
		if(isset($_POST['Customer']))
		{
			// Not all attributes, check rules
			$model->setAttributes($_POST['Customer']);

			if($model->validate()){
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);

					$transaction->commit();

                    Yii::app()->user->setFlash('success', Yii::t('app', 'You have updated your profile successfully .'));
				}catch(CDbException $e){
                    $transaction->rollback();

                    Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
                }
			}else{
				Yii::app()->user->setFlash('warning', Yii::t('app', 'Validation Failure'));
			}
		}
		// display the login form
		$this->render('profile',array('model'=>$model));
	}

	public function actionLogout(){
		Yii::app()->user->logout();

		$this->redirect(Yii::app()->homeUrl);
	}

}