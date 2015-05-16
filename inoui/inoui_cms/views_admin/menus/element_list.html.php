<section class="panel">
	
	<header class="panel-heading"><?= $this->title(); ?></header>


	<div class="list-group">
		<?php foreach ($menus as $key => $menu): ?>
		
			<?php
			$active = '';
			if (isset($this->_request->params['id'])&&$this->_request->params['id'] == $menu->_id) {
				$active = 'active';
			}
			?>

		    <a class="list-group-item <?= $active ?>	" href="<?= $this->url(array('Menus::edit', 'id'=>$menu->_id)); ?>">
		        <h4 class="list-group-item-heading"><?= $menu->title(); ?>	</h4>
		        <p class="list-group-item-text"><?= $this->time->to($menu->created, 'EEEE dd MMMM'); ?>	</p>
		    </a>
		<?php endforeach ?>

	</div>

</section>
