<?php
   /*
     Template Name: Candidate Dashboard
    */
   
   get_header();
   
   ?>

<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/dataTables.jqueryui.min.css" />
 <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/jquery-ui.css">

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



<script src="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/jquery.dataTables.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/rangeSlider/rangeSlider.js"></script>



<?php


global $wpdb;
   $user = wp_get_current_user();
   

   function checkUserJob($user_id,$post_id) {
       global $wpdb;
       $myrows = $wpdb->get_results( "SELECT apply_id from wp_job_apply where candidate_id=".$user_id." and post_id=".$post_id);
   
                            if ( $myrows )
                            {
                                return 1;
                            } else {
                                return 0;
                            }
   }
   

   
if($_POST['refer_submit']) {
	
	global $wpdb;
	
	$job_link = $_POST['job_link'];
	$job_title = $_POST['job_title'];
	$refer_name = $_POST['refer_name'];
	$refer_email = $_POST['refer_email'];
	$refer_user_id = $_POST['refer_user_id'];
	$refer_post_id = $_POST['refer_post_id'];
$first_name = get_user_meta($refer_user_id,'first_name',true);
$last_name = get_user_meta($refer_user_id,'last_name',true);
	
	 $sql = "INSERT INTO wp_refer_job_post (refer_user_id, refer_post_id, job_title, refer_name, refer_email, job_link, status) VALUES ($refer_user_id, $refer_post_id,'$job_title','$refer_name','$refer_email', '$job_link', 0)";
     if($wpdb->query($sql)){
		 
		 $lastid = $wpdb->insert_id;
		
		$to = $refer_email;
		$subject = "Refer Job - ".$job_title;
		$message = "
		<html>
		<body>
		<p>Hi ".$refer_name.",</p><p>I referred you to this job on Referlink. Check it out, I am sure you will like it!<br/></p>
		<p>Job Link: - <a href='".$job_link."?action=".base64_encode($lastid)."'>".$job_link."</a><br/><br/>Thanks,<br/>".$first_name.' '.$last_name."</p>
		</body>
		</html>
		";
$email_from = 'tyler@referlink.io';
//$email_from = $user->user_email;

		$headers = "From: " . strip_tags($email_from) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($email_from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


		mail($to,$subject,$message,$headers);
		
         $msg = '<div class="clearfix"></div><div class="col-md-12 col-lg-12 can-post job-list bg-inherit"><div class="alert alert-success" id="success-alert"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success!</strong> Job Successfully Sent.</div></div></div>';
		//header('Location:'.site_url().'/candidate-dashboard/');
    }
			   
}
$apply_job = '';
if($_POST['submit_resume']) {
               
               //print_r($_POST); die;
    global $wpdb;
                $allow = array("doc", "docx", "pdf");
                $todir = wp_upload_dir();
                $todir =  $todir['url'];
                $tobasedir = $upload_dir['basedir'];
                $resume_link = $cv_link = "";
                $candidate_id = $_POST['candidate_id'];
                $recruiter_id = $_POST['recruiter_id'];
                $refer_by_com = $_POST['refer_by_com'];
                $post_id = $_POST['post_id'];
                $apply_job_title = $_POST['apply_job_title'];
                
                
                if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
                
                $uploadedfile = $_FILES['resume'];
                $upload_overrides = array( 'test_form' => false );
                add_filter('upload_dir', 'my_upload_dir');
                $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
                remove_filter('upload_dir', 'my_upload_dir');

                if ( $movefile ) {
                    //echo "File is valid, and was successfully uploaded.\n";
                    //var_dump( $movefile);
                    $resume_link = $movefile['url'];
                } 

                
                /*$uploadedfile1 = $_FILES['cover_letter'];
                $upload_overrides1 = array( 'test_form' => false );
                add_filter('upload_dir', 'my_upload_dir');
                $movefile1 = wp_handle_upload( $uploadedfile1, $upload_overrides1 );
                remove_filter('upload_dir', 'my_upload_dir');

                if ( $movefile1 ) {
                    //echo "File is valid, and was successfully uploaded.\n";
                    //var_dump( $movefile1);
                     $cv_link = $movefile1['url'];
                } */
               
			   
                $cv_link = $_POST['cover_letter'];
                $curdate = time();
                $sql = "INSERT INTO wp_job_apply (candidate_id, post_id,recruiter_id,company_id, resume_file, cv_file, status,applied_date) VALUES ($candidate_id, $post_id,$recruiter_id,$refer_by_com, '$resume_link', '$cv_link', 0,$curdate)";
                //die;
                if($wpdb->query($sql)) 
               {
                    //header('Location:'.site_url().'/candidate-dashboard/');
               }

	$apply_user_info = get_user_by('id',$candidate_id);
	$recruiter_user_info = get_user_by('id',$recruiter_id);
	$name_c = $apply_user_info->first_name .' '.$apply_user_info->last_name ;
$name_r = $recruiter_user_info->first_name .' '.$recruiter_user_info->last_name ;
	$to = $recruiter_user_info->user_email; //'web2sols@gmail.com';//$current_userr->user_email;
	$subject = "Referlink Job Applicant";
	$message = '<p>Hi '.ucwords($name_r).',	</p>';
	$message .= '<p>'.ucwords($name_c).' has applied to the '.ucwords($apply_job_title).' position.</p>';
	$message .= '<p>Thank you,</p>';
	$message .= '<p>Tyler from Referlink</p>';
	
	$headers = "MIME-Version: 1.0\r\n"; // Defining the MIME version 
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: tyler@referlink.io\r\n"; // Sender Email 
	$headers .= "Content-Type: multipart/mixed;\r\n"; // Defining Content-Type 
	
$expolde_resume_link = explode('wp-content',$resume_link);
	$attachments = array(WP_CONTENT_DIR . $expolde_resume_link[1]);	
	
	wp_mail($to,$subject,$message,$headers, $attachments);

    $apply_job = '<div class="clearfix"></div><div class="col-md-12 col-lg-12 can-post job-list bg-inherit"><div class="alert alert-success"><strong>Success!</strong> '.$apply_job_title.' Job Proposal Successfully Submitted.</div></div><div class="clearfix"></div>';            
}
   
   if ( in_array( 'cs_candidate', (array) $user->roles ) ) {

	   
   ?>
<div class="main-section1">
    <section class="page-section">
        <div class="container-fluid candidate-dash-area">

            <div class="row">
  
<?php 
$defaultopen1 = ''; $defaultopen2 = ''; $defaultopen = ''; 
$message_refresh = base64_decode($_REQUEST['message_refresh']);
	if($_REQUEST['_sf_s'] || $_REQUEST['_sft_job_type'] || $_REQUEST['_sft_cs_locations'] || !empty($apply_job) || $_REQUEST['company_info']) {
		$defaultopen1 = 'defaultOpen';
	}else if($message_refresh == 'message_inbox'){
		$defaultopen2 = 'defaultOpen';
	}else{
		$defaultopen = 'defaultOpen';
	}

?>
                <div class="col-md-12 tab-container">
	                <div class="tab-inner-container">
	                    <div class="tab">
							<button class="tablinks" onclick="openCity(event, 'London')" id="<?php echo $defaultopen; ?>">Profile</button>
							<button class="tablinks" onclick="openCity(event, 'jobs')" id="<?php echo $defaultopen1; ?>" >Jobs</button>
	                       <!-- <button class="tablinks" onclick="openCity(event, 'Paris')">Job Preferences</button>-->
	                        <!--<button class="tablinks" onclick="openCity(event, 'Tokyo')">Recent Visitors</button>-->

	                        <button class="tablinks" onclick="openCity(event, 'Japan')" id="<?php echo $defaultopen2; ?>">Messages</button>
							
	                    </div>
						<div class="container" style="background: #fff;margin: 0px;">
	                    <div id="London" class="tabcontent">                      
	                        <div class="col-md-12 col-lg-12 can-post">
	                			
	                			<div class="skills"><p>Recruiters will see the above candidate card as their view</p>
	                				<h2>Financial Systems & Data Tools <i class="icon-plus8" data-toggle="modal" data-target="#myModal"></i></h2>
	<?php

	if($_POST['cs_specialisms'] != "") {
		//$cs_specialisms = $_POST['cs_specialisms'];
		update_user_meta( $user->ID,'cs_specialisms', array_map( 'strip_tags', $_POST['cs_specialisms'] ) );
	}
	 $specialisms = get_user_meta($user->ID,'cs_specialisms',true); 	
	 $experience_cnt = get_user_meta($user->ID,'experience_count', true ); 
	 $experience_count = ($experience_cnt) ? $experience_cnt : 0;
	 
	 $check1 = get_user_meta($user->ID, 'check1', true);
	 $field_select = get_user_meta($user->ID, 'job_field_preferred', true);
	 $position_select = get_user_meta($user->ID, 'job_position_preferred', true);
	 $response_lists = get_user_meta($user->ID, 'response_list', true);
	 $miles_data = get_user_meta($user->ID, 'miles', true);
	 $zipcode = get_user_meta($user->ID, 'zipcode', true);

	 $salary_from = get_user_meta($user->ID,'salary_from', true );
	 $salary_to = get_user_meta($user->ID,'salary_to', true );
	 $inbox_noti = inbox_notification_count($user->ID);
	?>								
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Add Systems</h4>
	      </div>
	      <div class="modal-body">
			
	        <!--<form id="skills" action="" method="post">-->
				<label>Systems</label>
				<?php //echo cs_get_specialisms_dropdown('cs_specialisms', 'cs_specialisms', $user->ID, 'form-control chosen-select', true) ?>
				<input type="button" name="submit" id="skills_submit" class="acc-submit cs-section-update cs-bgcolor csborder-color cs-color" value="Update System">
				
			<!--</form>-->
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>
						<ul class="skils">
							<?php if($specialisms != "") { ?>
							
								<?php foreach($specialisms as $special) { $special_tags = get_term_by( 'slug', $special, 'specialisms' ); ?>
								<li style="text-transform: capitalize;"><?php echo $special_tags->name; ?></li>
								<?php } ?>
							
	                		<?php } else { ?>
							
								<p style="color:#777777; font-size:12px !important;">There is no record in Skills list</p>
							
							<?php } ?>
						</ul>
	                			</div>
	                			<div class="experience">
									<h2>Experience <i class="icon-plus8 expmodal " data-toggle="modal" rel="<?php echo $experience_count; ?>" data-target="#expmyModal"></i></h2>
									<div class="exp_list_ul">
									
									<?php if($experience_count > 0) { ?>
										<?php for($k = 1; $k <= $experience_count; $k++) { ?>
										<?php $exp = get_user_meta( $user->ID,'cs_experience_'.$k, true );?>
										<?php $cmp_logo = get_user_meta( $user->ID,'cs_experience_logo_'.$k, true );?>
										<?php if(!empty($exp)) { ?>

										<div class="col-md-12 list_wrap" id="<?php echo 'ul_'.$k; ?>" style="border: 1px solid #ccc; padding: 10px; margin-bottom:20px;">
											<input type="hidden" class="update_exp_key" value="<?php echo 'cs_experience_'.$k; ?>" />
											<div class="col-md-10 jb_details" style="padding:0px;">
												<div style="padding:0px;" class="col-md-2 company_logo_exp">
												<?php if(empty($cmp_logo)){ echo experience_company_logo_api($exp['website_url'], $k, $exp['jp_title']); } else{ ?>
													<img class="company_logo" id="<?php echo 'company_logo_'.$k; ?>" src="<?php echo $cmp_logo; ?>" title="<?php echo $exp['jp_title'];  ?>" rel="<?php echo $k; ?>" style="width: 70px; height:70px;">
												<?php }?>
												<i style="cursor:pointer;" class="icon-edit3 exp_logo"></i></div>
												<div class="col-md-10 right_line jb_info">
													<div class="col-md-12 right_div jb_title"><span class="jb_title"><?php echo $exp['jp_title'];  ?></span></div>
													<div class="col-md-12 right_div cmp_name"><?php echo $exp['cmp_name'];  ?></div>
													<div class="col-md-12 right_div website_url"><?php echo $exp['website_url'];  ?></div>
													<div class="col-md-12 right_div start_end"><span class="date_start"><?php echo $exp['date_start'].'</span> - <span class="date_end">'.$exp['date_end'];  ?></span></div>
													
												</div>											
												<div style="padding:0px 20px 0px 0px;" class="col-md-10 right_desc job_decs"><?php echo nl2br($exp['job_decs']);  ?></div>
											</div>
											<div class="col-md-2 right_div"><span class="badge badge_edit"><i class="icon-edit3"></i></span><span class="badge badge_remove"><i class="icon-trash"></i></span></div>
										</div>
										<div class="clearfix"></div>
										
									  
										<?php } } } else { ?>
										There is no record in Experience
									<?php } ?>
									</div>	
									
	                			</div>
								<!-- Modal -->
	<div id="expmyModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Your Experience</h4>
	      </div>
	      <div class="modal-body">
			<input type="hidden" id="company_logo" value="" />

			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
			<input type="text" name="jp_title" id="jp_title" class="form-control input-sm" placeholder="Position or Job Title">
					</div>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="text" name="cmp_name" id="cmp_name" class="form-control input-sm" placeholder="Employer ( Company Name )">
					</div>
				</div>
			</div>
<div class="row"><div class="col-md-12" style="padding: 0px 15px;"><div class="form-group"><input type="text" name="website_url" id="website_url" class="website_url form-control input-sm" placeholder="e.g. www.referlink.com"></div></div></div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
			<input type="text" name="date_start" id="date_start" class=" date_pic form-control input-sm" placeholder="Start Date">
					</div>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
					<div class="col-md-6">
						<input type="text" name="date_end" id="date_end" class="date_pic form-control input-sm" placeholder="End Date"></div><div class="col-md-6">
						<select class="" id="date_end_select" style="border: 1px solid #ccc !important;"><option>-Select-</option><option value="Present">Present</option></select></div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<!--<textarea name="job_decs" id="job_decs" placeholder="Responsibilities or Details" ></textarea>-->
				<span style="font-size: 17px;opacity: 0.8;">Responsibilities or Details</span>
				<div style="min-height: 100px; border: 1px solid #f2f2f2; padding:10px;"contenteditable="true" id="job_decs"></div>
			</div>
			<input type="hidden" id="update_exp_keyy" value="0" />
			<input type="button" value="Submit" class="acc-submit cs-section-update cs-bgcolor csborder-color cs-color experience_submit">
				    		
			
	    </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

	<!-- Experience logo add-->


	<div id="exp_logo_modal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title exp_logo_title">Your Experience Company Logo</h4>
	      </div>
	      <div class="modal-body">
			
	<form action="" method="post" id="exp_logo_form" enctype="multipart/form-data">
								<div class="cs-img-detail">

	                                <div class="upload-btn-div">

	                                    <div class="fileUpload uplaod-btn btn cs-color csborder-color" style="width:100%;">
											<input type="file" required="" id="company_explogo" name="company_explogo" style="width:100%;">
											<input type="hidden" id="company_explogo_key" name="company_explogo_key" value=""/>
	                                        <input type="button" class="user_img_submit acc-submit cs-section-update cs-bgcolor csborder-color cs-color" name="submit" value="Upload Logo">				

	                                    </div>

	                                    <br>

	                                    <span id="cs_candidate_profile_img_msg">Max file size is 1MB, Minimum dimension: 270x210 And Suitable files are .jpg &amp; .png</span>

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

	 </div>
	</div>

	                    <div id="Paris" class="tabcontent">
	                      
	                      <div class="col-md-12 col-lg-12 can-post job-list">
	                        
	                        
							<form id="job-prefered" action="">
							
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<h2>Preferred Job Checklist</h2>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="form-check-label" for="exampleCheck1">I only want to be approached by ofers <br> that meet most of the items on the list </label>
													<input type="checkbox" <?php echo ($check1 == 1) ? 'checked="checked"' : ''; ?>class="form-check-input" id="exampleCheck1">
										</div>
									</div>
								</div>

							
	                		<div class="row">
								<div class="col-md-5">
									<h2>Field</h2>
									
									<select class="form-control profile_select" id="cs_job_field_preferred" name="job_field_preferred">
									  <option>--Select--</option>
									  <?php 
									  $fields['Bank'] = array("Investment Banking","Equity Research","Search & Tranding","Commercial Banking");
									  $fields['Public Accounting'] = array("Due Diligence","Tranasction Advisory","Valuations");
									  $fields['Corporates'] = array("FP&A","Treasury","Investor Relations","Corporate Development");
									  $fields['Institutions'] = array("Research","Portfolio Management","Private Equity"); ?>
									<?php foreach($fields as $fieldKey => $fieldVal){ ?>
									<optgroup label="<?php echo $fieldKey; ?> ">
									<?php foreach($fieldVal as $field){ ?>
									<option <?php echo ($field_select == $field) ? 'selected="selected"' : ''; ?> value="<?php echo $field; ?>"><?php echo $field; ?></option>
									<?php } ?>								
									</optgroup>
									<?php } ?>
									
									</select>
								</div><div class="col-md-7">&nbsp;</div>
	                		</div>
	                		
	                		<div class="position row" style="margin-top: 35px;">
								<div class="col-md-5">
									<h2>Position</h2>
									<select class="form-control profile_select" id="cs_job_position_preferred" name="job_position_preferred">
									  <option>--Select--</option>
									  <?php $positions = array("Corporate Finance","Financial Advisor","Investment Finance","Collectors","Public Accounting","Loan Officers");  ?>
									<?php foreach($positions as $position){ ?>
									<option <?php echo ($position_select == $position) ? 'selected="selected"' : ''; ?> value="<?php echo $position; ?>"><?php echo $position; ?></option>
									<?php } ?>
									</select>
								</div><div class="col-md-7">&nbsp;</div>
	                		</div>
	                		
	                		<div class="position responsibilities row" style="margin-top: 35px;">
								<div class="col-md-8">
									<h2>Responsibility</h2>
									<input type="hidden" name="response_ul_input" id="response_ul_input" value="<?php echo $response_lists; ?>" />
									<ul class="response_ul">
									<?php
									if($response_lists){
										$response_lists_arr  = explode(',',$response_lists);
										foreach($response_lists_arr as $response_list){
											echo '<li>'.$response_list.'</li>';
										}
									}
									?>
										<li id="add_sign">+</li>
									</ul>
								</div><div class="col-md-4">&nbsp;</div>
	                		</div>
	                		
	                		<div class="position row" style="margin-top: 5px;">
								<div class="col-md-8">
									<h2 style="margin-bottom: 25px;">Pay Range</h2>
									<input class="range-slider-demo" id="range_salary" type="hidden" value="<?php echo str_replace('k',' ',$salary_from).','.str_replace('k',' ',$salary_to);?>"/>
								</div><div class="col-md-4">&nbsp;</div>
	                		</div>
	                		<div class="commute row" style="margin-top: 40px;">
								
									<div class="col-md-10">
										<h2>Commute</h2>
										The ideal commute will be with in <select name="miles" id="miles">
									<?php $miles = array("5","10","15","20","25","30","35","40","45","50"); ?>
									<?php foreach($miles as $mile){ ?>
									<option <?php echo ($miles_data == $mile) ? 'selected="selected"' : ''; ?> value="<?php echo $mile; ?>"><?php echo $mile; ?></option>
									<?php } ?></select> miles of <input type="text" id="zipcode" name="zipcode" value="<?php echo $zipcode; ?>"> ZIP Code
									</div>
								
	                		</div>
							<div class="row" style="margin-top: 35px;"><input type="button" value="Submit" id="profile_submit" class="acc-submit cs-section-update cs-bgcolor csborder-color cs-color"></div>
							
							</form>
	                      </div>
	<!-- Modal Responsibility -->
	<div id="resmyModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Add Responsibility</h4>
	      </div>
	      <div class="modal-body">
			
	        <!--<form id="skills" action="" method="post">-->
				<label>Responsibility</label>
				<?php //echo cs_get_specialisms_dropdown('cs_specialisms', 'cs_specialisms', $user->ID, 'form-control chosen-select', true) ?>
				<input type="text" name="responsibility_name" id="responsibility_name" />
				<input type="button" name="submit" id="respons_submit" class="acc-submit cs-section-update cs-bgcolor csborder-color cs-color" value="Add">
				
			<!--</form>-->
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>                      
	                    </div>
						
	                    <div id="Tokyo" class="tabcontent">
	                        <div class="col-md-12 col-lg-12 can-post job-list">
	                    		<h2 style="line-height: 20px !important; margin-bottom: 5px;">Recruiters</h2><p style="margin-bottom: 25px !important;">These are the recruiters that have viewed yours profile.</p>
	                            <div class="recruiters">
	                    		<?php
	                    		

	                    		$blogusers = get_users( '&orderby=nicename&role=recruiter' );
	                    		// Array of WP_User objects.
	                    		foreach ( $blogusers as $main ) {
	                    		$logo_r = '';	
	                    		$logerId  =  $main->ID;
	                    		$logerData = get_userdata($logerId);
	                    		$logerDescription = $logerData->description;
	                    		$logerImg = get_user_meta($logerId, 'user_avatar', true);
	                    		$refer_by_com = get_user_meta($logerId, 'refer_by_com', true);
	                    		$refer_by_comid = get_user_meta($logerId, 'refer_by', true);
								$comid = base64_encode($refer_by_comid);
	                    		$department = get_user_meta($logerId, 'department', true);
							
	                    		$logerName = $logerData->display_name;
	                    		$logerEmail = $logerId->user_email;
	                    		$user_roles=$logerData->roles;
	                    			
	                    		echo '<div class="recruiter"><a style="cursor:pointer;" data-toggle="modal" data-target="#recuireter_info_modal'.$logerId.'">';	
								
								if ( $logerImg != '' ) {
									$logo_r = '<div class="loger_img"><img src="'.esc_url($logerImg).'" alt="'.$logerName.'" /></div>';
								}else{
									$logo_r = '<div class="loger_img"><img src="'.site_url().'//wp-content/uploads/2018/06/dummy.png" alt="'.$logerName.'" /></div>';
								}
								echo $logo_r;
	                    		?>
	                    		
	                    		<?php
	                    			echo '<h5 style="margin-bottom: 0px;">' . $logerName . '</h5>';
	                    			echo '<p>' . wp_trim_words($logerDescription, 5) . '</p>';
									echo '</a></div>';	
									echo '<div id="recuireter_info_modal'.$logerId.'" class="modal fade" role="dialog"><div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title exp_logo_title">'.$logo_r.'<center style="margin-top: 12px;">'.$logerName.'</center></h4>
	      </div>
	      <div class="modal-body">
			<ul>
			<li><strong style="display: inline-block; width: 100px;">Company : </strong><a href="'.site_url().'/company-information/?companyname='.$comid.'">'.$refer_by_com.'</a></li>
			<li><strong style="display: inline-block; width: 100px;">Position : </strong>'.ucfirst($department).'</li>
			<li> <strong style="display: inline-block; width: 100px;">Bio : </strong><br> '.nl2br($logerDescription).'</li></ul>
			
	    </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>';
	                    		}
	                    		?>
	                    		</div>
	                    	</div>
	                    </div>
					<!-- Message Module -->
						
						<div id="Japan" class="tabcontent message_block">
	                        <section id="tabs">
								<div class="container1">
	                            <div class="row">
									<div class="col-xs-12 ">
										<nav>
											<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
												
												<a class="nav-item nav-link" id="inbox" data-toggle="tab" href="#nav-inbox" role="tab" aria-controls="nav-profile" aria-selected="true">Inbox<span class="count_noti"><?php echo $inbox_noti; ?></span></a>
												<a class="nav-item nav-link" id="sent" data-toggle="tab" href="#nav-sent" role="tab" aria-controls="nav-contact" aria-selected="false">Sent</a>
												<a class="nav-item nav-link" id="trash" data-toggle="tab" href="#nav-trash" role="tab" aria-controls="nav-about" aria-selected="false">Trash</a>
												<!--<a style="float:right;" class="nav-item nav-link" id="new-message" data-toggle="tab" href="#nav-newmessage" role="tab" aria-controls="nav-home" aria-selected="true">Compose</a>-->
											</div>
										</nav>
										<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
											
											<div class="tab-pane fade in active" id="nav-inbox" role="tabpanel" aria-labelledby="inbox"><h3 style="text-align: center;">Inbox <a href="<?php echo site_url(); ?>/candidate-dashboard/?message_refresh=<?php echo base64_encode('message_inbox'); ?>" style="float: right;"><img src="<?php echo site_url(); ?>/wp-content/uploads/2018/12/refresh-150x150.png" style="width: 25px;"></a></h3>
												<table id="candidate_datatype1" class=" candidate_datatype table table-striped table-bordered" style="width:100%">
	        <thead>
	            <tr>
					
	                <th>Date</th>
	                <th>Sender Name</th>
					<th>Company Name</th>
	                <th>Subject</th>
	                <th>Action</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php
			global $wpdb;
				
				$messages_table = $wpdb->prefix."messages";
				$current_user = wp_get_current_user();
				$current_user_id = $current_user->ID;
				

			$results = $wpdb->get_results('select * from '.$messages_table .' where receiverid = '.$current_user_id.' and (status = 1 or status = 2) order by ID desc');

				foreach($results as $result){
				
					
					$sender_info = get_userdata($result->senderid);
							
					$fname = get_user_meta($sender_info->ID,'first_name',true);
					$lname = get_user_meta($sender_info->ID,'last_name',true);
					
					$company_name = get_user_meta($sender_info->ID,'refer_by_com',true);
					
					// $senderemail = $sender_info->user_email;
					 $display_name = $sender_info->display_name;
					$delid = json_encode($result->ID);
					$name = $fname.' '.$lname;
					$sender_name_list = ($name) ? $name : $display_name;
					$readable = ($result->status == 1) ? 'unread' : 'read';			
					echo '<tr class="'.$readable.'" id="tr_'.$result->ID.'"><td class="receiverdate">'.date('d-m-Y',$result->currenttime). '</td><td class="receivername">'.$sender_name_list. '</td><td class="receiveremail" rel="'.$result->senderemail.'" >'.$company_name. '</td><td class="subject_txt">'.$result->subject.'</td><td> <a class="view_message" data-type="inbox" data-id="'.$result->ID.'" rel="'.$sender_info->ID.'" href="javascript:void(0);">View</a> / <a data-email="'.$result->receiveremail.'" class="reply_message"  data-id="'.$result->ID.'" rel="'.$sender_info->ID.'" href="javascript:void(0);">Reply</a> / <a data-email="'.$result->receiveremail.'" class="delete_message"  data-id="'.$result->ID.'" rel="'.$sender_info->ID.'" href="javascript:void();">Delete</a><div class="div_message" style="display:none;">'.stripslashes($result->message).'</div></td></tr>';
				}
				?>
				</tbody>
	    </table>
											</div>
											<div class="tab-pane fade" id="nav-sent" role="tabpanel" aria-labelledby="sent"><h3 style="text-align: center;">Sent</h3>
												<table id="candidate_datatype2" class=" candidate_datatype table table-striped table-bordered" style="width:100%">
	        <thead>
	            <tr>
	                <th>Sender Name</th>
					<th>Company Name</th>
	                <th>Subject</th>
	                <th>#</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php
			global $wpdb;
				
				$messages_table = $wpdb->prefix."messages";
				$current_user = wp_get_current_user();
				$current_user_id = $current_user->ID;

			$results = $wpdb->get_results('select * from '.$messages_table .' where senderid = '.$current_user_id.' and status = 1 order by ID desc');
			
				foreach($results as $result){
					

					
					$receiver_info = get_userdata($result->receiverid);
							
					$fname = get_user_meta($receiver_info->ID,'first_name',true);
					$lname = get_user_meta($receiver_info->ID,'last_name',true);
					
					// $senderemail = $sender_info->user_email;
					 $display_name = $receiver_info->display_name;

					$name = $fname.' '.$lname;
					$receiver_name_list = ($name) ? $name : $display_name;
					
					$company_name = get_user_meta($receiver_info->ID,'refer_by_com',true);
					
								
					echo '<tr><td>'.$receiver_name_list. '</td><td>'.$company_name. '</td><td class="subject_txt">'.$result->subject.'</td><td><a class="view_message" data-type="sent" data-id="'.$result->ID.'" rel="'.$receiver_info->ID.'" href="javascript:void(0);">View</a><div class="div_message" style="display:none;">'.stripslashes($result->message).'</div></td></tr>';
				}
				?>
				</tbody>
	    </table>
											</div>
											<div class="tab-pane fade" id="nav-trash" role="tabpanel" aria-labelledby="trash"><h3 style="text-align: center;">Trash</h3>
												<table id="candidate_datatype3" class=" candidate_datatype table table-striped table-bordered" style="width:100%">
	        <thead>
	            <tr>
	                <th>Sender Name</th>
					<th>Company Name</th>
	                <th>Subject</th>
	                <th>#</th>
	            </tr>
	        </thead>
	        <tbody>
	        <?php
			global $wpdb;
				
				$messages_table = $wpdb->prefix."messages";
				$current_user = wp_get_current_user();
				$current_user_id = $current_user->ID;

			$results = $wpdb->get_results('select * from '.$messages_table .' where receiverid = '.$current_user_id.' and status = 0 order by ID desc');
			
				foreach($results as $result){
					
					$sender_info = get_userdata($result->senderid);
							
					$fname = get_user_meta($sender_info->ID,'first_name',true);
					$lname = get_user_meta($sender_info->ID,'last_name',true);
					
					// $senderemail = $sender_info->user_email;
					 $display_name = $sender_info->display_name;
					 $company_name = get_user_meta($sender_info->ID,'refer_by_com',true);

					$name = $fname.' '.$lname;
					$sender_name_list = ($name) ? $name : $display_name;
								
					echo '<tr><td>'.$sender_name_list. '</td><td>'.$company_name. '</td><td class="subject_txt">'.$result->subject.'</td><td><a class="view_message" data-type="trash" data-id="'.$result->ID.'" rel="'.$sender_info->ID.'" href="javascript:void(0);">View</a><div class="div_message" style="display:none;">'.stripslashes($result->message).'</div></td></tr>';
				}
				?>
				</tbody>
	    </table>
											</div>
											
										</div>
									
									</div>
								</div>
	                    	</div>
							</section>
	<!-- Modal Message  -->
	<div id="messagebox_modal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title subject_title">Subject</h4>
	      </div>
	      <div class="modal-body  message_content">Message</div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>   

	<!--Reply message-->					
	<div id="myModalreply" class="modal fade myModalreply" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title reply_title"></</h4>
		  </div>
		  <div class="modal-body">
			 <div class="panel-body">

				<?php //echo do_shortcode('[contact-form-7 id="5" title="Contact form 1"]'); ?>
					<form role="form" method="post" id="message_form" >
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" class="form-control"
						 name="replyname" id="replyname" value="" readonly="readonly" required maxlength="50">

					</div>
					<!--<div class="form-group">
						<label for="email">
							Email:</label>
						<input type="email" class="form-control" id="replyreceiveremail" name="replyreceiveremail" value="" readonly="readonly" required maxlength="50">
						<input type="hidden" class="form-control" id="replysenderemail" name="replysenderemail" value="" maxlength="50">
					</div>-->
					<div class="form-group">
						<input type="hidden" class="form-control" id="replyreceiveremail" name="replyreceiveremail" value="" maxlength="50">
						<input type="hidden" class="form-control" id="replysenderemail" name="replysenderemail" value="" maxlength="50">
					</div>
					
					<div class="form-group">
						<label for="name">Subject:</label>
						<input type="text" class="form-control" id="replysubject" readonly="readonly" name="replysubject" required maxlength="50">
					</div>
					<div class="form-group">
						<label for="name">
							Message:</label>
						<textarea style="height: 100px;" class="form-control" required type="textarea" name="replymessage"
						id="replymessage" placeholder="Your Message Here"
						maxlength="6000" rows="7"></textarea>
					</div>

					<input type="hidden" name="replyreceiverid" id="replyreceiverid" value="" />
					<input type="hidden" name="replymessageid" id="replymessageid" value="" />
					<button type="button"  style="margin: 0 auto; width: 200px;" class="btn btn-lg btn-notification btn-block replymessagesend" id="replymessagesend">Send</button>

				</form>
				<div id="replysuccessmessage">
					<h3 style="color:green !important;">Sent your message successfully!</h3>
				</div>
				<div id="replyerrormessage">
					<h3 style="color:red !important;">Sorry there was an error sending your form.</h3>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>
										
	                    </div> <!--Wrap Close-->
						
					
					
	                    <div id="jobs" class="tabcontent">
							
							<?php echo do_shortcode('[searchandfilter id="2740"]'); ?>
							<?php echo $msg; echo $apply_job;?>
	                        <?php
	                            $args = array(
	                            'post_type' => 'jobs',
	                            //'meta_key' => 'cs_job_status',
	                            //'meta_value' => 'active',
								'orderby' => 'date',
								'order' => 'DESC',
								'post_status' => 'publish',
								'posts_per_page' => -1
	                            );
								$args['search_filter_id'] = 2740;
	                            $loop = new WP_Query($args);

	                            while ($loop->have_posts()):
	                            $loop->the_post();
	                            $ID = get_the_ID();
								$auth = get_post($ID); // gets author from post
								$authid = $auth->post_author; // gets author id for the post
	                            $refer_by_com = get_user_meta($authid, 'refer_by', true);
	                                                        
								$user_email = get_the_author_meta('user_email',$authid); // retrieve user email
								
								$user_firstname = get_the_author_meta('user_firstname',$authid);
								$user_lastname = get_the_author_meta('user_lastname',$authid);
							?>
	                        <div class="col-md-12 col-lg-12 can-post job-list bg-inherit">
<?php 
$refer_com = get_user_meta($authid, 'refer_by_com', true);
$refer_comid = get_user_meta($authid, 'refer_by', true);
$comidd = base64_encode($refer_comid);
?>
	                            <div class="listing-wrap clearfix">    
	                                <div class="col-md-8">
										<h2><?php echo get_the_title(); ?></h2>
										<div class="col-md-3" style="text-align:center; padding:0px;">
											<div><?php echo company_logo_api($refer_comid,'api_clogo'); ?></div>
										</div>
										<div class="col-md-9">
											<?php echo '<a href="'.site_url().'/company-information/?companyname='.$comidd.'">'.$refer_com.'</a>'; ?>
											<div class="info_job"><b>Salary : </b><?php echo get_post_meta($ID, 'salary', true); ?> </div>
											<?php $jtid = get_post_meta($ID, 'job_type', true);  $tdata = get_term_by( 'term_id', $jtid, 'job_type' ); ?>
											
											<?php $term_location = wp_get_post_terms( $ID, 'cs_locations', array( 'fields' => 'names' ) );?>
											
											
											<div class="info_job"><b>Job Type : </b><?php echo $tdata->name; ?> </div>
											<div class="info_job"><b>Neighborhood : </b><?php echo $term_location[0]; ?> </div>
											<div class="info_job"><b>Excel Skill Level : </b><?php echo ucfirst(get_post_meta($ID, 'offering_visa_sponsorship', true)); ?> </div>
										</div>
										<div class="clearfix"></div>
										<div class="summery info_job" style="margin-top: 10px;">
											<div class="outer_decs" style="display:block;">
												<span><b>Job Description : </b></span>
												<?php
													$text = get_the_content();
													if($text == ''){
													 //$text =  get_post_meta($ID, 'why_us', true);
													}
													$text_cnt = '';
													$worccont = str_word_count($text);
													if($worccont > 7){
														$text_cnt = wp_trim_words($text,7,'');
														echo $text_cnt.' <a style="color:#61dac2;" class="more_decs" href="javascript:void(0);">Show More</a>';
													}else{
														echo $text_cnt = wp_trim_words($text,7);
													}
													
												?>
											</div>
											<div class="inner_decs" style="display:none;">
												<div class="cs-element-title1">
												<span><b>Job Description : </b></span><div class="less_cnt"><?php echo the_content(); ?></p><a style="color:#61dac2;" class="more_decs_less" href="javascript:void(0);">Show Less</a></div>
												</div>
											
											</div>
										</div>
	                                </div>
	                                <div class="col-md-4">
	                                    <div class="refer" style="margin: 15px 0px;">
	                                        <?php
	                                            $user = wp_get_current_user();
	                                            $resultCheck = checkUserJob($user->ID,$ID);
	                                            if($resultCheck == 0) {
	                                        ?>
										
										<div class="apply">
											<a style="cursor:pointer;" class="btn btn-info" data-toggle="modal" data-target="#myModal-apply<?php echo $ID; ?>">Apply</a>
										</div>
										<?php
										$author = get_the_author();
										
										?>
										
										<div id="myModal-apply<?php echo $ID; ?>" class="modal fade" role="dialog">
										  <div class="modal-dialog">
											<script>
												jQuery(document).ready(function(){
													<?php
													$user = wp_get_current_user();
													$email=$user->user_email;
													$first=$user->user_firstname;
													$last=$user->user_lastname;
													?>
													
													jQuery(".post-<?php echo $id ?> .recruiter-mail").val('<?php echo $user_email; ?>');
													jQuery(".post-<?php echo $id ?> .candidate-mail").val('<?php echo $email; ?>');
													jQuery(".post-<?php echo $id ?> .candidate-f").val('<?php echo $first; ?>');
													jQuery(".post-<?php echo $id ?> .candidate-l").val('<?php echo $last; ?>');
													
													jQuery(".post-<?php echo $id ?> .recruiter-f").val('<?php echo $user_firstname; ?>');
													jQuery(".post-<?php echo $id ?> .recruiter-l").val('<?php echo $user_lastname; ?>');
													
													jQuery(".recruiter-mail, .candidate-mail, .candidate-f, .candidate-l, .recruiter-f, .recruiter-l").hide();
													
												});
											</script>
											<!-- Modal content-->
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Apply For Job</h4>
											  </div>
											  <div class="modal-body">
												 <div class="panel-body">
												 
	                                                                                             <form action="<?php echo site_url(); ?>/candidate-dashboard/" method="post" enctype="multipart/form-data">
	                                                                                                 
	                                                                                                 <input type="hidden" name="candidate_id" value="<?php echo $user->ID; ?>" />
	                                                                                                 <input type="hidden" name="post_id" value="<?php echo $ID; ?>" />
	                                                                                                 <input type="hidden" name="recruiter_id" value="<?php echo $authid; ?>" />
	                                                                                                 <input type="hidden" name="refer_by_com" value="<?php echo $refer_by_com; ?>" />
																									 <input type="hidden" name="apply_job_title" value="<?php echo get_the_title(); ?>" />
	                                                                                                 
													 <label>Upload Resume</label>
													 <input type="file" name="resume" value="Upload Resume" required>
													
													 <!-- <label>Upload Cover Letter</label>
													 <input type="file" name="cover_letter" value="Upload Cover letter"> -->
	                                                                                                 
	                                                                                                 
	                                                                                                 <label>Note for Recruiter</label>
	                                                                                                 <textarea name="cover_letter" rows="5" required=""></textarea>
													
													 <input type="submit" name="submit_resume" value="Apply Now" class="btn btn-success">
	                                                                                                 
	                                                                                             </form>
													
													<!-- <div class="post-<?php //echo $id; ?>"><?php //echo do_shortcode('[contact-form-7 id="2744" title="Apply Job"]'); ?></div> -->
												</div>
											  </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											  </div>
											</div>

										  </div>
										</div>
										
	                                            <?php } else { ?>
	                                                <div class="apply">
	                                                        <a class="btn btn-success" href="javascript:void(0);">Applied</a>
	                                                </div>
	                                            <?php } ?>
										
										<button type="button" class="" data-toggle="modal" data-target="#myModal-refer-job<?php echo $ID; ?>">
											<i class="fa fa-random" aria-hidden="true"> </i> Refer To Candidate 
										</button>
	                                    <div id="myModal-refer-job<?php echo $ID; ?>" class="modal fade" role="dialog">
										  <div class="modal-dialog">

											<!-- Modal content-->
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Refer Job to Candidate</h4>
											  </div>
											  <div class="modal-body">
												 <div class="panel-body">
												 <!--<input type="text" value="<?php echo get_the_permalink(); ?>" class="myInput">
												<a href="javascript:void(0);" onclick="myFunction()" class="btn btn-success">COPY To CLIPBOARD</a>-->
								
													<form action="" method="post" style="margin-top:20px">
											
													<!--<select name="company">
													<?php 
													//$blogusers = get_users(array('role'=>'cs_candidate'));
													//foreach ( $blogusers as $user ) {
													?>
														<option name="<?php //echo $user->ID; ?>"><?php //echo esc_html( $user->display_name ); ?></option>
													<?php //} ?>
													</select>	-->											
													
													<input type="text" class="form-control" name="job_title" value="<?php echo get_the_title(); ?>" readonly="readonly" />
													<input type="text" required class="form-control" name="refer_name" placeholder="Refer Name" value=""  />
													<input type="email" required placeholder="Refer Email..." class="form-control" name="refer_email" value="" />

													<hr />
													<input type="hidden" name="refer_user_id" value="<?php echo get_current_user_id(); ?>" />
													<input type="hidden" name="refer_post_id" value="<?php echo get_the_ID(); ?>" />
													<input type="hidden" name="job_link" value="<?php echo get_the_permalink(); ?>" />
													<input type="submit" class="btn btn-success" name="refer_submit" value="Send" />
													</form>
												</div>
											  </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											  </div>
											</div>

										  </div>
										</div>

					
	                                    </div>
	                                    
	                                    <!--<span class="more">Show More...</span>-->
	                                </div>  
	                            </div>
	                        </div>
	                        <?php endwhile; ?>   
	                    </div>

					</div>
				</div>
            </div>
        </div>
    </section>
</div>
<div class="load_img"></div>
<?php } else { ?>
<?php wp_redirect( site_url() ); ?>
<?php } ?>
<script>
   function openCity(evt, cityName) {
       var i, tabcontent, tablinks;
       tabcontent = document.getElementsByClassName("tabcontent");
       for (i = 0; i < tabcontent.length; i++) {
           tabcontent[i].style.display = "none";
       }
       tablinks = document.getElementsByClassName("tablinks");
       for (i = 0; i < tablinks.length; i++) {
           tablinks[i].className = tablinks[i].className.replace(" active", "");
       }
       document.getElementById(cityName).style.display = "block";
       evt.currentTarget.className += " active";
   }
   
   // Get the element with id="defaultOpen" and click on it
   document.getElementById("defaultOpen").click();

   jQuery(document).ready(function() {

   var urll = location.protocol + "//" + location.host+'/staging';

	   
       jQuery("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
           e.preventDefault();
           jQuery(this).siblings('a.active').removeClass("active");
           jQuery(this).addClass("active");
           var index = jQuery(this).index();
           jQuery("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
           jQuery("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
       });
	   
	   // Skill Add Form
	   var arr = [];

	   jQuery('body').on('click','#skills_submit', function(){
		  var selet =  jQuery('#cs_specialisms :selected').map(function(i, el) {
		  arr[i++] = jQuery(el).val();
		  });
		// Ajax
		var li_data = '';
		var li_data_header = '';
		var ajax_data = '';
		var skildata = '';
		for(var i = 0; i < arr.length; i++){
			 skildata = arr[i].replace(/\-/g,' ');
			 li_data += '<li style="text-transform: capitalize;" >'+skildata+'</li>';
			 li_data_header += '<li class="col-md-6" style="text-transform: capitalize;">*'+skildata+'</li>';
			 if(arr.length - 1 == i){
				 ajax_data += arr[i];
			 }else{
				ajax_data += arr[i]+',';
			 }
		}

		jQuery('ul.skils').html(li_data);
		jQuery('ul.skils_header').html(li_data_header);
		jQuery('#myModal').modal('hide');
		var ajax_url = urll+'/wp-admin/admin-ajax.php/';
				jQuery.ajax({
					type: 'POST',
					url: ajax_url,
					data: {action:'candidate_skils',skils : ajax_data},
					success: function (responseData) {
					
				},
		});
		
		
	   });
	   
	   
	   // Experience Data Add
	   
	    jQuery('#date_end_select').change(function(){
			jQuery('#date_end').val('');
		});
	    jQuery('body').on('click','.experience_submit', function(){
		
alert(urll);
		
			var jp_title = jQuery('#jp_title').val();
			var cmp_name = jQuery('#cmp_name').val();
			var website_url = jQuery('#website_url').val();
			var date_start = jQuery('#date_start').val();
			var date_end = jQuery('#date_end').val();
			var job_decs = jQuery('#job_decs').html();
			//var cmp_logo = jQuery('#company_exp_logo').val();
			var exp_key = jQuery('#update_exp_keyy').val();
			var ul_id = jQuery('#update_exp_keyy').attr('rel');
			var exp_count = jQuery('.expmodal').attr('rel');
			var selectEnd = jQuery('#date_end_select').children("option:selected").val();
			if(selectEnd == 'Present'){
				date_end = selectEnd;
			}
			//var size  =  jQuery('#company_exp_logo')[0].files[0].size;
			//var tmp_name  =  jQuery('#company_exp_logo')[0].files[0].temp_name;

			var logo_src = '';
			logo_src = jQuery('#company_logo').val();
			
			if(jp_title == ''){
				alert('Please fill your position or job title');
			}else if(cmp_name == ''){
				alert('Please fill your employer or company name');
			}else if(website_url == ''){
				alert('Please fill company website url');
			}else if(date_start == ''){
				alert('Please select start job date');
			}else if(date_end == ''){
				alert('Please select end job date');
			}else if(job_decs == ''){
				alert('Please fill responsibilities or details');
			}else{
			
			jQuery('.load_img').html('<div class="load_img_wrap"><div class="load_img_subwrap"><img src="http://referlink.io/staging/wp-content/uploads/2018/08/load.gif" /><div style="text-align:center"></div></div></div>');
			
			var dummy_logo = "'https://referlink.io/staging/wp-content/uploads/2018/11/sponsorship-fpo.gif'";
			if(website_url){
			
				logo_src = "https://logo.clearbit.com/"+website_url;
				
				var onerror = 'onerror="this.onerror=null;this.src='+dummy_logo+'"';
			}

			var row_c_arr = 0;

			if(exp_key == 0 || exp_key == '0'){

				row_c_arr = exp_count;
			}else{

				var row_c = exp_key.split('_');
				row_c_arr = row_c[2];
			}


			job_decs=job_decs.replace(/\n/g,"<br>");	
			var li_exp = '<input type="hidden" class="update_exp_key" value="cs_experience_'+row_c_arr+'" /><div class="col-md-10 jb_details" style="padding:0px;"><div style="padding:0px;" class="col-md-2 company_logo_exp"><img class="company_logo" id="company_logo_'+row_c_arr+'" src="'+logo_src+'" '+onerror+' title="'+jp_title+'" rel="'+row_c_arr+'" style="width: 70px; height:70px;"><i class="icon-edit3 exp_logo"></i></div><div class="col-md-10 right_line jb_info"><div class="col-md-12 right_div jb_title"><span class="jb_title">'+jp_title+'</span></div><div class="col-md-12 right_div cmp_name">'+cmp_name+'</div><div class="col-md-12 right_div website_url">'+website_url+'</div><div class="col-md-12 right_div start_end"><span class="date_start">'+date_start+'</span> - <span class="date_end">'+date_end+'</span></div></div>	<div class="col-md-12 right_desc job_decs">'+job_decs+'</div></div><div class="col-md-2 right_div"><span class="badge badge_edit"><i class="icon-edit3"></i></span><span class="badge badge_remove"><i class="icon-trash"></i></span></div>';
		
			
			
			if(exp_key == 0 || exp_key == '0'){
				jQuery('.exp_list_ul').append('<div class="col-md-12 list_wrap" style="border: 1px solid #ccc; padding: 10px; margin-bottom:20px;" id="ul_'+row_c_arr+'">'+li_exp+'</div>');
	
			}else{
				jQuery('#ul_'+row_c_arr).html(li_exp);
			}
			
			jQuery('#expmyModal').modal('hide');

			var ajax_url = urll+'/wp-admin/admin-ajax.php/';
					jQuery.ajax({
						type: 'POST',
						url: ajax_url,
						data:  {action:'candidate_exp',jp_title : jp_title,cmp_name : cmp_name, website_url : website_url, date_start : date_start,date_end : date_end,job_decs : job_decs,exp_key : row_c_arr},
						success: function (responseData) {
						jQuery('.expmodal').attr('rel',responseData);
						jQuery('.load_img').html('');

jQuery('#jp_title').val('');
jQuery('#cmp_name').val('');
jQuery('#website_url').val('');
jQuery('#date_start').val('');
jQuery('#date_end').val('');
jQuery('#job_decs').val('');

						
					},
			}); 
			
			} // else end
		
		
		
	   });

	   // Experience Company Logo Add
	   
	   jQuery('body').on('click','.exp_logo', function(){
		   
		   var exp_title = 'Company Logo Photo';//jQuery(this).parent().children().attr('title');
		   var exp_src = jQuery(this).parent().children().attr('src');
		   var exp_key = jQuery(this).parent().children().attr('rel');
		   jQuery('.exp_logo_title').html(exp_title);
		   jQuery('#company_explogo_key').val(exp_key);
		   jQuery('#exp_logo_modal').modal('show');
	   });
	   // Experience Company Logo Add
	   
	   
	   
	   jQuery('body').on('click', '.user_img_submit',function(e){
			
			e.preventDefault();
			
			jQuery('.load_img').html('<div class="load_img_wrap"><div class="load_img_subwrap"><img src="http://referlink.io/staging/wp-content/uploads/2018/08/load.gif" /><div style="text-align:center"></div></div></div>');
			
			
			var file_data = jQuery('#company_explogo').prop('files')[0];
			var file_data_key	 = jQuery('#company_explogo_key').val();
			
			var form_data = new FormData();
			form_data.append('file', file_data);
			form_data.append('company_explogo_key', file_data_key);
			form_data.append('action', 'exp_upload_logo');  
			
			var ajax_url = urll+'/wp-admin/admin-ajax.php/';
			
				jQuery.ajax({
					type: 'POST',
					url: ajax_url,
					data: form_data,
					contentType: false,
                    processData: false,
					success: function (responseData) {
						var spt = responseData.split('msz');
						if(spt[0] != 'no'){
jQuery('#company_logo_'+spt[0]).attr('src',spt[1]);
jQuery('.load_img').html('');
 jQuery('#exp_logo_modal').modal('hide');
						}else{
							alert('Invalid File, Please try again!');
							jQuery('.load_img').html('');
						}
						
						

				},
			});
  
		}); 
		
	   // Update Experience 

		jQuery('body').on('click', '.right_div .badge_edit',function(){
			
		    var company_logo = jQuery(this).parent().parent().children('.jb_details').children('.company_logo_exp').children('.company_logo').attr('src');
		    var jp_title = jQuery(this).parent().parent().children('.jb_details').children('.jb_info').children('.jb_title').children().html();
			var cmp_name = jQuery(this).parent().parent().children('.jb_details').children('.jb_info').children('.cmp_name').html();
			var website_url = jQuery(this).parent().parent().children('.jb_details').children('.jb_info').children('.website_url').html();
			var date_start = jQuery(this).parent().parent().children('.jb_details').children('.jb_info').children('.start_end').children('.date_start').html();
			var date_end = jQuery(this).parent().parent().children('.jb_details').children('.jb_info').children('.start_end').children('.date_end').html();
			//var company_logo = jQuery(this).parent().parent().parent().children('.col-md-1').children().children().attr('src');
			var job_decs = jQuery(this).parent().parent().children('.jb_details').children('.job_decs').html();
			var exp_id = jQuery(this).parent().parent().children('.update_exp_key').val();
			var ul_id = jQuery(this).parent().parent().attr('id');
			
			if(date_end == 'Present'){
				date_end = '';
				jQuery('#date_end_select').val('Present');
			}else{
				jQuery('#date_end_select').val('-Select-');
			}
			job_decs = job_decs.replace(/\n/g,"");
			jQuery('#company_logo').val(company_logo);
			jQuery('#jp_title').val(jp_title);
			jQuery('#cmp_name').val(cmp_name);
			jQuery('#website_url').val(website_url);
			jQuery('#date_start').val(date_start);
			jQuery('#date_end').val(date_end);
			jQuery('#job_decs').html(job_decs);
			jQuery('#update_exp_keyy').val(exp_id);
			jQuery('#update_exp_keyy').attr('rel',ul_id);
			//jQuery('#company_exp_logo').val(company_logo);
			
		   jQuery('#expmyModal').modal('show');
	   });
	   
	   // Experience Data Remove
	   
	   jQuery('body').on('click', '.right_div .badge_remove',function(){
		   
		   jQuery('.load_img').html('<div class="load_img_wrap"><div class="load_img_subwrap"><img src="http://referlink.io/staging/wp-content/uploads/2018/08/load.gif" /><div style="text-align:center"></div></div></div>');
		   
			var exp_key = jQuery(this).parent().parent().children('.update_exp_key').val();
			
			var row_count = exp_key.split('_');
			
			var ajax_url = urll+'/wp-admin/admin-ajax.php/';
				jQuery.ajax({
					type: 'POST',
					url: ajax_url,
					data: {action:'candidate_exp_remove',exp_key : exp_key, row_count : row_count[2]},
					success: function (responseData) {
		jQuery('.load_img').html(' ');
					jQuery('#ul_'+responseData).css('display','none');
					
				},
			});
			
			
		
	
  
		}); 
	   
	   // Experiance modal close time
	   jQuery("#expmyModal").on("hidden.bs.modal", function () {
			jQuery('#jp_title').val('');
			jQuery('#cmp_name').val('');
			jQuery('#date_start').val('');
			jQuery('#date_end').val('');
			jQuery('#job_decs').val('');
			jQuery('#update_exp_keyy').val('0');
		});
	   
	   jQuery("body").delegate(".date_pic", "focusin", function(){
        jQuery(this).datepicker({ dateFormat: 'mm/yy' });
	   });

		
		
		// Respknsibility Add
		
		
		jQuery('#add_sign').click(function(){
		  jQuery('#resmyModal').modal('show');
	   });
	   
	   var res_add = '';
		jQuery('#respons_submit').click(function(){
		  var res =  jQuery('#responsibility_name').val();
		  var res_add = jQuery('#response_ul_input').val();
		  if(res_add != ''){
			res_add += ','+res+',';
		  }else{
			  res_add += res+',';
		  }

		  jQuery('.response_ul').prepend('<li>'+res+'</li>');
		  jQuery('#response_ul_input').val(res_add);
		  jQuery('#responsibility_name').val('');
		  jQuery('#resmyModal').modal('hide');
	   });
	   
	   
	   // Profile Submit
	   
	   jQuery('#profile_submit').click(function(){
		
			var check1 = jQuery('#exampleCheck1').attr("checked") ? 1 : 0;
			var field_select = jQuery('#cs_job_field_preferred option:selected').val();
			var position_select = jQuery('#cs_job_position_preferred option:selected').val();
			var response_ul_input = jQuery('#response_ul_input').val();
			var range_salary = jQuery('#range_salary').val();
			var miles = jQuery('#miles option:selected').val();
			var zipcode = jQuery('#zipcode').val();
			
			if(zipcode == ''){
				alert('Please fill your area zipcode');
			}else{
				
			jQuery('.load_img').html('<div class="load_img_wrap"><div class="load_img_subwrap"><img src="http://referlink.io/staging/wp-content/uploads/2018/08/load.gif" /><div style="text-align:center"></div></div></div>');
			
			var ajax_url = urll+'/wp-admin/admin-ajax.php/';
					jQuery.ajax({
						type: 'POST',
						url: ajax_url,
						data:  {action:'candidate_profile',check1 : check1,field_select : field_select,position_select : position_select,response_ul_input : response_ul_input,range_salary : range_salary,miles : miles, zipcode : zipcode},
						success: function (responseData) {
						jQuery('.expmodal').attr('rel',responseData);
						jQuery('.load_img').html('');
					},
			});
			
			} // else end
		
		
		
	   });
	   
	   jQuery('.view_message').click(function(){
		   var message = jQuery(this).parent().children('.div_message').html();
		   var subject = jQuery(this).parent().parent().children('.subject_txt').html();
		   
		   var message_id = jQuery(this).attr('data-id');
		   var message_type = jQuery(this).attr('data-type');

		   jQuery('.subject_title').html(subject);
		   jQuery('.message_content').html(message);
		   jQuery('#messagebox_modal').modal();
		   
		   if(message_type == 'inbox'){
		   jQuery(this).parent().parent().css('font-weight','normal');
		   var ajax_url = urll+'/wp-admin/admin-ajax.php/';
					jQuery.ajax({
						type: 'POST',
						url: ajax_url,
						data:  {action:'message_readable',message_id : message_id},
						success: function (responseData) {
						jQuery('.expmodal').attr('rel',responseData);
						jQuery('.load_img').html('');
					},
			});
		   }
			
	   });
	   
	   // Reply Module
	   
	   jQuery('.reply_message').click(function(){
		   

		   var subject = jQuery(this).parent().parent().children('.subject_txt').html();
		   var receviername = jQuery(this).parent().parent().children('.receivername').html();
		   var receiveremail = jQuery(this).parent().parent().children('.receiveremail').attr('rel');
		   var messageid = jQuery(this).attr('data-id');
		   var replyemail = jQuery(this).attr('data-email');
		   var receiverid = jQuery(this).attr('rel');
		   var title = 'Reply';

		   jQuery('.reply_title').html(title);
		   jQuery('#replyname').val(receviername);
		   jQuery('#replyreceiveremail').val(receiveremail);
		   jQuery('#replysubject').val(subject);
		   jQuery('#replyreceiverid').val(receiverid);
		   jQuery('#replymessageid').val(messageid);
		   jQuery('#replysenderemail').val(replyemail);


		   jQuery('#myModalreply').modal('show');

	   });
	   
	   jQuery('.delete_message').click(function(){
		   var messageid = jQuery(this).attr('data-id');
		   alert('Message Deleted');
		    var ajax_url = urll+'/wp-admin/admin-ajax.php/';
				jQuery.ajax({
					type: 'POST',
					url: ajax_url,
					data: {action:'message_trash', messageid : messageid},
					success: function (messageid) {
							var li_data = jQuery('#tr_'+messageid).html();
							var trash_data = jQuery('#trash_data').html();
							jQuery('#trash_data').html('<tr>'+li_data+'</tr>'+trash_data);
							jQuery('#tr_'+messageid).css('display','none');
							
						
					}
				});
		   
	   });
	   
	   jQuery('body').on('click','.replymessagesend',function(){
		   
		   var s_name = jQuery(this).parent().children().children('#replyname').val();
		   var s_email = jQuery(this).parent().children().children('#replyreceiveremail').val();
		   var s_subject = jQuery(this).parent().children().children('#replysubject').val();
		   var s_message = jQuery(this).parent().children().children('#replymessage').val();
		   var s_messageid = jQuery(this).parent().children('#replymessageid').val();
		   var s_id = jQuery(this).parent().children('#replyreceiverid').val();
		   var receiveremail = jQuery(this).parent().children().children('#replysenderemail').val();

		   
		   var ajax_url = urll+'/wp-admin/admin-ajax.php/';
				jQuery.ajax({
					type: 'POST',
					url: ajax_url,
					data: {action:'recuireter_message_candidate',name : s_name, email : s_email, subject : s_subject, message : s_message, receiver : s_id,receiveremail : receiveremail},
					success: function (responseData) {
						//jQuery('.load_img').html(' ');
						if(responseData == 'yes'){
							jQuery('#replyerrormessage').css('display','none');
							jQuery('#replysuccessmessage').css('display','block');
							
						}else{
							jQuery('#replysuccessmessage').css('display','none');
							jQuery('#replyerrormessage').css('display','block');
						}
					},
				});
			
	   });

	   
	   
   jQuery(".more_decs").click(function(){
      jQuery(this).parent().parent().children('.inner_decs').show();
      jQuery(this).parent('.outer_decs').hide();
      //jQuery('.active-show .more-prt').show();
   });
    jQuery(".more_decs_less").click(function(){
      jQuery(this).parent().parent().parent().parent().children('.outer_decs').show();
      jQuery(this).parent().parent().parent('.inner_decs').hide();
   });
   
var html_srch = jQuery('.sf-field-search').html();
jQuery('.sf-field-search').html('<h4>Search</h4>'+html_srch);
jQuery('.sf-field-taxonomy-specialisms .sf-input-select option.sf-item-0').text('Specialty');


	   
		
//jQuery("#ex2").slider();
		
jQuery('.candidate_switch .slider').click(function(){
var triger_rel = jQuery(this).attr('rel');

if(triger_rel == 'active'){
triger_rel = 'inactive';
jQuery('.slider.round').html('<strong style="margin: 5px 12px; display:block; text-align:right;">Inactive</strong>');
jQuery('.candidate_switch_rec').html('<input type="checkbox"><span rel="inactive" class="slider round"><strong style="margin: 5px 12px; display:block; color:#fff; text-align:right;">Inactive</strong></span>');
jQuery('.q_active_mark').html('Recruiters know not to reach out to you');
}else{
triger_rel = 'active';
jQuery('.slider.round').html('<strong style="margin: 5px 12px; display:inline-block;">Active</strong>');
jQuery('.candidate_switch_rec').html('<input type="checkbox" checked="checked"><span rel="active" class="slider round"><strong style="margin: 5px 12px; display:inline-block; color:#fff;">Active</strong></span>');
jQuery('.q_active_mark').html('Recruiters will know to reach out to you');
}
jQuery(this).attr('rel',triger_rel);


jQuery('.load_img').html('<div class="load_img_wrap"><div class="load_img_subwrap"><img src="'+urll+'/wp-content/uploads/2018/08/load.gif" /><div style="text-align:center"></div></div></div>');

var ajax_url = urll+'/wp-admin/admin-ajax.php/';
jQuery.ajax({
	type: 'POST',
	url: ajax_url,
	data: {action:'candidate_mode',triger_rel : triger_rel},
	success: function (responseData) {
		jQuery('.load_img').html(' ');
		
	},
});
				
});

// Hints candidates hover
jQuery(".active_q_icon").hover(function(){
    jQuery('.q_active_mark').show();
    }, function(){
    jQuery('.q_active_mark').hide();
});

}); // ready function end
   
   
jQuery('.candidate_datatype').DataTable({
			"order": false
		});
function myFunction() {
  /* Get the text field */
  var copyText = jQuery(".myInput");

  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the Job Link");
}
</script>
<style>
.less_cnt {font-size:13px !important;}
.less_cnt p {font-size:13px !important;}
#cs_specialisms_chosen ul li input.default{width:100% !important;} 
.candidate-dash-area{
    font-family: "Montserrat", sans-serif !important;
	font-size: 14px;
}
.main-section .managers p{
	font-family: "Montserrat", sans-serif !important;
}


</style>
<?php get_footer(); ?>