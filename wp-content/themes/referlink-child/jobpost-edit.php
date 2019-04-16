<?php
/*
  Template Name: Job Post Edit
 */

get_header();
?>
<?php
   $user = wp_get_current_user();
   //print_r($user);
   
   
   
    $userid = $user->ID;

    $all_meta_for_user = get_user_meta($user->ID);
    //print_r( $all_meta_for_user );

    $user = wp_get_current_user();
    $role = ( array ) $user->roles;
    //echo $role[0];
	
    $company_name = get_user_meta($user->ID,'nickname', true);
    //$ref_id = get_user_meta($user->ID,'company_name', true);
  
    $ref_url = site_url().'/recruiter-register/?ref_id='.$userid.'&ref_company='.$company_name;
    $ref_name = 'Recruiter Registration by '.$company_name;
  
  if ( in_array( 'cs_employer', (array) $user->roles ) ) {
      $back_site_url = "/company-recruiters/";
  } else if ( in_array( 'recruiter', (array) $user->roles ) ) {
      $back_site_url = "/recruiter-dashboard/";      
  } else {
      
      wp_redirect( site_url() );
  }
  if ( in_array( 'cs_employer', (array) $user->roles ) || in_array( 'recruiter', (array) $user->roles )) {
     
      if($_POST['submit']) {
          //print_r($_POST);die;
            $post_id = $_REQUEST['rec_id'];
            $post_id = base64_decode($post_id);
            
            $post_data = get_post($post_id);
            
            $my_post = array(
                'ID'           => $post_id,
                'post_title'   => $_POST['post_title'],
                'post_content' => $_POST['post_content'],
            );

            wp_update_post($my_post);
           
            //$why_us = update_post_meta($post_id,'why_us',$_POST['why_us']);
            $remote = update_post_meta($post_id,'remote_copy',$_POST['remote_copy']);
            $work_experience = update_post_meta($post_id,'work_experience',$_POST['work_experience']);
            $offering_visa_sponsorship = update_post_meta($post_id,'offering_visa_sponsorship',$_POST['offering_visa_sponsorship']);
            $salary_range_start = update_post_meta($post_id,'salary',$_POST['salary']);
            //$salary_range_end = update_post_meta($post_id,'salary_range_end',$_POST['salary_range_end']);
            $job_type_post = update_post_meta($post_id,'job_type',$_POST['job_type']);
            $job_type = update_post_meta($post_id,'job_type_post',$_POST['job_type_post']);
			wp_set_post_terms($post_id, $_POST['job_type_post'], 'job_type' );
			wp_set_post_terms($post_id, $_POST['job_location_post'], 'cs_locations' );
			
			header('Location: '.site_url().'/company-jobs?action=jobs&rec_id='.base64_encode($userid));
      }
?>


<link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/bootstrap.css" rel="stylesheet" />
<!-- FONT AWESOME ICONS  -->
<link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/font-awesome.css" rel="stylesheet" />
<!-- CUSTOM STYLE  -->
<link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/dataTables.jqueryui.min.css" />
 <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/jquery-ui.css">
 
<script src="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/dataTables.jqueryui.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/dataTable/jquery.dataTables.min.js"></script>

	<div class="content-wrapper">
            <?php
                    
                     $post_id = $_REQUEST['rec_id']; 
					
                    $post_id = base64_decode($post_id);
                    $post_data = get_post($post_id);
                    $post_title = $post_data->post_title;
                    $post_content = $post_data->post_content;
                    $remote = get_post_meta($post_id,'remote_copy',true);
                    $work_experience = get_post_meta($post_id,'work_experience',true);
                    $offering_visa_sponsorship = get_post_meta($post_id,'offering_visa_sponsorship',true);
                    $salary_range_start = get_post_meta($post_id,'salary',true);
                    //$salary_range_end = get_post_meta($post_id,'salary_range_end',true);
                    $job_type = get_post_meta($post_id,'job_type_post',true); 
                    $job_type_post = get_post_meta($post_id,'job_type',true); 
					 $term_location_id = wp_get_post_terms( $post_id, 'cs_locations', array( 'fields' => 'ids' ) ); 
					$rec_id1 = $_REQUEST['rec_id1'];
					$rec_id1 = base64_decode($rec_id1);
?>
<div class="container">
		<div class="row">
		
			
                    <div class="col-md-12">
                        <h4 class="page-head-line">Edit Job Post</h4>
                    </div>

		</div>

		<div class="row">
			<div class="col-md-8">
			 <form class="wpuf-form-layout1 wpuf-style" action="" method="post">

                
				<div class="form-group">
					<label for="post_title">Title</label>
					<input class="textfield wpuf_post_title_2393" id="post_title_2393" data-required="no" data-type="text" name="post_title" placeholder="" value="<?php echo $post_title; ?>" size="40" type="text">
				</div>
				<div class="form-group">
					<div style="font-weight: bold;">Job Type</div>
					<label class="wpuf-radio-inline"><input name="job_type_post" class="wpuf_job_type_2393" value="full_time" <?php if($job_type == 'full_time') echo 'checked="checked"'; ?>  type="radio">Full Time</label>
					<label class="wpuf-radio-inline"><input name="job_type_post" class="wpuf_job_type_2393" value="part_time" <?php if($job_type == 'part_time') echo 'checked="checked"'; ?> type="radio">Part Time</label>
					<label class="wpuf-radio-inline"><input name="job_type_post" class="wpuf_job_type_2393" value="freelance" <?php if($job_type == 'freelance') echo 'checked="checked"'; ?> type="radio">Freelance</label>
				</div>
				<div class="form-group">
					<div style="font-weight: bold;">Remote</div>
					<label class="wpuf-radio-inline"><input name="remote_copy" class="wpuf_remote_copy_2393" value="yes" <?php if($remote == 'yes') echo 'checked="checked"'; ?> type="radio">Yes</label>
					<label class="wpuf-radio-inline"><input name="remote_copy" class="wpuf_remote_copy_2393" value="no" <?php if($remote == 'no') echo 'checked="checked"'; ?> type="radio">No</label>
				</div>
				<div class="form-group">
					<div style="font-weight: bold;">What level of excel is your candidate expected to know?</div>
					<label class="wpuf-radio-inline"><input name="offering_visa_sponsorship" class="wpuf_offering_visa_sponsorship_2393" value="beginner" <?php if($offering_visa_sponsorship == 'beginner') echo 'checked="checked"'; ?> type="radio">Beginner</label>
					<label class="wpuf-radio-inline"><input name="offering_visa_sponsorship" class="wpuf_offering_visa_sponsorship_2393" value="intermediate" <?php if($offering_visa_sponsorship == 'intermediate') echo 'checked="checked"'; ?> type="radio">Intermediate</label>
					<label class="wpuf-radio-inline"><input name="offering_visa_sponsorship" class="wpuf_offering_visa_sponsorship_2393" value="advanced" <?php if($offering_visa_sponsorship == 'advanced') echo 'checked="checked"'; ?> type="radio">Advanced</label>
				</div>
				<div class="form-group">
					<label for="work_experience">What type of job is this? <img src="https://referlink.io/wp-content/uploads/2018/12/tooltip.png" width="25" class="hits_icon_job"><span class="required">*</span></label>
					<select class="wpuf_work_experience_2393" name="job_type" data-required="yes" data-type="select">
						<option value="">- Select -</option>
						<option value="111" <?php if($job_type_post == '111') echo 'selected="selected"'; ?>>Back-end</option>
						<option value="113" <?php if($job_type_post == '113') echo 'selected="selected"'; ?>>Front-end</option>
						<option value="112" <?php if($job_type_post == '112') echo 'selected="selected"'; ?>>Hybrid</option>
						
					</select>
				</div>
				<div class="form-group">
					<label for="work_experience">Work Experience<span class="required">*</span></label>
					<select class="wpuf_work_experience_2393" name="work_experience" data-required="yes" data-type="select">
						<option value="">- Select -</option>
						<option value="intern" <?php if($work_experience == 'intern') echo 'selected="selected"'; ?>>Intern</option>
						<option value="1+_years" <?php if($work_experience == '1+_years') echo 'selected="selected"'; ?>>1+ Years</option>
						<option value="2+_years" <?php if($work_experience == '2+_years') echo 'selected="selected"'; ?>>2+ Years</option>
						<option value="3+_years" <?php if($work_experience == '3+_years') echo 'selected="selected"'; ?>>3+ Years</option>
						<option value=">5_years" <?php if($work_experience == '>5_years') echo 'selected="selected"'; ?>>&gt;5 Years</option>
					</select>
				</div>
				<?php echo do_shortcode('[job_texnomoy_location selected="'.$term_location_id[0].'"]'); ?>
				<div class="form-group">
					<label for="salary_range_start">Salary<span class="required">*</span></label>
					<input class="textfield wpuf_salary_2393" id="salary_2393" type="text" data-required="yes" data-type="text" name="salary" placeholder="$75,000" value="<?php echo $salary_range_start; ?>" size="40">
				</div>
				<div class="form-group">
				   <textarea class="textareafield" name="post_content" data-required="no" data-type="textarea" placeholder="Job Description" rows="5" cols="20"><?php echo $post_content; ?></textarea>
				</div>
				<div class="form-group">
					<input  name="submit" value="Update" type="submit">
				</div>
			</form>
               <div class="row">  
				  <div class="col-md-12">  
					<a href="<?php echo site_url(); ?>/company-jobs?action=jobs&rec_id=<?php echo base64_encode($rec_id1); ?>" class="btn btn-info btn-md" style="float: right;font-size: 16px !important;color: #fff !important; border-radius: 5px;">Back</a>
					
				  </div>
			  </div>
		</div>
		</div>

</div>
<style>
label.wpuf-radio-inline {
    font-weight: normal;
    margin-left: 20px;
}
.wp-jobhunt input[type="radio"], .wp-jobhunt input[type="checkbox"] {
    outline: none;
    margin-right: 4px;
    vertical-align: text-bottom;
}
</style>
<?php } else { ?>
<?php wp_redirect( site_url() ); ?>
<?php } 
get_footer();
?>
<script>
jQuery(document).ready(function(){ 
jQuery(".hits_icon_job").hover(function(){

    jQuery('.tooltip_jobwrap_edit').show();
    }, function(){

    jQuery('.tooltip_jobwrap_edit').hide();
});
});
</script>