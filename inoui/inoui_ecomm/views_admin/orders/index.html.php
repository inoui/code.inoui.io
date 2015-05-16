<?php
	// $this->set(array('topActions'=>array(
	// 
	// 	'new' => array(
	//         'title' => $t('Add category'),
	//         'url' => array('Categories::add', 'library'=>'inoui_admin', 'admin'=>true),
	//         'options' => array('class'=>'btn btn-success')
	//     )
	// 
	// )));
	$this->title($t('Your orders'));
?>

<div class="row" id="plugTest">
	<div class="col-md-12" data-on="col-md-6">
		<?= $this->_render('element', 'list'); ?>
	</div>
	<div class="col-md-0" data-on="col-md-6" id="orderReceipt">
		
	</div>
</div>
