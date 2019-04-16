<?php
/*
  Template Name: Company Jobs
 */

get_header();
?>
<?php
   $user = wp_get_current_user();
   //print_r($user);
   
    $id = $user->ID;


    $all_meta_for_user = get_user_meta($user->ID);
    //print_r( $all_meta_for_user );

    $user = wp_get_current_user();
    $role = ( array ) $user->roles;
    //echo $role[0];
	
    $company_name = get_user_meta($user->ID,'nickname', true);
    //$ref_id = get_user_meta($user->ID,'company_name', true);
  
    $ref_url = site_url().'/recruiter-register/?ref_id='.$id.'&ref_company='.$company_name;
    $ref_name = 'Recruiter Registration by '.$company_name;
  
  if ( in_array( 'cs_employer', (array) $user->roles ) ) {
      $back_site_url = "/company-recruiters/";
  } else if ( in_array( 'recruiter', (array) $user->roles ) ) {
      $back_site_url = "/recruiter-dashboard/";      
  } else {
      
      wp_redirect( site_url() );
  }
  if ( in_array( 'cs_employer', (array) $user->roles ) || in_array( 'recruiter', (array) $user->roles )) {
      
      $rec_id1 = base64_decode($_REQUEST['rec_id1']);
       if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete') {
      
            $rec_id = base64_decode($_REQUEST['rec_id']);
            
            wp_delete_post($rec_id);
            header('Location: '.site_url().'/company-jobs?action=jobs&rec_id='.base64_encode($rec_id1));

        }
      
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
            $job_type = update_post_meta($post_id,'job_type',$_POST['job_type']);
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
                    //$why_us = get_post_meta($post_id,'why_us',true);
                    $remote = get_post_meta($post_id,'remote_copy',true);
                    $work_experience = get_post_meta($post_id,'work_experience',true);
                    $offering_visa_sponsorship = get_post_meta($post_id,'offering_visa_sponsorship',true);
                    $salary_range_start = get_post_meta($post_id,'salary',true);
                    //$salary_range_end = get_post_meta($post_id,'salary_range_end',true);
                    $job_type = get_post_meta($post_id,'job_type_post',true); 
$term_location = wp_get_post_terms( $post_id, 'cs_locations', array( 'fields' => 'names' ) );
					if(!empty($job_type)){
					$job_type = str_replace('_',' ',$job_type);					
					}
					
                    $job_type_post = get_post_meta($post_id,'job_type',true); 
                    
                    if($_REQUEST['action'] == 'jobs') { $author_id= base64_decode($_REQUEST['rec_id']); ?>
                
                    <div class="container">
                        
                        <div class="row">
						
  
                            <div class="col-md-8" style="padding:0px;">
                                <h4 class="page-head-line">Posted Jobs</h4>

                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">

                                <table class="candidate_datatype table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th>Posted Date</th>
                                                        <th>Job Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <?php 
                                                     $cnt = 0;
                                                     $posts = get_posts(array('author'=>$author_id,'post_type' => 'jobs','posts_per_page'=>-1));

        //if this author has posts, then include his name in the list otherwise don't
        if(isset($posts) && !empty($posts))
        {
            
                foreach ( $posts as $post ) {

                $cnt++;
                $jtid = get_post_meta($post->ID,'job_type',true);
				$tdata = get_term_by( 'term_id', $jtid, 'job_type' );
				$dater = '';
				if(!empty($post->post_date)){
					$dd = explode(' ',$post->post_date);
					$dd1 = explode('-',$dd[0]);
					$dater = $dd1[2].'-'.$dd1[1].'-'.$dd1[0];
				}
                ?>
               <tr>
                   <td><?php echo $cnt; ?></td>
                    <td><span><?php echo esc_html( $post->post_title ); ?></span></td>
                    <td><span><?php echo $dater; ?></span></td>
                    <td><span><?php echo $tdata->name; ?></span></td>
                   <td>
                       <a style="margin-left: 10px;" href="<?php echo site_url() ?>/company-jobs/?action=view&rec_id=<?php echo base64_encode($post->ID); ?>&rec_id1=<?php echo $_REQUEST['rec_id']; ?>" class="icon-eye3"></a><a style="margin-left: 10px;" href="<?php echo site_url() ?>/edit-job-post/?action=edit&rec_id=<?php echo base64_encode($post->ID); ?>&rec_id1=<?php echo $_REQUEST['rec_id']; ?>" class="icon-edit3"></a><a style="margin-left: 10px;" href="<?php echo site_url() ?>/company-jobs/?action=delete&rec_id=<?php echo base64_encode($post->ID); ?>&rec_id1=<?php echo $_REQUEST['rec_id']; ?>" class="icon-trash delete_data"></a>
                   </td>


               </tr>

        <?php } } else { ?>
               <tr>
                   <td colspan="7">No Jobs Found</td>
               </tr>
        <?php } ?>

                                                </tbody>
                                            </table>

                            </div>
                        </div>
						
						<div class="row">  
					  <div class="col-md-12"> 
						<a href="<?php echo site_url().$back_site_url; ?>"  class="btn btn-info btn-md" style="float: right;font-size: 16px !important;color: #fff !important; border-radius: 5px; margin-top: 20px;">Back</a>
					  </div>
					  </div>
        </div>
            
          <?php } else if($_REQUEST['action'] == 'view') { 
			$post_id = $_REQUEST['rec_id'];
            $post_id = base64_decode($post_id);
			
             $jtid = get_post_meta($post_id, 'work_experience', true);  
			 $tdata2 = get_term_by( 'term_id', $jtid, 'experience_finance' ); 
			 $work_experience = $tdata2->name;
			 
			 $term_location = wp_get_post_terms( $post_id, 'cs_locations', array( 'fields' => 'names' ) );
			 print_r($term_location);

                $tdata = get_term_by( 'term_id', $job_type_post, 'job_type' ); 
                $new_job_type = $tdata->name;
               
                ?> 
             <div class="container view_post_wrap">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="page-head-line">View Posted Job</h4>
                            </div>
						<div class="row">
                      
                      <div class="col-md-12 col-xs-12 col-sm-6 col-lg-9">
                          
                          <div class="col-md-12">  
							  <ul class=" details">
								<li><p><label>Title :&nbsp;&nbsp;</label><?php echo $post_title; ?></p></li>
								<li><p style="text-transform: capitalize;"><label>Job Type :&nbsp;&nbsp;</label><?php echo $job_type; ?></p></li>

<li><p style="text-transform: capitalize;"><label>Neighborhood :&nbsp;&nbsp;</label><?php echo $term_location; ?></p></li>
								<li><p style="text-transform: capitalize;"><label>Remote :&nbsp;&nbsp;</label></span><?php echo $remote; ?></p></li>
								<li><p style="text-transform: capitalize;"><label>Excel Skill Level :&nbsp;&nbsp;</label><?php echo $offering_visa_sponsorship; ?></p></li>
							    <li><p><label>What type of job is this :&nbsp;&nbsp;</label><?php echo $new_job_type; ?></p></li>
								<li><p><label>Work Experience :&nbsp;&nbsp;</label><?php echo $work_experience; ?></p></li>
								<li><p><label>Salary :&nbsp;&nbsp;</label><?php echo $salary_range_start; ?></p></li>
								<li><p><label>Description :&nbsp;&nbsp;</label><?php echo nl2br($post_content); ?></p></li>
							  </ul>
                          </div>
              
                      </div>
					  <div class="row">  
					  <div class="col-md-12">  
						<a href="<?php echo site_url(); ?>/company-jobs?action=jobs&rec_id=<?php echo base64_encode($rec_id1); ?>" class="btn btn-info btn-md" style="float: right;font-size: 16px !important;color: #fff !important; border-radius: 5px;">Back</a>
					  </div>
					  </div>
                    </div>
                    </div>
             </div>
		<?php }  ?>
    </div>
<?php } else { ?>
<?php wp_redirect( site_url() ); ?>
<?php } ?>
<?php 
get_footer();
?>
<style>
.view_post_wrap .page-head-line{
    text-align: center;
    margin: 35px;
    font-size: 22px;
    font-weight: 600;
}
.view_post_wrap ul.details {
    font-size: 16px;
}
</style>
<script>
jQuery(document).ready(function(){

            jQuery('.candidate_datatype').DataTable();
            jQuery('.delete_data').click(function(){

                    var r = confirm("Are you sure you want to delete?");
                    
                    if (r == true) {
                        return true;
                    } else {
                        return false;
                    }

            });
    });
</script>