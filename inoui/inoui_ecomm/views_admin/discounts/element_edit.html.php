<?= $this->form->create($discount, array('url'=>array('Discounts::edit', 'id'=>$discount->_id), 'type'=>'file', 'class'=>''));?>

<section class="panel">
	<header class="panel-heading"><?= $t('New discount') ?></header>


	<div class="panel-body">
		<div class="view-body">
			<?=$this->form->field('title', array(
				'label' => $t('Discount name'),
				'placeholder' => $t('eg. Europe'),
				'class' => 'form-control'
			)); ?>

			<?=$this->form->field('description', array(
				'label' => $t('Description'),
				'class' => 'form-control',
				'type' => 'textarea'
			)); ?>
			
			<hr />	
			
			<div class="row">
				<div class="col-md-6">
					<?=$this->form->field('start', array(
						'label' => $t('Valid from'),
						'class' => 'form-control default-date-picker',
						'type' => 'text'
					)); ?>

				</div>
				<div class="col-md-6">
					<?=$this->form->field('end', array(
						'label' => $t('Valid until'),
						'class' => 'form-control default-date-picker',
						'type' => 'text'
					)); ?>

					
				</div>
			</div>

			<hr />
			
			<div class="row">
				<div class="col-md-6">
					<?=$this->form->field('code', array(
						'label' => $t('Discount code'),
						'class' => 'form-control ',
						'type' => 'text'
					)); ?>

				</div>
				<div class="col-md-6">
					<?=$this->form->field('quantity', array(
						'label' => $t('Quantity'),
						'class' => 'form-control ',
						'type' => 'text',
						'help' => array('title'=>'Leave empty for no limit')
					)); ?>

					
				</div>
			</div>
			

			<hr />
			
			<div class="row">
				<div class="col-md-6">
					<?=$this->form->field('value', array(
						'label' => $t('Discount value'),
						'class' => 'form-control ',
						'type' => 'text'
					)); ?>

				</div>
				<div class="col-md-6">
					<?=$this->form->field('type', array(
						'label' => $t('Discount type'),
						'class' => 'form-control ',
						'type' => 'text',
						'help' => array('title'=>'%')
					)); ?>

					
				</div>
			</div>

		</div>
		<div class="view-footer">
			<div class="actions">
				<?=$this->form->submit($t('Save'), array(
					'class' => 'btn btn-primary'
				)); ?>
			
			</div>
		</div>		




	</div>
</section>

<?=$this->form->end(); ?>

