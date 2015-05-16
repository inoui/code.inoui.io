

<div class="container">		
	
	<?= $this->form->create($user, array('url'=>'Users::register', 'id'=>'loginform', 'class'=>'form-horizontal'));?>

		<?=$this->form->field('email', array(
			'placeholder' => $t('Enter email'),
			'label' => array($t('Email address') => array('class'=>'sr-only')),
			'class' => 'form-control'
		)); ?>

		<?=$this->form->field('password', array(
			'placeholder' => $t('Password'),
			'label' => array($t('Password') => array('class'=>'sr-only')),
			'type' => 'password',
			'class' => 'form-control'			
		)); ?>

		<?=$this->form->submit($t('Sign in'), array('class'=>'btn btn-default')); ?>

	<?=$this->form->end(); ?>
	
</div>



