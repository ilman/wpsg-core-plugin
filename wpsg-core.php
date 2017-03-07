<?php
/**
 * @package WPSG_Core
 * @version 1.0
 */
/*
Plugin Name: WPSG Core
Plugin URI: http://localhost/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Ilman Maulana
Version: 1.0
*/

require_once('framework/includes/SG_Util.php');
require_once('framework/includes/WPSG_Helpers_Lite.php');

require_once('framework/plugins/sg_popular_posts/sg_popular_posts.php');
require_once('framework/plugins/sg_related_posts/sg_related_posts.php');
require_once('framework/plugins/sg_user_avatar/sg_user_avatar.php');

require_once('framework/shortcodes/sg_sc_framework.php');
require_once('framework/shortcodes/sg_sc_framework_block.php');
require_once('framework/shortcodes/sg_sc_framework_list.php');
require_once('framework/shortcodes/sg_sc_post.php');
require_once('framework/shortcodes/sg_sc_wp.php');

require_once('framework/custom_post_types/sg_cpt_snippet.php');
