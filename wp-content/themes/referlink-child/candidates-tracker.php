<?php
/*
  Template Name: Candidates Tracker
 */

get_header();
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

<?php
   
   //print_r($user);
   global $wpdb;
   $user = wp_get_current_user();
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
  
  
    
    $roleData = '';
    
    
    if(isset($_POST['update_job'])) 
      {
            global $wpdb;                        
            //echo "hello";
            //die;
            $post_id = $_POST['post_ids'];
            $my_post = array(
                'ID'           => $post_id,
                'post_title'   => $_POST['post_title']
            );

            // Update the post into the database
            wp_update_post( $my_post );
            
            $apply_ids = $_POST['apply_ids'];
            //$wpdb->query($wpdb->prepare("UPDATE wp_job_apply SET status=".$_POST['job_status']." WHERE apply_id=".$apply_ids));

			$wpdb->update('wp_job_apply', array('status' => $_POST['job_status']),array('apply_id' => $apply_ids),array('%d'));
update_post_meta($post_id, 'recruiter_note_content',$_POST['note_content']);

           // header('Location: '.site_url().'/candidates-tracker');

      }
      
    
  if ( in_array( 'cs_employer', (array) $user->roles ) ) {
      $roleData = '1';
      $refer_by_com = get_user_meta($rec_id, 'refer_by_com', true);
      $back_site_url = "/company-dashboard/";
  } else if ( in_array( 'recruiter', (array) $user->roles ) ) {
      
      $roleData = '2';
      $back_site_url = "/recruiter-dashboard/";      
  } else {
      
      wp_redirect( site_url() );
  }

  
  if($roleData == '1' || $roleData == '2') {
      
      
?>
<div class="main-section">
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Candidates Tracker<a href="<?php echo site_url().$back_site_url; ?>" class="btn btn-info btn-md" style="float: right;font-size: 14px !important;color: #fff !important;">Home</a></h4>

                </div>
            </div>
            
                    
                    <?php 
                    
                        $htmlHeader ='<div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="candidate_datatype table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>';
                                                        if($roleData == '1') {
                                                            $htmlHeader.='<th>Recruiter Name</th>';
                                                        }
                                            $htmlHeader.='<th>Job Title</th>
                                                    <th>Candidate Name</th>
                                                    <th>Job Applied</th>
                                                    <th>Note From Candidate</th>
                                                    <th>Recruiter Notes</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                        
                        
                             $cnt = 0;
                             if($roleData == '1') {
                                $myrows = $wpdb->get_results( "SELECT * from wp_job_apply where company_id=".$user->ID);
                             } else if($roleData == '2') {
                                 $myrows = $wpdb->get_results( "SELECT * from wp_job_apply where recruiter_id=".$user->ID);
  
                             }

							 
                             $html = '';
                            if ( $myrows )
                            {
                                foreach ( $myrows as $resultData ) 
                                {
                                    $apply_id = $resultData->apply_id;
                                    $candidate_id = $resultData->candidate_id;
                                    $candidate_list = $resultData->candidates;
                                    $post_id = $resultData->post_id;
                                    $recruiter_id = $resultData->recruiter_id;
                                    $resume_file = $resultData->resume_file;
                                    $cv_file = $resultData->cv_file;
                                    $job_status = $resultData->status;
                                    $applied_date = $resultData->applied_date;
                                    $post_data = get_post($post_id);
                                    $user_data  = get_userdata($candidate_id);
                                    $recruiter_name = get_userdata($recruiter_id);
                                    $note_content = get_post_meta($post_id,'recruiter_note_content',true);
									$note_cnt = ($note_content) ? $note_content : 'No note...';
                                    $cnt++;
                                    
                                    if($job_status == 0) 
                                        $status_data = "In Process";
                                    else if($job_status == 1) 
                                        $status_data = "Interviewing";
                                    else if($job_status == 2) 
                                        $status_data = "Employed";
                                    else if($job_status == 3) 
                                        $status_data = "Employed for 90 days";
                                    else if($job_status == 4) 
                                        $status_data = "Terminated";
                                    ?>
                    
                                    <div id="myModal-apply<?php echo $apply_id; ?>" class="modal fade" role="dialog">
                                        
                                    <div class="modal-dialog">
                                          <!-- Modal content-->
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title">Update Job</h4>
                                            </div>

                                            <div class="modal-body">

                                                <div class="panel-body">

                                                    <form action="" method="post" enctype="multipart/form-data">

                                                        <input type="hidden" name="apply_ids" id="apply_ids" value="<?php echo $apply_id; ?>" />
                                                        <input type="hidden" name="post_ids" value="<?php echo $post_id; ?>" />
														

                                                        <label for="status"><h5>Job Title</h5></label>
                                                        <input type="text" name="post_title" id="post_title" value="<?php echo $post_data->post_title; ?>"/>

                                                        <label for="status"><h5>Status</h5></label>
                                                        <select name="job_status" id="job_status" data-type="select" style="border:1px solid #f2f2f2 !important;">

                                                            <option value="0" <?php echo ($job_status == 0)  ? 'selected="selected"': ''; ?>>In Process</option>
                                                            <option value="1" <?php echo ($job_status == 1)  ? 'selected="selected"': ''; ?>>Interviewing</option>
                                                            <option value="2" <?php echo ($job_status == 2)  ? 'selected="selected"': ''; ?>>Employed</option>
                                                            <option value="3" <?php echo ($job_status == 3)  ? 'selected="selected"': ''; ?>>Employed for 90 days</option>
                                                            <option value="4" <?php echo ($job_status == 4)  ? 'selected="selected"': ''; ?>>Terminated</option>


                                                        </select><br/>
														<label for="status"><h5>Recruiter Notes</h5></label>
                                                        <textarea name="note_content" row="5"><?php echo $note_content; ?></textarea>
                                                        <br/>
                                                        <br/>
                                                        
                                                        <input type="submit" name="update_job" id="update_data" value="Update" class="btn btn-success">


                                                    </form>

                                                  </div>
                                            </div>
                                            <div class="modal-footer">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                          </div>

                                    </div>
                                  </div>

                                 <?php
                                 
                                    $html .='<tr><td>'.$cnt.'</td>';
                                    if($roleData == '1') {
                                        
                                        $html.='<td><span>'.esc_html( $recruiter_name->display_name ).'</span></td>';
                                        
                                    }
                                    $html.='<td><span>'.esc_html( $post_data->post_title ).'</span></td>
                                        <td><span>'.esc_html( $user_data->display_name ).'</span></td>
                                        <td><span>'.date('d-m-Y',$applied_date).'</span></td>
                                        <td><span style="font-style: italic;">'.esc_html( $cv_file ).'</span></td>
                                        <td><label rel="'.$post_id.'" style="cursor:pointer;" class="note_btn"><i class="icon-eye3"></i>&nbsp;View<input type="hidden" id="note_btn_'.$post_id.'" value="'.esc_html( $note_cnt ).'" /></label></td>
                                        <td><a>'.$status_data.'</a></td>
                                       <td>
                                           <a style="cursor:pointer;" class="icon-edit3" data-toggle="modal" data-target="#myModal-apply'.$apply_id.'"></a>&nbsp;&nbsp;&nbsp;
                                           <a target="_blank" href="'.$resume_file.'"><i class="icon-eye3"></i>&nbsp;&nbsp;Resume</a>
                                       </td>
                                   </tr>';

                            } } else {
            
                                   $html .='<tr>
                                       <td colspan="7">No Candidate at this time.</td>
                                   </tr>';
                            }
                            $html.='</tbody>
                                   </table></div>
                                    </div>';
                            
                            echo $htmlHeader.$html;
                            
                 ?>
                
        </div>
    </div>
</div>
<!-- Modal -->
<div id="note_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Note</h4>
	  </div>
	  <div class="modal-body note_content">
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>

  </div>
</div>
<script>
jQuery(document).ready(function(){
	
	jQuery('.candidate_datatype').DataTable();
	
	jQuery('.note_btn').click(function(){
		var rel = jQuery(this).attr('rel');
		var html_txt = jQuery('#note_btn_'+rel).val();
		jQuery('.note_content').html(html_txt);
		jQuery('#note_modal').modal('show');
	});
	
});

</script>

<?php }
get_footer();
?>