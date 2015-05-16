<?php $cover = rand(1, 11); ?>

<div id="catalog" class="part" data-init="" style="background-image:url(/media/fonds/honore<?= $cover ?>.jpg);">

	<div class="overlay hide"></div>	



	<div class="productView">
		<div class="block">			
			<div class="container">
				
				<h1 class="black"><?= $t('Cart'); ?>	</h1>
				
				<?= $this->form->create($cart, array('url'=>array('Carts::index')));?>


				<table class="table table-striped table-centered">
				  <thead>
				    <tr>
				      <th>#</th>
				      <th> </th>
				      <th><?= $t('Product'); ?></th>
				      <th><?= $t('Price'); ?></th>
				      <th><?= $t('Quantity'); ?></th>
				      <th><?= $t('Total'); ?></th>
				    </tr>
				  </thead>
				  <tbody>
					<?php foreach ($cart->items as $key => $item): ?>
					    <tr>
						  <td><?=$this->html->link('', array('Carts::remove', 'id'=>(string)$item->_id), array('icon'=>'trash')); ?></td>
					      <td><?= $this->html->image($item->product->thumbnail(), array('size'=>'50c')) ?></td>
					      <td><?=$this->html->link($item->product->title, array('Catalog::product', 'slug'=>$item->product->slug, 'category'=>$item->product->category('slug'))); ?></td>
					      <td><?= $item->product->price(); ?></td>
						  <td class="" style="width:10%">
								<?=$this->form->field("items.{$item->_id}", array(
									'value'=>$item->quantity,
									'label' => array($t('Quantity') => array('class'=>'sr-only')),
									'class' => 'form-control input-lg '
								)); ?>
							</td>
						  <td class="bold" align="center"><?= $item->total; ?></td>
					    </tr>
					<?php endforeach ?>
					
					<tr>
						<td colspan="6" align="right">
							<?=$this->form->submit($t('Update cart'), array(
								'class' => 'btn btn-warning'
							)); ?>
						</td>
					</tr>
					
					
					<tr>
						<td colspan="6" align="center">
				
							<h3 align='center'><?= $t('Subtotal') ?> : <?= $cart->total() ?>	</h3>
							<p  align='center'>Price excludes delivery, which is applied at checkout.<br/>
							If you have an exclusive discount code, you can enter this before you confirm your order.</p>
						</td>
					</tr>
					
					<tr>
						<td colspan="3" align="left">
							<?=$this->form->field('toc', array(
								'label' => $t(' I agree to the terms and refund policy.'),
								'type' => 'checkbox'
							)); ?>
						</td>
						<td colspan="3" align="right">
							<?=$this->html->link($t('Proceed to checkout'), array('Checkout::index'), array('class'=>'btn btn-warning btn-large')); ?>
				
						</td>
					</tr>
					
					
					
				  </tbody>
				</table>
							<?=$this->form->end(); ?>
			</div>
		</div>

	</div>

</div>
