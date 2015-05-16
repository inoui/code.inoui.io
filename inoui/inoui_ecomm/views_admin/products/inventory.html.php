<section class="panel">
	<header class="panel-heading tab-bg-dark-navy-blue ">
		<span class="wht-color"><?= $t('Products inventory'); ?></span>
	</header>

    <table class="table table-striped table-advance table-hover" data-toggle="row">
        <thead>
	        <tr >
	            <th><i class="ic icon-bullhorn"></i> <?= $t('Product name'); ?>	</th>
	            <th class="hidden-phone"><i class="ic icon-question-circle"></i> <?= $t('Quantity'); ?></th>
	            <th width="20%"><i class="ic icon-bookmark"></i> <?= $t('Status'); ?></th>
                <th width="20%"><i class="ic icon-bookmark"></i> <?= $t('Date created'); ?></th>
                <th><i class="ic icon-bookmark"></i> <?= $t('Actions'); ?></th>
	        </tr>
        </thead>
        <tbody class="">
			<?php foreach ($products as $key => $product): ?>
        	<tr>
            	<td>
                    <?=$this->html->link($this->html->image($product->thumbnail(), array('size'=>'170c170')), array('Products::edit', 'id'=>$product->_id), array('escape'=>false)); ?>
                    <?=$this->html->link($product->title, array('Products::edit', 'id'=>$product->_id), array('class'=>'pro-title')); ?>				
                </td>
            	<td>
                 <?=$this->form->text('quantity', array(
                    'value' => $product->quantity
                 )); ?>   
                </td>
                <td>

                <?= $this->time->to($product->created->sec, 'EEEE dd MMMM'); ?></td>
                <td>
                <?=$this->form->field('status', array(
                    'data-key' => "status_{$product->_id}",
                    'value' => $product->status,
                    'class' => 'form-control change',
                    'type' => 'select',
                    'data-action' => 'Admin.changeProductStatus',
                    'list' => inoui_ecomm\models\Products::getStatus()
                )); ?>
                </td>
                <td>            <?=$this->html->link($t('Delete'), array('Products::delete', 'id'=>$product->_id), array('class' => 'btn btn-danger confirm')); ?>
</td>
        	</tr>
			<?php endforeach ?>
		</tbody>
	</table>	
</section>
=