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
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/js_composer.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/iconmoon.css" />

<style>


.banner{
    position: relative;
    left: -104.5px;
    box-sizing: border-box;
    width: 1349px;
    padding-left: 104.5px;
    min-height: 59.735vh;
}
div#wpadminbar {
    display: none;
}
</style>

<?php //$google_analytics = array(''); ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-137239819-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-137239819-1');
</script>
  </head>

    <body  <?php

    body_class();

    if ($cs_site_layout != 'full_width') {

        echo jobcareer_bg_image();

    }

    ?>><div id="wptime-plugin-preloader"></div>



<?php 
if(is_user_logged_in()){
$user = wp_get_current_user();
$companyid = $user->ID;
$comroles = $user->roles;
$comrole = $comroles[0];
if ($comrole == 'cs_employer'){
if(isset($_POST['company_profile_image'])){

  if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
      
	
	
	$uploadedfile = $_FILES['upload_image'];
	$upload_overrides = array( 'test_form' => false );
	add_filter('upload_dir', 'my_upload_dir');
	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
	remove_filter('upload_dir', 'my_upload_dir');
	
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );
	$file = array(
		'name'     => $files['name'],
		'type'     => $files['type'],
		'tmp_name' => $files['tmp_name'],
		'error'    => $files['error'],
		'size'     => $files['size']
	);
	$filename = $movefile['file'];
	$filetype = wp_check_filetype( basename( $filename ), null );
	$wp_upload_dir = wp_upload_dir();
	$attachment = array(
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit'
			);
	$attach_id = wp_insert_attachment( $attachment, $filename);

	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	wp_update_attachment_metadata( $attach_id, $attach_data );
		
	update_user_meta( $companyid, 'user_img', $attach_id );
	
	if ( $movefile ) {

		$resume_link = $movefile['url'];
		if ( metadata_exists( 'user', $companyid, 'user_avatar' ) ) {
			
			update_user_meta( $companyid, 'user_avatar', $resume_link );
		} else {
			add_user_meta( $companyid, 'user_avatar', $resume_link );
		}
	}
}		

if(isset($_POST['user_img_bg_btn'])){

  if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );

	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );
	$files = $_FILES['user_img_bg'];
	$file = array(
		'name'     => $files['name'],
		'type'     => $files['type'],
		'tmp_name' => $files['tmp_name'],
		'error'    => $files['error'],
		'size'     => $files['size']
	);
	$upload_overrides = array( 'test_form' => false );
	$upload = wp_handle_upload($file, $upload_overrides);
	$filename = $upload['file'];
	$filetype = wp_check_filetype( basename( $filename ), null );
	$wp_upload_dir = wp_upload_dir();
	$attachment = array(
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit'
			);
	$attach_id = wp_insert_attachment( $attachment, $filename);

	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	wp_update_attachment_metadata( $attach_id, $attach_data );
		
	update_user_meta( $companyid, 'user_img_bg', $attach_id );
}
} // roles...
} // is login
?>
<?php

            if (function_exists('jobcareer_under_construction')) {

                jobcareer_under_construction();

            }

            ?>

        <div id="cs_alerts" class="cs_alerts" ></div>

        <!-- Wrapper -->

        <div class="wrapper wrapper_<?php jobcareer_wrapper_class(); ?>">

            <?php

			if (function_exists('jobcareer_get_headers')) {

                jobcareer_get_headers();

			}

            if (get_post_type(get_the_ID()) != 'candidate' || get_post_type(get_the_ID()) != 'jobcareer' || get_post_type(get_the_ID()) != 'employer') {

                if (function_exists('jobcareer_below_header_style')) {

                    jobcareer_below_header_style();

                }

            }