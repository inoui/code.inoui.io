<?php

	use inoui_ecomm\models\Products;
	use inoui_admin\models\Categories;

	$this->set(array('topActions'=>array(

		'cancel' => array(
	        'title' => $t('Cancel'),
	        'url' => array('Products::index', 'library'=>'inoui_admin', 'admin'=>true),
	        'options' => array('class'=>'btn btn-default')
	    ),
		// 
		// 'save' => array(
		// 	        'title' => $t('Save'),
		// 	        'url' => array('Products::save', 'library'=>'inoui_admin', 'admin'=>true),
		// 	        'options' => array('class'=>'btn btn-success')
		// 	    )

	)));
	$this->title($t('Your products'));
?>



<section class="panel">
	<div class="panel-body">
		<?= $this->form->create($product, array('url'=>array('Products::add'), 'type'=>'file', 'class'=>''));?>
		<div class="row">

			<div class="col-xs-4">

				<h3><?= $t('Product details'); ?></h3>
				<p><?= $t('Write a name and description, and provide a type and vendor to categorize this product.'); ?></p>

			</div>



			<div class="col-xs-8">

				<?=$this->form->field('title', array(
					'label' => $t('Title'),
					'placeholder' => $t('eg. my new product'),
					'class' => 'form-control'
				)); ?>

				<?=$this->form->field('description', array(
					'label' => $t('Description'),
					'class' => 'form-control wysiwyg',
					'type' => 'textarea'
				)); ?>
				
				<div class="row">
			      <div class="col-xs-4">
					<?=$this->form->field('category_id', array(
						'label' => $t('Primary category'),
						'class' => 'change form-control',
						'data-action' => 'Admin.addCategory',
						'type' => 'nestedSelect',
						'list' => $categories,
						'empty' => $t('Select a category')
					)); ?>

					<?=$this->form->field('new_category', array(
	            		'template' => '{:input}{:error}',
						'placeholder' => $t('Provide a category name'),
						'class' => 'form-control hide',
						'disabled' => true
					)); ?>


			      </div>

			      <div class="col-xs-4">
					<?=$this->form->field('channel_id', array(
						'label' => $t('Product type'),
						'class' => 'change form-control',
						'data-action' => 'Admin.onChannelSelect',
						// 'type' => 'nestedSelect',
						'list' => $channels,
						'empty' => $t('Select a product type')
					)); ?>

			      </div>

			      <div class="col-xs-4">
						
					<?=$this->form->field('status', array(
						'label' => $t('Status'),
						'class' => 'form-control',
						'type' => 'select',
						'wrap' => '',
						'list' => Products::getStatus()
					)); ?>

			      </div>
			    </div>
			</div>		
		</div>

		<hr />		
		<div id="channelForm">
			<?php if (isset($channel)): ?>
				<?php echo $this->_render('element', 'channel'); ?>
			<?php endif; ?>
		</div>	
	
		<div class="row">
			<div class="col-xs-4">

				<h3><?= $t('Inventory'); ?></h3>
				<p><?= $t('Manage inventory, and configure the options for selling this product.'); ?></p>

			</div>

			<div class="col-xs-8">
				<div id="inventoryForm">
					<?php echo $this->_render('element', 'inventory'); ?>
				</div>
			</div>

		</div>
	
		<hr />
		
		<div class="row hide">

			<div class="col-xs-4">

				<h3><?= $t('Images'); ?></h3>
				<p><?= $t('Upload image of this product.'); ?></p>

			</div>

			<div class="col-xs-8">
			
				<div id="upload"></div>

			</div>

		</div>
	
	
		<hr />
		
		<div class="row">
			<div class="col-xs-4">

				<h3><?= $t('Search Engines'); ?></h3>
				<p><?= $t('Set up the page title, meta description and handle. These help define how this product shows up on search engines.'); ?></p>

			</div>

			<div class="col-xs-8">

				<?=$this->form->field('page_title', array(
					'label' => $t('Page title'),
					'placeholder' => $t('0 of 70 characters used'),
					'class' => 'form-control'
				)); ?>
			
				<?=$this->form->field('page_desc', array(
					'label' => $t('Page description'),
					'placeholder' => $t('0 of 160 characters used'),
					'class' => 'form-control'
				)); ?>
			
			
				<?=$this->form->field('slug', array(
					'label' => $t('Page url'),
					'placeholder' => $t('0 of 160 characters used'),
					'class' => 'form-control'
				)); ?>
			

			</div>

		</div>
	
		<hr />
	
		<div class="" align="right">
			<?=$this->form->button($t('Cancel'), array(
				'class' => 'btn btn-default'
			)); ?>

			<?=$this->form->submit($t('Save'), array(
				'class' => 'btn btn-success'
			)); ?>
		</div>
	
	</div>		
</section>



<?=$this->form->end(); ?>