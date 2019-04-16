<?php

/**

 * The template for Settings up Functions

 */

/**

 * @Get logo

 *

 */

$jobcareer_options = CS_JOBCAREER_GLOBALS()->theme_options();

if (!function_exists('jobcareer_logo')) {



    function jobcareer_logo() {

        global $jobcareer_options;

        $logo = '';

        if (isset($jobcareer_options['cs_custom_logo'])) {

            $logo = $jobcareer_options['cs_custom_logo'];

        }

        if ($logo == '') {

            $logo = trailingslashit(get_template_directory_uri()) . 'assets/images/logo.png';

        }

        ?>

        <div class="logo">

            <a href="<?php echo esc_url(home_url()); ?>">    

               <?php  /* ?> <img src="<?php if (isset($logo)) {echo esc_url($logo);} ?>" style="width:<?php

                     if (isset($jobcareer_options['cs_logo_width'])) {

                         echo jobcareer_special_char($jobcareer_options['cs_logo_width']);

                     }

                     ?>px; height: <?php

                     if (isset($jobcareer_options['cs_logo_height'])) {

                         echo jobcareer_special_char($jobcareer_options['cs_logo_height']);

                     }

                     ?>px;" alt="<?php bloginfo('name'); ?>"> <?php  */?>
					 
					 <img src="<?php echo site_url(); ?>/wp-content/uploads/2018/11/logo-new.png" style="width: 100%;"  alt="Referlink" />

            </a>

        </div>

        <?php

    }



}



if (!function_exists('jobcareer_header_meta')) {



    function jobcareer_header_meta() {

        global $post;

        if (is_singular()) {



            while (have_posts()) : the_post();

                $post_type = get_post_type($post->ID);



                if ($post_type == 'jobcareer' || $post_type == 'jobs') {



                    $cs_thumb_url = '';



                    if (has_post_thumbnail()) {

                        $image_id = get_post_thumbnail_id($post->ID);

                        $thumb_url = jobcareer_attachment_image_src($image_id, 0, 0);

                        $cs_thumb_url = $thumb_url;

                    }

                    if( $post_type == 'jobs' ){

                        $user_id = get_post_meta( $post->ID, 'cs_job_username', true );

                        $user_image = get_user_meta( $user_id, 'user_img', true );

                        $cs_thumb_url = cs_get_image_url($user_image, '');

                    }

                    $cs_meta = '

                    <meta property="fb:app_id" content="966242223397117" />

                    <meta property="og:title" content="' . get_the_title() . '"/>

                    <meta property="og:description" content="' . wp_trim_words(get_the_content(), 50, '') . '"/>

                    <meta property="og:type" content="article"/>

                    <meta property="og:url" content="' . get_permalink() . '"/>

                    <meta property="og:site_name" content="' . get_bloginfo('name') . '"/>

                    <meta property="og:image" content="' . esc_url($cs_thumb_url) . '"/>';



                    echo jobcareer_special_char($cs_meta);

                }

            endwhile;

        }

    }



}



/**

 * @cs sticky logo

 *

 *

 */

if (!function_exists('jobcareer_sticky_logo')) {



    function jobcareer_sticky_logo() {

        global $jobcareer_options;

        $stickey_logo = isset($jobcareer_options['jobcareer_sticky_logo']) ? $jobcareer_options['jobcareer_sticky_logo'] : '';

        $logo = $jobcareer_options['cs_custom_logo'];

        ?>

        <div class="logo 546sdf">

            <a href="<?php echo esc_url(home_url()); ?>">    
<?php /*?> 
                <img src="<?php echo esc_url($logo); ?>" style="width:<?php echo jobcareer_special_char($jobcareer_options['cs_logo_width']); ?>px; height: <?php echo jobcareer_special_char($jobcareer_options['cs_logo_height']); ?>px;" alt="<?php bloginfo('name'); ?>"> <?php */?> 
				<img src="<?php echo site_url(); ?>/wp-content/uploads/2018/10/logo.png" title="Referlink" alt="logo" />

            </a>

        </div>

        <?php

        if (isset($jobcareer_options['jobcareer_sticky_logo']) && $jobcareer_options['jobcareer_sticky_logo'] <> "" && $jobcareer_options['cs_sitcky_header_switch'] == 'on') {

            $logo = $jobcareer_options['jobcareer_sticky_logo'];

        } else {

            $logo = $jobcareer_options['cs_custom_logo'];

        }

        ?>

        <div class="logo sticky">

            <a href="<?php echo esc_url(home_url()); ?>">    

                <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>">

            </a>

        </div>

        <?php

    }



}



/**

 * @Set Header Position

 *

 *

 */

if (!function_exists('jobcareer_header_postion_class')) {



    function jobcareer_header_postion_class() {

        global $jobcareer_options;

        return 'header-' . $jobcareer_options['cs_header_position'];

    }



}

/**

 * @Set Header strip

 *

 *

 */

if (!function_exists('jobcareer_header_strip')) {



    function jobcareer_header_strip($container = 'on') {

        global $jobcareer_options;

        $cs_multi_setting_switch = isset($jobcareer_options['cs_multi_setting_switch']) ? $jobcareer_options['cs_multi_setting_switch'] : '';

        $cs_time_setting_switch = isset($jobcareer_options['cs_time_setting_switch']) ? $jobcareer_options['cs_time_setting_switch'] : '';

        $cs_social_setting_switch = isset($jobcareer_options['cs_social_setting_switch']) && $jobcareer_options['cs_social_setting_switch'] != '' ? $jobcareer_options['cs_social_setting_switch'] : '';

        $cs_content_time = isset($jobcareer_options['cs_content_time']) ? $jobcareer_options['cs_content_time'] : '';

        if (isset($jobcareer_options['cs_header_top_strip']) and $jobcareer_options['cs_header_top_strip'] == 'on') {

            $cs_afterlogin_class = '';

            ?>

            <div class="cs-top-bar">

                <div class="container">

                    <?php if ($cs_time_setting_switch == 'on') { ?>

                        <div class="left-side">

                            <span class="cs-timing-text"><?php echo esc_attr($cs_content_time); ?></span> 

                        </div>

                    <?php }

                    ?>



                    <div class="right-side">

                        <?php if (function_exists('icl_object_id') and $cs_multi_setting_switch != 'off') { ?>  

                            <?php echo do_action('icl_language_selector'); ?> 								

                        <?php } ?>

                        <div class="social-media">

                            <ul>

                                <?php if ($cs_social_setting_switch == 'on') { ?>

                                    <?php

                                    if (function_exists('jobcareer_social_network')) {

                                        jobcareer_social_network();

                                    }

                                }

                                ?>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

            <?php

        }

    }



}

//  Start function for Mega Menu walker 

if (!class_exists('jobcareer_mega_menu_walker')) {



    class jobcareer_mega_menu_walker extends Walker_Nav_Menu {



        private $CurrentItem, $CategoryMenu, $menu_style;



        // Start function for Mega menu

        function cs_menu_start() {

            $sub_class = $last = '';

            $count_menu_posts = 0;

            $mega_menu_output = '';

        }



        // Start function For Mega menu level



        function start_lvl(&$output, $depth = 0, $args = array(), $id = 0) {

            $indent = str_repeat("\t", $depth);



            $output .= $this->cs_menu_start();

            $columns_class = $this->CurrentItem->columns;



            $cs_parent_id = $this->CurrentItem->menu_item_parent;



            $parent_nav_mega = get_post_meta($cs_parent_id, '_menu_item_megamenu', true);



            if ($this->CurrentItem->megamenu == 'on' && $depth == 0) {

                $nav_styles = $this->CurrentItem->bg != '' ? ' style="background:url(' . esc_url($this->CurrentItem->bg) . ') no-repeat right bottom #fff;"' : '';

                $output .= "\n$indent<ul" . $nav_styles . " class=\"dropdown-menu megamenu $columns_class row\" >\n";

            } else {

                if ($parent_nav_mega == 'on' && $depth == 1) {

                    $output .= "\n$indent<ul>\n";

                } else {

                    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";

                }

            }

        }



        // Start function For Mega menu level end 



        function end_lvl(&$output, $depth = 0, $args = array()) {

            $indent = str_repeat("\t", $depth);

            $output .= "$indent</ul> <!--End Sub Menu -->\n";

            if ($this->CurrentItem->megamenu == 'on' && $depth == 0) {

                

            }

        }



        // Start function For Mega menu items



        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

            global $wp_query;

            $this->CurrentItem = $item;



            $parent_nav_mega = 'off';



            if ($depth == 1) {

                $parent_menu_id = $item->menu_item_parent;

                $parent_nav_mega = get_post_meta($parent_menu_id, '_menu_item_megamenu', true);

                $parent_nav_cols = get_post_meta($parent_menu_id, '_menu_item_columns', true);

            }



            if (empty($args)) {

                $args = new stdClass();

            }



            $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

            if ($depth == 0) {

                $class_names = $value = '';

                $mega_menu = '';

            } else if ($args->has_children) {

                $class_names = $value = '';

                $mega_menu = 'parentIcon cs-sub-menu';

            } else {

                $class_names = $value = $mega_menu = '';

            }

            $classes = empty($item->classes) ? array() : (array) $item->classes;

            if ($item->object == 'page' && empty($item->menu_item_parent) or $item->object == 'custom') {

                if ($this->CurrentItem->megamenu == 'on') {

                    

                } else {

                    $mega_menu = '';

                }

            }

            $class_names = join(" $mega_menu ", apply_filters('nav_menu_css_class', array_filter($classes), $item));

            if ($this->CurrentItem->megamenu == 'on' && $args->has_children) {

                $class_names = ' class="' . esc_attr($class_names) . ' dropdown menu-large"';

            } else if (empty($args) && $args->has_children) {

                if ($depth == 0) {

                    $class_names = ' class="' . esc_attr($class_names) . ' dropdown"';

                } else {

                    $class_names = ' class="' . esc_attr($class_names) . ' dropdown-submenu"';

                }

            } else {

                $class_names = ' class="' . esc_attr($class_names) . '"';

            }

            if ($parent_nav_mega == 'on' && $depth == 1) {

                if ($parent_nav_cols == 'one-columns') {

                    $nav_classes = 'col-lg-12 col-md-12 col-sm-12';

                } else if ($parent_nav_cols == 'two-columns') {

                    $nav_classes = 'col-lg-6 col-md-6 col-sm-12';

                } else if ($parent_nav_cols == 'three-columns') {

                    $nav_classes = 'col-lg-4 col-md-4 col-sm-6';

                } else {

                    $nav_classes = 'col-lg-3 col-md-3 col-sm-6';

                }

                $output .= '<li class="' . $nav_classes . '">';

            } else {

                $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

            }

            $attributes = isset($item->attr_title) && $item->attr_title != '' ? ' title="' . esc_attr($item->attr_title) . '"' : '';

            $attributes .= isset($item->target) && $item->target != '' ? ' target="' . esc_attr($item->target) . '"' : '';

            $attributes .= isset($item->xfn) && $item->xfn != '' ? ' rel="' . esc_attr($item->xfn) . '"' : '';

            $attributes .= isset($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';



            if (isset($args->has_children) && $args->has_children) {

                //$attributes .= ' class="dropdown-toggle" data-toggle="dropdown" ';

            }



            $item_output = isset($args->before) ? $args->before : '';

            if ($this->CurrentItem->tooltip != '') {

                $item_output .= '<span class="nav-tooltip">' . $this->CurrentItem->tooltip . '</span>';

            }

            if ($parent_nav_mega == 'on' && $depth == 1) {

                $item_output .= '<h6><a' . $attributes . '>';

            } else {

                $item_output .= '<a' . $attributes . '>';

            }

            $cs_link_before = isset($args->link_before) ? $args->link_before : '';

            $item_output .= $cs_link_before . apply_filters('the_title', $item->title, $item->ID);

            if ($this->CurrentItem->subtitle != '') {

                $item_output .= '<span>' . $this->CurrentItem->subtitle . '</span>';

            }

            $cs_link_after = isset($args->link_before) ? $args->link_before : '';

            $item_output .= $cs_link_after;

            if ($parent_nav_mega == 'on' && $depth == 1) {

                $item_output .= '</a></h6>';

            } else {

                $item_output .= '</a>';

            }

            if (isset($item->description) && $item->description != '') {

                $item_output .= '<span class="sub-title">' . $item->description . '</span>';

            }



            $item_output .= isset($args->after) ? $args->after : '';

            if (!empty($mega_menu) && empty($args->has_children) && $this->CurrentItem->megamenu == 'on') {

                $item_output .= $this->cs_menu_start();

            }

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id);

        }



        // Start function For Mega menu display elements



        function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {

            $id_field = $this->db_fields['id'];

            if (is_object($args[0])) {

                $args[0]->has_children = !empty($children_elements[$element->$id_field]);

            }

            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

        }



    }



}



if (!function_exists('cs_custom_pages_menu')) {



    function cs_custom_pages_menu() {

        $cs_menu = wp_list_pages(array(

            'title_li' => '',

            'echo' => false,

        ));



        echo '<ul class="nav navbar-nav">' . $cs_menu . '</ul>';

    }



}



/**

 * @Top and Main Navigation

 *

 *

 */

if (!function_exists('jobcareer_navigation')) {



    function jobcareer_navigation($nav = '', $menus = 'menus', $menu_class = '', $depth = '0') {

		global $jobcareer_options;

        if (has_nav_menu($nav)) {



            $defaults = array(

                'theme_location' => "$nav",

                'menu' => '',

                'container' => '',

                'container_class' => '',

                'container_id' => '',

                'menu_class' => "$menu_class",

                'menu_id' => "$menus",

                'echo' => false,

                'fallback_cb' => 'wp_page_menu',

                'before' => '',

                'after' => '',

                'link_before' => '',

                'link_after' => '',

                'items_wrap' => '<ul class="%1$s">%3$s</ul>',

                'depth' => "$depth",

                'walker' => new jobcareer_mega_menu_walker(),

            );

            echo do_shortcode(str_replace('sub-menu', 'sub-dropdown', (wp_nav_menu($defaults))));

        } else {

            $defaults = array(

                'theme_location' => "",

                'menu' => '',

                'container' => '',

                'container_class' => '',

                'container_id' => '',

                'menu_class' => "$menu_class",

                'menu_id' => "$menus",

                'echo' => false,

                'fallback_cb' => 'cs_custom_pages_menu',

                'before' => '',

                'after' => '',

                'link_before' => '',

                'link_after' => '',

                'items_wrap' => '<ul class="%1$s">%3$s</ul>',

                'depth' => "$depth",

                'walker' => new jobcareer_mega_menu_walker(),

            );

			

			echo do_shortcode(str_replace('sub-menu', 'sub-dropdown', (wp_nav_menu($defaults))));

        }

    }



}



/**

 * @ Header 

 *

 *

 */

if (!function_exists('jobcareer_get_headers')) {



    function jobcareer_get_headers() {

        get_template_part('frontend/templates/headers/modern');

    }



}



/**

 * @ Main navigation

 *

 *

 */

if (!function_exists('jobcareer_header_main_navigation')) {



    function jobcareer_header_main_navigation() {

        global $post, $post_meta;

        $post_type = get_post_type(get_the_ID());

        $meta_element = 'cs_full_data';

        $post_ID = get_the_ID();

        $post_meta = get_post_meta($post_ID, "$meta_element", true);



        if (function_exists("is_shop") and ! is_shop()) {

            if (is_author() || is_search() || is_archive() || is_category() || is_404()) {



                $cs_header_banner_style = '';

            }

        } else if (!function_exists("is_shop")) {

            if (is_author() || is_search() || is_archive() || is_category() || is_404()) {



                $cs_header_banner_style = '';

            }

        }



        jobcareer_navigation('main-menu', 'nav navbar-nav');

    }



}



/**

 * @ Subheader Style

 *

 *

 */

if (!function_exists('jobcareer_subheader_style')) {



    function jobcareer_subheader_style($post_ID = '') {

        global $post, $wp_query, $jobcareer_options, $post_meta;

        $post_type = get_post_type(get_the_ID());

        $post_ID = get_the_ID();

        $meta_element = 'cs_full_data';



        $post_meta = get_post_meta((int) $post_ID, "$meta_element", true);

        $cs_header_banner_style = get_post_meta((int) $post_ID, "cs_header_banner_style", true);

        $post_meta = get_post_meta((int) $post_ID, "$meta_element", true);



        //if (function_exists("is_shop") and ! is_shop()) {

//        if (function_exists("is_shop") ) {

//            if (is_author() || is_search() || is_archive() || is_category()) {

//                $cs_header_banner_style = '';

//            }

//        } else 

            if (!function_exists("is_shop")) {

            if (is_author() || is_search() || is_archive() || is_category()) {



                $cs_header_banner_style = '';

            }

        }



        if (isset($cs_header_banner_style) && $cs_header_banner_style == 'no-header') {

            // Do Nothing

        } else if (isset($cs_header_banner_style) && $cs_header_banner_style == 'breadcrumb_header') {

            jobcareer_breadcrumb_header($post_ID);

        } else if (isset($cs_header_banner_style) && $cs_header_banner_style == 'custom_slider') {

            jobcareer_shortcode_slider('pages', $post_ID);

        } else if (isset($cs_header_banner_style) && $cs_header_banner_style == 'map') {

            jobcareer_shortcode_map($post_ID);

        } else if (isset($jobcareer_options['cs_default_header']) && $jobcareer_options['cs_default_header']) {

            if ($jobcareer_options['cs_default_header'] == 'no_header') {

                // Do Noting

            } else if ($jobcareer_options['cs_default_header'] == 'breadcrumbs_sub_header') {

                jobcareer_breadcrumb_header($post_ID);

                //jobcareer_breadcrumbs(); 

            } else if ($jobcareer_options['cs_default_header'] == 'slider') {

                jobcareer_shortcode_slider('default-pages', $post_ID);

            }

        }

    }



}

/**

 * @ Below Header Style 

 *

 *

 */

if (!function_exists('jobcareer_below_header_style')) {



    function jobcareer_below_header_style() {

        global $jobcareer_options;

        $cs_header_position = isset($jobcareer_options['cs_header_position']) ? $jobcareer_options['cs_header_position'] : '';

        $cs_absolute_view = isset($jobcareer_options['cs_headerbg_options']) ? $jobcareer_options['cs_headerbg_options'] : '';

        $cs_absolute_slider = isset($jobcareer_options['jobcareer_headerbg_slider']) ? $jobcareer_options['jobcareer_headerbg_slider'] : '';

        $cs_absolute_image = isset($jobcareer_options['cs_headerbg_image']) ? $jobcareer_options['cs_headerbg_image'] : '';

        $cs_absolute_color = isset($jobcareer_options['cs_headerbg_color']) ? $jobcareer_options['cs_headerbg_color'] : '';

        if ($cs_header_position == 'absolute') {

            if (is_author() || is_search() || is_archive() || is_category() || is_home() || is_404()) {

                if ($cs_absolute_view == 'cs_rev_slider') {

                    ?>

                    <div class="cs-banner"> <?php echo do_shortcode('[rev_slider ' . $cs_absolute_slider . ']'); ?> </div>

                    <?php

                } else if ($cs_absolute_view == 'jobcareer_bg_image_color') {

                    $cs_style_elements = 'style="background:url(' . $cs_absolute_image . ') center top ' . $cs_absolute_color . ';"';

                    ?>

                    <div class="breadcrumb-sec" <?php echo jobcareer_special_char($cs_style_elements); ?>>&nbsp;</div>

                    <?php

                }

            }

        }

    }



}

/**

 * @Custom Slider by using shortcode

 *

 *

 */

if (!function_exists('jobcareer_shortcode_slider')) {



    function jobcareer_shortcode_slider($type = '', $post_ID = '') {

        global $post, $post_meta, $jobcareer_options;

        $cs_custom_slider_id = get_post_meta((int) $post_ID, "cs_custom_slider_id", true);



        if ($type == 'pages') {

            if (empty($cs_custom_slider_id)) {

                $custom_slider_id = "";

            } else {

                $custom_slider_id = htmlspecialchars($cs_custom_slider_id);

            }

        } else {

            if (empty($cs_custom_slider_id))

                $custom_slider_id = "";

            else

                $custom_slider_id = htmlspecialchars(

                        $cs_custom_slider_id);

        }

        if (isset($custom_slider_id) && $custom_slider_id != '') {

            ?>

            <div class="cs-banner"> <?php echo do_shortcode('[rev_slider ' . $custom_slider_id . ']'); ?> </div>

            <?php

        }

    }



}

/**

 * @Custom Map by using shortcode

 *

 *

 */

if (!function_exists('jobcareer_shortcode_map')) {



    function jobcareer_shortcode_map($post_ID = '') {

        global $post, $post_meta, $header_map;

        $cs_custom_map = get_post_meta((int) $post_ID, "cs_custom_map", true);

        if (empty($cs_custom_map)) {

            $custom_map = "";

        } else {

            $custom_map = html_entity_decode($cs_custom_map);

        }

        if (isset($custom_map) && $custom_map != '') {

            $header_map = true;

            ?>

            <div class="cs-map"> <?php echo do_shortcode($custom_map); ?> </div>

            <?php

        }

    }



}

/**

 * @Breadcrumb Header

 *

 * 

 */

if (!function_exists('jobcareer_breadcrumb_header')) {



    function jobcareer_breadcrumb_header($post_ID = '') {



        global $post, $wp_query, $jobcareer_options, $post_meta;

        $breadcrumSectionStart = '';

        $breadcrumSectionEnd = '';

        $post_type = '';

        if (is_page() || is_single()) {

            if (isset($post) && $post <> '') {

                $post_ID = $post->ID;

            } else {

                $post_ID = '';

            }

            $post_type = get_post_type($post_ID);

        }



        $cs_header_banner_style = get_post_meta((int) $post_ID, "cs_header_banner_style", true);

        $cs_page_subheader_color = get_post_meta((int) $post_ID, "cs_page_subheader_color", true);

        $cs_page_subheader_text_color = get_post_meta((int) $post_ID, "cs_page_subheader_text_color", true);

        $cs_page_subheader_no_image = get_post_meta((int) $post_ID, "cs_page_subheader_no_image", true);

        $cs_header_banner_image = get_post_meta((int) $post_ID, "cs_header_banner_image", true);

        $cs_page_subheader_parallax = get_post_meta((int) $post_ID, "cs_page_subheader_parallax", true);

        $cs_subheader_padding_top = get_post_meta((int) $post_ID, "cs_subheader_padding_top", true);

        $cs_subheader_padding_bottom = get_post_meta((int) $post_ID, "cs_subheader_padding_bottom", true);

        $staticContainerStart = '';

        $staticContainerEnd = '';

        $banner_image_height = '';

        $cs_sh_paddingtop = '';

        $cs_sh_paddingbottom = '';

        $isDeafultSubHeader = 'false';

        if (is_author() || is_search() || is_archive() || is_category() || is_home() || is_404()) {

            $isDeafultSubHeader = 'true';

        }

        $cs_sub_header_default_h = isset($jobcareer_options['cs_sub_header_default_h']) ? $jobcareer_options['cs_sub_header_default_h'] : '';



        if (isset($cs_header_banner_style) && ( $cs_header_banner_style == 'default_header' || $cs_header_banner_style == '' )) {

            //Padding Top & Bottom 

            $cs_sh_paddingtop = ( isset($jobcareer_options['cs_sh_paddingtop']) ) ? 'padding-top:' . $jobcareer_options['cs_sh_paddingtop'] . 'px;' : '';

            $cs_sh_paddingbottom ='0px'; //( isset($jobcareer_options['cs_sh_paddingbottom']) ) ? 'padding-bottom:' . $jobcareer_options['cs_sh_paddingbottom'] . 'px;' : '';

           $page_subheader_color = '#ccc';//( isset($jobcareer_options['cs_sub_header_bg_color'])) ? $jobcareer_options['cs_sub_header_bg_color'] : '';

            $page_subheader_text_color = ( isset($jobcareer_options['cs_sub_header_text_color']) ) ? $jobcareer_options['cs_sub_header_text_color'] : '';

            $header_banner_image = ( isset($jobcareer_options['cs_background_img']) ) ? $jobcareer_options['cs_background_img'] : '';

            $page_subheader_parallax = ( isset($jobcareer_options['cs_parallax_bg_switch']) ) ? $jobcareer_options['cs_parallax_bg_switch'] : '';

        } else {

            if ($isDeafultSubHeader == 'true') {



                $cs_sh_paddingtop = ( isset($jobcareer_options['cs_sh_paddingtop']) ) ? 'padding-top:' . $jobcareer_options['cs_sh_paddingtop'] . 'px;' : '';

                $cs_sh_paddingbottom = ( isset($jobcareer_options['cs_sh_paddingbottom']) ) ? 'padding-bottom:' . $jobcareer_options['cs_sh_paddingbottom'] . 'px;' : '';

                $header_banner_image = (isset($jobcareer_options['cs_background_img']) && $jobcareer_options['cs_background_img'] ) ? $jobcareer_options['cs_background_img'] : '';

                $page_subheader_parallax = ( isset($jobcareer_options['cs_parallax_bg_switch']) && $jobcareer_options['cs_parallax_bg_switch'] != '' ) ? $jobcareer_options['cs_parallax_bg_switch'] : '';

                $page_subheader_color = (isset($jobcareer_options['cs_sub_header_bg_color']) and $jobcareer_options['cs_sub_header_bg_color'] <> '' ) ? $jobcareer_options['cs_sub_header_bg_color'] : '';

                $page_subheader_text_color = (isset($jobcareer_options['cs_sub_header_text_color']) and $jobcareer_options['cs_sub_header_text_color'] <> '' ) ? $jobcareer_options['cs_sub_header_text_color'] : '';

            } else {

                if (empty($cs_page_subheader_color)) {

                    $page_subheader_color = "";

                } else {

                    $page_subheader_color = $cs_page_subheader_color;

                }

                if (empty($cs_page_subheader_text_color)) {

                    $page_subheader_text_color = "";

                } else {

                    $page_subheader_text_color = $cs_page_subheader_text_color;

                }

                if (isset($cs_page_subheader_no_image) && $cs_page_subheader_no_image != '') {

                    if (empty($cs_header_banner_image)) {

                        $header_banner_image = "";

                    } else {

                        $header_banner_image = $cs_header_banner_image;

                    }

                    if (empty($cs_page_subheader_parallax)) {

                        $page_subheader_parallax = "";

                    } else {

                        $page_subheader_parallax = $cs_page_subheader_parallax;

                    }

                } else {

                    $page_subheader_parallax = "";

                    $header_banner_image = "";

                }

                //Padding Top & Bottom

                if (empty($cs_subheader_padding_top)) {

                    $cs_sh_paddingtop = "";

                } else {

                    $cs_sh_paddingtop = 'padding-top:' . $cs_subheader_padding_top . 'px;';

                }

                if (empty($cs_subheader_padding_bottom)) {

                    $cs_sh_paddingbottom = "";

                } else {

                    $cs_sh_paddingbottom = 'padding-bottom:' . $cs_subheader_padding_bottom . 'px';

                }

            }

        }



        if ($page_subheader_color) {

            $subheader_style_elements = 'background: ' . $page_subheader_color . ';';

        } else {

            $subheader_style_elements = '';

        }



        if (class_exists('wp_jobhunt')) {

            // checking employer, candidates and job

            // covers and applying them in place of

            // default subheader image



            global $cs_plugin_options;

			

            $cs_candidate_dashboard = isset($cs_plugin_options['cs_js_dashboard']) ? $cs_plugin_options['cs_js_dashboard'] : '';

            $cs_employer_dashboard = isset($cs_plugin_options['cs_emp_dashboard']) ? $cs_plugin_options['cs_emp_dashboard'] : '';



            if (is_singular(array('jobs'))) {

                $cs_job_default_cover = isset($jobcareer_options['cs_job_default_cover']) ? $jobcareer_options['cs_job_default_cover'] : '';

                if ($cs_job_default_cover != '') {

                    $header_banner_image = $cs_job_default_cover;

                }

            } else if (is_page() && $post_ID == $cs_candidate_dashboard) {

                $cs_candidate_default_cover = isset($jobcareer_options['cs_candidate_dash_default_cover']) ? $jobcareer_options['cs_candidate_dash_default_cover'] : '';

                if ($cs_candidate_default_cover != '') {

                    $header_banner_image = $cs_candidate_default_cover;

                }

            } else if (is_page() && $post_ID == $cs_employer_dashboard) {

                $cs_employer_default_cover = isset($jobcareer_options['cs_employer_dash_default_cover']) ? $jobcareer_options['cs_employer_dash_default_cover'] : '';

				if ($cs_employer_default_cover != '') {

                    $header_banner_image = $cs_employer_default_cover;

                }

            }



            // end applying subheader image

        }

		



        if ($header_banner_image == '' && !get_option('cs_theme_options')) {

            $header_banner_image = trailingslashit(get_template_directory_uri()) . 'assets/images/subheader-image-jobline.jpg';

        }



        if (isset($header_banner_image) && $header_banner_image != '') {



            $cs_upload_dir = wp_upload_dir();

            $cs_upload_baseurl = isset($cs_upload_dir['baseurl']) ? $cs_upload_dir['baseurl'] . '/' : '';



            $cs_upload_dir = isset($cs_upload_dir['basedir']) ? $cs_upload_dir['basedir'] . '/' : '';



            if (false !== strpos($header_banner_image, $cs_upload_baseurl)) {

                $cs_upload_subdir_file = str_replace($cs_upload_baseurl, '', $header_banner_image);

            }



            $cs_images_dir = trailingslashit(get_template_directory()) . 'assets/images/';



            $cs_img_name = preg_replace('/^.+[\\\\\\/]/', '', $header_banner_image); 



			

            if (is_file($cs_upload_dir . $cs_img_name) || is_file($cs_images_dir . $cs_img_name)) {

                if (ini_get('allow_url_fopen')) {

                    if ($header_banner_image <> '') {

                        $banner_image_height = getimagesize($header_banner_image);

                    }

                }

            } else if (isset($cs_upload_subdir_file) && is_file($cs_upload_dir . $cs_upload_subdir_file)) {

                if (ini_get('allow_url_fopen')) {

                    $banner_image_height = getimagesize($header_banner_image);

                }

            } else {

                $banner_image_height = '';

            }



            if (isset($banner_image_height[1])) {

                $banner_image_height = $banner_image_height[1] . 'px';

            }



            if ($cs_sub_header_default_h != '' && $cs_sub_header_default_h > 0) {

                $banner_image_height = $cs_sub_header_default_h . 'px';

            }



            if ($page_subheader_parallax == 'on') {

                $parallaxStatus = 'no-repeat fixed';

            } else {

                $parallaxStatus = '';

            }

            if ($page_subheader_parallax == 'on') {

                $header_banner_image = 'url(' . $header_banner_image . ') center top ' . $parallaxStatus . '';

                $subheader_style_elements = 'background: ' . $header_banner_image . ' ' . $page_subheader_color . ';' . ' background-size:cover;';

            } else {

                $header_banner_image = 'url(' . $header_banner_image . ') center top ' . $parallaxStatus . '';

                $subheader_style_elements = 'background: ' . $header_banner_image . ' ' . $page_subheader_color . ';';

            }

            $breadcrumSectionStart = '';

            $breadcrumSectionEnd = '';

        }



        $parallax_class = '';

        $parallax_data_type = '';



        if (isset($page_subheader_parallax) && (string) $page_subheader_parallax == 'on') {

            $parallax_class = 'parallex-bg';

            $parallax_data_type = ' data-type="background"';

        }



        if ($subheader_style_elements) {

            $subheader_style_elements = 'style="' . $subheader_style_elements . ' min-height:' . $banner_image_height . '!important; ' . $cs_sh_paddingtop . ' ' . $cs_sh_paddingbottom . '  "';

        } else {

            $subheader_style_elements = 'style="min-height:' . $banner_image_height . '; ' . $cs_sh_paddingtop . ' ' . $cs_sh_paddingbottom . ' "';

        }

        $page_tile_align = get_jobcareer_subheader_text_align();



        // getting extra class for candidate and employer case

        $cs_user_default_cover_style = '';
      
			if ( is_user_logged_in() ) {
			$logerId  =  get_current_user_id();
			$logerData = get_userdata($logerId);
           
			
			
			
		if(isset($_FILES['user_img'])) {
			
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			$files = $_FILES['user_img'];
			$file = array(
				'name'     => $files['name'],
				'type'     => $files['type'],
				'tmp_name' => $files['tmp_name'],
				'error'    => $files['error'],
				'size'     => $files['size']
			);
			$upload_overrides = array( 'test_form' => false );
		$upload = wp_handle_upload($file, $upload_overrides);


		// $filename should be the path to a file in the upload directory.
		$filename = $upload['file'];

		// The ID of the post this attachment is for.
		//$parent_post_id = get_user_meta($logerId, 'user_img', true);

		// Check the type of tile. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( basename( $filename ), null );

		// Get the path to the upload directory.
		$wp_upload_dir = wp_upload_dir();

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $filename);

		// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		
		update_user_meta( $logerId, 'user_img', $attach_id );
			}
			
			if($_POST['first_name'] != "") {
			$first_name = $_POST['first_name'];
			update_user_meta( $logerId, 'first_name', $first_name);
			}
			
			if($_POST['last_name'] != "") {
			$last_name = $_POST['last_name'];
			update_user_meta( $logerId, 'last_name', $last_name);
			}
			
			if($_POST['email'] != "") {
			$email = $_POST['email']; 
			update_user_meta( $logerId, 'url', $email);
			}
			
			if($_POST['description'] != "") {
			$description = $_POST['description'];
			update_user_meta( $logerId, 'description', $description);
			}
			

			$cs_id1 = get_user_meta($logerId, 'user_img_bg', true);
			$cs_id2 = get_user_meta($logerId, 'user_img', true);
			
			
			//$cs_value =  wp_get_attachment_image_src($cs_id1,'medium');

			$logerDescription = get_user_meta( $logerId, 'description', true);
			$candidate_mode = get_user_meta($logerId, 'candidate_mode', true);
			$specialisms_header = get_user_meta($logerId,'cs_specialisms',true);
			 $logerImg = wp_get_attachment_image($cs_id2,'thumbnail');
			 $logerImgbg = wp_get_attachment_image_src($cs_id1,'large');
			 $logerImg_size = get_user_meta($logerId, 'user_avatar', true);  
//$logerImg_size = wp_get_attachment_image($cs_id1,array('80', '80'));
	
			$logerName_first = $logerData->user_firstname;
			$logerName_last = $logerData->user_lastname;
			$logerEmail = get_user_meta( $logerId, 'url', true);
			$user_roles=$logerData->roles;

			if (in_array("cs_candidate", $user_roles)){

				$cs_candidate_default_cover_style = isset($jobcareer_options['cs_candidate_default_cover_style']) ? $jobcareer_options['cs_candidate_default_cover_style'] . '-view' : '';

				$cs_candidate_default_cover_switch = isset($jobcareer_options['cs_candidate_default_cover_switch']) ? $jobcareer_options['cs_candidate_default_cover_switch'] : '';

				if ($cs_candidate_default_cover_switch == 'on') {

					$cs_user_default_cover_style = $cs_candidate_default_cover_style;

				}

			}else if(in_array("cs_employer", $user_roles) || in_array("cs_company", $user_roles)) {

				$cs_employer_default_cover_style = isset($jobcareer_options['cs_employer_default_cover_style']) ? $jobcareer_options['cs_employer_default_cover_style'] . '-view' : '';

				$cs_employer_default_cover_switch = isset($jobcareer_options['cs_employer_default_cover_switch']) ? $jobcareer_options['cs_employer_default_cover_switch'] : '';

				if ($cs_employer_default_cover_switch == 'on') {

					$cs_user_default_cover_style = $cs_employer_default_cover_style;

				}
				 

			}

		/* Candidates Dashboard code */
		
			if (in_array("cs_candidate", $user_roles))
			  { 
			
			if($_POST['location'] != "") {
			$location = $_POST['location'];
			update_user_meta( $logerId, 'location', $location);
			}
			if($_POST['excel_level'] != "") {
			$excel_level = $_POST['excel_level'];
			update_user_meta( $logerId, 'how_familiar_are_you_with_excel_', $excel_level);
			}
			if($_POST['experience_level'] != "") {
			$experience_level = $_POST['experience_level'];
			update_user_meta( $logerId, 'experience_level', $experience_level);
			}
			if($_POST['prefer_job'] != "") {
			$description = $_POST['prefer_job'];
			update_user_meta( $logerId, 'prefer_job', $description);
			}
			if($_POST['fianace_exp'] != "") {
			$cnt = count($_POST['fianace_exp']);
			if($cnt <= 1){
				$fianace_expp = implode(' ',$_POST['fianace_exp']);
			}else{
				$fianace_expp = implode('|',$_POST['fianace_exp']);
			}
			update_user_meta( $logerId, 'what_area_of_finance_is_your_experience_in_', $fianace_expp);
			}
			
			$logerlocation = get_user_meta( $logerId, 'location', true);
			$experience_level = get_user_meta($logerId, 'experience_level', true);
			$prefer_job = get_user_meta( $logerId, 'prefer_job', true);
			$finance_exp = get_user_meta( $logerId, 'what_area_of_finance_is_your_experience_in_', true);
			$tech = get_user_meta( $logerId, 'how_familiar_are_you_with_excel_', true);
			$biz = get_user_meta( $logerId, 'prefer_job', true);
			$img_tech = '';
			$img_biz = '';
			$medal_type_t = '';
			$medal_type_b = '';
			
			if($tech == '_can_understand/maintain_models_through_excel,_pulling_data_through_systems'){
				$medal_type_t = 'Beginner';
				}else if($tech == 'can_build_models_through_excel,_strong_understanding_of_databases'){
				$medal_type_t = 'Intermediate';
				}else if($tech == 'can_build_complex_models_leveraging_vba_for_automation_&_visualization'){
				$medal_type_t = 'Advanced';
			}
			
			
			?>
			<div class="cs-subheader11 candidate_dash <?php echo jobcareer_special_char($page_tile_align) . ' ' . jobcareer_special_char($parallax_class); ?> <?php echo esc_html($cs_user_default_cover_style) ?>" <?php echo jobcareer_special_char($subheader_style_elements); ?>> 
			
			<div class="container" style="background:#999999;">
            <div class="loger_herder" style="padding-top:10px !important;">

			<div class="col-md-12 top_header_2">
			<?php if($candidate_mode == '' || $candidate_mode == 'inactive'){ ?>
				<div class="q_active_mark">Recruiters are unable to find you</div>
			<?php }else{ ?>
				<div class="q_active_mark">Recruiters will know to reach out to you</div>
			<?php } ?>
				<div class="switch_div">
					<label class="candidate_switch switch">
					<?php if($candidate_mode == '' || $candidate_mode == 'inactive'){ $mode = 'inactive'; ?>
					  <input type="checkbox">
<span rel="<?php echo $mode; ?>" class="slider round"><strong style="margin: 5px 12px; display:block; text-align:right;">Inactive</strong></span>
					  <?php }else{ $mode = 'active'; ?>
					  <input checked="checked" type="checkbox">
<span rel="<?php echo $mode; ?>" class="slider round"><strong style="margin: 5px 12px;display: inline-block;">Active</strong></span>
					  <?php } ?>
					  
					</label>
<img src="<?php echo site_url();?>/wp-content/uploads/2018/12/tooltip.png" class="active_q_icon">
				</div>
				<div class="message_header" data-toggle="modal" data-target="#candidate_info_recuiter">View Candidate Card</div>
			</div>
			<div class="col-md-12">
            	<div class="loger_img"><span style="display: inline-block;position: relative;"><i class="icon-edit3" data-toggle="modal" data-target="#avtar" style="position: absolute;right: 25px; bottom:40px; cursor: pointer;"></i>
                <?php if ($logerImg) { echo $logerImg; } else { ?>
                    <img src="<?php echo site_url(); ?>/wp-content/uploads/2018/06/dummy.png" alt="" />
                <?php   } 	?>
				</span>
				<!--Modal-->

				<div id="avtar" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Profile Photo</h4>
					  </div>
					  <div class="modal-body">
						<form id="avtar" action="" method="post" enctype="multipart/form-data">
							<div class="cs-img-detail">

                                <div class="alert alert-dismissible user-img"> 

                                    <div class="page-wrap" id="cs_user_img_box" style="border: 1px solid #ccc; padding: 20px 20px 0 20px;">

                                            <?php  if ($logerImg) { echo $logerImg; } else { ?>
                                                <img src="<?php echo site_url(); ?>/wp-content/uploads/2018/06/dummy.png" id="cs_user_img_img" width="100" alt="" />
                                            <?php } ?>
                                    </div>

                                </div>

                                <div class="upload-btn-div">

                                    <div class="fileUpload uplaod-btn btn cs-color csborder-color">
										<input type="file" required="" id="user_img" name="user_img">
                                        <input type="submit"class="acc-submit cs-section-update cs-bgcolor csborder-color cs-color" name="submit" value="Upload Photo">				

                                    </div>

                                    <br />

                                    <span id="cs_candidate_profile_img_msg"><?php esc_html_e('Max file size is 1MB, Minimum dimension: 270x210 And Suitable files are .jpg & .png', 'jobhunt'); ?></span>

                                </div>

                            </div>
						</form>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>

				  </div>
				</div>

                </div><div class="clearfix"></div>
				<div class="loger_info">
<p style="font-size: 18px !important; line-height: 18px !important; margin-bottom:5px !important; color:#fff !important;"><?php  echo $logerName_first .' '. $logerName_last;   ?></p>
				<!--<i class="icon-plus8" data-toggle="modal" data-target="#name"></i>-->
				<!-- Modal -->
				<div id="name" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Update Info</h4>
					  </div>
					  <div class="modal-body">
						<form id="name" action="" method="post">
						<div class="col-md-6">
							<label>First Name</label>
							<input type="text" name="first_name" id="first_name" value="<?php  echo $logerName_first; ?>" class="regular-text">
						</div><div class="col-md-6">	
							<label>Last Name</label>
							<input type="text" name="last_name" id="last_name" value="<?php  echo $logerName_last; ?>" class="regular-text">
						</div><div class="col-md-12">	
							<label>Current Position</label>
							<input type="text" name="email" placeholder="Please put your current position and the company you work for" id="email" value="<?php  echo $logerEmail; ?>" class="regular-text">
						</div><div class="col-md-12">	
							<label>Location</label>
							<?php echo do_shortcode('[custom_texnomoy_location selected="'.$logerlocation.'" ]');?>
						</div><div class="col-md-12">
							<label>Tagline</label>
							<input type="text" name="description" id="description" value="<?php  echo $logerDescription; ?>" class="regular-text">
						</div><div class="clearfix"></div><div class="col-md-12">	
							<label>What area of finance is your experience in?</label><br>
							<?php $arr_exp = array('Accounting'=>'accounting_','I-Banking'=>'i-banking','FP&A'=>'fp&a_','Private Equity'=>'private_equity','Consulting'=>'consulting'); 
							if(!empty($finance_exp)){
							$ex_finance = explode('|',$finance_exp);
								foreach($ex_finance as $kval){ $ex_finance2[] = trim($kval);}
							}

							foreach($arr_exp as $kkey3 => $val3){		

								if(in_array($val3,$ex_finance2)){ $checked3 = 'checked="checked"'; }else{ $checked3 = '';}						
							
								echo ' <label style="font-weight: normal;"><input type="checkbox" '.$checked3.' name="fianace_exp[]" value="'.$val3.'" /> '.$kkey3.' </label>';
							}	
							?>
						<hr></div><div class="clearfix"></div><div class="col-md-12">
							<label>How familiar are you with Excel?</label>
							<?php $arr_excel = array('Can understand/maintain models through excel, pulling data through systems'=>'_can_understand/maintain_models_through_excel,_pulling_data_through_systems','Can build models through excel, strong understanding of databases'=>'can_build_models_through_excel,_strong_understanding_of_databases','Can build complex models leveraging VBA for automation & visualization'=>'can_build_complex_models_leveraging_vba_for_automation_&_visualization');
							
							foreach($arr_excel as $kkey => $val){ $tech = trim($tech);
								if($tech == $val){$checked = 'checked="checked"';} else{ $checked = '';}	
								echo ' <label style="font-weight: normal;"><input type="radio" '.$checked.' name="excel_level" value="'.$val.'" /> '.$kkey.' </label>';
							}	
							?>
							
						<hr></div><div class="clearfix"></div><div class="col-md-12">	
							<label>How much experience do you have in Finance?</label><br>
							<?php $arr_exp4 = array('Intern'=>'intern','Entry Level'=>'entry_level','Mid-Senior'=>'mid-senior','Management'=>'management',); 
							foreach($arr_exp4 as $kkey1 => $val1){ $experience_level = trim($experience_level);
								if($experience_level == $val1){$checked1 = 'checked="checked"';} else{ $checked1 = '';}	
								echo ' <label style="font-weight: normal;"><input type="radio" '.$checked1.' name="experience_level" value="'.$val1.'" /> '.$kkey1.' </label>';
							}	
							?>
						<hr></div><div class="clearfix"></div><div class="col-md-12">	
							<label>When it comes to your day-to-day, which do you prefer?</label><br>
							<?php $arr_exp6 = array('Back-End Candidate'=>'back-end_candidate','Hybrid Candidate'=>'hybrid_candidate','Front-End Candidate'=>'front-end_candidate'); 
							
							foreach($arr_exp6 as $kkey2 => $val2){ $prefer_job = trim($prefer_job);
								if($prefer_job == $val2){$checked2 = 'checked="checked"';} else{ $checked2 = '';}	
								echo ' <label style="font-weight: normal;"><input type="radio" '.$checked2.' name="prefer_job" value="'.$val2.'" /> '.$kkey2.' </label>';
							}	
							?>
						<hr></div>
							<input type="submit"class="acc-submit cs-section-update cs-bgcolor csborder-color cs-color" id="name" name="submit_name" value="Update Info">
						</form>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>

				  </div>
				</div>
		<?php 
			$loc_candiadtes = (!empty($logerlocation)) ? ucwords(str_replace('-',' ',$logerlocation)) : '';
			$prefer_candiadtes = (!empty($prefer_job)) ? ucwords(str_replace('_',' ',$prefer_job)) : '';
			
			$finance_experience1 = (!empty($finance_exp)) ? str_replace('_',' ',$finance_exp) : '';
			$finance_ex = explode('|',$finance_experience1);
			unset($exvalu);
			foreach($finance_ex as $exval){ 
				$exvalu[] = (trim($exval) == 'fp&a') ? 'FP&A' : ucwords($exval);
			}
			$finance_experience = implode(', ',$exvalu);
	
			
			
			$experience_level2 = (!empty($experience_level)) ? ucwords(str_replace('_',' ',$experience_level)) : '';
			if($prefer_job == 'back-end_candidate'){ $prefer_icon = '036-graph-analysis.png';}else if($prefer_job == 'hybrid_candidate'){ $prefer_icon = '037-business-agreement.png';}else if($prefer_job == 'front-end_candidate'){$prefer_icon = '030-business-presentation.png';}else{ $prefer_icon = '';}
		?>

				<p style="color:#fff !important; font-size: 16px !important; margin-top: 12px !important; margin-bottom: 9px !important; line-height: 20px !important;"><i class="icon-location6" style="margin-right: 2px;"></i><?php  echo $loc_candiadtes;  ?></p>
				<?php if(!empty($logerEmail)){ ?>
				<p style="color:#fff !important; font-size: 16px !important; line-height: 20px !important; margin-bottom: 4px !important;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/019-briefcase.png" width="20" style="margin-right: 5px;"><?php  echo $logerEmail;   ?></p>
				<?php } ?>
				<p style="color:#fff !important; font-size: 16px !important; line-height: 20px !important; margin-bottom: 4px !important;"><strong><?php echo $logerDescription; ?></strong><br/><a style="color:#fff; font-size:12px;" href="javascript:void();" class="icon-edit3" data-toggle="modal" data-target="#name">Edit Profile</a></p>
                
                </div>
				
				</div>
				
				<div class="clearfix"></div><hr>
				<div class="col-md-6">
					<div class="col-md-12" style="padding-left:0px; margin-bottom:10px;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/<?php echo $prefer_icon; ?>" width="40" /> Prefers a <?php  echo str_replace('Candidate','',$prefer_candiadtes);?> Role</div>
					<div class="col-md-12" style="padding-left:0px; margin-bottom:10px;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/028-table.png" width="40" /> Excel: <?php echo $medal_type_t; ?></div>
					<div class="col-md-12" style="padding-left: 0px; margin-bottom:10px;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/035-bar-chart-2.png" width="40" /> Experience Level: <?php echo $experience_level2; ?></div>
					<?php if($logerDescription == '12'){ ?>
					<div class="col-md-12" style="padding-left: 0px;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/034-creative-1.png" width="40" /> </div>
					<?php } ?>
				</div>
				<div class="col-md-6">
					<div class="col-md-12" style="margin: 20px 0px; padding-left:0px;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/022-pie-chart-1.png" width="40" /> <strong>Type of Finance Experience:</strong><ul class="skils_header_fin"><li class="col-md-12" style="margin-left: 30px;"><?php echo $finance_experience; ?></li></ul></div>
							
					<div class="col-md-12" style="padding-left:0px;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/032-calculator.png" width="40" /> <strong>Financial Systems & Data Tools:</strong><p>
					<?php if($specialisms_header != "") { ?>
							<ul class="skils_header col-md-12" style="margin-top: 10px;margin-left: 15px;">
								<?php foreach($specialisms_header as $special2) { $special_tags2 = get_term_by( 'slug', $special2, 'specialisms' ); ?>
								<li class="col-md-6">*<?php echo $special_tags2->name; ?></li>
								<?php } ?>
							</ul>
	                		<?php } else { ?>
							<p>There is no record in Skills list</p>
							<?php } ?>
					</p></div>
				</div>


				<div class="clearfix"></div>
				
                
            </div>
            </div>
<!-- Modal content-->
											<div id="candidate_info_recuiter" class="modal fade" role="dialog">
												<div class="modal-dialog candidate_modal_req" style="background: #999999; border-radius: 5px; width: 450px;">
													<div class="modal-body">
														<div class="panel-body">
															<div class="col-md-12 col-lg-12 can-post" style="background: #999; padding:0px;">
																<div class="loger_herder" style="padding-bottom: 0px;">

			<div class="col-md-12 top_header_2">
<center style="font-size: 12px;color: #fff !important;margin-bottom: 25px;display: inline-block;">This is what your candidate card looks like to a recruiter</center>
				<div class="switch_div" style="pointer-events:none;">
					<label class="switch candidate_switch_rec">
<?php if($candidate_mode == '' || $candidate_mode == 'inactive'){ $mode = 'inactive'; ?>

					 <input type="checkbox">
<span rel="<?php echo $mode; ?>" class="slider round"><strong style="margin: 5px 12px; display:block; text-align:right; color:#fff;">Inactive</strong></span>
					  <?php }else{ $mode = 'active'; ?>
					  <input checked="checked" type="checkbox">
<span rel="<?php echo $mode; ?>" class="slider round"><strong style="margin: 5px 12px; display:inline-block; color:#fff;">Active</strong></span>
					  <?php } ?>
				</div>
				<div class="send_message_wrap"><img class="icons_img" src="<?php echo get_stylesheet_directory_uri(); ?>/icons/033-email.png" width="30">Send Message</div>
			</div>
			<div class="col-md-12" style="margin-bottom:20px;">
            	<div class="loger_img">
                <?php if ($logerImg) {
						echo $logerImg;
					  } else { 
						echo '<img src="'.site_url().'/wp-content/uploads/2018/06/dummy.png" id="cs_user_img_img" width="70" alt="" />';
					  }
				?>
                </div><div class="clearfix"></div>
				<div class="loger_info">
				<p class="f"><?php  echo $logerName_first .' '. $logerName_last;?></p>
				<p class="s"><i class="icon-location6" style="margin-right: 2px;"></i><?php  echo $loc_candiadtes;  ?></p>
				<?php if(!empty($logerEmail)){ ?>
				<p style="color:#fff !important; font-size: 16px !important; line-height: 20px !important; margin-bottom: 4px !important;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/019-briefcase.png" width="20" style="margin-right: 5px;"><?php  echo $logerEmail;   ?></p>
				<?php } ?>
				<p class="t"><strong><?php echo $logerDescription;?></strong><br></p>
                
                </div>
				
				</div>
				
				<div class="clearfix"></div><br>
				<div class="loger_info_wrap">
					<div class="col-md-12" style="padding-left:0px; margin-bottom:20px;"><img class="icons_img" src="<?php echo get_stylesheet_directory_uri(); ?>/icons/<?php echo $prefer_icon; ?>" width="40" /> Prefers a <?php  echo str_replace('Candidate','',$prefer_candiadtes);?> Role</div>
					
					<div class="col-md-12" style="padding-left: 0px; margin-bottom: 20px;"><img class="icons_img" src="<?php echo get_stylesheet_directory_uri(); ?>/icons/028-table.png" width="40" /> Excel: <?php echo $medal_type_t; ?></div>
					
					<div class="col-md-12" style="padding-left: 0px; margin-bottom: 20px;"><img class="icons_img" src="<?php echo get_stylesheet_directory_uri(); ?>/icons/035-bar-chart-2.png" width="40" /> Experience Level: <?php echo $experience_level2; ?></div>
				</div>
				<div class="clearfix"></div>
				<hr>
				<div class="loger_info_wrap">
					<div class="col-md-12" style="margin-bottom: 20px; padding-left: 0px;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/029-stats.png" class="icons_img" width="40" /> <strong>Type of Finance Experience:</strong><ul class="skils_header_fin"><li class="col-md-12" style="margin-left: 46px;"><?php echo $finance_experience; ?></li></ul></div>
					<div class="col-md-12" style="padding-left: 0px;"><img class="icons_img" src="<?php echo get_stylesheet_directory_uri(); ?>/icons/032-calculator.png" width="40" /> Financial Systems & Data Tools:
						<?php if($specialisms_header != "") { ?>
							<ul class="skils_header col-md-12" style="margin-top: 10px; margin-left: 28px;">
								<?php foreach($specialisms_header as $special2) { $special_tags2 = get_term_by( 'slug', $special2, 'specialisms' ); ?>
								<li class="col-md-6">*<?php echo $special_tags2->name; ?></li>
								<?php } ?>
							</ul>
							<?php } else { ?>
							<p>There is no record in Skills list</p>
						<?php } ?>
						</div>
				</div>
				<div class="clearfix"></div>
            </div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
                <?php
			}else if(in_array("cs_employer", $user_roles) || in_array("cs_company", $user_roles)) { 
			$cs_user_default_cover_style =  ($logerImgbg[0]) ? $logerImgbg[0] : site_url().'/wp-content/uploads/2015/11/1.jpg';

			?>
			
			<div class="cs-subheader11 company_dash <?php echo jobcareer_special_char($page_tile_align) . ' ' . jobcareer_special_char($parallax_class); ?> <?php echo esc_html($cs_user_default_cover_style) ?>" <?php echo jobcareer_special_char($subheader_style_elements); ?>> 
			<?php 
			global $wpdb;
			
				$submission_id_h = get_user_meta($logerId, 'RM_UMETA_SUB_ID', true);
                            
				$submission_query_h = "SELECT data,form_id FROM wp_rm_submissions WHERE submission_id = ". $submission_id_h;

				$results_h = $wpdb->get_row($submission_query_h);

				$all_data_h = unserialize($results_h->data);
				
				$companyname_cmp = (get_user_meta($logerId,'company_name',true)) ? get_user_meta($logerId,'company_name',true) : $all_data_h['35']->value;
				
				$location_cmp = (get_user_meta($logerId,'location',true)) ? get_user_meta($logerId,'location',true) : $all_data_h['57']->value;
				
			?>
			
				<div style=" min-height:300px; background:url('<?php echo $cs_user_default_cover_style; ?>');background-size: cover; background-repeat: no-repeat; "><p style="position: absolute;top: 40%;right: 8%;cursor: pointer;display: block;border: 1px solid;padding: 4px 8px;font-size: 14px !important;font-weight: bold;" id="company_bg"><i class="icon-camera6" ></i><span style="margin-left: 8px;">&nbsp;Upload Cover Photo</span></p>
				<div class="container" style=" top: 187px; position: relative;">
					<div class="loger_info" style="background: #ccc; opacity: 0.8; border-radius: 5px 5px 2px 2px; padding-top:18px;">
					<div class="cpmany_logo" style="width: 90px; float: left;margin-top: 30px; margin-left: 30px; margin-top: 15px; top: 20px; position: relative;"><?php if ($logerImg_size) {  echo '<img src="'.$logerImg_size.'" id="cs_user_img_img" width="80" height="80" alt="" />'; } else { ?>
					
													<?php echo company_logo_api($logerId); ?>

												<?php }?>
												</div>
						<div style="float: left;"><h2 style="margin-top: 38px;margin-bottom: 2px;    font-size: 14px !important;line-height: 10px !important; text-align: left; color:#000 !important"><?php  echo $logerName_first .' '. $logerName_last;   ?> </h2>
						<span style="color: #000;"><?php echo ucwords($companyname_cmp); ?></span><br/><span style="color: #000;"><?php echo ucwords(str_replace('-',' ',$location_cmp)); ?></span></div><div class="clearfix"></div>
					</div>
				</div>
				</div><style>.cpmany_logo img{border-radius:40px; width: 80px !important;}</style>
				
			<?php }
			}else{

                if (is_page()) {

                    get_jobcareer_subheader_title();

                } else if (is_single() && $post_type != 'post') {

                    get_jobcareer_subheader_title();

                } else if (is_single() && $post_type == 'post') {

                    get_jobcareer_subheader_title();

                } else {

                    get_jobcareer_default_post_title();

                }  
				
			}

//                if ($cs_sub_header_overlay_color != '') {

//

//                    $cs_sub_header_overlay_color = jobcareer_hex2rgb($cs_sub_header_overlay_color);

//                    if (isset($cs_sub_header_overlay_color[0]) && isset($cs_sub_header_overlay_color[1]) && isset($cs_sub_header_overlay_color[2])) {

//                        

                ?>

        <!--                        <div class="overlay" style="background:rgba(//<?php //echo absint($cs_sub_header_overlay_color[0])  ?>,<?php //echo absint($cs_sub_header_overlay_color[1])  ?>,<?php //echo absint($cs_sub_header_overlay_color[2])  ?>,<?php //echo esc_html($cs_overlay_opacity)  ?>) !important"></div>-->

                <?php

//                    }

//                }

                get_jobcareer_subheader_breadcrumb();

                ?>

        </div>
        </div>

        <?php

    }



}



/**

 * @Page Sub header title and subtitle 

 *

 *

 */

if (!function_exists('get_jobcareer_subheader_breadcrumb')) {



    function get_jobcareer_subheader_breadcrumb() {

        global $post, $wp_query, $jobcareer_options, $post_meta;

        $meta_element = 'cs_full_data';

        $post_ID = get_the_ID();

        $post_type = get_post_type(get_the_ID());

        $post_meta = get_post_meta((int) $post_ID, "$meta_element", true);

        $cs_header_banner_style = get_post_meta((int) $post_ID, "cs_header_banner_style", true);

        $cs_page_breadcrumbs = get_post_meta((int) $post_ID, "cs_page_breadcrumbs", true);

        $cs_page_subheader_text_color = get_post_meta((int) $post_ID, "cs_page_subheader_text_color", true);



        $cs_brec_chk = false;



        $cs_header_banner_style = isset($cs_header_banner_style) ? $cs_header_banner_style : '';





        if (isset($cs_header_banner_style) && $cs_header_banner_style == 'breadcrumb_header' && $cs_page_breadcrumbs == 'on') {

            $cs_brec_chk = true;

        } else if (isset($jobcareer_options['cs_default_header']) && $cs_header_banner_style != 'breadcrumb_header' && (isset($jobcareer_options['jobcareer_breadcrumbs_switch']) and $jobcareer_options['jobcareer_breadcrumbs_switch'] == 'on')) {

            $cs_brec_chk = true;

        } else if (isset($jobcareer_options['cs_default_header']) && $post_type == 'jobcareer' && (isset($jobcareer_options['jobcareer_breadcrumbs_switch']) && $jobcareer_options['jobcareer_breadcrumbs_switch'] == 'on')) {

            $cs_brec_chk = true;

        } else {

            $cs_brec_chk = false;

        }



        if ($cs_brec_chk == true) {

            if (is_author() || is_search() || is_archive() || is_category() || is_home() || $post_meta == '') {

                if (isset($jobcareer_options['cs_sub_header_text_color']) && $jobcareer_options['cs_sub_header_text_color'] <> '') {

                    ?>

                    <?php

                }

            } else {

                if (isset($cs_header_banner_style) and $cs_header_banner_style == 'default_header') {

                    if (isset($jobcareer_options['cs_sub_header_text_color']) && $jobcareer_options['cs_sub_header_text_color'] <> '') {

                        ?>

                        <?php

                    }

                } else if (isset($cs_page_subheader_text_color) && $cs_page_subheader_text_color != '') {

                    ?>

                    <?php

                }

            }

            ?>

            <div class="breadcrumb">

                <div class="row">

                    <div class="col-md-12">

                        <?php jobcareer_breadcrumbs(); ?>

                    </div>

                </div>

            </div>

            <?php

        }

    }



}

/**

 * @Page Sub header title and subtitle 

 *

 *

 */

if (!function_exists('get_jobcareer_subheader_text_align')) {



    function get_jobcareer_subheader_text_align() {

        global $post, $post_meta, $jobcareer_options;

        $meta_element = 'cs_full_data';

        $post_ID = get_the_ID();

        $post_meta = get_post_meta($post_ID, "$meta_element", true);

        $page_tile_align = get_post_meta((int) $post_ID, "cs_page_title_align", true);

        $cs_header_banner_style = get_post_meta((int) $post_ID, "cs_header_banner_style", true);

        if (!is_single() && !is_page()) {

            $cs_header_banner_style = isset($jobcareer_options['cs_default_header']) ? $jobcareer_options['cs_default_header'] : '';

        }



        if (isset($cs_header_banner_style) && $cs_header_banner_style == 'breadcrumb_header') {



            if (isset($page_tile_align) && $page_tile_align == 'right') {

                $page_tile_align = 'align-right';

            } else if (isset($page_tile_align) && $page_tile_align == 'center') {

                $page_tile_align = 'align-center';

            } else if (isset($page_tile_align) && $page_tile_align == 'left') {

                $page_tile_align = 'align-left';

            } else {

                $page_tile_align = 'align-center';

            }

        } else if (isset($cs_header_banner_style) && $cs_header_banner_style == 'breadcrumbs_sub_header') {



            if (isset($jobcareer_options['cs_title_align']) && $jobcareer_options['cs_title_align'] == 'right') {

                $page_tile_align = 'align-right';

            } else if (isset($jobcareer_options['cs_title_align']) && $jobcareer_options['cs_title_align'] == 'center') {

                $page_tile_align = 'align-center';

            } else if (isset($jobcareer_options['cs_title_align']) && $jobcareer_options['cs_title_align'] == 'left') {

                $page_tile_align = 'align-left';

            } else {

                $page_tile_align = 'align-center';

            }

        } else {

            if (isset($jobcareer_options['cs_title_align']) && $jobcareer_options['cs_title_align'] == 'right') {

                $page_tile_align = 'align-right';

            } else if (isset($jobcareer_options['cs_title_align']) && $jobcareer_options['cs_title_align'] == 'center') {

                $page_tile_align = 'align-center';

            } else if (isset($jobcareer_options['cs_title_align']) && $jobcareer_options['cs_title_align'] == 'left') {

                $page_tile_align = 'align-left';

            } else {

                $page_tile_align = 'align-center';

            }

        }

        return $page_tile_align;

    }



}

/**

 * @Page Sub header title and subtitle 

 *

 *

 */

if (!function_exists('get_jobcareer_subheader_title')) {



    function get_jobcareer_subheader_title($shop_id = '') {

        global $post, $jobcareer_options;

        $meta_element = 'cs_full_data';

        $post_ID = get_the_ID();

        $post_meta = get_post_meta($post_ID, "$meta_element", true);

        $post_ID = $post->ID;

        $text_color = '';



        $cs_header_banner_style = get_post_meta((int) $post_ID, "cs_header_banner_style", true);

        $cs_sub_header_text_color = get_post_meta((int) $post_ID, "cs_page_subheader_text_color", true);

        $cs_page_title = get_post_meta((int) $post_ID, "cs_page_title", true);

        $cs_page_subheading_title = get_post_meta((int) $post_ID, "cs_page_subheading_title", true);



        $color = '';

        $text_color = '';



        $cs_page_title_style = isset($cs_page_title_style) ? $cs_page_title_style : '';

        $cs_page_title = (isset($cs_page_title) and $cs_page_title <> '') ? $cs_page_title : '';



        if (isset($cs_header_banner_style) and $cs_header_banner_style == 'breadcrumb_header') {

            $text_color = $cs_sub_header_text_color;

        } else {

            if (isset($cs_page_subheader_text_color) and $cs_page_subheader_text_color <> '') {

                $text_color = isset($jobcareer_options['cs_sub_header_text_color']) ? $jobcareer_options['cs_sub_header_text_color'] : '';

            } else {

                $text_color = isset($jobcareer_options['cs_sub_header_text_color']) ? $jobcareer_options['cs_sub_header_text_color'] : '';

            }

        }





        if (isset($cs_header_banner_style) and $cs_header_banner_style == 'default_header') {

            if (isset($jobcareer_options['cs_title_align']) && $jobcareer_options['cs_title_align'] == 'right') {

                $page_tile_align = 'right !important';

            } else if (isset($jobcareer_options['cs_title_align']) && $jobcareer_options['cs_title_align'] == 'center') {

                $page_tile_align = 'center !important';

            } else if (isset($jobcareer_options['cs_title_align']) && $jobcareer_options['cs_title_align'] == 'left') {

                $page_tile_align = 'left !important';

            } else {

                $page_tile_align = 'left !important';

            }

        } else {



            $page_tile_align = get_post_meta((int) $post_ID, "cs_page_title_align", true);

            if ($page_tile_align != '') {

                $page_tile_align = $page_tile_align . ' !important';

            } else {

                $page_tile_align = 'left !important';

            }

        }

        if ($text_color != '') {

            $color = 'style="color:' . $text_color . ' !important"';

        }



        if (isset($cs_header_banner_style) && $cs_header_banner_style == 'breadcrumb_header') {



            if ((isset($cs_page_title) && $cs_page_title == 'on') || (isset($cs_page_subheading_title) && $cs_page_subheading_title != '')) {

                echo '<div class="cs-page-title">';

            }

            if (isset($cs_page_title) && $cs_page_title == 'on') {

                echo '<h1 ' . $color . '>';

                echo get_the_title($post_ID);

                echo '</h1>';

            }

            if (isset($cs_page_subheading_title) && $cs_page_subheading_title != '') {

                echo '<p ' . $color . '>';

                echo do_shortcode($cs_page_subheading_title);

                echo '</p>';

            }

            if ((isset($cs_page_title) && $cs_page_title == 'on') || (isset($cs_page_subheading_title) && $cs_page_subheading_title != '')) {

                echo '</div>';

            }

        } else {

            $cs_title_switch = $jobcareer_options['cs_title_switch'];

            if (isset($cs_title_switch) && $cs_title_switch == 'on') {

                echo '<div class="cs-page-title">';

                echo '<h1 ' . $color . '>';

                echo get_the_title($post_ID);

                echo '</h1>';

                echo '</div>';

            }

        }

    }



}

/**

 * @ Default page title function

 */

if (!function_exists('get_jobcareer_default_post_title')) {



    function get_jobcareer_default_post_title() {

        global $post, $jobcareer_options;

        $textAlign = isset($jobcareer_options['cs_title_align']) ? $jobcareer_options['cs_title_align'] : 'center';



        if (empty($jobcareer_options['cs_sub_header_text_color']))

            $text_color = "";

        else

            $text_color = 'style="color:' . $jobcareer_options['cs_sub_header_text_color'] . ' !important;"';

        if (is_author()) {

            global $author;

            $userdata = get_userdata($author);

            if (isset($_GET['action']) && $_GET['action'] == 'detail') {

                echo jobcareer_special_char($userdata->display_name);

            } else {

                $cs_j_author = get_queried_object();

                $cs_j_role = $cs_j_author->roles[0];

                if ($cs_j_role == 'cs_candidate') {

                    $cs_candidate_cv = get_user_meta($userdata->ID, "cs_candidate_cv", true);

                    $cs_candidate_job_title = get_user_meta($userdata->ID, 'cs_job_title', true);

                    $cs_candidate_facebook = get_user_meta($userdata->ID, 'cs_facebook', true);

                    $cs_candidate_twitter = get_user_meta($userdata->ID, 'cs_twitter', true);

                    $cs_candidate_linkedin = get_user_meta($userdata->ID, 'cs_linkedin', true);

                    $cs_candidate_google_plus = get_user_meta($userdata->ID, 'cs_google_plus', true);

                    $cs_candidate_address = get_user_meta($userdata->ID, 'cs_post_loc_address', true);

                    // gettting data from plugin

                    ?>

                    <div class="cs-profile">

                        <?php if ($cs_candidate_default_cover_switch != 'on') { ?>

                            <div class="info">

                                <div class="title"><h3><?php echo $userdata->display_name; ?></h3></div>

                                <?php if (isset($cs_candidate_job_title) && $cs_candidate_job_title != '') {

                                    ?><div class="join-date"><span><?php echo esc_html($cs_candidate_job_title); ?></span></div>

                                        <?php } ?>

                                <div class="cs-profile-contact-info">

                                    <ul>

                                        <?php if ($cs_candidate_facebook != '') { ?>

                                            <li><a href="<?php echo esc_url($cs_candidate_facebook); ?>" data-original-title="<?php esc_html_e('facebook', 'jobcareer'); ?>"><i class="icon-facebook7"></i></a></li>

                                            <?php

                                        }

                                        if ($cs_candidate_twitter != '') {

                                            ?>

                                            <li><a href="<?php echo esc_url($cs_candidate_twitter); ?>" data-original-title="<?php esc_html_e('twitter', 'jobcareer'); ?>"><i class="icon-twitter6"></i></a></li>

                                            <?php

                                        }

                                        if ($cs_candidate_linkedin != '') {

                                            ?>

                                            <li><a href="<?php echo esc_url($cs_candidate_linkedin); ?>" data-original-title="<?php esc_html_e('linkedin', 'jobcareer'); ?>"><i class="icon-linkedin4"></i></a></li>

                                            <?php

                                        }

                                        if ($cs_candidate_google_plus != '') {

                                            ?>

                                            <li><a href="<?php echo esc_url($cs_candidate_google_plus); ?>" data-original-title="<?php esc_html_e('google', 'jobcareer'); ?>"><i class="icon-googleplus7"></i></a></li>

                                            <?php

                                        }

                                        if (isset($cs_candidate_cv) && $cs_candidate_cv != '') {

                                            ?>   

                                            <li><a class="cs-candidate-download" target="_blank" href="<?php echo esc_url($cs_candidate_cv); ?>"><?php esc_html_e("Download CV", 'jobcareer'); ?></a></li>

                                        <?php } ?>

                                    </ul>

                                </div>

                            </div>

                        <?php } ?>

                        <div class="post-options">

                            <ul>

                                <li><i class="icon-clock-o"></i><?php esc_html_e('Member Since', 'jobcareer') ?>, <?php echo date_i18n(get_option('date_format'), strtotime($userdata->user_registered)); ?></li>

                                    <?php

                                    if ($cs_candidate_address != '') {

                                        echo '<li><i class="icon-location6"></i>' . $cs_candidate_address . '</li>';

                                    }

                                    ?>

                            </ul>

                        </div>

                    </div><?php

                } else if ($cs_j_role == 'cs_employer') {

                    echo jobcareer_special_char($userdata->display_name);

                } else {

                    //echo esc_html__('Author', 'jobcareer') . " " . esc_html__('Archives', 'jobcareer') . ": " . $userdata->display_name;

                    echo jobcareer_special_char($userdata->display_name);

                }

            }

        } elseif (function_exists('is_shop') && is_shop()) {

			$shop_page_ID = wc_get_page_id('shop');

            echo '<div class="cs-page-title">';

            echo '<h1 ' . balanceTags($text_color, false) . '>';

            echo get_the_title($shop_page_ID);

            echo '</h1>';

            echo '</div>';

        } elseif (is_tag() || is_tax('event-tag')) {

            echo '<div class="cs-page-title">';

            echo '<h1 ' . balanceTags($text_color, false) . '>';

            echo esc_html__('Tags', 'jobcareer') . " " . esc_html__('Archives', 'jobcareer') . ": " . single_cat_title('', false);

            echo '</h1>';

            echo '</div>';

        } elseif (is_search()) {

            echo '<div class="cs-page-title">';

            echo '<h1 ' . balanceTags($text_color, false) . '>';

            printf(esc_html__('Search Results : %s', 'jobcareer'), '<span>' . get_search_query() . '</span>');

            echo '</h1>';

            echo '</div>';

        } elseif (is_day()) {

            echo '<div class="cs-page-title">';

            echo '<h1 ' . balanceTags($text_color, false) . '>';

            printf(esc_html__('Daily Archives: %s', 'jobcareer'), '<span>' . get_the_date() . '</span>');

            echo '</h1>';

            echo '</div>';

        } elseif (is_month()) {

            echo '<div class="cs-page-title">';

            echo '<h1 ' . balanceTags($text_color, false) . '>';

            printf(esc_html__('Monthly Archives: %s', 'jobcareer'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'jobcareer')) . '</span>');

            echo '</h1>';

            echo '</div>';

        } elseif (is_year()) {

            echo '<div class="cs-page-title">';

            echo '<h1 ' . balanceTags($text_color, false) . '>';

            printf(esc_html__('Yearly Archives: %s', 'jobcareer'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'jobcareer')) . '</span>');

            echo '</h1>';

            echo '</div>';

        } elseif (is_404()) {

            echo '<div class="cs-page-title">';

            echo '<h1 ' . balanceTags($text_color, false) . '>';

            esc_html_e('Error 404', 'jobcareer');

            echo '</h1>';

            echo '</div>';

        } elseif (is_home()) {

            echo '<div class="cs-page-title">';

            echo '<h1 ' . balanceTags($text_color, false) . '>';

            esc_html_e('Home', 'jobcareer');

            echo '</h1>';

            echo '</div>';
            echo '</div>';

        } elseif (!is_page()) {

            echo '<div class="cs-page-title">';

            echo '<h1 ' . balanceTags($text_color, false) . '>';

            esc_html_e('Archives', 'jobcareer');

            echo '</h1>';

            echo '</div>';

        }

    }



}