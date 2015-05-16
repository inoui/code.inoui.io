<div>
<br/><br/><br/><br/>
    <div class="row">

        <div class="offset3 span8" >
            <h1>Mot de passe oublié</h1>
        	<?= $this->form->create($user, array('url'=>'Users::forgot', 'id'=>'loginform', 'class'=>'form-inline'));?>
            <?=$this->flashMessage->show(); ?>                
	        <fieldset>
		        <?=$this->form->field('email', array(
		            'placeholder' => $t('Email'),
		        )); ?>


                <div class="control-group">
                  <div class="controls">
                      <?=$this->form->submit($t('Récupérer le mot de passe'), array('class'=>'btn btn-default')); ?>
                  </div>
                </div>
            </fieldset>
            <?=$this->form->end(); ?>
        </div>
                          
    </div>
    
</div>