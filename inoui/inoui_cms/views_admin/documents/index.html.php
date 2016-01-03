<?php

	if (isset($channel)) {
		$url = ['Documents::add', 'args' => $channel->slug];
	} else {
		$url = ['Documents::add'];
	}

	$this->set(array('topActions'=>array(
		'new' => array(
	        'title' => $t('Add document'),
	        'url' => $url,
	        'options' => array('class'=>'btn btn-success')
	    )
	)));
	$this->title($t('Your documents'));
?>

<section class="panel">
	<header class="panel-heading tab-bg-dark-navy-blue ">
		<span class="wht-color"><?= $this->title(); ?></span>
	</header>


    <?php if (count($documents)): ?>


    <table class="table table-striped table-advance table-hover" data-toggle="row">
        <thead>
	        <tr >
	            <th><i class="ic icon-bullhorn"></i> <?= $t('Document title'); ?>	</th>

				<th><?= $t('Slug'); ?></th>
				<th><?= $t('Position'); ?></th>
				<th><?= $t('Document type'); ?></th>
				<th> </th>
	        </tr>
        </thead>
        <tbody>
			<?php foreach ($documents as $key => $document): ?>
        	<tr>
            	<td>
					<?=$this->html->link($document->title, array('Documents::edit', 'id'=>$document->_id), array('escape' => false)); ?>
				</td>
				<td>
					<?= $document->slug; ?>
				</td>
				<td>
					<?= $document->position; ?>
				</td>

				<td>
					<?= $document->type(); ?>
				</td>
				<td>
					<?=$this->html->link($t('Delete'), array('Documents::delete', 'id'=>$document->_id), array('class' => ' confirm', 'icon' => 'trash-o')); ?>
				</td>
        	</tr>
			<?php endforeach ?>
		</tbody>
	</table>
    <?php else: ?>
        <h2>No documents yet</h2>
    <?php endif; ?>

</section>
