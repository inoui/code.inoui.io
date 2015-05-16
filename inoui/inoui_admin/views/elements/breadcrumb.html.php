<ul class="breadcrumb">	
	<?php if (isset($breadcrumbs)): ?>
	<?php foreach($breadcrumbs as $name => $bread): ?>
		<li><?=$this->html->link($name, $bread); ?></li>
	<?php endforeach; ?>
	<?php endif ?>
	<?php if(isset($topActions)): ?>
	<div class="pull-right top-actions ">
		<?php foreach ($topActions as $key => $action): ?>
			<?= $this->html->link($action['title'], $action['url'], $action['options']); ?>	
		<?php endforeach ?>
	</div>
	<?php endif; ?>
</ul>

