<?php

	if ($channel) {
		$url = ['Pages::add', 'args' => $channel->slug];
	} else {
		$url = ['Pages::add'];
	}

	$this->set(array('topActions'=>array(
		'new' => array(
	        'title' => $t('Add page'),
	        'url' => $url,
	        'options' => array('class'=>'btn btn-success')
	    )
	)));
	$this->title($t('Your pages'));
?>

<section class="panel">
	<header class="panel-heading tab-bg-dark-navy-blue ">
		<span class="wht-color"><?= $this->title(); ?></span>
	</header>

    <table class="table table-striped table-advance table-hover" data-toggle="row">
        <thead>
	        <tr >
	            <th><i class="ic icon-bullhorn"></i> <?= $t('Page title'); ?>	</th>

				<th><?= $t('Slug'); ?></th>
				<th><?= $t('Position'); ?></th>
				<th><?= $t('Page type'); ?></th>
				<th> </th>				
	        </tr>
        </thead>
        <tbody>
			<?php foreach ($pages as $key => $page): ?>
        	<tr>
            	<td>
					<?=$this->html->link($page->title, array('Pages::edit', 'id'=>$page->_id), array('escape' => false)); ?>
				</td>	
				<td>
					<?= $page->slug; ?>
				</td>
				<td>
					<?= $page->position; ?>
				</td>

				<td>
					<?= $page->type(); ?>
				</td>
				<td>
					<?=$this->html->link($t('Delete'), array('Pages::delete', 'id'=>$page->_id), array('class' => ' confirm', 'icon' => 'trash-o')); ?>
				</td>
        	</tr>
			<?php endforeach ?>
		</tbody>
	</table>	
</section>

