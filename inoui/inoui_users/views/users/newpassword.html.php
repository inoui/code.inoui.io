<ul class="nav nav-tabs">
    <li class="active"><a href="#connection" data-toggle="tab"><?=$t('New password');?></a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="connection">

    
        <?=$this->flashMessage->show(); ?>
        <p>Veuillez entrer un nouveau mot de passe</p>

        <?= $this->form->create($user, array('url'=>array('Users::newpassword', 'id'=>$approval_code), 'id'=>'passform'));?>

        <?=$this->form->field('password', array(
    		'label' => array($t('Your Password: ') => array('class' => 'required')), 
    		'class'=>'full',
    		'type'=>'password',        		
    	)); ?>
        <?=$this->form->field('password2', array(
    		'label' => array($t('Confirm password : ') => array('class' => 'required')), 
    		'class'=>'full',
    		'type'=>'password',        		
    	)); ?>

        <?=$this->form->submit($t('Validate'), array('class'=>'btn btn-danger')); ?>
        <?=$this->form->end(); ?>

    </div>
</div>


