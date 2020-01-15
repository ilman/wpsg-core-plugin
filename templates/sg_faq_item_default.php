<?php 
	global $wpsg_faq_item_idx;
	if(!isset($wpsg_faq_item_idx) || !$wpsg_faq_item_idx){ $wpsg_faq_item_idx = 0; }
	$wpsg_faq_item_idx++;
?>
<div class="<?php echo trim('expandable-content-container '.$class) ?>">
	<input class="expandable-content__checkbox" data-expander-input="" data-interaction-section="faq" data-interaction-topic="<?php echo $title ?>" data-interaction-type="open expander" id="<?php echo 'faq-'.$wpsg_faq_item_idx ?>" type="checkbox">
	<div class="expandable-content title-content-expander">
		
		<label class="expandable-content__head title-content-expander__head" for="<?php echo 'faq-'.$wpsg_faq_item_idx ?>">
			<h3 class="title-content-expander__heading">
				<?php echo $title ?>
			</h3>
			<i class="title-content-expander__state">
				<svg class="inline-icon inline-icon--x-small inline-icon__outline inline-icon__outline--black" viewBox="0 0 24 24">
					<path stroke-miterlimit="10" d="M2 7l10 10L22 7" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"></path>
				</svg>
			</i>

		</label>
		<div class="expandable-content__content title-content-expander__content">
			<div class="expandable-content__content-wrapper title-content-expander__content-wrapper">
				<?php echo do_shortcode($content) ?>
			</div>	
		</div>
		
	</div>
</div>