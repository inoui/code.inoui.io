
<?php if (isset($channel->schema->fields)): ?>
<?php foreach ($channel->schema->fields as $key => $group): ?>
<div class="row">

	<div class="col-xs-4">
		<h3><?= $key; ?></h3>
	</div>

	<div class="col-xs-8">
		<?php foreach ($group as $name => $field): ?>
			<?=$this->form->field('channel.'.$name, (array)$field); ?>
		<?php endforeach; ?>
	</div>

</div>

<hr />

<?php endforeach; ?>
<?php endif; ?>