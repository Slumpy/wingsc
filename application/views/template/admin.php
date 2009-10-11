<div id="admin" class="span-12 prefix-5 suffix-5 last">

	<?php if ( ! empty($menu)): ?>
		<ul class="menu">
		<?php $admin = Route::get('admin'); $request = Request::instance(); ?>
		<?php foreach ($menu as $type): ?>
			<li><?php echo html::anchor($request->uri(array('controller' => $type)), __(ucfirst($type))) ?><?php if ($request->controller === $type): ?>
				<ul>
					<li><?php echo html::anchor($request->uri(array('action' => NULL)), 'Create') ?></li>
					<li><?php echo html::anchor($request->uri(array('action' => 'edit')), 'Edit') ?></li>
				</ul><?php endif ?></li>
		<?php endforeach ?>
		</ul>
	<?php endif ?>

	<?php if ($message = cookie::get('message')): ?>
	<p class="message"><?php echo __($message) ?></p>
	<?php endif ?>

	<?php echo $content ?>

</div>
