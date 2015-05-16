<?= $this->form->create($user, array('url'=>'Users::login', 'id'=>'loginform', 'class'=>'form-signin'));?>
  <h2 class="form-signin-heading"><?= $t('Sign in now'); ?>	</h2>
  <div class="login-wrap">

			<?=$this->flashMessage->show(); ?>
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
      <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
          <span class="pull-right">
              <a data-toggle="modal" href="#passModal"> Forgot Password?</a>
          </span>
      </label>
		<?=$this->form->submit($t('Sign in'), array('class'=>'btn btn-lg btn-login btn-block')); ?>

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

