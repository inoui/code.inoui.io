<script type="text/javascript" charset="utf-8">
	window.onload = window.print;
</script>
<div class="box-body">
	<div class="panel panel-default">
	  <div class="panel-body">
		<div class='row'>
			<div class='col-md-12'>
				<div class="invoice-header clearfix">
					<h3 class='pull-right'>
					  <span><?= $t("Invoice"); ?>	</span>
					  <span class='text-muted'>#<?= $order->order_number ?>	</span>
					</h3>
				</div>
			</div>
		</div>
		<hr>
		<div class='row'>
			<div class='col-sm-4 seller'>
				
				
				<div class="well">
					  <strong><?= $preferences->name('billing_name'); ?></strong>
							<address >
								<?php echo $preferences->address('billing_address'); ?>
							</address>

				  <strong><?= $t('Invoice number:') ?>	 </strong>#<?= $order->order_number ?>	
				  <br>
				  <strong><?= $t('Invoice date:') ?>	 </strong> <?= $this->time->to($order->created, 'EEEE dd MMMM'); ?>
				  <br>
				  <strong><?= $t('Registered:') ?>	 </strong> <?= $preferences->company_number; ?>	
				  <br>
				  <strong><?= $t('Vat:') ?>	 </strong> <?= $preferences->vat; ?>	
				  <br>
			  </div>
			  

			</div>
			<div class='col-sm-4 buyer'>


			</div>
			<div class='col-sm-4 payment-info'>
				  <strong><?= $order->name('billing'); ?></strong>
					<address >
						<?php echo $order->address('billing'); ?>
					</address>
				
			</div>
		  </div>
	  </div>
	  <!-- COST TABLE -->
	  <table class="table table-striped table-hover font-400 font-14">
		<thead>
		  <tr>
			<th><?= $t('Code') ?>	</th>
			<th><?= $t('Item/ Description') ?>	</th>
			<th>
			  <div class='text-center'><?= $t('Qty') ?>	</div>
			</th>
			<th>
			  <div class='text-right hidden-xs'><?= $t('Unit Cost') ?>	</div>
			</th>
			<th>
			  <div class='text-right'><?= $t('Total Price') ?>	</div>
			</th>
		  </tr>
		</thead>
		<tbody>
			<?php foreach ($order->items as $key => $item): ?>
			    <tr>
			      <td>#<?= $item->sku; ?>	</td>
			      <td> <?= $item->product->title ?>	</td>
				  <td>			  <div class='text-center'><?= $item->quantity ?>	</div></td>
			      <td>			  <div class='text-right hidden-xs'><?= $item->product->price(); ?></td>
				  <td class="bold" >			  <div class='text-right'><?= $item->total; ?></div></td>
			    </tr>
			<?php endforeach ?>

		</tbody>
	  </table>
	  <!-- /COST TABLE -->
	  <!-- FOOTER -->
	  <hr>
	  <div class="panel-body">
		  <div class='row'>
			<div class='col-sm-12'>
			  <div class='text-right font-400 font-14'>

				<h3 class="amount"><?= $t('Shipping') ?> : <?= $order->total('shipping_rate') ?> </h3>
				<h3 class="amount"><?= $t('Total HT') ?> :</strong> <?= $order->total('ht') ?> </h3>
				<h3 class="amount"><?= $t('Vat') ?>  (<?= $order->vat_rate() ?>%):</strong> <?= $order->total('vat') ?></h3>
				<h2 class="amount"><?= $t('Total') ?> : <?= $order->total() ?> </h2>
			  <br/>

	  		</div>
			  
		  </div>
		</div>
	  </div>
	  <!-- /FOOTER -->
	  <hr>
	  <div class="divide-100"></div>
	</div>
</div>
