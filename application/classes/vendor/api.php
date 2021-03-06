<?php

defined('SYSPATH') or die('No direct script access.');

class Vendor_Api
{
	//private $_uri = 'http://partner.consultsystems.loc';
	private $_key = 'xG$%ngh!J';
	public function __construct($uri = NULL) 
	{
		if (!is_null($uri))
		{
			$this->_uri = $uri;
		}
	}
	private function generate_certificate(array $variables)
	{
		return md5(serialize($variables) . $this->_key);
	}
	public function send_post($action, array $variables = array())
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, URL::site('', TRUE, TRUE). '/api/' . $action);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		//curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$post_fields = array();
		foreach ($variables as $key => $value) 
		{
			$post_fields[] = $key . '=' . urlencode($value);
		}
	//	$post_fields[] = 'certificate=' . $this->generate_certificate(serialize($variables));
		curl_setopt($curl, CURLOPT_POSTFIELDS, implode('&', $post_fields));
		curl_setopt($curl, CURLOPT_USERAGENT, 'Opera 10.00');
		
		$answer = curl_exec($curl);

		var_dump(curl_getinfo($curl));
	
		//проверяем, если ошибка, то получаем номер и сообщение
		if(!$answer){
			$error = curl_error($curl).'('.curl_errno($curl).')';
			$result = $error;
		}
		else{
			$result = $answer;
		}
		curl_close($curl);
		return $result;

	}
	public static function factory($uri = NULL)
	{
		return new Vendor_Api($uri);
	}
	
	public function send_message_client_registered($certificate, $partner_id, $client_id, $name, $login, $email, $site = NULL, $tariff = NULL)
			//возвращает ответ сервера 200 - ок
			//403 - не прошел сертификат
			//422 - ошибка данных, в теле json_encode(массив ошибок)
	{
		return $this->send_post(
					'register_client',
					array(
						'partner_id' => $partner_id,
						'foreign_id' => $client_id,
						'login' => $login,
						'name' => $name,
						'email' => $email,
						'site' => $site,
						'tariff' => $tariff,
						'certificate' => $certificate,
					)
				);
	}
	
	public function send_message_client_payment($certificate, $client_id, $payment_sum, $transaction_id)
			//возвращает ответ сервера 200 - ок
			//403 - не прошел сертификат
			//422 - ошибка данных, в теле json_encode(массив ошибок)
	{
		return $this->send_post(
					'register_payment',
					array(
						'client_id' => $client_id,
						'payment_sum' => $payment_sum,
						'transaction_id' => $transaction_id,
						'certificate' => $certificate,
					)
				);
	}

}