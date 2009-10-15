<?php if ( ! $project->loaded()): ?>

<p>No project found.</p>

<?php else: ?>

<h2 class="top"><?php echo $project->title ?></h2>

<p class="bottom">Completed on <?php echo date('F jS, Y', $project->completed) ?>
	<?php if (count($project->associates)): ?> in association with: 
		<?php foreach ($project->associates as $a): ?>
			<?php echo $a->website ? HTML::anchor($a->website, $a->name) : $a->name ?>
		<?php endforeach ?>
	<?php endif ?></p>

<p><?php if ($project->website): echo HTML::anchor($project->website, 'View Website') ?><?php endif ?></p>

<div class="image">
	<ul class="chooser">
	<?php foreach ($project->images as $i => $image): ?>
		<li><?php echo HTML::anchor($image->verbose('file'), '[ '.($i+1).' ]', array('title' => $image->title)) ?></li>
	<?php endforeach ?>
	</ul>
	<?php $image = $project->images[0] ?>
	<p><?php echo HTML::image($image->verbose('file'), array('alt' => $image->title)) ?></p>
</div>


<?php endif ?>