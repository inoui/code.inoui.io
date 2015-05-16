<?php
use lithium\core\Environment;
$locale = Environment::get('locale');
?>

<?= $this->form->hidden('name'); ?>


<header class="panel-heading">
    <h1 class="editable" data-field="title" data-disable-toolbar="true" data-disable-return="true" data-placeholder="<?= $t('Title') ?>">
		<?= $page->title; ?>
	</h1>		
</header>

<div class="panel-body">
    <h2 class="editable" data-field="subtitle" data-disable-toolbar="true" data-placeholder="<?= $t('Excerpt') ?>">
        <?php echo $page->subtitle; ?>
    </h2>
    <div class="editable mimages"  data-field="content" data-placeholder="<?= $t('content') ?>">
	   <?php echo $page->content; ?>
    </div>
</div>
