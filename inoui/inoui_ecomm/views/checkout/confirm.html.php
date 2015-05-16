<?php $cover = rand(1, 11); ?>

<div id="catalog" class="part" data-init="" style="background-image:url(/media/fonds/honore<?= $cover ?>.jpg);">

	<div class="overlay hide"></div>	

	<div class="productView">
		<div class="block ">
			
			<div class="container">

				<h1 class="black"><?= $t('Confirmation') ?>	</h1>
				<hr />
				<div class="row">
					<div class="col-xs-7 bg">
						<h5><?= $t('Your order:') ?></h5>
						<p><?= $t('Thank you for your order, you will soon received a confirmation email.'); ?>	</p>
					</div>
					<div class="col-xs-5">
						<h5><?= $t('Your order:') ?></h5>
						<ul class="list-unstyled well">
						<?php foreach ($order->items as $key => $item): ?>
							<li><?=$this->html->link($item->product->title, array('Catalog::product', 'slug'=>$item->product->slug, 'category'=>$item->product->category('slug'))); ?> - <?= $item->quantity; ?> x <?= $item->product->price(); ?> ~ <strong><?= $item->total; ?></strong></li>

						<?php endforeach ?>
							<li><strong><?= $t('Total order:') ?></strong> <span class="label label-warning"><?= $order->total() ?></span></li>
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
