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
				'email_text'=>Yii::t('app', 'email.topic'),
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
			
			$subject = '=?UTF-8?B?'.base64_encode($this->email_topic).'?=';
			
			$headers = 'From: ' . Yii::app()->params['registration.adminEmail'] . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
			
			foreach($email_adds_arr as $user)
			{
				Yii::log('User-Email: ' . $user . ' wurde ausgeschickt durch Admin', 'info', 'ContactEMail');
				mail($user, $this->email_topic, $this->email_text.'\n-------
Visit the on the Civi plattform at '.Yii::app()->params['registration.url'], $headers);
			}			
			$sent=true;
			return $sent;
		}
	}
}
