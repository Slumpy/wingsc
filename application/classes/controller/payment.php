<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Payment extends Controller_Template_Wings {

	public function action_index()
	{
		$this->template->content = View::factory('payment/index')
			->bind('post', $post)
			->bind('errors', $errors);

		$post = Validate::factory($_POST)
			->filter(TRUE, 'trim')
			->rule('amount', 'not_empty')
			->rule('amount', 'numeric')
			->rule('invoice', 'not_empty')
			->rule('invoice', 'digit')
			->rule('gateway', 'not_empty')
			->rule('gateway', 'in_array', array(array('gcheckout', 'paypal')));

		if ($post->check())
		{
			// Format the amount into dollars
			$post['amount'] = number_format($post['amount'], 2);

			// Return URL when payment is complete
			$return = URL::site($this->request->uri, Request::$protocol);

			if ($post['gateway'] === 'gcheckout')
			{
				$config = Kohana::config('gcheckout');

				// Process the payment using Google Checkout
				gCheckout_Cart::factory($config->merchant_id, $config->merchant_key, $config->sandbox)
					->continue_shopping_url($return)
					->item(gCheckout_Item::factory('w.ings invoice #'.$post['invoice'], '', 1, $post['amount']))
					->default_tax(gCheckout_Tax::factory(0, FALSE)
						->area(gCheckout_Area_World::factory()))
					->execute(TRUE);
			}
			else
			{
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
			}
		}

		$errors = $post->errors('forms/payment');
	}

} // End Payment