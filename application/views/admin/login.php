<div id="login">

	<h2>Administration Login</h2>
	<?php echo form::open() ?>

	<?php include Kohana::find_file('views', 'template/errors') ?>

	<dl>
		<dt><?php echo form::label('username', 'Username') ?></dt>
		<dd><?php echo form::input('username', $post['username']) ?></dd>

		<dt><?php echo form::label('password', 'Password') ?></dt>
		<dd><?php echo form::password('password') ?></dd>

		<dd class="submit"><?php echo form::button(NULL, 'Login', array('type' => 'submit')) ?></dd>
	</dl>

	<?php echo form::close() ?>

</div>