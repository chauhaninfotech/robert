<?php
/*
  Template Name: Company Infomation
 */

if ( is_user_logged_in() ) {
   get_header('banner');
} else {
   get_header();
}
global $wpdb;
$user = wp_get_current_user();

function checkUserJob($user_id,$post_id) {
   global $wpdb;
   $myrows = $wpdb->get_results( "SELECT apply_id from wp_job_apply where candidate_id=".$user_id." and post_id=".$post_id);

	if ( $myrows ){ return 1; } else { return 0; }
}
   

function form_field($form_id){

    global $wpdb;
    $field_table = $wpdb->prefix."rm_fields";
    $result = $wpdb->get_results('select field_id from '.$field_table.' where form_id = '.$form_id.' order by field_order asc');
    $resultArr = array();
    foreach($result as $data) {
        $resultArr[] = $data->field_id;
    }
    return $resultArr;
    
}

$apply_job = '';
$msg = '';
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
		<p>Hi ".$refer_name."</p><p>I referred you to this job on Referlink. Check it out, I am sure you will like it!<br/></p>
		<p>Job Link: - <a href='".$job_link."?action=".base64_encode($lastid)."'>".$job_link."</a><br/><br/>Thanks,<br/>".$first_name.' '.$last_name."</p>
		</body>
		</html>
		";

		$headers = "From: " . strip_tags($user->user_email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($user->user_email) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


		mail($to,$subject,$message,$headers);
		
         $msg = '<div class="clearfix"></div><div class="col-md-12 col-lg-12 can-post job-list bg-inherit"><div class="alert alert-success" id="success-alert"><button type="button" class="close" data-dismiss="alert">x</button><strong>Success!</strong> Job Successfully Sent.</div></div></div>';
		//header('Location:'.site_url().'/candidate-dashboard/');
    }
			   
}

if($_POST['submit_resume']) {

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
                    $resume_link = $movefile['url'];
                } 

                
                $cv_link = $_POST['cover_letter'];
                $curdate = time();
                $sql = "INSERT INTO wp_job_apply (candidate_id, post_id,recruiter_id,company_id, resume_file, cv_file, status,applied_date) VALUES ($candidate_id, $post_id,$recruiter_id,$refer_by_com, '$resume_link', '$cv_link', 0,$curdate)";
                //die;
                if($wpdb->query($sql)) 
               {
                    //header('Location:'.site_url().'/candidate-dashboard/');
               }
                

    $apply_job = '<div class="clearfix"></div><div class="col-md-12 col-lg-12 can-post job-list bg-inherit"><div class="alert alert-success"><strong>Success!</strong> '.$apply_job_title.' Job Proposal Successfully Submitted.</div></div><div class="clearfix"></div>';            
}
   

?>
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css" rel="stylesheet" />
<?php
$user_id = base64_decode($_REQUEST['companyname']);

if(is_user_logged_in()) {    
?>
<div class="main-section">
	<div class="content-wrapper company-info-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Company Overview <a href="<?php echo site_url();?>/candidate-dashboard/?company_info=<?php echo $_REQUEST['companyname'];?>" class="label label-info" style="float: right;color: #fff !important;padding: 10px 20px;font-size: 15px !important; display: inline-block;">Back</a></h4>

                </div>
            </div>
			
			
			<?php //echo do_shortcode('[RM_Front_Submissions]');

                            
                            $user_avatar = get_user_meta($user_id, 'user_img', true);
                            
                            $user_avatar = wp_get_attachment_url($user_avatar);
                            
                            if ( metadata_exists( 'user', $user_id, 'edit_profile' ) ) {
   
                                
                                $first_name = get_user_meta($user_id, 'first_name', true);
                                $last_name = get_user_meta($user_id, 'last_name', true);
                                $name = $first_name.' '.$last_name;
                                $description = get_user_meta($user_id, 'description', true);
                                $pitch = get_user_meta($user_id, 'pitch', true);
                                $perks = get_user_meta($user_id, 'perks', true);
                                $location = get_user_meta($user_id, 'location', true);

                                $department = get_user_meta($user_id, 'department', true);
                                $company_name = get_user_meta($user_id, 'company_name', true);
                                $company = get_user_meta($user_id, 'company', true);
                                $website = get_user_meta($user_id, 'url', true);
                                
                                $user_avatar = get_user_meta($user_id, 'user_avatar', true);
								//$user_avatar = ($user_avatar != '') ? $user_avatar : site_url().'/wp-content/uploads/2018/06/dummy.png';
                                
                                $num_of_emp = get_user_meta($user_id, 'number_of_employees', true);
                                $num_of_emp_arr = ($num_of_emp) ? explode('_',$num_of_emp) : $num_of_emp;
								if(is_array($num_of_emp_arr)){
                                $number_of_employees = implode(' ',$num_of_emp_arr);
								}
                                
                                
                            } else {
                                  
                                $submission_id = get_user_meta($user_id, 'RM_UMETA_SUB_ID', true);
                            
                                $submission_query = "SELECT data,form_id FROM wp_rm_submissions WHERE submission_id = ". $submission_id;

                                $results = $wpdb->get_row($submission_query);

                                $all_data = unserialize($results->data);

                                $form_data = form_field($results->form_id);
						
                                foreach($form_data as $f_id){
							
                                        $type = $all_data[$f_id]->type;
                                        if($type != 'Terms' || $type != 'File'){
                                                $key = strtolower(str_replace(' ','_',$all_data[$f_id]->label));
                                                $value = $all_data[$f_id]->value;

                                                $result[$key] = $value;
                                        }
                                }
           
                                
                                $first_name = $result['first_name'];
                                $last_name = $result['last_name'];
                                $name = $first_name.' '.$last_name;
                                $description = $result['bio'];
                                $pitch = $result['pitch'];
                                $perks = $result['what_perks_does_the_company_offer?'];
                                $location = $result['location'];

                                $department = $all_data['36']->value;
                                $company_name = $result['company_name'];
                                $company = $result['company'];
                                $website = $result['website_url'];

                                $num_of_emp = $result['number_of_employees'];
                                $num_of_emp_arr = ($num_of_emp) ? explode('_',$num_of_emp) : $num_of_emp;
								if(is_array($num_of_emp_arr)){
                                $number_of_employees = implode(' ',$num_of_emp_arr);
								}
                                
                                
                            }
                            $email = get_user_meta($user_id, 'email', true);
                            
                            ?>
           
                  <div class="col-md-12">
						<div class="row">
                      <div class="col-md-3 col-xs-12 col-sm-6 col-lg-3">
                        <div class="thumbnail text-center photo_view_postion_b">
                            <?php //echo $all_data['40']->value[0]; ?>
							
							<?php if(!empty($user_avatar)) { ?>
                                       <img src="<?php echo $user_avatar; ?>" alt="stack photo" class="img">
							<?php }else{ echo company_logo_api($user_id); } ?>
                        </div>
                      </div>
                      <div class="col-md-9 col-xs-12 col-sm-6 col-lg-9">
                          <div class="">
                            <h2><?php echo $company_name; ?></h2>
                          </div>
                            <hr>
<?php $weburl = explode('://',$website);?>
                          <div class="col-md-6">  
							  <ul class=" details">
								<!--<li><p><label>Email :&nbsp;&nbsp;</label><?php //echo $email; ?></p></li>-->
								<li><p><label>Department :&nbsp;&nbsp;</label><?php echo $department; ?></p></li>
								<li><p><label>Website :&nbsp;&nbsp;</label><a class="weburl" target="_blank" href="http://<?php echo end($weburl); ?>"><?php echo $website; ?></a></p></li>
								<li><p><label>Location :&nbsp;&nbsp;</label><?php echo ucwords(str_replace('-',' ',$location)); ?></p></li>
							  </ul>
                          </div>
						  <div class="col-md-6">  
							  <ul class=" details">
								
								<li><p><label>Number Of Employees :&nbsp;&nbsp;</label><?php echo $number_of_employees; ?></p></li>
								<li><p><label>Pitch :&nbsp;&nbsp;</label><?php echo $pitch; ?></p></li>
								<li><p><label>Perks :&nbsp;&nbsp;</label><?php echo $perks; ?></p></li>
							  </ul>
                          </div>
              
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group row">
                        <div class="col-md-12">
                        <div class="form-group" style="border-bottom:1px solid black">
                            <h2>Company BIO</h2>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="row"> 
                     <div class="col-md-12">
                        <?php echo $description; ?> 
                     </div>
                     <!--<div class="row">
                           <div class="col-md-12">
								<a href="<?php echo site_url();?>/candidate-dashboard/?company_info=<?php echo $_REQUEST['companyname'];?>" class="label label-info" style="float: right;color: #fff !important;padding: 10px 20px;font-size: 15px !important; margin: 20px 0px; display: inline-block;">Back</a>
                            </div>
							
                    </div>-->

                     
                    </div>

						
					         
                </div>
<div class="clearfix"></div><hr>
				<div class="related_jobs" style="float:left; width: 100%;">
				<h2>Other Company Jobs</h2>
<?php 
echo $msg; echo $apply_job;

$rec_ids = get_users(array('meta_key'=> 'refer_by','meta_value'=> $user_id,'meta_compare' => '=',));
$rec_idd[] = $user_id;
foreach ($rec_ids as $rec_id){ $rec_idd[] = $rec_id->ID; }
$args = array('post_type' => 'jobs', 'author__in' => $rec_idd, 'orderby' => 'date','order' => 'DESC','post_status' => 'publish','posts_per_page' => -1 );

$loops = get_posts( $args );
if ($loops) {
foreach ( $loops as $loop ){

$ID = $loop->ID;
$auth = get_post($ID); // gets author from post
$authid = $auth->post_author; // gets author id for the post
$refer_by_com = get_user_meta($authid, 'refer_by', true);
							
$user_email = get_the_author_meta('user_email',$authid); // retrieve user email

$user_firstname = get_the_author_meta('user_firstname',$authid);
$user_lastname = get_the_author_meta('user_lastname',$authid);

$refer_com = get_user_meta($authid, 'refer_by_com', true);
$refer_comid = get_user_meta($authid, 'refer_by', true);
$comidd = base64_encode($refer_comid);		
		
?>
<div class="col-md-12 col-lg-12 can-post job-list bg-inherit" style="padding: 0px;">
	<div class="listing-wrap clearfix">
		<div class="col-md-10 col-lg-10">
			<h2><?php //the_permalink(); ?><?php echo get_the_title($ID); ?></a></h2>
			<div class="col-md-2" style="text-align:center; padding:0px;">
				<div><?php echo company_logo_api($refer_comid, 'api_clogo'); ?></div>
			</div>
			<div class="col-md-10">
				<?php echo '<a href="'.site_url().'/company-information/?companyname='.$comidd.'">'.$refer_com.'</a>'; ?> 
				<div><b>Salary : </b><?php echo get_post_meta($ID, 'salary', true); ?> </div>
				<?php $jtid = get_post_meta($ID, 'job_type', true);  $tdata = get_term_by( 'term_id', $jtid, 'job_type' ); ?>
<?php $term_location = wp_get_post_terms( $ID, 'cs_locations', array( 'fields' => 'names' ) );?>
				<div><b>Job Type : </b><?php echo $tdata->name; ?> </div>
<div class="info_job"><b>Neighborhood : </b><?php echo $term_location[0]; ?> </div>
				<div><b>Excel Skill Level : </b><?php echo ucfirst(get_post_meta($ID, 'offering_visa_sponsorship', true)); ?> </div>
			</div>
			<div class="clearfix"></div>
			<div class="summery" style="margin-top: 10px;">
				<div class="outer_decs" style="display:block;">
					<span><b>Job Description : </b></span>
					<?php
						$text = $loop->post_content;
						if($text == ''){
						 $text =  get_post_meta($ID, 'why_us', true);
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
					<span><b>Job Description : </b></span><div class="less_cnt"><?php echo $loop->post_content; ?></p><a style="color:#61dac2;" class="more_decs_less" href="javascript:void(0);">&nbsp;Show Less</a></div>
					</div>
					
				</div>
	         </div>							
		</div>
<div class="col-md-2 col-lg-2">
<?php 
$user = wp_get_current_user();
$resultCheck = checkUserJob($user->ID, $ID);
if($resultCheck == 0) {		
?>
	<div class="apply">
		<a style="cursor:pointer; border-radius:5px;" class="btn btn-info" data-toggle="modal" data-target="#myModal-apply<?php echo $ID; ?>">Apply</a>
	</div>
	<div id="myModal-apply<?php echo $ID; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Apply For Job</h4>
				</div>
				<div class="modal-body">
					<div class="panel-body">
						<form action="<?php echo site_url(); ?>/company-information/?companyname=<?php echo $_REQUEST['companyname']; ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="candidate_id" value="<?php echo $user->ID; ?>" />
							<input type="hidden" name="post_id" value="<?php echo $ID; ?>" />
							<input type="hidden" name="recruiter_id" value="<?php echo $authid; ?>" />
							<input type="hidden" name="refer_by_com" value="<?php echo $refer_by_com; ?>" />
							<input type="hidden" name="apply_job_title" value="<?php echo get_the_title($ID); ?>" />
							<label>Upload Resume</label>
							<input type="file" name="resume" value="Upload Resume" required>
							<label>Note for Recruiter</label>
							<textarea name="cover_letter" rows="5" required=""></textarea>
							<input type="submit" name="submit_resume" value="Apply Now" class="btn btn-success">
						</form>
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
			<a class="btn btn-success" style="border-radius:5px;" href="javascript:void(0);">Applied</a>
	</div>
<?php } ?>	
	<span style="cursor: pointer;" data-toggle="modal" data-target="#myModal-refer-job<?php echo $ID; ?>"><i class="fa fa-random" aria-hidden="true"> </i> Refer To Candidate</span>
	<div id="myModal-refer-job<?php echo $ID; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Refer Job to Candidate</h4>
				</div>
				<div class="modal-body">
					<div class="panel-body">
						<form action="<?php echo site_url(); ?>/company-information/?companyname=<?php echo $_REQUEST['companyname']; ?>" method="post" style="margin-top:20px">						
							<input type="text" class="form-control" name="job_title" value="<?php echo get_the_title($ID); ?>" readonly="readonly" />
							<input type="text" required class="form-control" name="refer_name" placeholder="Refer Name" value=""  />
							<input type="email" required placeholder="Refer Email..." class="form-control" name="refer_email" value="" />

							<hr />
							<input type="hidden" name="refer_user_id" value="<?php echo get_current_user_id(); ?>" />
							<input type="hidden" name="refer_post_id" value="<?php echo $ID; ?>" />
							<input type="hidden" name="job_link" value="<?php echo get_the_permalink($ID); ?>" />
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
										
</div><!--2 End-->
</div>
</div>
<?php } wp_reset_postdata(); }?>
				</div>
				<div class="clearfix"></div>
        </div>
    </div>
</div>
<?php } else { ?>
<?php wp_redirect( site_url() ); ?>
<?php } ?>
<script>
jQuery(document).ready(function(){
	jQuery(".more_decs").click(function(){
      jQuery(this).parent().parent().children('.inner_decs').show();
      jQuery(this).parent('.outer_decs').hide();
      //jQuery('.active-show .more-prt').show();
   });
    jQuery(".more_decs_less").click(function(){
      jQuery(this).parent().parent().parent().parent().children('.outer_decs').show();
      jQuery(this).parent().parent().parent('.inner_decs').hide();
   });
});
    
</script>
<style>
.cs-subheader11.align-left {
    display: none;
}
.company-info-area{
font-size: 14px;
margin-top: 25px;
}
.company-info-area h4.page-head-line {
font: 700 Normal 18px/18px "Montserrat", sans-serif !important;
    letter-spacing: 1px !important;
    text-transform: uppercase !important;
    color: #424242 !important;
}
.company-info-area h2 {
    font: 600 Normal 22px/44px "Raleway", sans-serif !important;
}
</style>
<?php 
get_footer();
?>