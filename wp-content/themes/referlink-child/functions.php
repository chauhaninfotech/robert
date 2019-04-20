<?php

function wpdocs_theme_name_scripts() {
    //wp_enqueue_style( 'confirmation', get_stylesheet_directory_uri().'/css/confirmation.css' );
	//wp_enqueue_style( 'recruiterOrCandidate', get_stylesheet_directory_uri().'/css/recruiterOrCandidate.css' );
	
	
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


function create_posttype_refer() {
 
    register_post_type( 'refer',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Refer Candidate' ),
                'singular_name' => __( 'Refer Candidate' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'refer'),
			'show_in_menu' => 'edit.php?post_type=jobs'
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype_refer' );



add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes_b' );
/**
 * Define the metabox and field configurations.
 */
function cmb2_sample_metaboxes_b() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'refer_';

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'repeater_demo',  // Belgrove Bouncing Castles
		'title'         => 'Refer Candidate',
		'object_types'  => array( 'jobs', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );
	$blog_group_id = $cmb->add_field( array(
		'id'          => 'candidate_refer',
		'type'        => 'group',
		'repeatable'  => true,
		'options'     => array(
			'group_title'   => 'Post {#}',
			'add_button'    => 'Add Another Candidate',
			'remove_button' => 'Remove Candidate',
			'closed'        => true,  // Repeater fields closed by default - neat & compact.
			'sortable'      => true,  // Allow changing the order of repeated groups.
		),
	) );

	// Regular text field
	$cmb->add_group_field( $blog_group_id, array(
		'name'       => __( 'Candidate Name', 'cmb2' ),
		'desc'       => __( 'Refer Candidate Name', 'cmb2' ),
		'id'         => $prefix . 'name',
		'type'       => 'text',
	) );

	$cmb->add_group_field( $blog_group_id, array(
		'name'       => __( 'Candidate Email', 'cmb2' ),
		'desc'       => __( 'Refer Candidate Mail', 'cmb2' ),
		'id'         => $prefix . 'mail',
		'type'       => 'text',
	) );
	
	$cmb->add_group_field( $blog_group_id, array(
		'name'       => __( 'Company', 'cmb2' ),
		'desc'       => __( 'Refer Candidate For Company', 'cmb2' ),
		'id'         => $prefix . 'company',
		'type'       => 'text',
	) );
	
	$cmb->add_group_field( $blog_group_id, array(
		'name'       => __( 'Refer By', 'cmb2' ),
		'desc'       => __( 'Refer Candidate By', 'cmb2' ),
		'id'         => $prefix . 'refer_by',
		'type'       => 'text',
	) );
	
	// Add other metaboxes as needed

}



/*function redirect_users_by_role() { 
   $current_user = wp_get_current_user(); 
   $role_name = $current_user->roles[0];
   if('candidate' === $role_name && is_page('home')) { 
      wp_redirect('http://referlink.io/candidate-deshboard/');
      exit(); 
   } 
 } 
add_action('init', 'redirect_users_by_role');*/

function user_login_redirect( $url, $request, $user ){
	if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
		if( $user->has_cap( 'administrator' ) ) {
			$url = admin_url();
		} elseif( $user->has_cap( 'um_candidate' ) ) {
			$url = home_url('/candidate-deshboard/');
		} 
		 else {
			$url = home_url();
		}
}
return $url;
}
add_filter( 'login_redirect', 'user_login_redirect', 10, 3 );

//Skill Ajax 

add_action("wp_ajax_candidate_skils", "candidate_skils");
add_action("wp_ajax_nopriv_candidate_skils", "candidate_skils");

function candidate_skils(){
	$userid = get_current_user_id();
	$skills = explode(',',$_POST['skils']);
	update_user_meta( $userid,'cs_specialisms', array_map( 'strip_tags', $skills ) );

echo $_POST['skils'];

die();
}

// Experience Ajax

add_action("wp_ajax_candidate_exp", "candidate_exp");
add_action("wp_ajax_nopriv_candidate_exp", "candidate_exp");

function candidate_exp(){
	$userid = get_current_user_id();
$exp_count = ($_POST['exp_key'] == 0) ? 0 : $_POST['exp_key'];
/*
	$exp_key_id = $_POST['exp_key'];
	$exp_key = '';
	if($exp_key_id == 0 || $exp_key_id == '0'){
		$exp_count = get_user_meta($userid, 'experience_count', true);
		if($exp_count > 0){
			$exp_count = $exp_count + 1;
			update_user_meta($userid, 'experience_count', $exp_count);
			$exp_key = 'cs_experience_'.$exp_count;
		}else{
			update_user_meta($userid, 'experience_count',1);
			$exp_key = 'cs_experience_1';
			$exp_count = $exp_key_id;
		}
	}else{
		$exp_key = 'cs_experience_'.$exp_key_id;
	}
*/
$exp_count = $exp_count + 1;

update_user_meta($userid, 'experience_count', $exp_count);
$exp_key = 'cs_experience_'.$exp_count;

	$exp['jp_title'] = $_POST['jp_title'];
	$exp['cmp_name'] = $_POST['cmp_name'];
	$exp['website_url'] = $_POST['website_url'];
	$exp['date_start'] = $_POST['date_start'];
	$exp['date_end'] = $_POST['date_end'];
	$exp['job_decs'] = $_POST['job_decs'];
	$exp['company_logo'] = $_POST['cmp_logo'];
	

	update_user_meta( $userid, $exp_key, $exp);
	
	
	
	echo $exp_count;
	
	die();
}

// Experience Ajax Company Logo

add_action("wp_ajax_exp_upload_logo", "exp_upload_logo");
add_action("wp_ajax_nopriv_exp_upload_logo", "exp_upload_logo");

function exp_upload_logo(){
	$userid = get_current_user_id();

	$company_explogo_key = $_POST['company_explogo_key'];

	$support_title = !empty($_POST['supporttitle']) ? $_POST['supporttitle'] : 'Support Title';

        if (!function_exists('wp_handle_upload')) {
           require_once(ABSPATH . 'wp-admin/includes/file.php');
       }
      // echo $_FILES["upload"]["name"];
      $uploadedfile = $_FILES['file'];
      $upload_overrides = array('test_form' => false);
      $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

    
      if ($movefile && !isset($movefile['error'])) {
		  
		  $exp_key = 'cs_experience_logo_'.$company_explogo_key;
		  update_user_meta( $userid, $exp_key, $movefile['url']);
		  
		 $res =  $company_explogo_key.'msz'.$movefile['url'];
    } else {
        /**
         * Error generated by _wp_handle_upload()
         * @see _wp_handle_upload() in wp-admin/includes/file.php
         */
        $res =  'nomszno';//$movefile['error'];
    }
	
	echo $res;
	die();
}

// Experience Data Remove

add_action("wp_ajax_candidate_exp_remove", "candidate_exp_remove");
add_action("wp_ajax_nopriv_candidate_exp_remove", "candidate_exp_remove");

function candidate_exp_remove(){
$userid = get_current_user_id();
$exp_key = $_POST['exp_key'];
$exp_count = $_POST['row_count'];
update_user_meta( $userid, $exp_key, '');
echo $exp_count;
	
	die();
}

add_action("wp_ajax_candidate_profile", "candidate_profile");
add_action("wp_ajax_nopriv_candidate_profile", "candidate_profile");

function candidate_profile(){
$userid = get_current_user_id();
$check1 = $_POST['check1'];
$field_select = $_POST['field_select'];
$position_select = $_POST['position_select'];
$response_list_arr = explode(',',$_POST['response_ul_input']);
array_pop($response_list_arr);
$response_list = implode(',',$response_list_arr);
$range_salary = explode(',',$_POST['range_salary']);
$miles = $_POST['miles'];
$zipcode = $_POST['zipcode'];

update_user_meta($userid, 'check1', $check1);
update_user_meta($userid, 'job_field_preferred', $field_select);
update_user_meta($userid, 'job_position_preferred', $position_select);
update_user_meta($userid, 'response_list', $response_list);
update_user_meta($userid, 'salary_from', trim($range_salary[0]));
update_user_meta($userid, 'salary_to', trim($range_salary[1]));
update_user_meta($userid, 'miles', $miles);
update_user_meta($userid, 'zipcode', $zipcode);

	
die();
}

add_action("wp_ajax_recuireter_message_candidate", "recuireter_message_candidate");
add_action("wp_ajax_nopriv_recuireter_message_candidate", "recuireter_message_candidate");

function recuireter_message_candidate(){
	global $wpdb;
	
	$userid = get_current_user_id();
	$senderid = $userid;
	$sendername = $_POST['name'];
	$senderemail = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$receiverid = $_POST['receiver'];
	$receiveremail = $_POST['receiveremail'];
	$status  = '1';
	$currenttime  = time();
	
	 $messages_table = $wpdb->prefix."messages";

	 
$wpdb->insert( $messages_table, 
	array('senderid' => $senderid,'receiverid' => $receiverid,'sendername' => $sendername,'senderemail' => $senderemail,'receiveremail' => $receiveremail,'subject' => $subject,'message' => $message,'currenttime' => $currenttime,'status' => $status), 
	array('%d','%d','%s','%s','%s','%s','%s','%d','%d'));
	 
     $wpdb->query($sql);
	 
	 $this_insert = $wpdb->insert_id;
		$return = 'no';
		if($this_insert > 0){
			$return = 'yes';
		}
	echo $return;
	die();
}

function inbox_notification_count($userid){
global $wpdb;
$messages_table = $wpdb->prefix."messages";
$result = $wpdb->get_results('select * from '.$messages_table.' where receiverid = '.$userid.' and status = 1');
$res = 0;
if($wpdb->num_rows > 0){
$res = '('.$wpdb->num_rows.')';
}
return $res;
}

add_action("wp_ajax_message_readable", "message_readable");
add_action("wp_ajax_nopriv_message_readable", "message_readable");

function message_readable(){
global $wpdb;
$messages_table = $wpdb->prefix."messages";
$message_id = $_POST['message_id'];

$wpdb->update( 
	$messages_table, 
	array( 
		'status' => '2'
	), 
	array( 'ID' => $message_id ), 
	array( 
		'%d'	
	), 
	array( '%d' ) 
);

die();
}


add_action("wp_ajax_message_trash", "message_trash");
add_action("wp_ajax_nopriv_message_trash", "message_trash");

function message_trash(){
global $wpdb;
$messages_table = $wpdb->prefix."messages";
$message_id = $_POST['messageid'];

$wpdb->update( 
	$messages_table, 
	array( 
		'status' => '0'
	), 
	array( 'ID' => $message_id ), 
	array( 
		'%d'	
	), 
	array( '%d' ) 
);

echo $message_id;
die();
}

function custom_texnomoy_location_func($selected = '') {

$terms = get_terms( array(
	  'taxonomy' => 'cs_locations',
	  'hide_empty' => false,  )
	);
$select =  '';
$selected = (is_array($selected)) ? $selected['selected'] : '';

$location = '<div class="wpuf-fields"><select name="location" style="color: #666!important; height: 45px;" data-type="select" id="location" required  class="sf-input-select location_select"><option value=" ">--All--</option>';

 foreach($terms as $term){

if(!empty($selected)){
	$select = ($selected == $term->slug) ? 'selected="selected"' : '';
}

     $location .= '<option '.$select.' value="'.$term->slug.'">'.$term->name.'</option>';
  }
  $location .= '</select></div>';
  
    return $location;
}
add_shortcode( 'custom_texnomoy_location', 'custom_texnomoy_location_func' );

function job_texnomoy_location_func($selected = '') {

$terms = get_terms( array(
	  'taxonomy' => 'cs_locations',
	  'hide_empty' => false,  )
	);
$select =  '';
$selected = (is_array($selected)) ? $selected['selected'] : '';

$location = '<div class="form-group"><label for="neighborhood">Neighborhood<span class="required">*</span></label><select name="job_location_post" style="color: #666!important; height: 45px;" required 
 type="select" id="location" class="sf-input-select location_select"><option value=" ">--Select--</option>';

 foreach($terms as $term){

if(!empty($selected)){
	$select = ($selected == $term->term_id) ? 'selected="selected"' : '';
}

     $location .= '<option '.$select.' value="'.$term->term_id.'">'.$term->name.'</option>';
  }
  $location .= '</select></div>';
  
    return $location;
}
add_shortcode( 'job_texnomoy_location', 'job_texnomoy_location_func' );


/*
function payment_gateway_ci_func(){

$pp = '<p style="text-align: center;font-size: 18px !important;">After Payment you can create company account</p><div id="paypal-button-container"></div>';
$pp .= '<script src="https://www.paypalobjects.com/api/checkout.js"></script>';
$pp .= "<script> paypal.Button.render({env: 'sandbox', style: {layout: 'vertical',size:'medium',shape:'rect',color:  'blue'},funding: {allowed: [paypal.FUNDING.CARD,paypal.FUNDING.CREDIT],disallowed: []},client: { sandbox: 'AUWhz-XjpIT4pqhXfP4RDVzdQmkFCHUf1dPMuZ01lQZb8hVuw9yK01smqrAufxpBIoVF09oyO8ZrU1q1'},payment: function (data, actions) {return actions.payment.create({payment: {transactions: [{amount: {total: '99',currency: 'USD'}}]}});},onAuthorize: function (data, actions) {return actions.payment.execute().then(function () { jQuery('#form_4_1-element-36').css('display','inline-block'); alert('Payment Completed'); jQuery('.payment_status').val('Order Completed');});}},'#paypal-button-container');jQuery(document).ready(function(){ ('.payment_status').val('Order Processing...');  });</script>";

return $pp;
}
add_shortcode('payment_gateway_ci', 'payment_gateway_ci_func');
*/

function register_btn_func(){

$useragent=$_SERVER['HTTP_USER_AGENT'];

if(!is_user_logged_in()){
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)){
	
	$btn = '<div class="vc_btn3-container home_logbtn vc_btn3-inline">
	<center><a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-round vc_btn3-style-modern vc_btn3-color-primary" href="mailto:sales@referlink.io" title="">Contact Sales</a></center></div>';
	}else{
		$btn = '<div class="vc_btn3-container home_logbtn vc_btn3-inline">
		<center><a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-round vc_btn3-style-modern vc_btn3-color-primary" href="'.site_url().'/register-page/" title="">Create Your Account </a></center></div>';
	}
}else{
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)){
		
		$btn = '<div class="vc_btn3-container home_logbtn vc_btn3-inline">
		<center><a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-round vc_btn3-style-modern vc_btn3-color-primary" href="mailto:mroloff.dev@gmail.com" title="">Contact Sales</a></center></div>';
	}else{
		$btn = '<div class="vc_btn3-container home_logbtn vc_btn3-inline">
		<center><a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-round vc_btn3-style-modern vc_btn3-color-primary" href="javascript:void(0);" title="">Already Logged In</a></center></div>';
	}

}
return $btn;
}


// Recuiter Ajax logo

add_action("wp_ajax_recuiter_upload_logo", "recuiter_upload_logo");
add_action("wp_ajax_nopriv_recuiter_upload_logo", "recuiter_upload_logo");

function recuiter_upload_logo(){
	$userid = get_current_user_id();

	//$company_explogo_key = $_POST['company_explogo_key'];

	$support_title = !empty($_POST['supporttitle']) ? $_POST['supporttitle'] : 'Support Title';

        if (!function_exists('wp_handle_upload')) {
           require_once(ABSPATH . 'wp-admin/includes/file.php');
       }
      // echo $_FILES["upload"]["name"];
      $uploadedfile = $_FILES['file'];
      $upload_overrides = array('test_form' => false);
      $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

    
      if ($movefile && !isset($movefile['error'])) {

   $url = $movefile['url'];
   $type = $movefile['type'];
   $file = $movefile['file'];
   $title = preg_replace('/\.[^.]+$/', '', basename($file) );
   $parent = 0;
   $attachment = array(
     'post_mime_type' => $type,
     'guid' => $url,
     'post_parent' => $parent,
     'post_title' => $title,
     'post_content' => '',
   );
  $id = wp_insert_attachment($attachment, $file, $parent);


		  update_user_meta( $userid, 'user_avatar' , $movefile['url']);
		  update_user_meta( $userid, 'user_img' , $id);

		 $res =  $movefile['url'];
    } else {
        /**
         * Error generated by _wp_handle_upload()
         * @see _wp_handle_upload() in wp-admin/includes/file.php
         */
        $res =  'nomszno';//$movefile['error'];
    }
	
	echo $res;
	die();
}


// Recuiter Ajax logo

add_action("wp_ajax_recuiter_profile", "recuiter_profile");
add_action("wp_ajax_nopriv_recuiter_profile", "recuiter_profile");

function recuiter_profile(){

	$userid = get_current_user_id();

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$company_name = $_POST['company_name'];
	$department = $_POST['department'];
	$job_decs = $_POST['job_decs'];
$position_rec = $_POST['position_rec'];

	update_user_meta($userid, 'refer_by_com', $company_name);
	update_user_meta($userid, 'department', $department);
	update_user_meta($userid, 'first_name', $first_name);
	update_user_meta($userid, 'last_name', $last_name);
	update_user_meta($userid, 'description', $job_decs);
update_user_meta($userid, 'position_rec', $position_rec);
								
	die();
}



add_shortcode('register_btn', 'register_btn_func');

function company_form_website_func(){

$weburl= '<div class="rmrow"><div class="rmfield" for="website_54" style=""><label>Website<sup class="required" aria-required="true">&nbsp;*</sup></label></div><div class="rminput"><input type="text" name="Website_54"  required field_validation="" custom_validation="" value="" pattern="^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$" id="website_54" placeholder="e.g. www.referlink.com" style="height: 46px; border: 1px solid rgb(242, 242, 242); border-radius: 0px;" aria-required="true" class=""></div></div>';

return $weburl;
}
add_shortcode('company_form_website', 'company_form_website_func');


function custom_texnomoy_location_company_func($selected = '') {

$terms = get_terms( array(
	  'taxonomy' => 'cs_locations',
	  'hide_empty' => false,  )
	);
$select =  '';
$selected = (is_array($selected)) ? $selected['selected'] : '';

$location = '<div class="rmrow"><div class="rmfield"><label>What neighborhood is the company in?</div><div class="rminput"><select id="location_143" style="height: 45px;" required data-type="select" id="location" class="sf-input-select location_select"><option value="">--Select Neighborhood --</option>';

 foreach($terms as $term){

if(!empty($selected)){
	$select = ($selected == $term->slug) ? 'selected="selected"' : '';
}

     $location .= '<option '.$select.' value="'.$term->slug.'">'.$term->name.'</option>';
  }
  $location .= '</select></div></div>';
  
    return $location;
}


add_shortcode('company_texnomoy_location', 'custom_texnomoy_location_company_func');




function take_test_btn_func(){

if(!is_user_logged_in()){
$btn = '<div class="wpb_wrapper"><div class="vc_btn3-container vc_btn3-inline">
	<a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-round vc_btn3-style-modern vc_btn3-color-primary" href="'.site_url().'/candidates-register/" title="">Take the Test</a></div>
</div>';
}else{
$btn = '';
}
return $btn;
}

add_shortcode('take_test_btn', 'take_test_btn_func');

/* Company picture upload*/

function pippin_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return $attachment[0]; 
}

function my_upload_dir($upload) {

      $upload['subdir'] = $upload['subdir'];

      $upload['path']   = $upload['basedir'] . $upload['subdir'];

      $upload['url']    = $upload['baseurl'] . $upload['subdir'];

      return $upload;

}

add_action("wp_ajax_candidate_mode", "candidate_mode");
add_action("wp_ajax_nopriv_candidate_mode", "candidate_mode");

function candidate_mode(){

	$userid = get_current_user_id();

	$triger_rel = $_POST['triger_rel'];

	update_user_meta($userid, 'candidate_mode', $triger_rel);
								
	die();
}

function company_logo_api($company_id, $class_name=''){

global $wpdb;
$weburl = '';		
$image = '';		
	$submission_id_h = get_user_meta($company_id, 'RM_UMETA_SUB_ID', true);
				
	$submission_query_h = "SELECT data,form_id FROM wp_rm_submissions WHERE submission_id = ". $submission_id_h;

	$results_h = $wpdb->get_row($submission_query_h);

	$all_data_h = unserialize($results_h->data);
	
	$company_website = (get_user_meta($company_id,'url',true)) ? get_user_meta($company_id,'url',true) : $all_data_h['55']->value;
	
	$host = parse_url($company_website);

	if(!empty($host['host'])){
		$weburl = $host['host'];	
	}else{
			
		preg_match('/(.*?)((\.co)?.[a-z]{2,4})$/i', $host['path'], $m);
		$domain = explode('.',$m[1]);
		$ext = isset($m[2]) ? $m[2]: '';
		$weburl = $domain[1].$ext;
	}

			
				
    $user_avatar = get_user_meta($company_id, 'user_img', true);
	$user_avatar = wp_get_attachment_url($user_avatar);
	
	 if ( metadata_exists( 'user', $company_id, 'edit_profile' ) ) {
	$user_avatar = get_user_meta($company_id, 'user_avatar', true);
	
	}
	
  $dummy_logo = "'".site_url()."/wp-content/uploads/2018/06/dummy.png'";
  if (empty($user_avatar)) {
	  
	  $image = '<img style="width:100%" class="'.$class_name.'" src="https://logo.clearbit.com/'.$weburl.'" onerror="this.onerror=null;this.src='.$dummy_logo.'" />';
		
		
  }else{
	  $image = '<img src="'.$user_avatar.'" style="width:100%" class="'.$class_name.'" />';
  }
  
  return $image;
}



function candidate_logo_api($user_id){

    $user_avatar = get_user_meta($user_id, 'user_img', true);
	$user_avatar = wp_get_attachment_url($user_avatar);
  if (empty($user_avatar)) {
	$user_avatar = site_url().'/wp-content/uploads/2018/06/dummy.png';
  }
  
  return '<img src="'.$user_avatar.'" class="api_clogo" />';
}


//Experience company logo

function experience_company_logo_api($company_website, $k, $title){

global $wpdb;
$weburl = '';		
$image = '';		
	
	$host = parse_url($company_website);

	if(!empty($host['host'])){
		$weburl = $host['host'];	
	}else{
			
		preg_match('/(.*?)((\.co)?.[a-z]{2,4})$/i', $host['path'], $m);
		$domain = explode('.',$m[1]);
		$ext = isset($m[2]) ? $m[2]: '';
		$weburl = $domain[1].$ext;
	}

	
  $dummy_logo = "'".site_url()."/wp-content/uploads/2018/11/sponsorship-fpo.gif'";
  
  $image = '<img class="company_logo" id="company_logo_'.$k.'" title="'.$title.'"  rel="'.$k.'" src="https://logo.clearbit.com/'.$weburl.'" onerror="this.onerror=null;this.src='.$dummy_logo.'" style="width: 70px; height:70px;" />';
  
  return $image;
}


add_action("wp_ajax_website_url_link", "website_url_link");
add_action("wp_ajax_nopriv_website_url_link", "website_url_link");


function website_url_link(){
$url = parse_url($_POST['website_url']);
if($url['host']){
$url_link = $url['host'];
}else{
$url_link = $url['path'];
}
if(strpos($url_link, 'www') !== false ){}else{ $url_link = 'www.'.$url_link; }

echo $url_link;
die();
}

add_action( 'wp_logout', 'auto_redirect_external_after_logout');
function auto_redirect_external_after_logout(){
  wp_redirect( site_url() );
  exit();
}

function xyz_filter_wp_mail_from($email){
return "sales@referlink.io";
}
add_filter("wp_mail_from", "xyz_filter_wp_mail_from");

function rezzz_add_loginout_navitem($items, $args ) {

if ( !(is_user_logged_in()) ) {
$login_item = '<li class="nav-login"><a href="'.site_url().'/register-page/">Register</a></li>';
$login_item .= '<li class="nav-login"><a href="'.site_url().'/signin/">Sign In</a></li>';
}
else {
$login_item = '<li class="nav-login">'.wp_loginout($_SERVER['REQUEST_URI'], false).'</li>';
}
$items .= $login_item;

return $items;
}

add_filter('wp_nav_menu_items', 'rezzz_add_loginout_navitem', 10, 2);


function login_frm($post){
		
		global $error;
		$username = $post['username'];
		$password = $post['password'];
		
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            
            $user = get_user_by('email',$username);
             
        }else{
            
            $user = get_user_by('login',$username);
        }

		$user = wp_authenticate($username, $password);

		if(!is_wp_error($user)){

			wp_set_current_user( $user->ID, $user->user_login );
							   
			wp_set_auth_cookie( $user->ID );
			   
			do_action( 'wp_login', $user->user_login );
			
	$roles = $user->roles;
	$role = ($roles[0]) ? $roles[0] : $roles;
	
			if($role == 'cs_candidate'){
				   $rec = 'candidate-dashboard/';
				   
		   }elseif($role == 'recruiter'){
			   $rec = 'recruiter-dashboard/';
			   
		   }elseif($role == 'cs_employer' || $role == 'um_company'){
			   $rec = 'company-dashboard/';
			   
		   }else{
			   $rec = '';
		   }
		
		    $location = home_url().'/'.$rec; 
			
			ob_start();
			wp_redirect( $location );

			//$rec = site_url().'/'.$rec;
//echo '<script>jQuery(document).ready(function(){ window.location.href = "'.$rec.'"; } </script>';
				
			exit;
		   
		}else{
			$res = $user->get_error_message();
		    //$res = '<div class="res_error"><strong>ERROR</strong>:Invalid Details</div>';
		}
		

		return $res;
}

function forget_password_frm($post){
		
		global $error; $res ='';
		$username = $post['username_forget'];
		
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            
            $user = get_user_by('email',$username);
             
        }else{
            
            $user = get_user_by('login',$username);
        }

		if($user->ID > 0){
		
			$res = '<p class="res_error_green"><strong>Success</strong> : Please check your registered email.</p>';
			
			$to = $user->user_email;
			$subject = "Referlink Password Reset";
			$message = "
			<html>
			<body>
			<p>Hi ".$user->first_name.",</p><h2>Confirm Reset Password</h2><p>Hello! Someone requested that the password be reset for the following account:</p><p>".site_url()."</p><p>User Name: ".$user->user_login ."</p><br><p>If this was a mistake, just ignore this email and nothing will happen.</p><p>To reset your password, visit the following address:</p><br><p><a href='".site_url()."/signin/?reset_pass=true&user_token=".base64_encode($user->user_login)."'>".site_url()."/signin/?reset_pass=true&user_token=".base64_encode($user->user_login)."</a></p>
			</body>
			</html>
			";
			$email_from = 'sale@referlink.io';

			$headers = "From: " . strip_tags('Referlink') . "\r\n";
			$headers .= "Reply-To: ". strip_tags($email_from) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			mail($to,$subject,$message,$headers);
			
			
				
		}else{
			
			$res = '<p class="res_error"><strong>ERROR</strong> : Invalid Details</p>';
		}
	
		return $res;
}

function reset_password_frm($post){
		
		global $error; $res ='';
		$new_password = $post['new_password'];
		$confirm_password = $post['confirm_password'];
		$username = $post['username_reset'];
		
        $user = get_user_by('login',$username);
if (strlen( $new_password ) > 5 ) {
	
if($new_password == $confirm_password){
		if($user->ID > 0){
		
			wp_set_password( $new_password, $user->ID );
			
			$to = $user->user_email;
			$subject = "Your new password";
			$message = "
			<html>
			<body>
			<p>Hi ".$user->first_name.",</p><h2>New Password</h2><p>Hello! Password Reset Successfully. Below is your username and password.</p><p>".site_url()."</p><p>User Name: ".$user->user_login ."</p><p>Password: ".$user->new_password ."</p>
			</body>
			</html>
			";
			$email_from = 'sale@referlink.io';

			$headers = "From: " . strip_tags('Referlink') . "\r\n";
			$headers .= "Reply-To: ". strip_tags($email_from) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			mail($to,$subject,$message,$headers);
			
		$res = '<p class="res_error_green"><strong>Success</strong> : Your password is reset.</p>';
		}			
	}else{
		
		$res = '<p class="res_error"><strong>ERROR</strong> : Confirm password have not matched</p>';
	}
}else{
		
		$res = '<p class="res_error"><strong>ERROR</strong> : Password length must be greater than 5 </p>';
}
	
		return $res;
}
/*Custom Job Post type start*/

function cw_post_type_jobs() {
$supports = array(
'title', // post title
'editor', // post content
'author', // post author
'thumbnail', // featured images
'excerpt', // post excerpt
'custom-fields', // custom fields
'comments', // post comments
'revisions', // post revisions
'post-formats', // post formats
);
$labels = array(
'name' => _x('Jobs', 'plural'),
'singular_name' => _x('Jobs', 'singular'),
'menu_name' => _x('Jobs', 'admin menu'),
'name_admin_bar' => _x('Jobs', 'admin bar'),
'add_new' => _x('Add New ', 'add new'),
'add_new_item' => __('Add New Job'),
'new_item' => __('Add New Job'),
'edit_item' => __('Edit Job'),
'view_item' => __('View Job'),
'all_items' => __('All Jobs'),
'search_items' => __('Search Jobs'),
'not_found' => __('No Job found.'),
);
$args = array(
'supports' => $supports,
'labels' => $labels,
'public' => true,
'query_var' => true,
'rewrite' => array('slug' => 'jobs'),
'has_archive' => true,
'hierarchical' => false,
);
register_post_type('jobs', $args);
}
add_action('init', 'cw_post_type_jobs');

/*Custom Job Post type end*/

// hook into the init action and call create_skills_taxonomies when it fires

add_action( 'init', 'create_skills_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_skills_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Specialisms', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Specialisms', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Specialisms', 'textdomain' ),
		'all_items'         => __( 'All Specialisms', 'textdomain' ),
		'parent_item'       => __( 'Parent Specialisms', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Specialisms:', 'textdomain' ),
		'edit_item'         => __( 'Edit Specialisms', 'textdomain' ),
		'update_item'       => __( 'Update Specialisms', 'textdomain' ),
		'add_new_item'      => __( 'Add New Specialisms', 'textdomain' ),
		'new_item_name'     => __( 'New Specialisms Name', 'textdomain' ),
		'menu_name'         => __( 'Specialisms', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'specialisms' ),
	);

	register_taxonomy( 'specialisms', array( 'jobs' ), $args );
	
	
	$labels = array(
		'name'              => _x( 'Job Type', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Job Type', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Job Type', 'textdomain' ),
		'all_items'         => __( 'All Job Type', 'textdomain' ),
		'parent_item'       => __( 'Parent Job Type', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Job Type:', 'textdomain' ),
		'edit_item'         => __( 'Edit Job Type', 'textdomain' ),
		'update_item'       => __( 'Update Job Type', 'textdomain' ),
		'add_new_item'      => __( 'Add New Job Type', 'textdomain' ),
		'new_item_name'     => __( 'New Job Type Name', 'textdomain' ),
		'menu_name'         => __( 'Job Type', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'job_type' ),
	);

	register_taxonomy( 'job_type', array( 'jobs' ), $args );
	
	$labels = array(
		'name'              => _x( 'Locations', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Locations', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Locations', 'textdomain' ),
		'all_items'         => __( 'All Locations', 'textdomain' ),
		'parent_item'       => __( 'Parent Locations', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Locations:', 'textdomain' ),
		'edit_item'         => __( 'Edit Locations', 'textdomain' ),
		'update_item'       => __( 'Update Locations', 'textdomain' ),
		'add_new_item'      => __( 'Add New Locations', 'textdomain' ),
		'new_item_name'     => __( 'New Job Locations', 'textdomain' ),
		'menu_name'         => __( 'Locations', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'cs_locations' ),
	);

	register_taxonomy( 'cs_locations', array( 'jobs' ), $args );
	
	$labels = array(
		'name'              => _x( 'Experience', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Experience', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Experience', 'textdomain' ),
		'all_items'         => __( 'All Experience', 'textdomain' ),
		'parent_item'       => __( 'Parent Experience', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Experience:', 'textdomain' ),
		'edit_item'         => __( 'Edit Experience', 'textdomain' ),
		'update_item'       => __( 'Update Experience', 'textdomain' ),
		'add_new_item'      => __( 'Add New Experience', 'textdomain' ),
		'new_item_name'     => __( 'New Job Experience', 'textdomain' ),
		'menu_name'         => __( 'Experience', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'experience_finance' ),
	);

	register_taxonomy( 'experience_finance', array( 'jobs' ), $args );

	
}



if ( ! function_exists('cs_get_specialisms_dropdown') ) {

    function cs_get_specialisms_dropdown($name, $id, $user_id = '', $class = '', $required_status = 'false') {
        global $cs_form_fields2, $post;
        $output = '';
        $cs_spec_args = array(
            'orderby' => 'name',
            'order' => 'ASC',
            'fields' => 'all',
            'slug' => '',
            'hide_empty' => false,
        );
        $terms = get_terms('specialisms', $cs_spec_args);
$content = '<select class="mdb-select colorful-select dropdown-primary md-form" multiple searchable="Search here.."><option value="" disabled selected>Choose your country</option>';
 foreach($terms as $term){
$content .= '<option value="'.$term->slug.'">'.$term->slug.'</option>';
}
$content .='</select><div>ctrl+click use for multiple select</div>';

        return $content;
    }

}


// calling taxonomy

function custom_taxonomy_calling_func($taxonomy_name, $catsArray = '') {

$terms = get_terms( array(
	  'taxonomy' => $taxonomy_name,
	  'hide_empty' => false, 'include'  => $catsArray, 'orderby' => 'include' )
	);

foreach($terms as $term){
	
	$texonomy[$term->term_id] = $term->name;
	
} 


    return $texonomy;
}
 
