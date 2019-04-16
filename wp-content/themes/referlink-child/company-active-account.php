<?php
/*
  Template Name: Company Active Account
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
  
  if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete') {
      
      $rec_id = base64_decode($_REQUEST['rec_id']);
      wp_delete_user($rec_id);
      header('Location: '.site_url().'/company-active-account');
      
  }
  
  if(isset($_POST['update'])) {
      
      //print_r($_POST);
      //die;
                $metas = array(
                    'first_name'  => $_POST['first_name1'], 
                    'last_name'   => $_POST['last_name1'],
                    'location'    => $_POST['location'],
                    'email'       => $_POST['email1'],
                    'department'  => $_POST['department'],
                    'description' => $_POST['description'],
                    'pitch'       => $_POST['pitch'],
                    'website'     => $_POST['website'],
                    'number_of_employees' => $_POST['number_of_employees']
                );
                
                 $rec_id1 = base64_decode($_REQUEST['rec_id']);

          foreach($metas as $key => $value) {
              update_user_meta( $rec_id1, $key, $value );
          }
          
          
          wp_update_user( array( 'ID' => $rec_id1, 'user_email' => $_POST['email1'] ) );
          wp_update_user( array( 'ID' => $rec_id1, 'user_nicename' => $_POST['first_name1'].$_POST['last_name1']));
          wp_update_user( array( 'ID' => $rec_id1, 'display_name' => ucwords($_POST['first_name1'])." ".ucwords($_POST['last_name1'])));
          
          
          
          if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
                
            $uploadedfile = $_FILES['upload_image'];
            $upload_overrides = array( 'test_form' => false );
            add_filter('upload_dir', 'my_upload_dir');
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            remove_filter('upload_dir', 'my_upload_dir');

            if ( $movefile ) {
                //echo "File is valid, and was successfully uploaded.\n";
                //var_dump( $movefile);
                $resume_link = $movefile['url'];
                $image_id = pippin_get_image_id($resume_link);
//die;
                update_user_meta( $rec_id1, 'user_img', $image_id );
                if ( metadata_exists( 'user', $rec_id1, 'user_avatar' ) ) {
                    
                    update_user_meta( $rec_id1, 'user_avatar', $resume_link );
                } else {
                    add_user_meta( $rec_id1, 'user_avatar', $resume_link );
                }
            }
          
//          $allow = array("jpg", "jpeg", "gif", "png");
//            $todir = wp_upload_dir();
//            $todir =  $todir['url'];
//            $tobasedir = $upload_dir['basedir'];
//            
//            if ( $_FILES['upload_image']['tmp_name'] ) // is the file uploaded yet?
//            {
//                $info = explode('.', strtolower( $_FILES['upload_image']['name']) ); // whats the extension of the file
//                
//                //print_r($info);
//                
//                if ( in_array( end($info), $allow) ) // is this file allowed
//                {
//                    if ( move_uploaded_file( $_FILES['upload_image']['tmp_name'], $tobasedir."/".basename($_FILES['upload_image']['name'] ) ) )
//                    {
//                        // the file has been moved correctly
//                        
//                        $final_name = $todir."/".$_FILES['upload_image']['name'];
//                        
//                        update_user_meta( $rec_id1, 'user_avatar', $final_name );
//                    }
//                }
//                else
//                {
//                    // error this file ext is not allowed
//                }
//            }
//      
  }
  
  
  if ( in_array( 'cs_employer', (array) $user->roles ) ) {

      
      
?>
<div class="main-section">
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Recruiter account <a href="<?php echo site_url(); ?>/company-dashboard/" class="btn btn-info btn-md" style="float: right;font-size: 14px !important;color: #fff !important;">Home</a></h4>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
				
					<?php if(isset($_REQUEST['action'])){ ?>
					<?php 
$rec_id = base64_decode($_REQUEST['rec_id']);
$user_info = get_userdata($rec_id);
$rec_email = $user_info->user_email; 

$first_name = get_user_meta($rec_id, 'first_name', true);
$last_name = get_user_meta($rec_id, 'last_name', true);
$name = $first_name.' '.$last_name;
$description = get_user_meta($rec_id, 'description', true);
$status = get_user_meta($rec_id, 'wpuf_user_status', true);
$active = get_user_meta($rec_id, '_wpuf_user_active', true);
$pitch = get_user_meta($rec_id, 'pitch', true);
//$location = get_user_meta($rec_id, 'location', true);

$term_location = wp_get_post_terms( $rec_id, 'cs_locations', array( 'fields' => 'names' ) );

$department = get_user_meta($rec_id, 'department', true);
$company_name = get_user_meta($rec_id, 'company_name', true);
$website = get_user_meta($rec_id, 'website', true);
$refer_by_com = get_user_meta($rec_id, 'refer_by_com', true);
$user_avatar = get_user_meta($rec_id, 'user_avatar', true);

$num_of_emp = get_user_meta($rec_id, 'number_of_employees', true);
$num_of_emp_arr = ($num_of_emp) ? explode('_',$num_of_emp) : $num_of_emp;
if(is_array($num_of_emp_arr)){
$num_of_emp_ex = implode(' ',$num_of_emp_arr);
}else{
	$num_of_emp_ex = $num_of_emp_arr;
}




?>
						<?php if($_REQUEST['action'] == 'view'){ ?> 

						<div class="row">
                      <div class="col-md-3 col-xs-12 col-sm-6 col-lg-3">
                        <div class="thumbnail text-center photo_view_postion_b" >
                          <img src="<?php echo $user_avatar;?>" alt="stack photo" class="img">
                        </div>
                      </div>
                      <div class="col-md-9 col-xs-12 col-sm-6 col-lg-9">
                          <div class="" style="border-bottom:1px solid black">
                            <h2><?php echo $name; ?> </h2>
							 
                          </div>
                            <hr>
                          <div class="col-md-6">  
							  <ul class=" details">
								<!--<li><p><label>Email :&nbsp;&nbsp;</label><?php //echo $rec_email; ?></p></li>-->
								<!--<li><p><label>Company Name :&nbsp;&nbsp;</label><?php //echo ucwords($company_name); ?></p></li>-->
								<li><p><label>Recruiting :&nbsp;&nbsp;</label></span><?php echo ucwords($department); ?></p></li>
								<li><p><label>Location :&nbsp;&nbsp;</label><?php echo $term_location[0]; ?></p></li>
							  </ul>
                          </div>
						  <div class="col-md-6">  
							  <ul class=" details">
								<!--<li><p><label>Number Of Employee :&nbsp;&nbsp;</label><?php //echo $num_of_emp_ex; ?></p></li>-->
								<li><p><label>Refer By Company :&nbsp;&nbsp;</label><?php echo $refer_by_com; ?></p></li>
								<!--<li><p><label>Pitch :&nbsp;&nbsp;</label></span><?php //echo $pitch; ?></p></li>-->
								<li><p><label>Status :&nbsp;&nbsp;</label><?php echo ucfirst($status); ?></p></li>
							  </ul>
                          </div>
              
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group row">
                        <div class="col-md-12">
                        <div class="form-group" style="border-bottom:1px solid black">
                            <h2>Description</h2>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="row"> 
                     <div class="col-md-12">
                        <?php echo $description; ?> 
                     </div>
                     
                     
                    </div>
					<div class="row">
                           <div class="col-md-12">
								<a href="<?php echo site_url();?>/company-recruiters/" class="label label-info" style="float: right;color: #fff !important;padding: 10px 20px;font-size: 15px !important; margin: 20px 0px; display: inline-block;">Back</a>
                            </div>
							
                    </div>

						
					<?php } if($_REQUEST['action'] == 'edit'){ ?>
<div class="container bootstrap snippet">

    <div class="row"><form class="form" action="" enctype="multipart/form-data" method="post" id="registrationForm">
  		<div class="col-sm-3"><!--left col-->
          <div class="text-center">
			<!-- <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar"> -->
              
                        <img src="<?php echo $user_avatar;?>" class="avatar img-thumbnail" alt="avatar">
                        
			<h6>Upload a different photo...</h6>
			<input type="file" name="upload_image" class="text-center center-block file-upload">
		  </div></hr><br>
		</div><!--/col-3-->
    	<div class="col-sm-9">   
			<h2>Recruiter Profile Update</h2>
             <div class="form-group">
				   <div class="col-md-12">
						<center><button style="float: right; border-radius: 5px; margin-bottom: 10px" class="btn btn-lg btn-info" name="update" type="submit">Save recruiter profile</button></center>
					</div>
					
			</div>            
						  
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  
                      <div class="row">
                          
                          <div class="col-md-4">
                              <label for="first_name"><h5>First name</h5></label>
                              <input type="text" class="form-control" name="first_name1" id="first_name" value="<?php echo $first_name; ?>" title="enter your first name if any.">
                          </div>
                      
                          
                          <div class="col-md-4">
                            <label for="last_name"><h5>Last name</h5></label>
                              <input type="text" class="form-control" name="last_name1" id="last_name" value="<?php echo $last_name; ?>" title="enter your last name if any.">
                          </div>
						  
						   <div class="col-md-4">
							  <label for="department"><h5>Recruiting</h5></label>
							  <select name="department" id="department">
								<option value="">---Select---</option>
								<option <?php if($department == 'finance'){ echo 'selected="selected"'; } ?> value="finance">Finance</option>
								<option <?php if($department == 'recruiter'){ echo 'selected="selected"'; } ?> value="recruiter">Recruiter</option>
							</select>
                          </div>
						  
                      </div>
 
                      <!--<div class="row">
                          
                          <div class="col-md-6">
                              <label for="email"><h5>Email</h5></label>
                              <input type="email" class="form-control" name="email1" id="email" value="<?php echo $rec_email; ?>" title="enter your email.">
                          </div>
                      
                          
                         
                      </div>
                
                      <div class="row">
                          
                          <div class="col-xs-6">
                              <label for="company"><h5>Company</h5></label>
                              <input type="text" class="form-control" readonly="" value="<?php //echo $company_name; ?>" title="enter a company name">
                          </div>
						<div class="col-md-6">
                            
                            <label for="website"><h5>Number of Employees</h5></label>
                            <select class="wpuf_number_of_employees_2366" name="number_of_employees" data-required="no" data-type="select">
                                  
                                    <option value="">- select -</option>
                                    <option value="less_then_5" <?php //echo ($num_of_emp == 'less_then_5') ? 'selected' : ''; ?>>Less then 5</option>
                                    <option value="5-10" <?php //echo ($num_of_emp == '5-10') ? 'selected' : ''; ?>>5-10</option>
                                    <option value="10-15" <?php //echo ($num_of_emp == '10-15') ? 'selected' : ''; ?>>10-15</option>
                                    <option value="more_then_15" <?php //echo ($num_of_emp == 'more_then_15') ? 'selected' : ''; ?>>More then 15</option>
                                    
                            </select>
                              
                          </div>
                          
                          <div class="col-md-6">
                              <label for="location"><h5>Location</h5></label>
                              <input type="text" class="form-control" name="location" id="location" value="<?php //echo $location; ?>" title="enter a location">
                          </div>
                      </div>-->
                
                      <!--<div class="row">
							
							<div class="col-md-6">
                              <label for="website"><h5>Website</h5></label>
                              <input type="text" class="form-control" name="website" id="website" value="<?php //echo $website; ?>" title="enter a website">
                            </div>
							
							<div class="col-md-6">
                              <label for="website"><h5>Pitch</h5></label>
                              <input type="text" class="form-control" name="pitch" id="pitch" value="<?php //echo $pitch; ?>" title="enter a pitch">
							</div>
                          
						</div>-->
						 <div class="row">
							<div class="col-md-12">
                                <label for="bio"><h5>Bio</h5></label>
                                <textarea class="" rows="5" name="description" id="description"><?php echo nl2br($description); ?></textarea>
                            </div>
						</div>
							
                    <div class="form-group">
                           <div class="col-md-12">
								<a href="<?php echo site_url();?>/company-recruiters/" class="label label-info" style="float: right;color: #fff !important;padding: 10px 20px;font-size: 15px !important; margin: 20px 0px; display: inline-block;">Back</a>
                            </div>
							
                    </div>

              <hr>
              
             </div><!--/tab-pane-->
              </div><!--/tab-pane-->
          </div><!--/tab-content-->
</form>
        </div><!--/col-9-->
    </div><!--/row-->
					<?php }}else{ ?>
				
                                <table class="candidate_datatype table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
											<th>Recruiter Name</th>
											<th>Recruiter Email</th>
                                            <th>Registration Date</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
									   <?php 
										$cnt = 0;
										$blogusers = get_users(array('meta_key' => 'refer_by', 'meta_value' => $id, 'role'=>'recruiter'));
										foreach ( $blogusers as $user ) {
											
										$cnt++;
										$rec_id = base64_encode($user->ID);
										$status = get_user_meta($user->ID, 'wpuf_user_status', true);
										$registered = '';
										if(!empty($user->user_registered)){
											$dd = explode(' ',$user->user_registered);
											$dd1 = explode('-',$dd[0]);
											$registered = $dd1[2].'-'.$dd1[1].'-'.$dd1[0];
										}
				
										?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
											<td><span><?php echo esc_html( $user->display_name ); ?></span></td>
											<td><span><?php echo esc_html( $user->user_email ); ?></span></td>
                                            <td><?php echo $registered;?></td>
											<!--<td><?php //echo get_user_meta($user->ID,'pitch', true);?> </td>-->
											<td><?php echo ucfirst($status); ?></td>
                                            <td><a href="<?php echo site_url() ?>/company-recruiters/?action=view&rec_id=<?php echo $rec_id; ?>" class="icon-eye3"></a>&nbsp;&nbsp;
                                                <a href="<?php echo site_url() ?>/company-recruiters/?action=edit&rec_id=<?php echo $rec_id; ?>" class="icon-edit3"></a>&nbsp;&nbsp;
                                                <a href="<?php echo site_url() ?>/company-recruiters/?action=delete&rec_id=<?php echo $rec_id; ?>" class="icon-trash delete_data"></a>&nbsp;&nbsp;
                                                <a href="<?php echo site_url() ?>/company-jobs/?action=jobs&rec_id=<?php echo $rec_id; ?>" class="">Posted Jobs</a></td>
                                            
                                            
                                        </tr>
                                        
										<?php } ?>
										
										
                                    </tbody>
                                </table>
					<?php } ?>
         
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
<?php wp_redirect( site_url() ); ?>
<?php } ?>
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
<?php 
get_footer();
?>