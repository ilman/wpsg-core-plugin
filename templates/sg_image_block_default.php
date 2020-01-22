<?php 
	$image_size = ($image_size) ? $image_size : 'medium';
	$image = wp_get_attachment_image_src($image, $image_size);
	if($image){
		$image_url = @$image[0];
	}

	$class = ($content) ? trim($class.' with-content') : trim($class.' no-content');
?>

<?php ob_start(); ?>
<div class="sg-block <?php echo $class ?>" data-mh="block">
	<div class="block-thumb">
		<img src="<?php echo $image_url ?>" alt="image" />
	</div>
	<div class="block-body">
		<h4 class="title" data-mh="block-title"><?php echo $title ?></h4>
		<?php echo $content ?>
	</div>
</div>
<?php $output = ob_get_clean(); ?>

<?php 
	if($url){
		echo '<a class="block-link" href="'.$url.'">'.$output.'</a>';
	}
	else{
		echo $output;
	}
?>