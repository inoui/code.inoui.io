

<section class="panel">
	<header class="panel-heading"><?= $this->title(); ?></header>
	
	<div class="list-group">

		<?php foreach ($shippings as $key => $shipping): ?>
			
			<?php
			$active = '';
			if (isset($this->_request->params['id'])&&$this->_request->params['id'] == $shipping->_id) {
				$active = 'active';
			}
			?>
			
		    <a class="list-group-item <?= $active ?>	" href="<?= $this->url(array('Shippings::edit', 'id'=>$shipping->_id)); ?>">
		        <h4 class="list-group-item-heading"><?= $shipping->title; ?>	</h4>
		        <p class="list-group-item-text"><?= $this->time->to($shipping->created, 'EEEE dd MMMM'); ?>	</p>
		    </a>
		<?php endforeach ?>
	</div>

</section>

