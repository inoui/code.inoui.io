
	<h1>Connexion à vos requêtes</h1>
	<?= $this->form->create($user, array('url'=>'Users::login', 'id'=>'loginform', 'class'=>'form-horizontal'));?>
	<?=$this->flashMessage->show(); ?>                
	<fieldset>
	<?=$this->form->field('email', array(
	'placeholder' => $t('Email'),
	)); ?>

	<?=$this->form->field('password', array(
	'placeholder' => $t('Mot de passe'),
	'type' => 'password',
	)); ?>

	<div class="control-group">
	<div class="controls">
	<?=$this->form->submit($t('Se connecter'), array('class'=>'btn btn-default')); ?>
	<p><?= $this->html->link("Mot de passe oublié ?", array('Users::forgot')) ?></p>
	</div>
	</div>
	</fieldset>
	<?=$this->form->end(); ?>
