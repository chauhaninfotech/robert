<!DOCTYPE html>

<html <?php language_attributes(); ?>>
	<head>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
        <meta charset="<?php bloginfo('charset'); ?>">

        <?php

        /**

         * The template for displaying header

         */ 

        $var_arrays = array('jobcareer_sett_options', 'jobcareer_node', 'jobcareer_xmlObject', 'jobcareer_page_option', 'post');

        $header_global_vars = CS_JOBCAREER_GLOBALS()->globalizing($var_arrays);

        extract($header_global_vars);

        $jobcareer_options = CS_JOBCAREER_GLOBALS()->theme_options();

        $cs_site_layout = '';



        if (isset($jobcareer_options['cs_layout'])) {

            $cs_site_layout = $jobcareer_options['cs_layout'];

        } else {

            $cs_site_layout == '';

        }

        $cs_post_id = isset($post->ID) ? $post->ID : '';

        if (isset($cs_post_id) and $cs_post_id <> '') {

            $cs_postObject = get_post_meta($post->ID, 'cs_full_data', true);

        } else {

            $cs_post_id = '';

        }

        ?>

        <link rel="profile" href="<?php echo cs_server_protocol(); ?>gmpg.org/xfn/11">

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        

        <?php

        if (isset($jobcareer_options['cs_custom_js']) and $jobcareer_options['cs_custom_js'] <> '') {

            echo '<script type="text/javascript">

					"use strict";

					 ' . htmlspecialchars_decode($jobcareer_options['cs_custom_js']) . '

				  </script> ';

        }

        if (function_exists('jobcareer_header_settings')) {

            jobcareer_header_settings();

        }

    

        // Google Fonts Enqueue

        if (function_exists('jobcareer_load_fonts')) {

            jobcareer_load_fonts();

        }

          

        jobcareer_header_meta();

        wp_head();

        ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/innerstyle.css" />
    </head>

    <body  <?php body_class();

    if ($cs_site_layout != 'full_width') {

        echo jobcareer_bg_image();

    }

    ?> style="position:relative;">
<?php 
$user = wp_get_current_user();
$companyid = $user->ID;
$comroles = $user->roles;
$comrole = $comroles[0];

$crrId = get_current_user_id();
//$cs_profile_image = cs_get_image_url($cs_profile_img_name, 'cs_media_4');
$css_id1 = get_user_meta($crrId, 'user_img', true);
$cs_profile_image = '';
$cs_profile_image = wp_get_attachment_image($css_id1,array('30', '30'));

?>
<div id="wptime-plugin-preloader"></div>

        <div id="cs_alerts" class="cs_alerts" ></div>

        <!-- Wrapper -->

        <div class="wrapper wrapper_<?php jobcareer_wrapper_class(); ?>">

           <header class="cs-default-header" id="header">
            <div class="main-head">
        <div class="navbar navbar-default navbar-static-top container">

            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    
        <div class="logo">

            <a href="<?php echo site_url(); ?>"><img src="<?php echo site_url(); ?>/wp-content/uploads/2018/11/logo-new.png" style="width: 100%;" alt="Referlink">

            </a>

        </div>

        
                </div>
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 text-right">
                                        <div class="nav-right-area">
                        <nav class="navigation">
                            <ul class="nav navbar-nav"><li id="menu-item-3226" class="menu-item  menu-item-type-post_type  menu-item-object-page"><a href="<?php echo site_url(); ?>/contact-us/">Contact Us</a></li>
<li class="cs-login-area">
        <div class="login">

            <div class="login-dashboard-main">

                <div class="cs-loging-dashboard">

                   
                    <div class="dropdown keep-open">  

                        <a class="navicon-button x dropdown-toggle" data-toggle="dropdown" href="#">

                            <div class="navicon"></div>

                            <figure><?php

                                if ( $cs_profile_image == '' ) {
									
									$cs_profile_image = site_url().'/wp-content/uploads/2018/06/dummy.png';
									
									if(empty($css_id1)){
										$avtar = get_user_meta($crrId,'user_avatar',true);
										if(!empty($avtar) && $avtar == 1){
											$cs_profile_image = $avtar;
										}
									 }
									 
		
									if(empty($cs_profile_image) && $cs_user_role_type == 'employer'){
										echo company_logo_api($crrId);
									}else{
						
										echo '<img rel="kahgsdk" src="' . esc_url($cs_profile_image) . '" alt="" width="50" height="40">';
									}

                                }else{
									echo $cs_profile_image.' muk3';
									echo $cs_profile_image;
								}

                                ?>

                            </figure>

                        </a>

                        <div class="cs-login-dropdown">
                                    <ul class="dropdown-menu <?php echo esc_html($menu_cls); ?>">

                                        <li>
                                            <h5><?php echo esc_html($user_display_name) ?></h5>
                                            <?php
                                            if ( $cs_loc_country != '' && $cs_loc_city != '' ) {
                                            ?>
                                            <span><?php echo esc_html(ucfirst(urldecode($cs_loc_country))) . ', ' . esc_html(ucfirst(urldecode($cs_loc_city))) ?></span>
                                            <?php
                                            }?>
                                        </li>

										<li>

												<a href="<?php echo site_url().'/candidate-dashboard/'; ?>" <?php echo force_balance_tags($data_toogle); ?>><i class="icon-suitcase5"></i> <?php esc_html_e('My Profile', 'jobhunt'); ?></a>

										</li>
										
	
<?php  if ( is_user_logged_in() ) {  ?>
                                                <li><a class="logout-btn-1" href="<?php echo esc_url(wp_logout_url(cs_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) ?>"><i class="icon-logout"></i>Logout</a></li>
                                            <?php }	 ?>											
                                        
                                    </ul>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        </li></ul>																													
                        </nav>												

                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
</div>