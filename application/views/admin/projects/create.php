<div id="project">

	<h2>Create a New Project</h2>
	<?php echo form::open() ?>

	<?php include Kohana::find_file('views', 'template/errors') ?>

	<dl>
		<dt><?php echo form::label('title', 'Title') ?></dt>
		<dd><?php echo form::input('title', $post['title']) ?></dd>

		<dt><?php echo form::label('associate_id', 'Associate') ?></dt>
		<dd><?php echo form::select('associate_id', $associates, $post['associate_id']) ?></dd>

		<dt><?php echo form::label('completed', 'Completed On') ?></dt>
		<dd><?php echo form::input('completed', $post['completed']) ?></dd>

		<dt><?php echo form::label('website', 'Website URL') ?></dt>
		<dd><?php echo form::input('website', $post['website']) ?></dd>

		<dd class="submit"><?php echo form::button(NULL, 'Create Project', array('type' => 'submit')) ?></dd>
	</dl>

	<?php echo form::close() ?>

</div>