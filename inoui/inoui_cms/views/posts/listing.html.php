<?php foreach ($posts as $key => $post): ?>
	<section class="article_section">
		<h1><?php echo $post->title ?></h1>	
		<div class="intro"><?php echo $post->subtitle ?></div>
		<?php echo $post->content ?>
	</section>
<?php endforeach ?>