<?php
	$this->set(array('topActions'=>array(
		'new' => array(
	        'title' => $t('Add post'),
	        'url' => array('Posts::add'),
	        'options' => array('class'=>'btn btn-success')
	    )
	)));
	$this->title($t('Your posts'));
?>

<section class="panel">
	<header class="panel-heading tab-bg-dark-navy-blue ">
		<span class="wht-color"><?= $this->title(); ?></span>
	</header>

    <table class="table table-striped table-advance table-hover" data-toggle="row">
        <thead>
	        <tr >
	            <th><i class="ic icon-bullhorn"></i> <?= $t('Post title'); ?>	</th>
	            <th class="hidden-phone"><i class="ic icon-question-circle"></i> <?= $t('Publication date'); ?></th>
				<th><?= $t('Category'); ?></th>
				<th><?= $t('Status'); ?></th>
				<th> </th>				
	        </tr>
        </thead>
        <tbody>
			<?php foreach ($posts as $key => $post): ?>
        	<tr>
            	<td>
					<?=$this->html->link('=='.$post->title(), array('Posts::edit', 'id'=>$post->_id), array('escape' => false)); ?>
				</td>
            	<td><span class="date"><?= $this->time->to($post->published, 'EEEE dd MMMM'); ?>	</span></td>
				
				<td><?= $post->category(); ?>	</td>

				<td>
					<?= $this->form->checkbox('status', array(
						'data-toggle' => 'switch',
						'value' => $post->status,
						'data-on-label' => $t('Online'),
						'data-off-label' => $t('Offline'),
					)) ?>	
				</td>
				<td>
					<?=$this->html->link($t('Delete'), array('Posts::delete', 'id'=>$post->_id), array('class' => 'btn btn-danger confirm')); ?>
				</td>
        	</tr>
			<?php endforeach ?>
		</tbody>
	</table>	
</section>


<div class="row">
	<div class="col-sm-6" >
	<div id="item-list-content">
		<ul id="item-list-items">
			<li class="note active">
				<a href="">
				    <span class="comments" title="4 comments">4</span>
				    <div class="container">
				        <span>coco <abbr class="date tiny" title="2014-02-17T09:58:34.000Z">1h</abbr></span>
				        <h3>Mise a jour website</h3>
				        <span></span>
			    	</div>
				</a>
			</li>
		</ul>		
	</div>
	</div>
	<div class="col-sm-6"></div>
</div>
