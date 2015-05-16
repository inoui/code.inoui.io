<?php
use inoui_ecomm\models\Orders;
?>
<section class="panel">
	<?=$this->html->link($t('Print invoice'), array('Orders::printorder', 'id'=>$order->_id), array('class'=>' btn btn-info pull-right', 'icon'=>'print', 'target'=>'_blank')); ?>
	<header class="panel-heading"><?= $t('Order #') ?><?= $order->order_number; ?></header>
	<?= $this->form->create($order, array('url'=>array('orders::edit','id'=>$order->_id), 'type'=>'file', 'class'=>''));?>
	
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<h5><?= $t('Shipping information:') ?></h5>
				<div class="well">
					<address >
					  <strong><?= $order->name(); ?></strong> / 
					  <a href="mailto:<?= $order->email ?>	"><?= $order->email ?>	</a><br/>
						<?php echo $order->address('shipping'); ?>
					</address>

				</div>

			</div>
			<div class="col-md-6">
				<h5><?= $t('Billing information:') ?></h5>
				<div class="well">
				  <strong><?= $order->name('billing'); ?></strong>
					<address >
						<?php echo $order->address('billing'); ?>
					</address>
				</div>
			</div>
		</div>

		<?php if ($order->comments): ?>
		<h5><?= $t('Comments')?>	</h5>
		<div class="well">
			<?= $order->comments ?>	
		</div>
		<?php endif ?>


		<h5><?= $t('Order')?>	</h5>			

		<table class="table table-striped table-bordered ">
		  <thead>
		    <tr>

		      <th><?= $t('Sku'); ?></th>
		      <th><?= $t('Product'); ?></th>
		      <th><?= $t('Quantity'); ?></th>
		      <th><?= $t('Price'); ?></th>
		      <th><?= $t('Total'); ?></th>
		    </tr>
		  </thead>
		  <tbody>
			<?php foreach ($order->items as $key => $item): ?>
			    <tr>
			      <td>#<?= $item->sku; ?>	</td>
			      <td> <?=$this->html->link($item->product->title, array('Catalog::product', 'slug'=>$item->product->slug, 'category'=>$item->product->category('slug'), 'library'=>'inoui_ecomm', 'admin'=>null)); ?></td>
				  <td><?= $item->quantity ?>	</td>
			      <td><?= $item->product->price(); ?></td>
				  <td class="bold" ><?= $item->total; ?></td>
			    </tr>
			<?php endforeach ?>

			<tr>
				<td colspan="5" align="center">
					<h2 align='center'><?= $t('Total') ?> : <?= $order->total() ?> <br/>
						<small><?= $t('Shipping');  ?>	<?= $order->total('shipping_rate'); ?></small>	</h2>
				</td>
			</tr>

		  </tbody>
		</table>
		<div class="row">
			<div class="col-md-4">
				<?=$this->form->field('status', array(
					'label' => $t('Change status'),
					'class' => 'form-control change',
					'value' =>$order->status,
					'list'=>Orders::getStatus(),
					'type'=>'select',
					'data-action' => 'Admin.changeOrderStatus'
				)); ?>


			</div>
			<div class="col-md-8">

				<div class="infoStatus hidden">
					<div class="tracking hidden">
					<?=$this->form->field('tracking', array(
						'label' => $t('Tracking info'),
						'placeholder' => $t('eg. xz215651'),
						'class' => 'form-control '
					)); ?>
					</div>

					<?=$this->form->field('status_message', array(
						'label' => $t('Message'),
						'value' => '',
						'class' => 'form-control',
						'type' => 'textarea'
					)); ?>

					<?=$this->form->field('sendmail', array(
						'label'=> array('&nbsp;'.$t('Send mail to customer') => array('escape' => false)),
						'options' => array('escape'=>false),
						'type' => 'checkbox'
					)); ?>

				</div>


			</div>

		</div>
		<div class="pull-right">
			<?=$this->form->submit($t('Save'), array(
				'class' => 'btn btn-primary'
			)); ?>
		</div>
	</div>
	<?=$this->form->end(); ?>

</section>
