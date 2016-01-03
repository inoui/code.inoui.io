<section class="panel">	
	<header class="panel-heading"><?= $this->title(); ?></header>
	<div class="list-group">

		<ul class="list-results list-unstyled ui-sortable" data-class="Pages">

			<?php foreach ($pages as $key => $page): ?>
				<li data-id="<?= $page->_id; ?>	">
					<div class="headline">
						<?=$this->html->link($page->title(), array('Pages::edit', 'id'=>$page->_id), array('escape' => false)); ?>
					</div>
					<small>
						<span class="date"><?= $this->time->to($page->created, 'EEEE dd MMMM'); ?>	</span>
					</small>
				</li>
			<?php endforeach ?>

		</ul>
	</div>	
</section>