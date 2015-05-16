<?php if (isset($channel) && isset($channel->schema->options->variants)): ?>
    <?php echo $this->_render('element', 'inventory-variants'); ?>

<?php else: ?>
<div class="row">
  <div class="col-xs-4">
    <?=$this->form->field('price', array(
        'label' => $t('Price'),
        'class' => 'form-control'
    )); ?>
  </div>
  <div class="col-xs-4">
    <?=$this->form->field('sku', array(
        'label' => $t('Sku'),
        'class' => 'form-control'
    )); ?>
  </div>
  <div class="col-xs-4">
    <?=$this->form->field('quantity', array(
        'label' => $t('Quantity'),
        'class' => 'form-control'
    )); ?>
  </div>
</div>
<?php endif; ?>








