<?php
/*
  Template Name: Company Overview
 */

get_header();
global $wpdb;

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

?>

    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css" rel="stylesheet" />
<?php
$crr_userdata = wp_get_current_user();
$user_id = $crr_userdata->ID;


$cid = base64_encode($user_id);
  
  
  if ( in_array( 'cs_employer', (array) $crr_userdata->roles ) ) {
      
      
      if(isset($_POST['update'])) {
          
          $metas = array(
                    'first_name'  => $_POST['first_name1'], 
                    'last_name'   => $_POST['last_name1'],
                    'location'    => $_POST['location'],
                    'email'       => $_POST['email1'],
                    'nickname'    => $_POST['email1'],
                    'department'  => $_POST['department'],
                    'description' => $_POST['description'],
                    'url'     	  => $_POST['website'],
                    'number_of_employees' => $_POST['number_of_employees'],
                    'edit_profile' => 1
                );
                
                 $rec_id1 = base64_decode($cid);

          foreach($metas as $key => $value) {
              update_user_meta( $rec_id1, $key, $value );
          }
          
          
          wp_update_user( array( 'ID' => $rec_id1, 'user_email' => $_POST['email1'] ) );
          wp_update_user( array( 'ID' => $rec_id1, 'user_nicename' => $_POST['first_name1'].$_POST['last_name1']));
          wp_update_user( array( 'ID' => $rec_id1, 'display_name' => ucwords($_POST['first_name1'])." ".ucwords($_POST['last_name1'])));
          wp_update_user( array( 'ID' => $rec_id1, 'user_url' => $_POST['website']));
          
          if ( metadata_exists( 'user', $rec_id1, 'company' ) ) {
                update_user_meta( $rec_id1, 'company', $_POST['company'] );
          } else {
                add_user_meta( $rec_id1, 'company', $_POST['company'] );
          }
          
          if ( metadata_exists( 'user', $rec_id1, 'company_name' ) ) {
                update_user_meta( $rec_id1, 'company_name', $_POST['company_name'] );
          } else {
                add_user_meta( $rec_id1, 'company_name', $_POST['company_name'] );
          }
          
          if ( metadata_exists( 'user', $rec_id1, 'number_of_employees' ) ) {
                update_user_meta( $rec_id1, 'number_of_employees', $_POST['number_of_employees'] );
          } else {
                add_user_meta( $rec_id1, 'number_of_employees', $_POST['number_of_employees'] );
          }
          
          if ( metadata_exists( 'user', $rec_id1, 'department' ) ) {
                update_user_meta( $rec_id1, 'department', $_POST['department'] );
          } else {
                add_user_meta( $rec_id1, 'department', $_POST['department'] );
          }
          
          if ( metadata_exists( 'user', $rec_id1, 'pitch' ) ) {
                update_user_meta( $rec_id1, 'pitch', $_POST['pitch'] );
          } else {
                add_user_meta( $rec_id1, 'pitch', $_POST['pitch'] );
          }
          
          
          if ( metadata_exists( 'user', $rec_id1, 'perks' ) ) {
                update_user_meta( $rec_id1, 'perks', $_POST['perks'] );
          } else {
                add_user_meta( $rec_id1, 'perks', $_POST['perks'] );
          }
 
		if(!empty($_FILES['upload_image_overview']['name'])){

            if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
                
            $uploadedfile = $_FILES['upload_image_overview'];
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
            
            
            if ( metadata_exists( 'user', $rec_id1, 'edit_profile' ) ) {
                update_user_meta( $rec_id1, 'edit_profile', '1' );
            } else {
                  update_user_meta( $rec_id1, 'edit_profile', '1' );
            } 
			
		}
		
		header('Location: '.site_url().'/company-overview');
   }
      
?>
<div class="main-section">
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Company Overview <a href="<?php echo site_url(); ?>/company-dashboard/" class="btn btn-info btn-md" style="float: right;font-size: 14px !important;color: #fff !important;">Home</a></h4>

                </div>
            </div>
			
			
			<?php //echo do_shortcode('[RM_Front_Submissions]');
				
                            $crr_userdata = wp_get_current_user();
							
                            $user_id = $crr_userdata->ID;
                            $rec_email = $crr_userdata->user_login;
                            //$rec_email = $crr_userdata->user_email;

                            //$logerImg = get_user_meta($rec_id, 'user_img', true);
                            
                            $user_avatar = get_user_meta($user_id, 'user_img', true);
                            
                            $user_avatar = wp_get_attachment_url($user_avatar);
                           
							
							
                            if ( metadata_exists( 'user', $user_id, 'edit_profile' ) ) {
                                //update_user_meta( $rec_id1, 'edit_profile', '1' );
                                
                                $first_name = get_user_meta($user_id, 'first_name', true);
                                $last_name = get_user_meta($user_id, 'last_name', true);
                                $name = $first_name.' '.$last_name;
                                $description = get_user_meta($user_id, 'description', true);
                                $pitch = get_user_meta($user_id, 'pitch', true);
                                $perks = get_user_meta($user_id, 'perks', true);
                                $email = $rec_email; //get_user_meta($user_id, 'email', true);
                                $location = get_user_meta($user_id, 'location', true);

                               $department = get_user_meta($user_id, 'department', true);
                                $company_name = get_user_meta($user_id, 'company_name', true);
                                $company = get_user_meta($user_id, 'company', true);
                                $website = get_user_meta($user_id, 'url', true);
                                
                                $user_avatar = get_user_meta($user_id, 'user_avatar', true);
								
                                
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
								//print_r($result);
                                //echo '<pre>'; print_r($result);

                                $first_name = $result['first_name'];
                                $last_name = $result['last_name'];
                                $name = $first_name.' '.$last_name;
                                $description = $result['bio'];
                                $pitch = $result['pitch'];
                                $perks = $result['what_perks_does_the_company_offer?'];
                                $email = $rec_email;
                                $location = $result['location'];

                                $department = $all_data['36']->value;
                                $company_name = $result['company_name'];
                                $company = $result['company'];
                                $website = $result['website_url'];

                                $num_of_emp = $result['how_many_employees_work_for_the_company?'];
                                $num_of_emp_arr = ($num_of_emp) ? explode('_',$num_of_emp) : $num_of_emp;
								if(is_array($num_of_emp_arr)){
									$number_of_employees = implode(' ',$num_of_emp_arr);
								}else{
									$number_of_employees = $num_of_emp_arr;
								}
                                
                                
                                
                            }
                            
  
                            ?>
							
			
            
            <?php if($_REQUEST['action'] == 'edit') { ?>
                
				
            
                <div class="container bootstrap snippet">

                    <div class="row">
                        <form class="form" action="" enctype="multipart/form-data" method="post" id="registrationForm">
                                <div class="col-sm-3"><!--left col-->
                                    <div class="text-center">
										<?php if(!empty($user_avatar)) { ?>
                                        <img src="<?php echo $user_avatar; ?>" class="avatar img-thumbnail" alt="avatar">
										<?php }else{ echo company_logo_api($user_id); } ?>
							
                                        <h6>Upload a different photo...</h6>
                                        <input type="file" name="upload_image_overview" class="text-center center-block file-upload">
                                    </div></hr><br>
                                </div><!--/col-3-->
                                
                                <div class="col-sm-9">   
                                        
                                    <h2>Profile Update</h2>
									<div class="form-group">
									   <div class="col-md-12">
											<center><button style="float: right; border-radius: 5px; margin-bottom: 10px" class="btn btn-lg btn-info" name="update" type="submit">Save Company profile</button></center>
										</div>
									</div>
                                    
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="home">
                                              <hr>

                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <label for="first_name"><h5>First name</h5></label>
                                                            <input type="text" class="form-control" name="first_name1" id="first_name" value="<?php echo $first_name; ?>" title="enter your first name">
                                                        </div>


                                                        <div class="col-md-6">
                                                          <label for="last_name"><h5>Last name</h5></label>
                                                            <input type="text" class="form-control" name="last_name1" id="last_name" value="<?php echo $last_name; ?>" title="enter your last name">
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <label for="location"><h5>Location</h5></label>
															<?php echo do_shortcode('[custom_texnomoy_location selected="'.$location.'"]'); ?>
                                                        </div>
														
														<div class="col-xs-6">
                                                            <label for="company"><h5>Company</h5></label>
                                                            <input type="text" class="form-control" name="company_name" id="company_name"  value="<?php echo $company_name; ?>" title="enter a company name">
                                                        </div>
                                                        
                                                    </div>
													<div class="row">
														<div class="col-md-12">
                                                            
                                                            <label for="website"><h5>Website</h5></label>
                                                            <input type="text" class="form-control" name="website" id="website_54" value="<?php echo $website; ?>" title="enter a website">
                                                        
                                                        </div>
                                                    
                                                    </div>  
                                                    <div class="row">
                                                        
                                                        <div class="col-md-6">

                                                            <label for="number of employees"><h5>Number of Employees</h5></label>
                                                            <select class="wpuf_number_of_employees_2366" name="number_of_employees" data-required="no" data-type="select">

                                                                    <option value="">- select -</option>
                                                                    <option value="Small(1-49)" <?php echo ($num_of_emp == 'Small (1-50)') ? 'selected' : ''; ?>>Small (1-50)</option>
                                                                    <option value="Medium (50-249)" <?php echo ($num_of_emp == 'Medium (50-249)') ? 'selected' : ''; ?>>Medium (50-249)</option>
                                                                    <option value="Large (250+)" <?php echo ($num_of_emp == 'Large (250+)') ? 'selected' : ''; ?>>Large (250+)</option>

                                                            </select>
															
																												
                                                        </div>
                                                    <?php $departs = array('Recruiter', 'Manager', 'Hiring Manager', 'Director'); ?>
                                                        <div class="col-md-6">
                                                            <label for="department"><h5>Department</h5></label>
																<select name="department" id="department">
																	<option value="">---Select---</option>
																	<?php foreach($departs as $depart){ 
																	
																	$selected = ($department == $depart) ? 'selected="selected"' : '';
																	
																		echo $option = '<option '.$selected.' value="'.$depart.'">'.$depart.'</option>';
																	}
																	?>
																	
																	
																	
																	
																</select>
                                                        </div>
                                                    </div>
													
													   

                                                    <div class="row">

                                                        

                                                        <div class="col-md-12">
                                                            
                                                            <label for="pitch"><h5>Pitch</h5></label>
															<textarea class="" rows="5" name="pitch" id="pitch"><?php echo $pitch; ?></textarea>
                                                            
                                                        </div>

                                                    </div>
                                              
                                                    <div class="row">
                                                        
                                                        <div class="col-md-12">
                                                            
                                                            <label for="bio"><h5>Perks</h5></label>
                                                            <textarea class="" rows="5" name="perks" id="perks"><?php echo $perks; ?></textarea>
                                                            
                                                        </div>
                                                    
                                                    </div>
                                                    
                                                    <div class="row">
                                                        
                                                        <div class="col-md-12">
                                                            
                                                            <label for="bio"><h5>Bio</h5></label>
                                                            <textarea class="" rows="5" name="description" id="description"><?php echo $description; ?></textarea>
                                                            
                                                        </div>
                                                    
                                                    </div>

                                                    <div class="form-group">
                                                         <div class="col-md-12">
                                                              
															<a href="<?php echo site_url();?>/company-overview/" class="label label-info" style="float: right;color: #fff !important;padding: 10px 20px;font-size: 15px !important; margin: 20px 0px; display: inline-block;">Back</a>
                                                          </div>
                                                    </div>

                                            <hr>

                                           </div><!--/tab-pane-->
                                            </div><!--/tab-pane-->
                                        </div><!--/tab-content-->
                              </form>
                                      </div><!--/col-9-->
                                  </div><!--/row-->
            
            <?php } else { ?>

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
                            <h2><?php echo ucwords($company_name); ?> <a href="<?php echo site_url();?>/company-overview?action=edit&pid=<?php echo $cid; ?>" class="label label-info" style="float: right;color: #fff !important;padding: 0px 10px;font-size: 15px !important;">Edit Profile</a></h2>
                          </div>
                            <hr>
                          <div class="col-md-6">  
							  <ul class=" details">
<li><p><label>Name :&nbsp;&nbsp;</label><?php echo $first_name.' '.$last_name; ?></p></li>
								<li><p><label>Email :&nbsp;&nbsp;</label><?php echo $rec_email; ?></p></li>
								<!--<li><p><label>Company :&nbsp;&nbsp;</label><?php //echo $company; ?></p></li>-->
								
								<li><p><label>Department :&nbsp;&nbsp;</label><?php echo $department; ?></p></li>
								<li><p><label>Location :&nbsp;&nbsp;</label><?php echo ucwords(str_replace('-',' ',$location)); ?></p></li>
							  </ul>
                          </div>
						  <?php $weburl = explode('://',$website);?>
						  <div class="col-md-6">  
							  <ul class=" details">
								<li><p><label>Website :&nbsp;&nbsp;</label><a class="weburl" target="_blank" href="http://<?php echo end($weburl); ?>"><?php echo $website; ?></a></p></li>
								<li><p><label>Number Of Employees :&nbsp;&nbsp;</label><?php echo $number_of_employees; ?></p></li>
								<li><p><label>Pitch :&nbsp;&nbsp;</label><?php echo nl2br($pitch); ?></p></li>
								<li><p><label>Perks :&nbsp;&nbsp;</label><?php echo nl2br($perks); ?></p></li>
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
                     <div class="col-md-12" style="padding-left:0px;">
                        <?php echo nl2br($description); ?> 
                     </div>
                     
                     
                    </div>

						
					         
                </div>
            
                                  
            <?php } ?>
        </div>
    </div>
</div>
<?php } else { ?>
<?php wp_redirect( site_url() ); ?>
<?php } ?>
<script>
    /*
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
			
    });  */
    
</script>
<?php 
get_footer();
?>