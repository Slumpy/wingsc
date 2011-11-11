<?php defined('SYSPATH') or die('No direct script access.');

class View_Pages_Payment extends View_Layout {

	public $data = array();

	public $errors = array();

	public function has_errors()
	{
		return ! empty($this->errors);
	}

	public function errors()
	{
		$errors = array();

		foreach ($this->errors as $field => $error)
		{
			$errors[] = array(
				'name' => $field,
				'message' => $error,
			);
		}

		return $errors;
	}

	public function inputs()
	{
		return array(
			'amount' => Form::input('amount', Arr::get($this->data, 'amount'), array(
				'placeholder' => '0.00',
				'size' => '6',
				'class' => 'center',
			)),
			'invoice' => Form::input('invoice', Arr::get($this->data, 'invoice'), array(
				'placeholder' => '0000',
				'size' => '6',
				'class' => 'center',
			)),
		);
	}

	public function providers()
	{
		return array(
			array(
				'name' => 'gcheckout',
				'title' => 'Google Checkout',
				'image' => 'https://checkout.google.com/buttons/checkout.gif'.URL::query(array(
					'merchant_id' => Kohana::config('gcheckout')->merchant_id,
					'w' => 180,
					'h' => 46,
					'style' => 'trans',
					'variant' => 'text',
					'loc' => 'en_US',
				), FALSE),
			),
			array(
				'name' => 'paypal',
				'title' => 'PayPal',
				'image' => 'https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif',
			),
			array(
				'name' => 'wepay',
				'title' => 'We Pay',
				'image' => 'media/img/logos/wepay.png',
				'preferred' => TRUE,
			),
		);
	}

} // End Pages_Payment
