<div class="list-container ">
	<div class="list-header well clearfix">
		<h3><?= $this->title(); ?></h3>
	</div>
	<ul class="list-results list-unstyled">

		<?php foreach ($contents as $key => $content): ?>
			<li>
				<div class="headline">
					<?=$this->html->link($content->title(), array('Contents::edit', 'id'=>$content->_id)); ?>
				</div>
				<small>
					<span class="date"><?= $this->time->to($content->created, 'EEEE dd MMMM'); ?>	</span>
				</small>
			</li>

		<?php endforeach ?>
	
	</ul>
</div>			
