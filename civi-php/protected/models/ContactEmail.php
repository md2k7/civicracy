<?php

/**
 * 
 * @author jakob
 *
*/
class ContactEmail extends CFormModel
{
	public $email_adds;
	public $email_text;
	public $email_topic;
	public $email_adds_arr;
	public $sent;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
				array('email_adds, email_text, email_topic', 'required'),
				array('sent', 'boolean'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
				'email_adds'=>Yii::t('app', 'email.adds'),
				'email_text'=>Yii::t('app', 'email.text'),
				'email_topic'=>Yii::t('app', 'email.topic'),
		);
	}
	
	/**
	 * Sends the email to the specified recipients
	 * 
	 */
	public function sendMail()
	{
		if(isset($this->email_adds) && isset($this->email_text) && isset($this->email_topic))
		{
			$email_adds_arr=explode(',',$this->email_adds);
			
			$subject = $this->email_topic;

			require_once(Yii::getPathOfAlias('webroot') . '/phpmailer/class.phpmailer.php');

			foreach($email_adds_arr as $user)
			{
				$mail = new PHPMailer(); // defaults to using php "mail()"
				$mail->CharSet = 'utf-8';
				$mail->SetFrom(Yii::app()->params['registration.adminEmail'], Yii::app()->params['registration.adminEmailName']);
				$mail->AddAddress($user);
				$mail->Subject = $this->email_topic;
				$mail->Body =  $this->email_text."\n\n".'-------'."\n".'Visit the Civi platform at '.Yii::app()->params['registration.url'];

				if($mail->Send())
					$this->createLogEntry(Log::USER_CONTROLLER, 'Admin sent password email to ' . $user->username);
				else
					Yii::log('mail send failed to ' . $user . ': ' . $mail->ErrorInfo, 'error', 'ContactEmail');
			}			
			$sent=true;
			return $sent;
		}
	}
}
