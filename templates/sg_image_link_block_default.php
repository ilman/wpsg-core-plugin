<?php 
	$image_size = ($image_size) ? $image_size : 'full';
	$image = wp_get_attachment_image_src($image, $image_size);
	if($image){
		$image_url = @$image[0];
	}
?>
<a class="<?php echo trim('image-link-card '.$class) ?>" href="<?php echo $url ?>">
	<div class="image-link-card__img" data-lazy-srcset="" style="background-image: url(<?php echo $image_url ?>);"></div>
	<div class="image-link-card__text">
		<span class="image-link-card__title">
			<?php echo $title ?>
			<svg class="inline-icon inline-icon--x-small inline-icon__outline inline-icon__outline--white" viewBox="0 0 24 24">
				<path stroke-miterlimit="10" d="M7 2l10 10L7 22" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"></path>
			</svg>
		</span>
	</div>
</a>