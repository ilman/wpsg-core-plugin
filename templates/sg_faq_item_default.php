<?php
	$item_slug = 'faq-'.$faq_list_id.'-item-'.$faq_list_item_id; 
?>
<input type="radio" id="<?php echo $item_slug ?>" name="<?php echo 'faq-'.$faq_list_id ?>" <?php echo ($faq_list_item_id===1) ? 'checked' : '' ?>>
<label class="item-button" for="<?php echo $item_slug ?>">
	<a>
		<strong><?php echo $title ?></strong>
	</a>
</label>

<div class="item <?php echo trim($class) ?>">
	<div class="content">
		<?php echo do_shortcode($content) ?>
	</div>
</div>