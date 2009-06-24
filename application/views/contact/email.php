<div id="contact" class="">

	<h1 class="intro">If you want more information about the services that <em>w.ings consulting</em> can provide for your business, or if you have comments about this website, please <?php echo html::mailto('woody@wingsc.com', 'email me') ?>. If you are considering hiring me for a project, please use the contact form below.</h1>

	<?php echo form::open(NULL, array('class' => 'span-12 prefix-5 suffix-5 last')) ?>

		<h2>Send Me A Lead</h2>
		<p class="byline">My response time is based entirely on how busy I am with current projects.<br/>
			It may take up to a week for me to respond to your message.</p>

		<?php include Kohana::find_file('views', 'template/errors') ?>

		<dl>
			<dt><?php echo form::label('name', 'Your Name') ?></dt>
			<dd><?php echo form::input('name', $post['name']) ?></dd>

			<dt><?php echo form::label('email', 'Email Address') ?></dt>
			<dd><?php echo form::input('email', $post['email']) ?></dd>

			<dt><?php echo form::label('work', 'Type of Work') ?></dt>
			<dd><?php echo form::select('work', $work_types, $post['work']) ?></dd>

			<dt><?php echo form::label('description', 'Project Description') ?></dt>
			<dd><?php echo form::textarea('description', $post['description']) ?></dd>

			<dt><?php echo form::label('budget', 'Budget') ?></dt>
			<dd><?php echo form::select('budget', $budget_types, $post['budget']) ?></dd>

			<dd class="submit"><?php echo form::button(NULL, 'Send Message', array('type' => 'submit')) ?></dd>
		</dl>


	<?php echo form::close() ?>

</div>