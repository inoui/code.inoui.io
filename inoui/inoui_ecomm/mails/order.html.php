<?php
use Lithium\core\Environment;
$locale = Environment::get('locale');
use \lithium\g11n\Message;
extract(Message::aliases());
use inoui\models\Preferences;
$preferences = Preferences::get();
?>



<table width="100%" border="0" cellpadding="20">
  <tr>
    <td>

		<p class="lead"><strong><?= $t('Dear') ?> <?= $order->name() ?>, </strong></p>

		<p class="lead"><?= $t('Thank you for shopping at {:site_name}', $preferences->to('array')) ?><br/><?= $t('We will process your order immediately.'); ?></p>

		<p class="callout">
			<?=$this->html->link($t('You can check the status of your order here'), array('Orders::index', 'id'=>(string)$order->order_number, 'email'=>$order->email, 'library'=>'inoui_ecomm',  'locale'=>$locale)); ?>
		</p>



		<table width="100%" cellpadding='0'>
		<tr>
			<td width="50%"><h3><?= $t('Your Order'); ?> <small>#<?= $order->order_number ?></small></h3></td>
			<td>
				


				<?php echo $order->address('shipping'); ?>
				<a href="mailto:<?= $order->email ?>	"><?= $order->email ?>	</a><br/>

			</td>
		</tr>


		<table width="100%" cellpadding='0'>
		  <thead>
		    <tr>

		      <th> </th>
		      <th><?= $t('Product'); ?></th>
		      <th><?= $t('Price'); ?></th>
		      <th><?= $t('Quantity'); ?></th>
		      <th><?= $t('Total'); ?></th>
		    </tr>
		  </thead>
		  <tbody >
			<?php foreach ($order->items as $key => $item): ?>
			    <tr>

			      <td align="center" style="border-top:1px solid #000"><?= $this->html->image($item->product->thumbnail(), array('size'=>'50c')) ?></td>
			      <td align="center" style="border-top:1px solid #000"><?=$this->html->link($item->product->title, array('Catalog::product', 'locale'=>$locale, 'slug'=>$item->product->slug, 'category'=>$item->product->category('slug'), 'library'=>'inoui_ecomm'), array('style'=>'color:#000')); ?></td>
			      <td align="center" style="border-top:1px solid #000"><?= $item->product->price(); ?></td>
				  <td  align="center" style="border-top:1px solid #000">
					<?= $item->quantity ?>	
					</td>
				  <td class="bold" align="center"  style="border-top:1px solid #000"><?= $item->total; ?></td>
			    </tr>
			<?php endforeach ?>


			<tr>
				<td colspan="5" align="center"  style="border:1px solid #000">
					<strong><?= $t('Shipping:') ?></strong> <span class="label label-warning"><?= $order->total('shipping_rate') ?></span>
					<h3 align='center'><?= $t('Total') ?> : <?= $order->total() ?></h3>
				</td>
			</tr>

		  </tbody>
		</table>


		</td>
	</tr>
</table>
