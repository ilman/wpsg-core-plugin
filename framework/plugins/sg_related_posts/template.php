<div class="row post-list">
	<?php while($post->have_posts()): $post->the_post(); ?>
		<div class="col-sm-3 post-item">
			<?php include(sg_view_path('framework/templates/block-post-thumb.php')); ?>
		</div>
		<!-- col -->
	<?php endwhile; ?>
</div>
<!-- row -->