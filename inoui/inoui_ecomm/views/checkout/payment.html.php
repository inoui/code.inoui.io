<?php $cover = rand(1, 11); ?>

<div id="catalog" class="part" data-init="" style="background-image:url(/media/fonds/honore<?= $cover ?>.jpg);">

	<div class="overlay hide"></div>	

	<div class="productView">
		<div class="block ">
			
			<div class="container">

				<h1 class="black"><?= $t('Checkout') ?>	</h1>
				<hr />
				<div class="row">
					<div class="col-xs-7 bg">

						<h5><?= $t('Finalize your order:') ?></h5>
						<?=$this->form->create($order, array('url'=>array('Checkout::payment', 'id'=>$order->_id))); ?>
						
						
						<div class="well">
							
							<?=$this->form->field('code_promo', array(
								'label' => $t('Promo code (Optional)*'),
								'class' => 'form-control'
							)); ?>

							<?=$this->form->field('comments', array(
								'type'=>'textarea',
								'label' => $t('Comments (Optional)*'),
								'class' => 'form-control'
							)); ?>
							

							<h5><?= $t('Payment method') ?>	</h5>
							<?= $this->html->image('cartes.gif')?>
		                    

							
							
							
						</div>
						
						<div class="row">
							<div class="col-xs-6">
								<?=$this->form->field('toc', array(
									'label' => $t('Accept terms of services.'),
									'type' => 'checkbox'
								)); ?>

							</div>
							<div class="col-xs-6" align="right">
								<?=$this->form->submit($t('Continue'), array('class'=>'btn btn-warning')); ?>
							</div>
						</div>						
						
						<?=$this->form->end(); ?>
						<hr />


					</div>
					<div class="col-xs-5">
						<h5><?= $t('Your order:') ?></h5>
						<ul class="list-unstyled well">
						<?php foreach ($cart->items as $key => $item): ?>
							<li><?=$this->html->link($item->product->title, array('Catalog::product', 'slug'=>$item->product->slug, 'category'=>$item->product->category('slug'))); ?> - <?= $item->quantity; ?> x <?= $item->product->price(); ?> ~ <strong><?= $item->total; ?></strong></li>
						<?php endforeach ?>
							<li><strong><?= $t('Total order:') ?></strong> <span class="label label-warning"><?= $cart->total() ?></span></li>
						</ul>


						<h5><?= $t('Delivery address:') ?></h5>
						<ul class="list-unstyled well">
							<li><?= $order->first_name ?>	<?= $order->last_name ?></li>
							<li><?= $order->address1 ?>	<?= $order->address2 ?></li>							
							<li><?= $order->city ?>	<?= $order->cp ?></li>
							<li><?= $order->country ?></li>
						</ul>



					</div>
				</div>
			
			
			</div>
		</div>

	</div>

</div>
