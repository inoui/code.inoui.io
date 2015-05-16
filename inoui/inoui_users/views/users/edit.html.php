<h3>User Form</h3>
<?=$this->form->create($user, array('action'=>'edit/'.$user->_id)); ?>

    <?php foreach($fields as $name => $field) { ?>
        <?=$this->form->field($name, $field['form']); ?>
    <?php } ?>

    <?=$this->form->submit($t('Save me')); ?>
<?=$this->form->end(); ?>
