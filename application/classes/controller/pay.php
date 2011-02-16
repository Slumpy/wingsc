<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pay extends Controller_Layout {

	public function action_index()
	{
		$this->request->response = Walrus::simple('pages/payment', array(
				'errors' => 'layout/errors',
			))
			->bind('data', $post)
			->bind('errors', $errors);

		$post = Validate::factory($_POST)
			->filter(TRUE, 'trim')
			->rule('amount', 'not_empty')
			->rule('amount', 'numeric')
			->rule('invoice', 'not_empty')
			->rule('invoice', 'digit')
			->rule('gateway', 'not_empty')
			->rule('gateway', 'in_array', array(array(/* 'wepay', **not working** */ 'gcheckout', 'paypal')));

		if ($post->check())
		{
			// Format the amount into dollars
			$post['amount'] = number_format($post['amount'], 2, '.', '');

			// Return URL when payment is complete
			$return = $this->request->url(NULL, Request::$protocol);

			switch ($post['gateway'])
			{
				case 'wepay':
					$params = array(
						'token' => Kohana::config('wepay')->token,
						'group_id' => Kohana::config('wepay')->group_id,
						'amount' => round($post['amount']),
						'reason' => 'w.ings invoice #'.$post['invoice'],
						'buyer_email' => 'woody@wingsc.com',
						'ref_id' => $post['invoice'],
						'partial' => 1,
					);

					$wepay = (Kohana::config('wepay')->stage ? 'https://stage.wepayapi.com/' : 'https://wepayapi.com/').'v1/';

					$response = Remote::get("{$wepay}sp/create?".http_build_query($params, '&'));

					echo Kohana::debug($params, $response);exit;
				break;
				case 'gcheckout':
					$config = Kohana::config('gcheckout');

					// Process the payment using Google Checkout
					gCheckout_Cart::factory($config->merchant_id, $config->merchant_key, $config->sandbox)
						->continue_shopping_url($return)
						->item(gCheckout_Item::factory('w.ings invoice #'.$post['invoice'], '', 1, $post['amount'])
							->digital_content(gCheckout_Digital::factory()
								->description('Thank you for your payment!')))
						->default_tax(gCheckout_Tax::factory(0, FALSE)
							->area(gCheckout_Area_World::factory()))
						->execute(TRUE);
				break;
				case 'paypal':
					// Process the payment using PayPal
					$params = array
					(
						'cmd' => '_xclick',
						'item_name' => 'w.ings invoice #'.$post['invoice'],
						'currency_code' => 'USD',
						'amount' => $post['amount'],
						'no_note' => 1,
						'no_shipping' => 1,
						'return' => $return,
						'cancel_return' => $return,
						'business' => 'woody@wingsc.com',
					);

					// Send the user to PayPal to complete their payment
					$this->request->redirect('https://www.paypal.com/cgi-bin/webscr?'.http_build_query($params));
				break;
			}
		}

		$errors = $post->errors('forms/payment');

		echo Kohana::debug($errors);
	}

} // End Pay
