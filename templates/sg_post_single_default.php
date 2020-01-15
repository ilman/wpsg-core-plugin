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
	<?php if($content): ?>
		<?php echo do_shortcode($content) ?>
	<?php else: ?>
		<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
	<?php endif; ?>
</li>
<?php endwhile; ?>
</ul>