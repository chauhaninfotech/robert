<?php
	/*
	  Template Name: Receuiter Dashboard
	 */
	get_header();

	?>
<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/optionalStyling.css">
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/dataTables.jqueryui.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/jquery-ui.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/dataTables.jqueryui.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/jquery.dataTables.min.js"></script>
<?php $user = wp_get_current_user(); ?>
<?php
	//print_r($user)
	if ( in_array( 'recruiter', (array) $user->roles ) ) {
		
	$current_role = ($user->roles[0]) ? $user->roles[0] : $user->roles;
$message = '';
if(isset($_POST['post_a_job'])){
	
	$title_name = $_POST['title_name'];
	$exprience_job_post = $_POST['exprience_job_post'];
	$remote_job = $_POST['remote_job'];
	$level_excel = $_POST['level_excel'];
	$job_type = $_POST['job_type'];
	$experience_finance = $_POST['experience_finance'];
	$location = $_POST['location'];
	$salary = $_POST['salary'];
	$description = $_POST['description'];
	$user_role = $_POST['user_role'];
	$author_id = $user->ID;
	
	
// Create job post
$my_post = array(
  'post_title'    => wp_strip_all_tags($title_name),
  'post_content'  => $description,
  'post_status'   => 'publish',
  'post_author'   => $author_id	,
  'post_type'   => 'jobs',
  'job_type' => $job_type,
  'cs_locations' => $location,
  'experience_finance' => $experience_finance,
);
 
// Insert the post into the database
$post_id = wp_insert_post( $my_post);

update_post_meta($post_id,'job_type_post',$exprience_job_post);
update_post_meta($post_id,'job_type',$job_type);
update_post_meta($post_id,'remote_copy',$remote_job);
update_post_meta($post_id,'offering_visa_sponsorship',$level_excel);
update_post_meta($post_id,'work_experience',$experience_finance);
update_post_meta($post_id,'salary',$salary);
update_post_meta($post_id,'user_role',$user_role);

$message = '<p style="color:#ff0000; font-size: 16px; font-weight: bold;">Your job post successfully created.</p>';

}
	?>
<div class="main-section1">
	<section class="page-section">
<?php
$defaultopen1 = ''; $defaultopen2 = ''; $defaultopen3 = ''; $defaultopen = '';
$message_refresh = base64_decode($_REQUEST['message_refresh']);
$search_filter = $_REQUEST['search_filter_data'];
$job_post = $_POST['post_a_job'];
if($search_filter == 'yes'){
		$defaultopen1 = 'defaultOpen';
}else if($message_refresh == 'message_inbox'){
		$defaultopen2 = 'defaultOpen';
}else if($job_post == 'Submit'){
		$defaultopen3 = 'defaultOpen';
}else{
	$defaultopen = 'defaultOpen';
}
?>
		<div class="container-fluid post-details candidate-dash-area">
			<div class="row">
				<div class="col-md-12 tab-container">
					<div class="tab-inner-container">	
						<div class="tab">
						<?php $useridd = get_current_user_id(); ?>
							<button class="tablinks" id="<?php echo $defaultopen; ?>" onclick="openCity(event, 'India')">Profile</button>
							<button class="tablinks" id="<?php echo $defaultopen1; ?>" onclick="openCity(event, 'London')">Candidates</button>
							<!--<button class="tablinks" onclick="openCity(event, 'Paris')">Jobs</button>-->
							<button class="tablinks" id="<?php echo $defaultopen3; ?>" onclick="openCity(event, 'Japan')">Post a Job</button>
							<a target="_blank" style="text-decoration: none;padding:0px;" href="<?php echo site_url(); ?>/candidates-tracker"><button class="tablinks">Candidate Tracker</button></a>
							<a target="_blank" style="text-decoration: none;padding:0px;" href="<?php echo site_url(); ?>/company-jobs/?action=jobs&rec_id=<?php echo base64_encode($useridd); ?>"><button class="tablinks">Jobs Posted</button></a>
							<button class="tablinks" onclick="openCity(event, 'Tokyo')" id="<?php echo $defaultopen2; ?>">Messages</button>
						</div>
						<div class="container" style="background: #fff;margin: 0px;">
							<div id="London" class="tabcontent">
								<div class="candidate-search col-md-12">
									<form method="post" action="<?php echo site_url();?>/recruiter-dashboard/" class="clearfix">
										<div style="padding-left:0px;" class="srch_res col-md-4"><h4>Candidate Search</h4><input type="text" name="search_filter_name" value="<?php echo $_POST['search_filter_name']; ?>" placeholder="Candidate First Name"/></div>
										<div class="srch_res col-md-3"><h4>Neighborhoods</h4><?php $filter_location = $_POST['location']; echo do_shortcode('[custom_texnomoy_location selected="'.$filter_location.'"]'); ?></div>
										<div class="srch_res col-md-3"><h4>Candidate Type</h4>
											<select name="candidate_type">
												<option value="">--All--</option>
												<option <?php if($_POST['candidate_type'] == 'back-end_candidate'){ echo 'selected="selected"'; } ?> value="back-end_candidate">Back-end</option>
												<option <?php if($_POST['candidate_type'] == 'front-end_candidate'){ echo 'selected="selected"'; } ?> value="front-end_candidate">Front-end</option>
												<option <?php if($_POST['candidate_type'] == 'hybrid_candidate'){ echo 'selected="selected"'; } ?> value="hybrid_candidate">Hybrid</option>
											</select>
										</div>
										<input type="hidden" name="search_filter_data" value="yes" />
										<div class="col-md-2 srch_res"><button type="submit" class="btn btn-info btn-md" name="filter_submit" style="margin-top:25px; padding: 12px 35px;">Search</button></div>
									</form>
								</div>
								<?php 
if(isset($_REQUEST['filter_submit'])){
	$fname = $_REQUEST['search_filter_name'];
	//$field = $_REQUEST['job_field_preferred'];
	$location = $_REQUEST['location'];
	$candidate_type = $_REQUEST['candidate_type'];
	
	if($fname != '' || $location != '' || $candidate_type != ''){
		$condi = 'AND';
		if($fname != '' && $location != '' && $candidate_type != ''){
		
			$args = array('role__in'     => array('cs_candidate'),'meta_query' =>  array('relation' => $condi,array('key'     => 'first_name','value'   => $fname,'compare' =>  '=',),array('key'     => 'location','value'=> $location,'compare' =>  '=', ),array('key'     => 'prefer_job','value'     => $candidate_type,'compare' =>  '=',),array('key'     => 'candidate_mode','value'     => 'active','compare' =>  '=',)));
			
		}else if($fname != '' && $location != ''){
			
			$args = array('role__in'     => array('cs_candidate'),'meta_query' =>  array('relation' => $condi,array('key'     => 'first_name','value'   => $fname,'compare' =>  '=',),array('key'     => 'location','value' => $location,'compare' =>  '=', ),array('key'     => 'candidate_mode','value'     => 'active','compare' =>  '=',)));
			
		}else if($fname != '' && $candidate_type != ''){
			
			$args = array('role__in'     => array('cs_candidate'),'meta_query' =>  array('relation' => $condi, array('key'     => 'location','value'=> $location,'compare' =>  '=', ),array('key'     => 'prefer_job','value'     => $candidate_type,'compare' =>  '=',),array('key'     => 'candidate_mode','value'     => 'active','compare' =>  '=',)));
			
		}else if($location != '' && $candidate_type != ''){
			
			$args = array('role__in'     => array('cs_candidate'),'meta_query' =>  array('relation' => $condi,array('key'     => 'location','value'=> $location,'compare' =>  '=', ),array('key'     => 'prefer_job','value'     => $candidate_type,'compare' =>  '=',),array('key'     => 'candidate_mode','value'     => 'active','compare' =>  '=',)));
			
		}else{
			
			$keyy = ''; $valuue = '';
			if($fname != ''){ $keyy = 'first_name'; $value =  $fname; }else if($candidate_type != ''){ $keyy = 'prefer_job'; $value =  $candidate_type; }else{ $keyy = 'location'; $value =  $location; }
			
			$args = array('role__in' => array('cs_candidate'),'meta_query' =>  array('relation' => $condi, array('key'=> $keyy,'value'=> $value,'compare' =>  '=', ),array('key'     => 'candidate_mode','value'     => 'active','compare' =>  '=',)));
		}
	}else{
		
		$args = array('role__in' => array('cs_candidate'),'meta_query' =>  array('relation' => 'AND', array('key'=> 'candidate_mode','value'=> 'active','compare' =>  '=' )));
	}
}else{
	
	$args = array('role__in' => array('cs_candidate'),'meta_query' =>  array('relation' => 'AND', array('key'=> 'candidate_mode','value'=> 'active','compare' =>  '=' )));
}

$blogusers = get_users($args);
					  // Array of WP_User objects.
	global $wpdb;
					  $i = 0;
	$current_user = wp_get_current_user();
	$recruiter_email = $current_user->user_email;
	$recruiter_name = $current_user->user_firstname .' '.$current_user->user_lastname;
	$inbox_noti = inbox_notification_count($current_user->ID);

foreach($blogusers as $user)
{
	$cs_get_edu_list = get_user_meta($user->ID, 'cs_edu_list_array', true);
	$cs_edu_titles = get_user_meta($user->ID, 'cs_edu_title_array', true);
	$cs_edu_from_dates = get_user_meta($user->ID, 'cs_edu_from_date_array', true);
	$cs_edu_to_dates = get_user_meta($user->ID, 'cs_edu_to_date_array', true);
	$cs_edu_institutes = get_user_meta($user->ID, 'cs_edu_institute_array', true);
	$candidate_mode = get_user_meta($user->ID, 'candidate_mode', true);
	$cs_edu_descs = get_user_meta($user->ID, 'cs_edu_desc_array', true);
	$cs_edu_title = get_user_meta($user->ID, 'cs_job_title', true);
	$cs_re_desc = get_user_meta($user->ID, 'description', true);
	$location = get_user_meta($user->ID, 'location', true);
	$position_candi = get_user_meta($user->ID, 'url', true);
	
	$candidate_type = get_user_meta($user->ID, 'prefer_job', true);
	$experience_level = get_user_meta($user->ID, 'experience_level', true);
	$specialisms = get_user_meta($user->ID,'cs_specialisms',true); 
	$experience_cnt = get_user_meta($user->ID,'experience_count', true ); 
	$experience_count = ($experience_cnt) ? $experience_cnt : 0;
	$user_info = get_userdata($user->ID);
	$fname = get_user_meta($user->ID,'first_name',true);
	$lname = get_user_meta($user->ID,'last_name',true);
	 $receiveremail = $user_info->user_email;
	 $display_name = $user_info->display_name;
	$name = $fname.' '.$lname;
	$candidate_name_list = ($name) ? $name : $display_name;
	//$user_login = get_user_meta(, 'user_login', true);
	
	$cs_id1 = get_user_meta($user->ID, 'user_img', true);
	$logerImg = wp_get_attachment_image($cs_id1,'thumbnail');
	$finance_exp = get_user_meta( $user->ID, 'what_area_of_finance_is_your_experience_in_', true);
	
	
	$experience_level2 = (!empty($experience_level)) ? ucwords(str_replace('_',' ',$experience_level)) : '';
	$finance_experience1 = (!empty($finance_exp)) ? str_replace('_',' ',$finance_exp) : '';
	$finance_ex = explode('|',$finance_experience1);
	unset($exvalu);
	foreach($finance_ex as $exval){ 
	
if(trim($exval) == 'fp&a'){
					$exvalu[] = 'FP&A';
				}else if(trim($exval) == 'i-banking'){
					$exvalu[] = 'I-Banking';
				}else{
					$exvalu[] = ucwords($exval);
				}

	}
	$finance_experience = implode(', ',$exvalu);
	$tech = get_user_meta( $user->ID, 'how_familiar_are_you_with_excel_', true);	
	
if($tech == '_can_understand/maintain_models_through_excel,_pulling_data_through_systems'){
$medal_type_t = 'Beginner';
}else if($tech == 'can_build_models_through_excel,_strong_understanding_of_databases'){
$medal_type_t = 'Intermediate';
}else if($tech == 'can_build_complex_models_leveraging_vba_for_automation_&_visualization'){
$medal_type_t = 'Advanced';
}
$prefer_candiadtes = (!empty($candidate_type)) ? ucwords(str_replace('_',' ',$candidate_type)) : '';
if($candidate_type == 'back-end_candidate'){ $prefer_icon = '036-graph-analysis.png';}else if($candidate_type == 'hybrid_candidate'){ $prefer_icon = '037-business-agreement.png';}else if($candidate_type == 'front-end_candidate'){$prefer_icon = '030-business-presentation.png';}else{ $prefer_icon = '';}
																					
?>
								<div class="col-md-12 can-post bg-inherit">
									<div class="listing-wrap clearfix">
										<div class="col-md-9 info_profile">
											<div class="col-md-4">
											<div style="cursor:pointer; text-align: center;" data-toggle="modal" data-target="#myModal-glance<?php echo $user->ID; ?>"><?php echo candidate_logo_api($user->ID); ?>
											
												<h5 style="text-transform: capitalize !important; margin-top: 5px !important;" class="username-title"><?php echo $candidate_name_list; ?><span><?php echo ($cs_edu_title) ? ' - '.$cs_edu_title : ''; ?></span></h5>
											</div>
											<!-- Modal content-->
											<div id="myModal-glance<?php echo $user->ID; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog candidate_modal_req">													
													<div class="modal-body">
														<div class="panel-body" style="padding:0px;">
															<div class="col-md-12 col-lg-12 can-post" style="background: #999;">
																<div class="loger_herder">

			<div class="col-md-12 top_header_2">
				<div class="switch_div" style="pointer-events:none;">
					<label class="candidate_switch switch">
					<?php if($candidate_mode == '' || $candidate_mode == 'inactive'){ $mode = 'inactive'; ?>
					  <input type="checkbox">
<span rel="<?php echo $mode; ?>" class="slider round"><strong style="margin: 5px 12px; display:block; text-align:right; color:#fff;">Inactive</strong></span>
					  <?php }else{ $mode = 'active'; ?>
					  <input checked="checked" type="checkbox">
<span rel="<?php echo $mode; ?>" class="slider round"><strong style="margin: 5px 12px;display: inline-block; color:#fff;">Active</strong></span>
					  <?php } ?>
					  
					</label>
				</div>
				<div class="send_message_wrap"data-toggle="modal" data-target="#myModalmessage<?php echo $user->ID; ?>"><img class="icons_img" src="<?php echo get_stylesheet_directory_uri(); ?>/icons/033-email.png" width="30">Send Message</div>
			</div>
			<div class="col-md-12" style="margin-bottom:20px;">
            	<div class="loger_img">
                <?php if ($logerImg) {
						echo $logerImg;
					  } else { 
						echo '<img src="'.site_url().'/wp-content/uploads/2018/06/dummy.png" id="cs_user_img_img" width="150" alt="" />';
					  }
				?>
                </div><div class="clearfix"></div>
				<div class="loger_info">
<p style="font-size: 18px !important; line-height: 18px !important; margin-bottom:5px !important; color:#fff !important;"><?php echo $candidate_name_list; ?></p>
			
		
				<p style="color:#fff !important; font-size: 16px !important; margin-top: 12px !important; margin-bottom: 9px !important; line-height: 20px !important;"><i class="icon-location6" style="margin-right: 2px;"></i><?php echo ucwords(str_replace('-',' ',$location)); ?></p>

			<?php if(!empty($position_candi)){ ?>
				<p style="color:#fff !important; font-size: 16px !important; line-height: 12px !important; margin-bottom: 4px !important;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/019-briefcase.png" width="20" style="margin-right: 5px;"><?php  echo $position_candi;   ?></p>
				<?php } ?>

				<p style="color:#fff !important; font-size: 16px !important; line-height: 20px !important; margin-bottom: 4px !important;"><strong><?php echo $cs_re_desc; ?></strong><br></p>
                
                </div>
				
				</div>
				
				<div class="clearfix"></div><br>
				<div class="loger_info_wrap">					
					<div class="col-md-12" style="padding-left:0px; margin-bottom:10px;"><img class="icons_img" src="<?php echo get_stylesheet_directory_uri(); ?>/icons/<?php echo $prefer_icon; ?>" width="40" /> Prefers a <?php  echo str_replace('Candidate','',$prefer_candiadtes);?> Role</div>
					
					
					<div class="col-md-12" style="padding-left: 0px; margin-bottom:10px;"><img class="icons_img" src="<?php echo get_stylesheet_directory_uri(); ?>/icons/028-table.png" width="40" /> Excel: <?php echo $medal_type_t; ?></div>
					
					<div class="col-md-12" style="padding-left: 0px; margin-bottom:10px;"><img class="icons_img" src="<?php echo get_stylesheet_directory_uri(); ?>/icons/035-bar-chart-2.png" width="40" /> Experience Level: <?php echo $experience_level2; ?></div>
				</div>
				<div class="clearfix"></div>
				<hr>
				<div class="loger_info_wrap">
				<div class="col-md-12" style="margin-bottom: 20px;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icons/029-stats.png" class="icons_img" width="40" /> <strong>Type of Finance Experience:</strong><ul class="skils_header col-md-12" style="margin-left: 12px;"><li 
				="col-md-12" style="margin-left: 46px;"><?php echo $finance_experience; ?></li></ul></div>
					<div class="col-md-12"><img class="icons_img" src="<?php echo get_stylesheet_directory_uri(); ?>/icons/032-calculator.png" width="40" /> <strong>Financial Systems &amp; Data Tools:</strong><?php if($specialisms != "") { ?>
								<ul class="skils_header col-md-12" style="margin-top: 10px;margin-left: 43px;">
									<?php foreach($specialisms as $special2) { $special_tags2 = get_term_by( 'slug', $special2, 'specialisms' ); ?>
									<li class="col-md-6">*<?php echo $special_tags2->name; ?></li>
									<?php } ?>
								</ul>
								<?php } else { ?>
								<p style="color:#ffffff;font-size: 12px !important;margin-left: 60px;">There is no record in Skills list</p>
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
											</div>
											<div class="col-md-8">
												<div class="summery candidate_info">
													<p><strong>Current Role & Company : </strong><?php echo ucwords($position_candi); ?></p>
													<p><strong>Neighborhood : </strong><?php echo ucwords(str_replace('-',' ',$location)); ?></p>
													<p><strong>Type of Finance Experience : </strong><?php echo $finance_experience; ?></p>
													<p><strong>Experience Level : </strong><?php echo $experience_level2; ?></p>
													<p><strong>Prefers</strong> a <?php  echo ucwords(str_replace('Candidate','',$prefer_candiadtes));?> role</p>
													<p><strong>Excel  : </strong><?php echo $medal_type_t; ?></p>
												</div>											
											</div>
										</div>
										<div class="col-md-3 col-lg-3">
												
											<!--<div class="refer">
												<button type="button" class="" data-toggle="modal" data-target="#myModal-refer<?php //echo $user->ID; ?>"><i class="fa fa-random" aria-hidden="true"></i> Refer This Candidate </button>
												<div id="myModal-refer<?php //echo $user->ID; ?>" class="modal fade" role="dialog">
													<div class="modal-dialog">
														
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Refer Candidate to Company</h4>
															</div>
															<div class="modal-body">
																<div class="panel-body">
																	<form action="#">
																		<label>Select Company</label>
																		<select name="company">
																			<?php 
																				//$comapnyusers = get_users(array('role'=>'um_company'));
																				//foreach ( $comapnyusers as $c_user ) {
																				?>
																			<option name="<?php //echo $c_user->ID; ?>"><?php //echo esc_html( $c_user->display_name ); ?></option>
																			<?php //} ?>
																		</select>
																		<label>Candidate</label>
																		<input type="text" class="form-control" value="<?php //echo esc_html($c_user->display_name); ?>" disabled/>
																		<label>Additional Information : </label>
																		<textarea rows="9" class="form-control"></textarea>
																		<hr />
																		<a href="#" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span>Refer</a>&nbsp;
																	</form>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</div>
											</div>-->
											<div class="message-btn">
												<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModalmessage<?php echo $user->ID; ?>">Send a Message</button>
												<div id="myModalmessage<?php echo $user->ID; ?>" rel="<?php echo $user->ID; ?>" class="modal fade myModalmessage" role="dialog">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Send a Message to <?php echo $candidate_name_list; ?></h4>
															</div>
															<div class="modal-body">
																<div class="panel-body">
																	<form role="form" method="post" id="message_form" >
																		<div class="form-group">
																			<label for="name">Name:</label>
																			<input type="text" class="form-control"
																				id="name" name="name" value="<?php echo $candidate_name_list; ?>" readonly="readonly" required maxlength="50">
																		</div>
																		<div class="form-group">
																			
																			<input type="hidden" class="form-control" id="receiveremail" name="receiveremail" value="<?php echo $receiveremail; ?>" readonly="readonly" required maxlength="50">
																			<input type="hidden" class="form-control" id="email" name="email" value="<?php echo $recruiter_email; ?>" readonly="readonly" required maxlength="50">
																		</div>
																		<div class="form-group">
																			<label for="name">Subject:</label>
																			<input type="text" class="form-control"
																				id="subject" name="subject" required maxlength="50">
																		</div>
																		<div class="form-group">
																			<label for="name">
																			Message:</label>
																			<textarea style="height: 100px;" class="form-control" required type="textarea" name="message"
																				id="message" placeholder="Your Message Here"
																				maxlength="6000" rows="7"></textarea>
																		</div>
																		<input type="hidden" name="candidate_id" id="candidate_id" value="<?php  echo $user->ID; ?>" />
																		<button type="button"  style="margin: 0 auto; width: 200px;" class="btn btn-lg btn-notification btn-block message_send" id="btnContactUs">Send</button>
																	</form>
																	<div id="success_message<?php  echo $user->ID; ?>" style="width:100%; text-align:center; margin-top:20px; height:100%; display:none; ">
																		<h3 style="color:green !important;">Sent your message successfully!</h3>
																	</div>
																	<div id="error_message<?php  echo $user->ID; ?>"
																		style="width:100%; height:100%; margin-top:20px; text-align:center;  display:none; ">
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
											</div>
											<!--<span class="more">Show More</span>-->
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<?php
									$i++;
								}
									if($i== 0){
										echo '<div class="col-md-12 can-post bg-inherit"><div class="listing-wrap clearfix"><p style="padding-left:10px;">No Record Found!</p></div></div>';
									}
									?>             
							</div>
							<div class="clearfix"></div>
							<div id="Paris" class="tabcontent">
								<?php
									$query = array(
									'post_type' => 'jobs',
									'meta_key' => 'cs_job_status',
									'meta_value' => 'active'
									);
									$loop = new WP_Query($query);
									while ($loop->have_posts()):
									$loop->the_post();
									$ID = get_the_ID();
									?>
								<div class="col-md-12 col-lg-12 can-post job-list bg-inherit">
									<div class="listing-wrap clearfix">
										<div class="col-md-8 col-lg-8">
											<h2><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
											- <span><?php echo get_post_meta($ID, 'cs_company_name', true); ?></span>
											<div class="summery">
												<span>Job Description</span>
												<?php
													$content = apply_filters('the_content', get_the_content());
													$text = substr($content, 0, strpos($content, '</p>') + 4);
													echo $text = preg_replace("/<img[^>]+\>/i", "", $text);
													?>
											</div>
											
										</div>
										<div class="col-md-4 col-lg-4">
											<div class="refer">
												<button type="button" class="" data-toggle="modal" data-target="#myModal-refer-job"><i class="fa fa-random" aria-hidden="true"> </i> Refer To Candidate </button>
												<div id="myModal-refer-job" class="modal fade" role="dialog">
													<div class="modal-dialog">
														<!-- Modal content-->
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Refer Job to Candidate</h4>
															</div>
															<div class="modal-body">
																<div class="panel-body">
																	<form action="#">
																		<label>Select Candidate</label>
																		<select name="company">
																			<?php 
																				$blogusers = get_users(array('role'=>'cs_candidate'));
																				foreach ( $blogusers as $user ) {
																				?>
																			<option name="<?php echo $user->ID; ?>"><?php echo esc_html( $user->display_name ); ?></option>
																			<?php } ?>
																		</select>
																		<label>Job</label>
																		<input type="text" class="form-control" value="<?php echo get_the_title(); ?>" disabled/>
																		<label>Additional Information : </label>
																		<textarea rows="9" class="form-control"></textarea>
																		<hr />
																		<a href="#" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span>Refer</a>&nbsp;
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
											<!--<div class="refer">
												<div class="linkedin"><a href="http://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i> Linkedin </a></div>
											</div>-->
											<span class="more">Show More...</span>
										</div>
									</div>
								</div>
								<?php endwhile; ?>   
							</div>
							<div id="India" class="tabcontent">
							
								<?php
								$logo_r = '';	
	                    		$logerId  =  get_current_user_id();
	                    		$logerData = get_userdata($logerId);
	                    		$logerDescription = $logerData->description;
	                    		$logerImg = get_user_meta($logerId, 'user_avatar', true);
	                    		$refer_by_com = get_user_meta($logerId, 'refer_by_com', true);
	                    		$department = get_user_meta($logerId, 'department', true);
	                    		$position_rec = get_user_meta($logerId, 'position_rec', true);
	                    		$fname = get_user_meta($logerId, 'first_name', true);
	                    		$lname = get_user_meta($logerId, 'last_name', true);
							
	                    		$logerName = $fname.' '.$lname;
	                    		$logerEmail = $logerId->user_email;

	                    			
	                    		
								
								if ( $logerImg != '' ) {
									$logo_r = '<img src="'.esc_url($logerImg).'" style="width: 100%; border-radius: 10px;" alt="'.$logerName.'" />';
								}else{
									$logo_r = '<img src="'.site_url().'//wp-content/uploads/2018/06/dummy.png" style="width: 100%; border-radius: 10px;" alt="'.$logerName.'" />';
								}
								
								?>
								<div class="col-md-12">
									<h1 class="section-title-profile h1">Profile</h1>
									<div class="row">
										<div class="col-md-3">
											<div class="profile-img">
												<?php echo $logo_r; ?>
												<i style="cursor:pointer;" class="icon-camera6 exp_logo"></i></i>
											</div>
										</div>
										<div class="col-md-8 info_profile_personal">
											<div class="profile-head">
														<h5><?php echo $logerName; ?></h5>
														<p class="proile-rating"><b>Company : </b><span><?php echo $refer_by_com; ?></span></p>
														<p class="proile-rating"><b>Recruiting : </b><span><?php echo ucfirst($department); ?></span></p>
														<p class="proile-rating"><b>Position : </b><span><?php echo $position_rec; ?></span></p>
														<p class="proile-rating"><b>Bio : </b><span><?php echo nl2br($logerDescription); ?></span></p>
											</div>
										</div>
										<div class="col-md-1"><i style="cursor:pointer;" class="icon-edit3 exp_profile"></i></div>
									</div>	
								</div>
			
			<!-- Modal content Logo-->
			<div id="exp_logo_modal" class="modal fade" role="dialog" aria-hidden="true" style="display: none;">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h4 class="modal-title exp_logo_title">Profile Photo</h4>
					  </div>
					  <div class="modal-body">
						
						<form action="<?php echo site_url();?>/recruiter-dashboard/" method="post" id="exp_logo_form" enctype="multipart/form-data">
							<div class="cs-img-detail">

								<div class="upload-btn-div">

									<div class="fileUpload uplaod-btn btn cs-color csborder-color" style="width:100%;">
										<input type="file" required="" id="company_explogo" name="company_explogo" style="width:100%;">
										<input type="button" class="user_img_submit acc-submit cs-section-update cs-bgcolor csborder-color cs-color" name="submit" value="Upload Photo">				

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
	
	<!-- edit profile-->
			<div id="expmyModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update Profile</h4>
			  </div>
			  <div class="modal-body">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name" value="<?php echo $fname; ?>" >
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name" value="<?php echo $lname; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="company_name" readonly="readonly" id="company_name" class="form-control input-sm" value="<?php echo $refer_by_com; ?>">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<select name="department" id="department">
								<option value="">---Select---</option>
								<option <?php if($department == 'finance'){ echo 'selected="selected"'; } ?> value="finance">Finance</option>
								<option <?php if($department == 'recruiter'){ echo 'selected="selected"'; } ?> value="recruiter">Recruiter</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12 col-sm-12 col-md-12">
							<input type="text" name="position_rec" id="position_rec" class="form-control input-sm" Placeholder="Company Position..." value="<?php echo $position_rec; ?>">
					</div>
				</div>
				<div class="form-group">
					<textarea name="job_decs" id="job_decs" placeholder="Bio..." ><?php echo strip_tags($logerDescription); ?></textarea>
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
	
							</div>
							
							<div id="Tokyo" class="tabcontent">
								<section id="tabs">
									<div class="col-md-12 ">
										<h1 class="section-title-profile h1">Messages</h1>
										<div class="row">
											<div class="col-md-12 ">
												<nav>
													<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
														<a class="nav-item nav-link" id="inbox" data-toggle="tab" href="#nav-inbox" role="tab" aria-controls="nav-profile" aria-selected="false">Inbox<span class="count_noti"><?php echo $inbox_noti; ?></span></a>
														<a class="nav-item nav-link" id="sent" data-toggle="tab" href="#nav-sent" role="tab" aria-controls="nav-contact" aria-selected="false">Sent</a>
														<a class="nav-item nav-link" id="trash" data-toggle="tab" href="#nav-trash" role="tab" aria-controls="nav-about" aria-selected="false">Trash</a>
														<!--<a style="float:right;" class="nav-item nav-link" id="new-message" data-toggle="tab" href="#nav-newmessage" role="tab" aria-controls="nav-home" aria-selected="true">Compose</a>-->
													</div>
												</nav>
												<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
													<div class="tab-pane fade active in" id="nav-inbox" role="tabpanel" aria-labelledby="inbox">
														<h3 style="text-align: center;">Inbox<a href="<?php echo site_url(); ?>/recruiter-dashboard/?message_refresh=<?php echo base64_encode('message_inbox'); ?>" style="float: right;"><img src="<?php echo site_url(); ?>/wp-content/uploads/2018/12/refresh-150x150.png" style="width: 25px;"></a></h3>
														<table id="message_datatype_inbox" class=" message_datatype table table-striped table-bordered" style="width:100%">
															<thead>
																<tr>
																	<th>Date</th>
																	<th>Candidate Name</th>
																	<th>Candidate message</th>
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
																				// $senderemail = $sender_info->user_email;
																				$display_name = $sender_info->display_name;
																				$name = $fname.' '.$lname;
																				$sender_name_list = ($name) ? $name : $display_name;
																				$readable = ($result->status == 1) ? 'unread' : 'read';	
																				//echo '<tr class="'.$readable.'"><td class="receivername">'.$sender_name_list. '</td><td class="receiveremail">'.$result->receiveremail. '</td><td class="subject_txt">'.$result->subject.'</td><td> <a class="view_message" data-type="inbox" data-id="'.$result->ID.'" rel="'.$sender_info->ID.'" href="javascript:void(0);">View</a> / <a data-email="'.$result->receiveremail.'" class="reply_message"  data-id="'.$result->ID.'" rel="'.$sender_info->ID.'" href="javascript:void(0);">Reply</a><div class="div_message" style="display:none;">'.$result->message.'</div></td></tr>';
																				echo '<tr class="'.$readable.'" id="tr_'.$result->ID.'"><td>'.date('d-m-Y',$result->currenttime). '</td><td class="receivername">'.$sender_name_list. '</td><td class="receiveremail" rel="'.$result->senderemail. '">'.wp_trim_words($result->message,4). '</td><td class="subject_txt">'.$result->subject.'</td><td> <a class="view_message" data-type="inbox" data-id="'.$result->ID.'" rel="'.$sender_info->ID.'" href="javascript:void(0);">View</a> / <a data-email="'.$result->receiveremail.'" class="reply_message"  data-id="'.$result->ID.'" rel="'.$sender_info->ID.'" href="javascript:void(0);">Reply</a> / <a data-email="'.$result->receiveremail.'" class="delete_message"  data-id="'.$result->ID.'" rel="'.$sender_info->ID.'" href="javascript:void();">Delete</a><div class="div_message" style="display:none;">'.stripslashes($result->message).'</div></td></tr>';
																			}
																			?>
															</tbody>
														</table>
													</div>
													<div class="tab-pane fade" id="nav-sent" role="tabpanel" aria-labelledby="sent">
														<h3 style="text-align: center;">Sent</h3>
														<table id="message_datatype_sent" class="message_datatype table table-striped table-bordered" style="width:100%">
															<thead>
																<tr>
																	<th>Receiver Name</th>
																	<th>Receiver Email</th>
																	<th>Subject</th>
																	<th>#</th>
																</tr>
															</thead>
															<tbody>
																<?php
																	$results = $wpdb->get_results('select * from '.$messages_table .' where senderid = '.$current_user_id.' and status = 1 order by ID desc');
																		foreach($results as $result){
																			$receiver_info = get_userdata($result->receiverid);
																			$fname = get_user_meta($receiver_info->ID,'first_name',true);
																			$lname = get_user_meta($receiver_info->ID,'last_name',true);
																			//$receiveremail = $receiver_info->user_email;
																			 $display_name = $receiver_info->display_name;
																			$name = $fname.' '.$lname;
																			$receiver_name_list = ($name) ? $name : $display_name;
																			echo '<tr><td>'.$receiver_name_list. '</td><td>'.$result->receiveremail. '</td><td class="subject_txt">'.$result->subject.'</td><td><a class="view_message" rel="'.$receiver_info->ID.'" href="javascript:void(0);">View</a><div class="div_message" style="display:none;">'.$result->message.'</div></td></tr>';
																		}
																		?>
															</tbody>
														</table>
													</div>
													<div class="tab-pane fade" id="nav-trash" role="tabpanel" aria-labelledby="trash">
														<h3 style="text-align: center;">Trash</h3>
														<table id="message_datatype_trash" class="message_datatype table table-striped table-bordered" style="width:100%">
															<thead>
																<tr>
																	<th>Sender Name</th>
																	<th>Sender Email</th>
																	<th>Subject</th>
																	<th>#</th>
																</tr>
															</thead>
															<tbody>
																<?php
																	$results = $wpdb->get_results('select * from '.$messages_table .' where receiverid = '.$current_user_id.' and status = 0 order by ID desc');
																		foreach($results as $result){
																			$sender_info = get_userdata($result->senderid);
																			$fname = get_user_meta($sender_info->ID,'first_name',true);
																			$lname = get_user_meta($sender_info->ID,'last_name',true);
																			// $senderemail = $sender_info->user_email;
																			 $display_name = $sender_info->display_name;
																			$name = $fname.' '.$lname;
																			$sender_name_list = ($name) ? $name : $display_name;
																			echo '<tr><td>'.$sender_name_list. '</td><td>'.$result->senderemail. '</td><td class="subject_txt">'.$result->subject.'</td><td><a class="view_message" rel="'.$sender_info->ID.'" href="javascript:void(0);">View</a><div class="div_message" style="display:none;">'.$result->message.'</div></td></tr>';
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
														<div class="form-group">
															
															<input type="hidden" class="form-control" id="replyreceiveremail" name="replyreceiveremail" value="" readonly="readonly" required maxlength="50">
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
							</div>
							<!--Japan-->
							<div id="Japan" class="tabcontent">
								<section id="tabs">
									<div class="col-md-12 ">
										<h1 class="section-title-profile h1">POST A JOB</h1>
<form id="regForm" class="regForm_can" action="" method="post">
<!-- One "tabregister" for each step in the form: -->
<div class="tabregister">
<?php echo $message; ?>
<p><label>Title<sup class="required">&nbsp;*</sup></label><input required type="text" name="title_name" value=""></p>
<p><label>Job Type<sup class="required">&nbsp;*</sup></label><div class="wpuf-fields" data-required="yes" data-type="radio">
<?php $exprience_job_post = array('full_time'=>'Full Time', 'part_time'=>'Part Time', 'freelance'=>'Freelance'); ?>
<?php $exprience_selected = 'full_time' ; ?>			
			<?php foreach($exprience_job_post as $kexp => $exp){ ?>
			
                    <label class="wpuf-radio-block">
                        <input name="exprience_job_post" <?php if($exprience_selected == $kexp) { echo 'checked="checked"'; } ?> class="wpuf_experience_level_2341" type="radio" value="<?php echo $kexp; ?>"><?php echo $exp; ?></label>
			<?php } ?>   
</div></p>
<p><label>Remote<sup class="required">&nbsp;*</sup></label><div class="wpuf-fields" data-required="yes" data-type="radio">
<?php $remote_job = array('no'=>'No', 'yes'=>'Yes'); ?>
<?php $remote_selected =  'no' ; ?>			
			<?php foreach($remote_job as $kexp => $exp){ ?>
			
                    <label class="wpuf-radio-block">
                        <input name="remote_job" <?php if($remote_selected == $kexp) { echo 'checked="checked"'; } ?> class="wpuf_experience_level_2341" type="radio" value="<?php echo $kexp; ?>"><?php echo $exp; ?></label>
			<?php } ?>   
</div></p>
<p><label>What level of Excel is your candidate expected to know?<sup class="required">&nbsp;*</sup></label><div class="wpuf-fields" data-required="yes" data-type="radio">
<?php $level_excel = array('beginner'=>'Beginner', 'intermediate'=>'Intermediate', 'advanced'=>'Advanced'); ?>
<?php $level_excel_selected = 'beginner' ; ?>			
			<?php foreach($level_excel as $kexp => $exp){ ?>
			
                    <label class="wpuf-radio-block">
                        <input name="level_excel" <?php if($level_excel_selected == $kexp) { echo 'checked="checked"'; } ?> class="wpuf_experience_level_2341" type="radio" value="<?php echo $kexp; ?>"><?php echo $exp; ?></label>
			<?php } ?>   
</div></p>
<p><label>What type of job is this? <img src="<?php echo site_url(); ?>/wp-content/uploads/2018/12/tooltip.png" class="hits_icon_job"><sup class="required">&nbsp;*</sup></label><div class="wpuf-fields" data-required="yes" data-type="radio">
<?php $catsArray = array(111, 113, 112); ?>
<?php $job_type = custom_taxonomy_calling_func('job_type', $catsArray ); ?>
<?php $job_type_selected = '111' ; ?>			
			<?php foreach($job_type as $kexp => $exp){ ?>
			
                    <label class="wpuf-radio-block">
                        <input name="job_type" <?php if($job_type_selected == $kexp) { echo 'checked="checked"'; } ?> class="wpuf_experience_level_2341" type="radio" value="<?php echo $kexp; ?>"><?php echo $exp; ?></label>
			<?php } ?>   
</div></p>
<p><label>Work Experience<sup class="required">&nbsp;*</sup></label><div class="wpuf-fields" data-required="yes" data-type="radio">
<?php $catsArray = array(442, 443, 444, 445); ?>
<?php $experience_finance = custom_taxonomy_calling_func('experience_finance', $catsArray); ?>
<?php $experience_finance_selected =  '442' ; ?>			
			<?php foreach($experience_finance as $kexp => $exp){ ?>
			
                    <label class="wpuf-radio-block">
                        <input name="experience_finance" <?php if($experience_finance_selected == $kexp) { echo 'checked="checked"'; } ?> class="wpuf_experience_level_2341" type="radio" value="<?php echo $kexp; ?>"><?php echo $exp; ?></label>
			<?php } ?>   
</div></p>
				
<p><label>Neighborhood<sup class="required">&nbsp;*</sup></label><?php echo do_shortcode('[custom_texnomoy_location]');?></p>
<p><label>Salary<sup class="required">&nbsp;*</sup></label><input type="text" placeholder="Add Salary, bonuses or anything else your company has to offer" value="<?php echo $_POST['salary']; ?>" required name="salary"></p>
<p><label>Description</label><sup class="required">&nbsp;*</sup><textarea required class="description" placeholder="Job Description" name="description"></textarea></p>
<div class="check_tc"><input required type="checkbox" name="t_c" value="yes" style="width: 20px;"> I have read and agreed to the <a target="_blank" href="https://app.termly.io/document/terms-of-use-for-saas/1134cfe0-0845-428f-9ed4-90fdd046e14b">Terms and Conditions</a><sup class="required">&nbsp;*</sup></div>
</div>	


<input type="hidden" value="<?php echo $current_role; ?>" name="user_role" />
<div class="wpuf-fields notes_wrap">
	<i style="color:red">Note : Jobs will expire after 30 days.</i>
</div>

<input type="submit" class="wpuf-submit-button" name="post_a_job" value="Submit">
</form>
									</div>
								</section>
							</div>
						<!--Japan-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<div class="load_img"></div>
</div>
<?php
	$query = new WP_Query( array( 'post_type' => 'interview', 'paged' => $paged ) );
	if ( $query->have_posts() ) : ?>
<?php while ( $query->have_posts() ) : $query->the_post(); 
	$desc = get_post_meta( get_the_ID(), 'page_rec_desc', true );
	$eventStartDate = get_post_meta( get_the_ID(), 'eventStartDate', true );
	$eventEndDate = get_post_meta( get_the_ID(), 'eventEndDate', true );
	$eventStartTime = get_post_meta( get_the_ID(), 'eventStartTime', true );
	$eventEndTime = get_post_meta( get_the_ID(), 'eventEndTime', true );
	$start = $eventStartDate.' '.$eventStartTime;
	$end = $eventEndDate.' '.$eventEndTime;
	$sec = strtotime($start);
	$date = date("Y-m-d H:i", $sec);
	 $date_n = $date . ":00";
	$end = strtotime($end);
	$date_end = date("Y-m-d H:i", $end);
	 $date_e = $date_end . ":00";
	?>
<?php endwhile; wp_reset_postdata(); ?>
<!-- show pagination here -->
<?php endif; ?>
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

	
	/**
	 Method to get Events and display it in the calendar.
	 If you need to make an asynchronous call, invoke ical.render in the callback method.
	 @param startTime - Calendar Display Range start
	 @para endTime - Calendar End Range end
	 */
	function loadCalendarEvents(startTime, endTime)
	{   
	ical.render(getCalendarData());
	}
	/**
	 * Click of Add in add event box.
	 */
	function addMyEvent()
	{ 
	newev = getEventFromForm() 
	<?php
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == "my_post_type") {
		//store our post vars into variables for later use
		//now would be a good time to run some basic error checking/validation
		//to ensure that data for these values have been set
		$title     = $_POST['title'];
		$content   = $_POST['content'];
		$post_type = 'my_custom_post';
		$custom_field_1 = $_POST['custom_1'];
		$custom_field_2 = $_POST['custom_2'];    
		//the array of arguements to be inserted with wp_insert_post
		$new_post = array(
		'post_title'    => $title,
		'post_content'  => $content,
		'post_status'   => 'publish',          
		'post_type'     => $post_type 
		);
		//insert the the post into database by passing $new_post to wp_insert_post
		//store our post ID in a variable $pid
		$pid = wp_insert_post($new_post);
		//we now use $pid (post id) to help add out post meta data
		add_post_meta($pid, 'meta_key', $custom_field_1, true);
		add_post_meta($pid, 'meta_key', $custom_field_2, true);
		}  
		?>
	return false;
	}
	function getEventFromForm()
	{
	var newEventContainer = jQuery("#customNewEventTemplate"); 
	var name=newEventContainer.find( "#eventName").val();
	var grp=newEventContainer.find("#eventGroup").val();
	var grpName=newEventContainer.find("#eventGroup  option:selected").text(); 
	var strtTime=newEventContainer.find("#eventStartTime").val();
	var endTime=newEventContainer.find("#eventEndTime").val();
	var startDate=newEventContainer.find("#eventStartDate").val();
	var endDate=newEventContainer.find("#eventEndDate").val();
	var description=newEventContainer.find("#eventDescription").val();
	var movable=newEventContainer.find("#chkMovable").val();
	var resizable=newEventContainer.find("#chkResizable").val();
	var attr1=newEventContainer.find("#attribute1").val();
	var attr2=newEventContainer.find("#attribute2").val();
	var attr3=newEventContainer.find("#attribute3").val();
	var attr4=newEventContainer.find("#attribute4").val();
	var attr5=newEventContainer.find("#attribute5").val();
	var attr6=newEventContainer.find("#attribute6").val();
	if(name=="")
	{
	name=HtmlEncode("No Title");
	}
	var alldaybox=jQuery("#allDayEvent", newEventContainer).get(0);
	var allday=alldaybox.checked;
	var start   =  getDateFromStrings(startDate, strtTime);
	var end     =  getDateFromStrings(endDate, endTime);         
	if(allday)
	{
	start.setHours(0,0,0);
	end.setHours(0,0,0);
	} 
	var newev={name:name,  startTime:start, endTime:end
	      , allDay:allday
	      , group:{groupId:grp, name: grpName}  
	      , eventId: Math.ceil(999*Math.random()) 
	      , description: description
	      , resizable: resizable
	      , movable: movable
	      , attribute1: attr1
	      , attribute2: attr2
	      , attribute3: attr3
	      , attribute4: attr4
	      , attribute5: attr5
	      , attribute6: attr6
	      };
	return newev;
	}
	function updateMyEvent()
	{
	newev = getEventFromForm();
	newev.eventId=editingEvent.eventId;
	jQuery("#customNewEventTemplate").hide()
	ical.updateEvent(newev);
	}
	//Show Edit Form
	var editingEvent;
	function editMyEvent(eventId)
	{
	var eventObject = ical.getEventById(eventId);
	editingEvent=eventObject;
	var newEventContainer = jQuery("#customNewEventTemplate"); 
	var name=newEventContainer.find( "#eventName").val(eventObject.eventName);
	var grp=newEventContainer.find("#eventGroup").val(eventObject.group.groupId);
	var strtTime=newEventContainer.find("#eventStartTime").val(  eventObject.formattedStartTime );
	var endTime=newEventContainer.find("#eventEndTime").val(eventObject.formattedStartTime );
	var startDate=newEventContainer.find("#eventStartDate").val( eventObject._startTime.toStandardFormat() );
	var endDate=newEventContainer.find("#eventEndDate").val(  eventObject._endTime.toStandardFormat() );
	var description=newEventContainer.find("#eventDescription").val(eventObject.description);
	var attr1=newEventContainer.find("#attribute1").val(eventObject.attribute1);
	var attr2=newEventContainer.find("#attribute2").val(eventObject.attribute2);
	var attr3=newEventContainer.find("#attribute3").val(eventObject.attribute3);
	var attr4=newEventContainer.find("#attribute4").val(eventObject.attribute4);
	var attr5=newEventContainer.find("#attribute5").val(eventObject.attribute5);
	var attr6=newEventContainer.find("#attribute6").val(eventObject.attribute6);
	newEventContainer.find("#newEvAddEventBtn").hide().end()
	.find("#newEvUpdateEventBtn").show();
	ical.hidePreview();
	ical.showEditEventTemplate(newEventContainer.get(0), eventObject.eventId);
	return false;
	}
	//Delete Event
	function deleteMyEvent(eventId)
	{
	var ev= {eventId:eventId}
	ical.deleteEvent(ev);
	}
	/**
	 * Onclick of Close in AddEvent Box.
	 */
	function closeAddEvent()
	{
	    ical.closeAddEvent();
	}
	/**
	 * Once page is loaded, invoke the Load Calendar Script.
	 */
	
	jQuery(document).ready(function() {
	 var urll = location.protocol + "//" + location.host;
	    jQuery("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
	        e.preventDefault();
	        jQuery(this).siblings('a.active').removeClass("active");
	        jQuery(this).addClass("active");
	        var index = jQuery(this).index();
	        jQuery("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
	        jQuery("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
	    });
	 // Message Send Functionality
	  jQuery('body').on('click', '.message_send',function(){
	   var s_name = jQuery(this).parent().children().children('#name').val();
	   var s_email = jQuery(this).parent().children().children('#email').val();
	   var s_subject = jQuery(this).parent().children().children('#subject').val();
	   var s_message = jQuery(this).parent().children().children('#message').val();
	   var s_candinate_id = jQuery(this).parent().children('#candidate_id').val();
	   var receiveremail = jQuery(this).parent().children().children('#receiveremail').val();
	   var ajax_url = urll+'/wp-admin/admin-ajax.php/';
			jQuery.ajax({
				type: 'POST',
				url: ajax_url,
				data: {action:'recuireter_message_candidate',name : s_name, email : s_email, subject : s_subject, message : s_message, receiver : s_candinate_id,receiveremail : receiveremail},
				success: function (responseData) {
					//jQuery('.load_img').html(' ');
					if(responseData == 'yes'){
						jQuery('#error_message'+s_candinate_id).css('display','none');
						jQuery('#success_message'+s_candinate_id).css('display','block');
						jQuery('#myModalmessage'+s_candinate_id+' #subject').val('');
						jQuery('#myModalmessage'+s_candinate_id+' #message').val('');
					}else{
						jQuery('#success_message'+s_candinate_id).css('display','none');
						jQuery('#error_message'+s_candinate_id).css('display','block');
					}
				},
			});
	});
	// Message modal close time
	  jQuery(".myModalmessage").on("hidden.bs.modal", function () {
	   var s_candinate_id = jQuery(this).attr('rel');
		jQuery('#myModalmessage'+s_candinate_id+' #subject').val('');
		jQuery('#myModalmessage'+s_candinate_id+' #message').val('');
		jQuery('#success_message'+s_candinate_id).css('dispaly','none');
		jQuery('#error_message'+s_candinate_id).css('dispaly','none');
		jQuery('#update_exp_keyy').val('0');
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
	  //var receviername = jQuery(this).parent().parent().children('.sorting_1').html();
	  var receviername = jQuery(this).parent().parent().children('.receivername').html();
	  var receiveremail = jQuery(this).parent().parent().children('.receiveremail').attr('rel');
	  var messageid = jQuery(this).attr('data-id');
	  var replyemail = jQuery(this).attr('data-email');
	  var receiverid = jQuery(this).attr('rel');
	  var title = (subject != '') ? 'Reply Of '+receviername : receviername;
	  jQuery('.reply_title').html(title);
	  jQuery('#replyname').val(receviername);
	  jQuery('#replyreceiveremail').val(receiveremail);
	  jQuery('#replysubject').val(subject);
	  jQuery('#replyreceiverid').val(receiverid);
	  jQuery('#replymessageid').val(messageid);
	  jQuery('#replysenderemail').val(replyemail);
	  jQuery('#myModalreply').modal('show');
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
	 jQuery('.delete_message').click(function(){
	  var messageid = jQuery(this).attr('data-id');
	   var ajax_url = urll+'/wp-admin/admin-ajax.php/';
		jQuery.ajax({
			type: 'POST',
			url: ajax_url,
			data: {action:'message_trash', messageid : messageid},
			success: function (messageid) {
					var li_data = jQuery('#tr_'+messageid).html();
					var trash_data = jQuery('#trash_data').html();
					jQuery('#message_datatype_trash tbody').append('<tr>'+li_data+'</tr>'+trash_data);
					jQuery('#tr_'+messageid).css('display','none');
	
			}
		});
	 });

	 // Experience Company Logo Add
	   
	   jQuery('body').on('click','.exp_logo', function(){
		   jQuery('#exp_logo_modal').modal('show');
	   });
	    jQuery('body').on('click','.exp_profile', function(){

		   jQuery('#expmyModal').modal('show');
	   });
	   
	   // Experience Company Logo Add
	   
	   
	   
	   jQuery('body').on('click', '.user_img_submit',function(e){
			
			e.preventDefault();
			
			jQuery('.load_img').html('<div class="load_img_wrap"><div class="load_img_subwrap"><img src="http://referlink.io/wp-content/uploads/2018/08/load.gif" /><div style="text-align:center"></div></div></div>');

			
			
			var file_data = jQuery('#company_explogo').prop('files')[0];
			//var file_data_key = jQuery('#company_explogo_key').val();
			
			
			//alert(file_data_key+' Mukesh');
			
			var form_data = new FormData();
			form_data.append('file', file_data);
			//form_data.append('company_explogo_key', file_data_key);
			form_data.append('action', 'recuiter_upload_logo');  
			
			var ajax_url = urll+'/wp-admin/admin-ajax.php/';
			
				jQuery.ajax({
					type: 'POST',
					url: ajax_url,
					data: form_data,
					contentType: false,
                    processData: false,
					success: function (responseData) {

						//if(responseData != 'no'){
jQuery('.profile-img img').attr('src',responseData);
jQuery('.load_img').html('');
jQuery('#exp_logo_modal').modal('hide');

				},
			});
  
		}); 
		
		
		jQuery('body').on('click','.experience_submit', function(){
		
			var first_name = jQuery('#first_name').val();
			var last_name = jQuery('#last_name').val();
			var company_name = jQuery('#company_name').val();
			var department = jQuery('#department option:selected').val();
			var job_decs = jQuery('#job_decs').val();
			var position_rec = jQuery('#position_rec').val();
			
			job_decs=job_decs.replace(/\n/g,"<br>");
			
			
			
			if(first_name == ''){
				alert('Please fill First Name');
			}else if(last_name == ''){
				alert('Please fill Last Name');
			}else if(company_name == ''){
				alert('Please fill Comapny Name');
			}else if(department == ''){
				alert('Please select department');
			}else if(job_decs == ''){
				alert('Please fill details');
			}else{
	
jQuery('.info_profile_personal').html('<div class="profile-head"><h5>'+first_name+' '+last_name+'</h5><p class="proile-rating">Company : <span>'+company_name+'</span></p><p class="proile-rating">Recruiting : <span style="text-transform: capitalize;">'+department+'</span></p><p class="proile-rating">Position : <span>'+position_rec+'</span></p><p class="proile-rating">Bio : <span>'+job_decs+'</span></p></div>');

			jQuery('.load_img').html('<div class="load_img_wrap"><div class="load_img_subwrap"><img src="http://referlink.io/wp-content/uploads/2018/08/load.gif" /><div style="text-align:center"></div></div></div>');
			
			var ajax_url = urll+'/wp-admin/admin-ajax.php/';
					jQuery.ajax({
						type: 'POST',
						url: ajax_url,
						data:  {action:'recuiter_profile',first_name : first_name,last_name : last_name,company_name : company_name,department : department,position_rec : position_rec, job_decs : job_decs},
						success: function (responseData) {
						jQuery('.load_img').html('');
						jQuery('#expmyModal').modal('hide');
					},
			});
			
			} // else end
		
		
		
	   });

jQuery(".hits_icon_job").hover(function(){

    jQuery('.tooltip_jobwrap').show();
    }, function(){

    jQuery('.tooltip_jobwrap').hide();
});


//jQuery(".tooltip_jobwrap").insertAfter('.job_type_post .wpuf_job_type_select_3270_2393');
jQuery('.message_datatype').DataTable({
			"order": false
		});	
});

	jQuery(".more").toggle(function(){
	    jQuery(this).text("Show Less").closest('.listing-wrap').addClass('active-show');
	   jQuery('.more-prt').hide();
	   jQuery('.active-show .more-prt').show();
	}, function(){
	    jQuery(this).text("Show More").closest('.listing-wrap').removeClass('active-show');
	   jQuery('.more-prt').hide();
	});
</script>
<style>
form.wpuf-form-add.wpuf-form-layout1 {
    margin-top: 0px !important;
    margin-bottom: 0px !important;
}
.candidate_info p {
    margin-bottom: 8px !important;
}
.candidate-dash-area{
    font-family: "Montserrat", sans-serif !important;
	font-size: 14px;
}
.profile-head h5{
    font: 700 Normal 16px/25px "Raleway", sans-serif !important;
    letter-spacing: 1px !important;
    text-transform: uppercase !important;
    color: #424242 !important;
}
.section-title-profile{
font: bold 22px/28px "Raleway", sans-serif !important;
    letter-spacing: 1px !important;
    text-transform: uppercase !important;
    color: #424242 !important;
    text-align: center;
    margin-bottom: 40px;

}
#regForm p, #regForm label {color:#000;}
.regForm_can label.wpuf-radio-block {
    margin-right: 15px;
    font-weight: normal;
}
.regForm_can label.wpuf-radio-block input {
    margin-right: 5px;
}
.check_tc {
    color: #000;
    font-weight: bold;
}
sup.required {
    color: #ff0000;
    font-size: 12px;
}
.notes_wrap{
 margin: 30px 5px;
}
</style>
<?php get_footer(); ?>