<?php

namespace common\helps;

use Yii;

class email{
	//单例模式
	private static $instance = NULL;
	
	public static function getInstance()
	{
		if(self::$instance === null)
		{
			$classname = __CLASS__;
			self::$instance = new $classname();
		}
		return self::$instance;
	}
	
	/**
	 * @desc 邮件发送. eg: 	email::getInstance()->send($toMail, $subject, $content)
	 * @param string $sendTo 目标邮箱
	 * @param unknown $subject 邮件标题
	 * @param unknown $content 邮件内容
	 * @param string $template 邮件模板
	 * @return bool string
	 */
	public function send($toEmail, $subject, $content, $template='template'){
		$mail= Yii::$app->mailer->compose($template, ['content'=>$content]);
		$mail->setTo($toEmail);
		$mail->setSubject($subject);
		/* $mail->setTextBody('这里是纯文本');//发布纯文字文本
		$mail->setHtmlBody("这里是带html标签的文本");    //发布可以带html标签的文本 */
		if($mail->send())
			return true;
		else
			return false;
	}
}