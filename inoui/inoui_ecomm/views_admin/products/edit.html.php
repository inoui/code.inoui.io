<?php

	use inoui_ecomm\models\Products;
	use inoui_admin\models\Categories;
	// $this->set(array('topActions'=>array(
	// 	'cancel' => array(
	//         'title' => $t('Cancel'),
	//         'url' => array('Products::index', 'library'=>'inoui_admin', 'admin'=>true),
	//         'options' => array('class'=>'btn btn-default')
	//     ),
	// 	'new' => array(
	// 	        'title' => $t('New product'),
	// 	        'url' => array('Products::add', 'library'=>'inoui_admin', 'admin'=>true),
	// 	        'options' => array('class'=>'btn btn-success')
	// 	    )

	// )));
	$this->title($t('Your products'));
?>



<section class="panel">
	<div class="panel-body">
		<?= $this->form->create($product, array('url'=>array('Products::edit', 'id'=>$product->_id), 'type'=>'file', 'class'=>'', 'data-id'=>$product->_id, 'id'=>'productFrm'));?>

		<div class="row">

			<div class="col-xs-4">

				<h3><?= $t('Product informations'); ?></h3>
				<p><?= $t('Write a name and description, and provide a type and vendor to categorize this product.'); ?></p>


				<?= $this->html->image($product->thumbnail(), array('size'=>'600x', 'class'=>'img-responsive')); ?>	
			</div>

			<div class="col-xs-8">

				<?=$this->form->field('title', array(
					'label' => $t('Title'),
					'placeholder' => $t('eg. my new product'),
					'class' => 'form-control'
				)); ?>

				<?php if($product->channel_id == '54f43687e723496603b7acd9'): ?>
					<?=$this->form->field('page_id', array(
						'label' => $t('Collection'),
						'class' => 'form-control',
						'type' => 'select',
						'wrap' => '',
						'list' => $collections
					)); ?>
				<?php endif; ?>

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
						'type' => 'nestedSelect',
						'list' => $categories,
						'empty' => $t('Select a category')
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
				<?php echo $this->_render('element', 'inventory'); ?>
			</div>

		</div>
	
		<hr />
		
		<div class="row">
			<div class="col-xs-4">
			
				<h3><?= $t('Images'); ?></h3>
				<p><?= $t('Upload image of this product.'); ?></p>

			</div>

			<div class="col-xs-8">
			


				<div data-url="<?= $this->url(array('Media::upload', 'library'=>'inoui_admin')) ?>" data-fk_type="products" data-fk_id="<?= $product->_id ?>" class="dropzone"></div>



				<div class="media_list" id="file_receipt">
					<?= $this->_render('element', 'file-list', array(), array('controller' => 'media')); ?>
				</div>

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
	
		<div class="" >
		
		
			<?=$this->html->link($t('Delete'), array('Products::delete', 'id'=>$product->_id), array('class' => 'btn btn-danger confirm')); ?>
		
		
			<div class="pull-right">
			<?=$this->form->button($t('Cancel'), array(
				'class' => 'btn btn-default'
			)); ?>

			<?=$this->form->submit($t('Save'), array(
				'class' => 'btn btn-success'
			)); ?>
			</div>
		</div>
	<?=$this->form->end(); ?>
	</div>	
</section>



