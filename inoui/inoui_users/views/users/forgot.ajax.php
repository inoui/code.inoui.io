<div class="modal-header">
	<button class="close" data-dismiss="modal">×</button>
	<h4><?=$t('Forgot password');?></h4>
</div>
<div class="modal-body" >
	<?=$this->flashMessage->show(); ?>
	<br/>
	<?= $this->twform->create($user, array('url'=>'Users::forgot', 'id'=>'loginform', 'class'=>'form-inline', 'data-toggle'=>'ajaxModal'));?>

	<fieldset>

        <p><?=$t('Please fill up your email');?></p>

        <?= $this->form->create($user, array('url'=>'Users::password', 'id'=>'passform'));?>
        <?=$this->twform->field('email', array(
            'placeholder' => 'Email',
            'class' => 'span2',
            'template' => '{:input}{:error}'
        )); ?>

        <?=$this->twform->submit($t('Validate'), array('class'=>'btn btn-danger')); ?>
        <?=$this->form->end(); ?>

	</fieldset>

</div>