<section class="panel">

	<header class="panel-heading"><?= $this->title(); ?></header>
	
	<div class="list-group">
		<?php foreach ($users as $key => $user): ?>
			<?php
			$active = '';
			if (isset($this->_request->params['id']) && $this->_request->params['id'] == $user->_id) {
				$active = 'active';
			}
			?>
		    <a class="list-group-item <?= $active ?>" href="<?= $this->url(array('Users::edit', 'id'=>$user->_id)); ?>">
		        <h4 class="list-group-item-heading"><?php echo "{$user->name()} - {$user->email}"; ?>	</h4>
		        <p class="list-group-item-text"><?= $this->time->to($user->created, 'EEEE dd MMMM'); ?>	</p>
		    </a>
		<?php endforeach ?>
	</div>

</section>

