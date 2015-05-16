<div id="catalog" class="part">

	<div class="overlay hide"></div>	

	<div class="productView">
		<div class="block ">
			
			<div class="container">

				<h1 class="black"><?= $t('Your order') ?>	#<?= $order->order_number; ?>	</h1>
				<hr />
				<div class="row">
					<div class="col-xs-7 bg">
						<h5><?= $t('Your order status:') ?> <?= $order->status ?> </h5>
						<ul class="list-unstyled well">
						<?php foreach ($order->items as $key => $item): ?>
							<li><?=$this->html->link($item->product->title, array('Catalog::product', 'slug'=>$item->product->slug, 'category'=>$item->product->category('slug'))); ?> - <?= $item->quantity; ?> x <?= $item->product->price(); ?> ~ <strong><?= $item->total; ?></strong></li>

						<?php endforeach ?>
						<li><strong><?= $t('Shipping:') ?></strong> <span class="label label-warning"><?= $order->total('shipping_rate') ?></span>
							<hr />
							</li>
						<li><h3><strong><?= $t('Total order:') ?></strong> <span class="label label-warning"><?= $order->total() ?></span></h3></li>
						</ul>
						<?php if ($order->status == 'ready'): ?>

							<?=$this->html->link($t('Print invoice'), array('Orders::index', 'id'=>$order->order_number, 'email' => $order->email, 'library'=>'inoui_ecomm', 'args'=>'print'), array('class'=>' btn btn-default', 'icon'=>'envelope', 'target'=>'_blank')); ?>
							<?=$this->html->link($t('Send back email'), array('Orders::index', 'id'=>$order->order_number, 'email' => $order->email, 'library'=>'inoui_ecomm', 'args'=>'email'), array('class'=>' btn btn-default', 'icon'=>'envelope')); ?>
						<?php endif ?>
					</div>
					<div class="col-xs-5">
						
						<div class="row">
							<div class="col-xs-6">
								<h5><?= $t('Shipping information:') ?></h5>
								<div class="well">
									<address >
									  <strong><?= $order->name(); ?></strong> / 
									  <a href="mailto:<?= $order->email ?>	"><?= $order->email ?>	</a><br/>
										<?php echo $order->address('shipping'); ?>
									</address>

								</div>						
								
							</div>
							<div class="col-xs-6">
								<?php if (isset($order->billing)): ?>
									<h5><?= $t('Billing information:') ?></h5>
									<div class="well">
									  <strong><?= $order->name('billing'); ?></strong>
										<address >
											<?php echo $order->address('billing'); ?>
										</address>
									</div>
								<?php endif ?>
								
							</div>
						</div>


					</div>
				</div>
			
			
			</div>
		</div>

	</div>

</div>
