<?php
	use WPSG_Core\SG_Util;

	$item_slug = 'multi-'.$multi_list_id.'-item-'.$multi_list_item_id; 
?>
<input type="radio" id="<?php echo $item_slug ?>" name="<?php echo 'multi-'.$multi_list_id ?>" <?php echo ($multi_list_item_id===1) ? 'checked' : '' ?>>
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