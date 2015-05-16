<?php
use lithium\core\Environment;
$locale = Environment::get('locale');
?>
<header class="panel-heading">
    <h1 class="editable" data-field="title" data-disable-toolbar="true" data-disable-return="true" data-placeholder="<?= $t('Paceholder title') ?>">
		<?= $post->title; ?>
	</h1>		
</header>

<div class="panel-body">
       <h2 class="editable" data-field="subtitle" data-disable-toolbar="true" data-placeholder="<?= $t('Paceholder intro') ?>">
		<?php echo $post->subtitle; ?>
	</h2>
       <div class="editable"  data-field="content" data-placeholder="<?= $t('Paceholder content') ?>">
		<?php echo $post->content; ?>
	</div>
</div>
