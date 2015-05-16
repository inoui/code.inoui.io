<?php


	$this->set(array('topActions'=>array(

		'new' => array(
	        'title' => $t('Add a channel'),
	        'url' => array('Channels::add', 'library'=>'inoui_cms', 'admin'=>true),
	        'options' => array('class'=>'btn btn-success')
	    )

	)));
	$this->title($t('Your channels'));
?>

<div class="row">
	<div class="col-xs-6">
		<?= $this->_render('element', 'list'); ?>
	</div>
	<div class="col-xs-6">
		<?php 
			if(isset($channel)) {
				if ($channel->exists()) {
					echo $this->_render('element', 'edit');
				} else {
					echo $this->_render('element', 'add');
				}
			}
		?>
		
	</div>
</div>
