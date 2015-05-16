<?php 
    $variants = $channel->schema->options->variants;
?>

<?php if (isset($product->variants) && count($product->variants)): ?>
    <?php foreach ($product->variants as $key => $variant): ?>
        <div class="row variant">
            <div class="col-xs-1">
                <?=$this->html->link('', '#', array('class'=>' btn action', 'icon'=>'trash-o','data-action' => 'Admin.deleteVariant')); ?>
            </div>
            <?php $i = 0; ?>
            <?php foreach ($variant as $name => $value): ?>
                <?php if ($i === 0): ?>                
                    <div class="col-xs-2">
                <?php else: ?>
                    <div class="col-xs-3">
                <?php endif; ?>
                <?php $i++; ?>
                    <?=$this->form->field('variants['.$key.'].'.$name, array(
                        'label' => $name,
                        'value' => $value,
                        'class' => 'form-control'
                    )); ?>
                </div>                
            <?php endforeach; ?>                

        </div>
    <?php endforeach; ?>
<?php else: ?>

    <div class="row variant">
          <div class="col-xs-1">
            <?=$this->html->link('', '#', array('class'=>' btn action', 'icon'=>'trash','data-action' => 'Admin.deleteVariant')); ?>
          </div>

        <?php foreach ($variants as $name => $variant): ?>
            <div class="col-xs-2">
                <?=$this->form->field('variants[0].'.$name, (array)$variant); ?>
            </div>
        <?php endforeach; ?>

      <div class="col-xs-3">
        <?=$this->form->field('variants[0].price', array(
            'label' => $t('Price'),
            'value' => isset($product->price) ? $product->price:'',
            'class' => 'form-control'
        )); ?>
      </div>
      <div class="col-xs-3">
        <?=$this->form->field('variants[0].sku', array(
            'label' => $t('Sku'),
            'value' => isset($product->sku) ? $product->sku:'',
            'class' => 'form-control'
        )); ?>
      </div>
      <div class="col-xs-3">
        <?=$this->form->field('variants[0].quantity', array(
            'label' => $t('Quantity'),
            'value' => isset($product->quantity) ? $product->quantity:'',
            'class' => 'form-control'
        )); ?>
      </div>
    </div>
<?php endif; ?>


<?=$this->html->link($t('Add a variant'), '#', array('class' => 'action btn btn-white btn-sm','data-action' => 'Admin.addVariant')); ?>
