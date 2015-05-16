<?php
use inoui_users\models\Users;
$this->html->style(array('/inoui_users/css/users.css'), array('inline' => false));
?>
<br/>
<ul class="nav nav-tabs">
    <li class="active">
        <a href="#infos" data-toggle="tab"><?=$t('My Account');?>q</a>
    </li>
    <li>
        <a href="#password" data-toggle="tab"><?=$t('Change password');?></a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="infos">
        
        <?= $this->form->create($user, array('url'=>'Users::index', 'class'=>'form-inline'));?>
        <?= $this->form->hidden('id');  ?>

        <div class="row">
            <div class="span6" align="">

                <h3><?=$t('Account - My account');?></h3>
                <br/>
                <?=$this->form->field('gender', array(
                    'template' => '{:input}{:error}',
                    'empty' => 'Séléctionner', 
                    // 'value'=>$event_id,
                    'list'=> Users::gender()
                    ));
                ?>


                <?=$this->form->field('first_name', array(
                    'placeholder' => $t('Account - Firstname'),
                    'class'=> 'span4',                        
                    'template' => '{:input}{:error}'
                )); ?>

                <?=$this->form->field('last_name', array(
                    'placeholder' => $t('Account - Lastname'),
                    'class'=> 'span4',                        
                    'template' => '{:input}{:error}'
                )); ?>

                <?=$this->form->field('email', array(
                    'placeholder' => $t('Account - Email'),
                    'class'=> 'span4',                            
                    'template' => '{:input}{:error}'
                )); ?>

            </div>

            <div class="span6" align="">

                <h3><?=$t('Account - Address');?></h3><br/>

                <?=$this->form->field('address1', array(
                    'placeholder' => $t('Account - Address'),
                    'class'=> 'span4',                        
                    'template' => '{:input}{:error}'
                )); ?>

                <?=$this->form->field('address2', array(
                    'placeholder' => $t('Account - Address (2)'),
                    'class'=> 'span4',                        
                    'template' => '{:input}{:error}'
                )); ?>

                <?=$this->form->field('city', array(
                    'placeholder' => $t('Account - City'),
                    'class'=> 'span3',                        
                    'template' => '{:input}{:error}'
                )); ?>

                <?=$this->form->field('post_code', array(
                    'placeholder' => $t('Account - Postcode'),
                    'class'=> 'span1',                        
                    'template' => '{:input}{:error}'
                )); ?>

                <?= $this->form->countrySelect('country', array(
                    'class'=> 'span4',
                    'template' => '{:input}{:error}'
                )); ?>

                <br/><br/>

                <h3><?=$t('Phones');?></h3><br/>

                <?=$this->form->field('phone', array(
                    'placeholder' => $t('Account - Phone'),
                    'class'=> 'span4',                        
                    'template' => '{:input}{:error}'
                )); ?>

                <?=$this->form->field('cell', array(
                    'placeholder' => $t('Account - Mobile'),
                    'class'=> 'span4',                        
                    'template' => '{:input}{:error}'
                )); ?>


            </div>

        </div>

        <br/><br/>
        <p align="" style="padding-right:40px"><?= $this->form->submit('Save', array('class'=>'btn btn-danger')); ?></p>

    <?=$this->form->end(); ?>
        
    </div>
    <div class="tab-pane" id="password">
        <?= $this->form->create($user, array('url'=>'Users::index', 'class'=>'form-inline'));?>
        <?= $this->form->hidden('id');  ?>
        <h3><?=$t('Password');?></h3><br/>

        <?=$this->form->field('password', array(
            'placeholder' => $t('Account - Password'),
            'class'=> 'span4',
            'type' => 'password',
            'template' => '{:input}{:error}'
        )); ?>

        <?=$this->form->field('password2', array(
            'placeholder' => $t('Account - Confirm password'),
            'class'=> 'span4',
            'type' => 'password',
            'template' => '{:input}{:error}'
        )); ?>

        <?=$this->form->end(); ?>

    </div>
</div>