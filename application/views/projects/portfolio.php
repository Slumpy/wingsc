<div id="portfolio">

	<div id="details" class="span-16">
		<?php echo $details ?>
	</div>

	<div id="list" class="span-6 last">
		<ol>
		<?php foreach ($list as $slug => $title): ?>
			<li class="<?php echo $slug === $active ? 'active' : '' ?>"><?php echo html::anchor(Route::get('work')->uri(array('project' => $slug)), $title) ?></li>
		<?php endforeach ?>
		</ol>
	</div>

</div>