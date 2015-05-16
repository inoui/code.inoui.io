

<section class="panel">
	<header class="panel-heading"><?= $this->title(); ?></header>
	
	<div class="list-group">

		<?php foreach ($discounts as $key => $discount): ?>
			
			<?php
			$active = '';
			if (isset($this->_request->params['id'])&&$this->_request->params['id'] == $discount->_id) {
				$active = 'active';
			}
			?>
			
		    <a class="list-group-item <?= $active ?>	" href="<?= $this->url(array('Discounts::edit', 'id'=>$discount->_id)); ?>">
		        <h4 class="list-group-item-heading"><?= $discount->title; ?>	</h4>
		        <p class="list-group-item-text"><?= $this->time->to($discount->created, 'EEEE dd MMMM'); ?>	</p>
		    </a>
		<?php endforeach ?>
	</div>

</section>

