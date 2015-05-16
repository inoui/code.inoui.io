<section class="panel">
	<header class="panel-heading"><?= $category->title; ?></header>

	<div class="panel-body">

		<?= $this->form->create($category, array('url'=>array('Categories::edit','id'=>$category->_id), 'type'=>'file', 'class'=>''));?>
		<div class="view-body">
			<?=$this->form->field('title', array(
				'label' => $t('Category title'),
				'placeholder' => $t('eg. pages'),
				'class' => 'form-control'
			)); ?>


			<?=$this->form->field('name.fr', array(
				'label' => $t('French'),
				'class' => 'form-control'
			)); ?>

			<?=$this->form->field('name.en', array(
				'label' => $t('English'),
				'class' => 'form-control'
			)); ?>

			<?=$this->form->field('slug', array(
				'label' => $t('Slug'),
				'class' => 'form-control'
			)); ?>
		
			<div class="uploader_div" data-type="categories" data-id="<?= $category->_id; ?>"></div>

			<div class="media_list" id="file_receipt">
				<?= $this->_render('element', 'file-list', array(), array('controller' => 'media')); ?>
			</div>
		

		</div>
		<div class="view-footer">
			<div class="actions">
				<?=$this->form->submit($t('Save'), array(
					'class' => 'btn btn-primary'
				)); ?>
				<?=$this->html->link($t('Delete'), array('Categories::delete', 'id'=>$category->_id), array('class' => 'btn btn-danger confirm')); ?>

			</div>
		</div>		
		<?=$this->form->end(); ?>



	</div>
</section>