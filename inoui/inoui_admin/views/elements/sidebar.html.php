<?php
	$navs = inoui\models\Navigation::getData('admin');
?>
<aside>
	<div id="sidebar"  class="nav-collapse ">
		<?php foreach ($navs as $key => $nav): ?>
			<?= $this->html->nav($nav, array('class'=>'sidebar-menu'));?>
		<?php endforeach ?>
	</div>
</aside>
    