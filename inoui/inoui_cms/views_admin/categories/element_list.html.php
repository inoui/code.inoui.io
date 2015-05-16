<section class="panel">
	<header class="panel-heading"><?= $this->title(); ?></header>
	<div class="list-group"> 
		<?php echo $this->_render('element', 'items', array('items' => $categories, 'level' => 1)); ?>
	</div>
</section>
