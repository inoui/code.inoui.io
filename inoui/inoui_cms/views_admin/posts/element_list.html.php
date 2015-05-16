<section class="panel">	
	<header class="panel-heading"><?= $this->title(); ?></header>
	<div class="list-group">

		<ul class="list-results list-unstyled ui-sortable" data-class="Posts">

			<?php foreach ($posts as $key => $post): ?>
				<li data-id="<?= $post->_id; ?>	">
					<div class="headline">
						<?=$this->html->link($post->title(), array('Posts::edit', 'id'=>$post->_id), array('escape' => false)); ?>
					</div>
					<small>
						<span class="date"><?= $this->time->to($post->created, 'EEEE dd MMMM'); ?>	</span>
					</small>
				</li>
			<?php endforeach ?>

		</ul>
	</div>	
</section>