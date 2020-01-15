<?php 
	if(!$icon_inline && $icon){
		$icon_size = ($icon_size) ? $icon_size : 'full';
		$icon = wp_get_attachment_icon_src($icon, $icon_size);

		$icon_inline = @$icon[0];
		$icon_inline = '<img src="'.$icon_inline.'" alt="image" />';
	}
	elseif($icon_inline){
		$icon_inline = @base64_decode($icon_inline);
		$icon_inline = @urldecode($icon_inline);
	}
?>

<div class="overview-section">
	<div class="overview-section__icon"><?php echo $icon_inline ?></div>
	<div class="overview-section__heading"><?php echo $title ?></div>
	<div class="overview-section__content"><?php echo $content ?></div>
</div>