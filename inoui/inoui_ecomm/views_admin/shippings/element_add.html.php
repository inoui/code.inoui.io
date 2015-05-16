
<section class="panel">
	<header class="panel-heading"><?= $t('New shipping method') ?></header>


	<div class="panel-body">
		<?= $this->form->create($shipping, array('url'=>array('Shippings::add'), 'type'=>'file', 'class'=>''));?>
		<div class="view-body">
			<?=$this->form->field('title', array(
				'label' => $t('Shipping name'),
				'placeholder' => $t('eg. Europe'),
				'class' => 'form-control'
			)); ?>

			<?=$this->form->field('price', array(
				'label' => $t('Shipping price'),
				'class' => 'form-control'
			)); ?>



			<?=$this->form->countrySelect('territories', array(
				'w' => 1,
				'multiple' => true,
				'style' => 'height:200px;',
				'label' => $t('Shipping price'),
				'class' => 'form-control'
			)); ?>




		</div>
		<div class="view-footer">
			<div class="actions">
				<?=$this->form->submit($t('Save'), array(
					'class' => 'btn btn-primary'
				)); ?>
			
			</div>
		</div>		
		<?=$this->form->end(); ?>



	</div>
</section>
