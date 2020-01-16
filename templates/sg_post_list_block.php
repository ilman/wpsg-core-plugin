<?php
	if(!isset($col_width)){ $col_width = 12; }
	if(!isset($class)){ $class = ''; }	
	if(!isset($style)){ $style = ''; }

	$class = trim("post-list row $class");
	if(!$style){ $style = ' style="'.$style.'"'; }	
?>
<ul class="<?php echo $class ?>"<?php echo $style ?>>
<?php while ( $sg_post->have_posts() ) : $sg_post->the_post(); ?>
<li <?php post_class('post-item col-sm-'.$col_width); ?>>
	<a class="block-link" href="<?php the_permalink() ?>">
		<div class="sg-block block-post boxed" data-mh="block">
			<div class="block-thumb">
				<img src="<?php the_post_thumbnail_url('post-medium') ?>" alt="image" />
			</div>
			<div class="block-body">
				<h4 class="title" data-mh="block-title"><?php the_title() ?></h4>
				<?php $content ?>
			</div>
		</div>
	</a>
</li>
<?php endwhile; ?>
</ul>