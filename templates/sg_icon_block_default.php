<?php 
	if(!$icon_inline && $icon){
		$icon_size = ($icon_size) ? $icon_size : 'medium';
		$icon = wp_get_attachment_icon_src($icon, $icon_size);

		$icon_inline = @$icon[0];
		$icon_inline = '<img src="'.$icon_inline.'" alt="image" />';
	}
	elseif($icon_inline){
		$icon_inline = @base64_decode($icon_inline);
		$icon_inline = @urldecode($icon_inline);
	}

	$class = ($content) ? trim($class.' with-content') : trim($class.' no-content');
?>

<?php ob_start(); ?>
<div class="sg-block <?php echo $class ?>" data-mh="block">
	<div class="block-thumb">
		<?php echo $icon_inline ?>
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