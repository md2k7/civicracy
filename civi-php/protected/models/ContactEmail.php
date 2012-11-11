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
	public $sent;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
				array('email_adds, email_text', 'required'),
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
		);
	}
	
	/**
	 * Sends the email to the specified recipients
	 * 
	 */
	public function sendMail()
	{
		if(isset($this->email_adds) && isset($this->email_text))
		{
			$this->sent=true;
			return $this-sent;
		}
	}
}
