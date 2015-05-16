<section class="panel">
	<header class="panel-heading"><?= $user->name(); ?></header>
		<?= $this->form->create($user, array('url'=>array('Users::edit','id'=>$user->_id), 'type'=>'file', 'class'=>''));?>
	<div class="panel-body">
		
		<div class="row">
			<div class="col-md-6">
				<?=$this->form->field('first_name', array(
					'label' => $t('First Name'),
					'class' => 'form-control'
				)); ?>
				
			</div>
			<div class="col-md-6">
				<?=$this->form->field('last_name', array(
					'label' => $t('Last Name'),
					'class' => 'form-control'
				)); ?>
				
			</div>
		</div>
		

		
		<?=$this->form->field('email', array(
			'label' => $t('Email'),
			'class' => 'form-control'
		)); ?>

		<hr />

		<?=$this->form->field('role', array(
			'label' => $t('User role'),
			'class' => 'form-control',
			'type' => 'select',
			'list' => inoui_users\models\Users::roles()
		)); ?>

		<hr />



		<div class="row">
			<div class="col-md-6">

				<?=$this->form->field('password', array(
					'label' => $t('Password'),
					'value' => '',
					'class' => 'form-control'
				)); ?>
				
			</div>
			<div class="col-md-6">

				<?=$this->form->field('password2', array(
					'label' => $t('Repeat password'),
					'value' => '',
					'class' => 'form-control'
				)); ?>
				
			</div>
		</div>
		


		<div class="actions">
			<?=$this->form->submit($t('Save'), array(
				'class' => 'btn btn-primary'
			)); ?>
			<?=$this->html->link($t('Delete'), array('Posts::delete', 'id'=>$user->_id), array('class' => 'btn btn-danger confirm')); ?>
		</div>

	</div>
	<?=$this->form->end(); ?>
</section>
