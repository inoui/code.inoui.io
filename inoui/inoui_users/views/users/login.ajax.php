<?php $redirect = urlencode($this->url("Users::index", array('absolute'=>true))); ?>
<div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h4>Connexion</h4>
</div>
<div class="modal-body" >
    <h1 align="center">Connexion</h1>
    <?=$this->flashMessage->show(); ?>
    <br/>
    <?= $this->twform->create($user, array('url'=>'Users::login', 'class'=>'form-inline', 'data-toggle'=>'ajaxModal'));?>


	    <div class="span3">
			<h1 ><?=$t('Social');?></h1>
	        <a href="<?= $this->url(array('Facebook::authorize')); ?>?m=1&r=<?= $redirect; ?>" class="btn btn-primary btn-large popup"><i class="icon-facebook-sign"></i> <?=$t('Login with');?> Facebook</a>
		</div>
		<div class="span3">
			<h1 ><?=$t('Sign up');?></h1>
			<fieldset>

		        <?=$this->twform->field('email', array(
		            'placeholder' => $t('Email'),
		            'class' => 'input-small',
		            'template' => '{:input}{:error}'
		        )); ?>

		        <?=$this->twform->field('password', array(
		            'placeholder' => $t('Password'),
		            'class' => 'input-small',
		            'type' => 'password',
		            'template' => '{:input}{:error}'
		        )); ?>

        	<?=$this->twform->submit($t('Validate'), array('class'=>'btn btn-primary btn-large')); ?>
        <p><?= $this->html->link($t('Forgot password ?'), array('Users::forgot'), array('data-toggle'=>'ajaxModal')) ?></p>
    	</fieldset>
    <?=$this->form->end(); ?>		
		</div>



</div>