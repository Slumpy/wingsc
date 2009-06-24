<?php if (empty($project)): ?>

<p>No project found.</p>

<?php else: ?>

<h2 class="top"><?php echo $project['title'] ?></h2>

<p class="bottom">Completed on <?php echo date('F jS, Y', $project['completed']) ?><?php if (isset($project['asc_name'])): ?> in association with <?php echo html::anchor($project['asc_website'], $project['asc_name']) ?><?php endif ?></p>

<p><?php if ($project['website']): echo html::anchor($project['website'], 'View Website') ?><?php endif ?></p>

<p class="image bottom"><?php echo html::image('media/portfolio/'.url::title($project['title']).'.jpg', array('alt' => $project['title'].' Screenshot')) ?></p>

<?php endif ?>