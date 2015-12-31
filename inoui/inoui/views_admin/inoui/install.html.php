
<?= $this->form->create($preferences, array('url'=>'Inoui::install', 'class'=>'form-signin'));?>
  <h2 class="form-signin-heading"><?= $t('Install'); ?>	</h2>
  <div class="login-wrap">

		<?=$this->flashMessage->show(); ?>

		<?=$this->form->field('email', array(
			'placeholder' => $t('Enter admin email'),
			'label' => array($t('Enter admin email') => array('class'=>'sr-only')),
			'class' => 'form-control'
		)); ?>

        <?=$this->form->field('password', array(
			'placeholder' => $t('Password'),
			'label' => array($t('Password') => array('class'=>'sr-only')),
			'type' => 'password',
			'class' => 'form-control'
		)); ?>
        <?=$this->form->field('password2', array(
			'placeholder' => $t('Password verification'),
			'label' => array($t('Password verification') => array('class'=>'sr-only')),
			'type' => 'password',
			'class' => 'form-control'
		)); ?>

        <hr>

        <?=$this->form->field('site_name', array(
			'placeholder' => $t('Site Name'),
            'label' => array($t('Site Name') => array('class'=>'sr-only')),
			'class' => 'form-control'
		)); ?>
        <?=$this->form->field('description', array(
			'placeholder' => $t('Description'),
            'label' => array($t('Description') => array('class'=>'sr-only')),
			'class' => 'form-control'
		)); ?>






		<?=$this->form->submit($t('Install'), array('class'=>'btn btn-lg btn-login btn-block')); ?>

  </div>
<?=$this->form->end(); ?>




<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="passModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Forgot Password ?</h4>
            </div>
            <div class="modal-body">
                <p>Enter your e-mail address below to reset your password.</p>
                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <button class="btn btn-success" type="button">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
