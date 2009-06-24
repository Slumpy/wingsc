<?php echo form::open(NULL) ?>

	<?php include Kohana::find_file('views', 'template/errors') ?>

	<dl>
		<dt><?php echo form::label('name', 'Your Name') ?></dt>
		<dd><?php echo form::input('name', $post['name']) ?></dd>

		<dt><?php echo form::label('email', 'Email Address') ?></dt>
		<dd><?php echo form::input('email', $post['email']) ?></dd>

		<dt><?php echo form::label('work', 'Type of Work') ?></dt>
		<dd><?php echo form::select('work', $work_types, $post['work']) ?></dd>

		<dt><?php echo form::label('description', 'Project Description') ?></dt>
		<dd><?php echo form::textarea('description', $post['description'], array('rows' => 8)) ?></dd>

		<dt><?php echo form::label('budget', 'Budget') ?></dt>
		<dd><?php echo form::select('budget', $budget_types, $post['budget']) ?></dd>

		<dd class="submit"><?php echo form::button(NULL, 'Send Message', array('type' => 'submit')) ?></dd>
	</dl>

<?php echo form::close() ?>
