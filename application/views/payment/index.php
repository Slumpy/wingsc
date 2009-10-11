<div id="payment">

	<h1 class="intro">Want to make a payment on an invoice? You can pay with Google Checkout or PayPal right here.<br/>
		For other payment options, please <?php echo HTML::anchor(Route::get('contact')->uri(), 'contact me') ?>.</h1>

	<?php echo form::open(NULL) ?>

		<?php include Kohana::find_file('views', 'template/errors') ?>

		<p>I would like to pay
			$<?php echo form::input('amount', $post['amount']) ?> on invoice
			#<?php echo Form::input('invoice', $post['invoice']) ?> using:</p>

		<ul class="gateway">
			<li><label><?php echo Form::radio('gateway', 'paypal', $post['gateway'] === 'paypal') ?> <?php echo HTML::image('https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif', array('alt' => 'PayPal')) ?></label></li>
			<li><label><?php echo Form::radio('gateway', 'gcheckout', $post['gateway'] === 'gcheckout') ?> <?php echo HTML::image('https://checkout.google.com/buttons/checkout.gif?merchant_id=760570731838371&w=168&h=44&style=white&variant=text&loc=en_US', array('alt' => 'Google Checkout')) ?></label></li>
		</ul>

		<p><?php echo Form::button(NULL, 'Send Payment') ?></p>

	<?php echo form::close() ?>

</div>