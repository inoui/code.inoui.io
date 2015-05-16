<script type="text/javascript" charset="utf-8">
	window.onload = window.print;
</script>

<section>
                  <div class="panel panel-primary">
                      <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                      <div class="panel-body">
                          <div class="row invoice-list">
                              <div class="text-center corporate-id">
								<?=$this->html->image('logo.png', array('alt' => 'altText')); ?>
                              </div>
                              <div class="col-lg-4 col-sm-4">
                                  <h4><?= $t('BILLING ADDRESS'); ?>	</h4>
                                  <p>
									<?= $order->name('billing'); ?><br/>
									<?php echo $order->address('billing'); ?>
                                  </p>
                              </div>
                              <div class="col-lg-4 col-sm-4">
                                  <h4><?= $t('SHIPPING ADDRESS'); ?></h4>
                                  <p>
									<?= $order->name(); ?><br/>
									<?php echo $order->address('shipping'); ?>
                                  </p>
                              </div>
                              <div class="col-lg-4 col-sm-4">
                                  <h4><?= $t('INVOICE INFO'); ?>	</h4>

                                  <ul class="unstyled">
                                      <li><?= $t('Invoice number:') ?> <strong>69626</strong></li>
                                      <li><?= $t('Invoice date:') ?> <strong><?= $this->time->to($order->created);?></strong></li>
                                      <li><?= $t('Registered:') ?>	 <strong><?= $preferences->company_number; ?></strong></li>
									  <li><?= $t('Vat:') ?>	<strong><?= $preferences->vat; ?></strong></li>
                                  </ul>
									<?= $preferences->name(); ?><br/>
									<?php echo $preferences->address('shipping'); ?>

                              </div>
                          </div>
                          <table class="table table-striped table-hover">
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
                              </thead>
								<tbody>
									<?php foreach ($order->items as $key => $item): ?>
									    <tr>
									      <td>#<?= $item->sku; ?>	</td>
									      <td> <?= $item->product->title ?>	</td>
										  <td><div class='text-center'><?= $item->quantity ?>	</div></td>
									      <td><div class='text-right hidden-xs'><?= $item->product->price(); ?></td>
										  <td class="bold" ><div class='text-right'><?= $item->total; ?></div></td>
									    </tr>
									<?php endforeach ?>

								</tbody>
                          </table>
                          <div class="row">
                              <div class="col-lg-4 invoice-block pull-right">
                                  <ul class="unstyled amounts">
									   <li><strong><?= $t('Shipping') ?> :</strong> <?= $order->total('shipping_rate') ?></li>
									   <li><strong><?= $t('Total HT') ?> :</strong> <?= $order->total('ht') ?></li>
									   <li><strong><?= $t('Vat') ?>  (<?= $order->vat_rate() ?>%) :</strong> <?= $order->total('vat') ?></li>
									   <li><strong><?= $t('Total') ?> :</strong> <?= $order->total() ?></li>

                                  </ul>
                              </div>
                          </div>

                      </div>
                  </div>
              </section>

