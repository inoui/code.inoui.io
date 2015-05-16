<?php
	$this->set(array('topActions'=>array(
		'new' => array(
	        'title' => $t('New shipping method'),
	        'url' => array('Shippings::add'),
	        'options' => array('class'=>'btn btn-success')
	    )
	)));
	$this->title($t('Shipping method'));
?>

<div class="row">
	<div class="col-md-4 col-lg-6">
		<?= $this->_render('element', 'list'); ?>
	</div>
	<div class="col-md-8  col-lg-6">
		<?php 
			if(isset($shipping)) {				
				if($shipping->exists()) {
					echo $this->_render('element', 'edit');
				} else {
					echo $this->_render('element', 'add');
				}					
			}
		?>
	</div>
</div>
