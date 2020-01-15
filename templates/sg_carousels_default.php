<?php 

$content = do_shortcode($content);

/*carousel__item carousel__item--desktop-in-4 carousel__item--mobile-in-1 carousel__item--tablet-in-3 wpsg-carousel-item default*/

$content = preg_replace('/carousel__item--desktop-in-[0-9]*/', 'carousel__item--desktop-in-'.$cols, $content);
$content = preg_replace('/carousel__item--tablet-in-[0-9]*/', 'carousel__item--tablet-in-'.$cols_sm, $content);
$content = preg_replace('/carousel__item--mobile-in-[0-9]*/', 'carousel__item--mobile-in-'.$cols_xs, $content);

echo '<div class="'.trim('carousel-wrapper '.$class).'">
<div class="carousel">
<input checked="checked" class="carousel__activator" type="radio">
<div class="carousel__controls">
</div>
<div class="carousel__screen">
<div class="carousel__track">
'.$content.'
</div>
</div>
</div>
</div>';