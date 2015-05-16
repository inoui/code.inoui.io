	<div class="list-group level-<?php echo $level; ?>">
		<?php foreach ($items as $key => $category): ?>
			<?php
				$active = '';
				if (isset($this->_request->params['id'])&&$this->_request->params['id'] == $category['_id']) {
					$active = 'active';
				}
			?>
		    <a class="list-group-item <?= $active ?>	" href="<?= $this->url(array('Categories::edit', 'id'=>$category['_id'])); ?>">
		        <h4 class="list-group-item-heading"><?= $category['title']; ?>	</h4>
		        <p class="list-group-item-text"><?= $this->time->to($category['created'], 'EEEE dd MMMM'); ?></p>
		    </a>

			<?php 
				if (isset($category['children']) && !empty($category['children'])) {

					echo $this->_render('element', 'items', array('items' => $category['children'], 'level' => $level+1));
				}
			 ?>

		<?php endforeach ?>
	</div>
