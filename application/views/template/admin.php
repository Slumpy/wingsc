<div id="admin" class="span-12 prefix-5 suffix-5 last">
	<?php if ($message = cookie::get('message')): ?>
	<p class="message"><?php echo $message ?></p>
	<?php endif ?>

	<?php echo $content ?>
</div>