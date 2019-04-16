<?php
   /*
     Template Name: Company Dashboard
    */
get_header();

?>
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css" rel="stylesheet" />


<?php

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
   $user = wp_get_current_user();
   //print_r($user);
   
	$id = $user->ID;
   
	$all_meta_for_user = get_user_meta($user->ID);
	//print_r( $all_meta_for_user );
  
    $role = ( array ) $user->roles;
    //echo $role[0];
if ( metadata_exists( 'user', $user->ID, 'edit_profile' ) ) {
  $company_name = get_user_meta($user->ID,'company_name', true);
}else{
	$submission_id = get_user_meta($user->ID, 'RM_UMETA_SUB_ID', true);
                            
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
	
	$company_name = $result['company_name'];
}
  //$ref_id = get_user_meta($user->ID,'company_name', true);
  
  $ref_url = site_url().'/recruiter-register/?ref_id='.$id.'&ref_company='.$company_name;
  $ref_name = 'Recruiter Registration by '.$company_name;
  
  
  if ( in_array( 'cs_employer', (array) $user->roles ) ) {


	
?>




<div class="container"><i class="icon-camera6" id="company_profile_click" style="display: block;margin-top: 20px; cursor:pointer;margin-left:5%;"></i></div>
  <div class="content-wrapper company_info_wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Main Page</h4>

                </div>

            </div>
            
            <div class="row">
                 
                 <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="<?php echo site_url(); ?>/company-overview/" class="dashboard-div-wrapper bk-clr-two">
                        <h3 style="margin:0px;">Company Overview</h3><i style="color:#000000;">Candidates will see this when they click on your company. Here you can edit as needed, evey recruiter will be linked to this page through the jobs they post.</i>
                    </a>
                </div>
				<div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="<?php echo site_url(); ?>/company-recruiters/" class="dashboard-div-wrapper bk-clr-two">
                        <h3 style="margin:0px;">Manage Recruiters</h3><i style="color:#000000;">Manage all your recruiter accounts here, below this box is a link you will send out to your team to sign up.</i>
                    </a>
                </div>
                

            </div>
			<div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="<?php echo site_url(); ?>/candidates-tracker/" class="dashboard-div-wrapper bk-clr-three">
                       <h3 style="margin:0px;">Candidate Tracker</h3><i style="color:#000000;">Here, you can manage all of the candidates that have applied, and what their status is; based on the recruiters' update.</i>
                    </a>
					</div>
                 
                 <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="notice-board">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                           Add Recruiter Link
                                <div class="pull-right" >
                                    <div class="dropdown">
								  <button class="btn btn-info dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
									<span class="glyphicon glyphicon-cog"></span>
									<span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick='window.location.reload(true);'>Refresh</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
								  </ul>
								</div>
                                </div>
                            </div>
                          
                            <div class="panel-footer">
								<input type="text" value="<?php echo $ref_url; ?>" id="myInput">

								<!-- The button used to copy the text -->
								<button onclick="myFunction()" class="btn btn-default btn-block"><i class="glyphicon glyphicon-copy"></i> Copy URL</button>

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            
        </div>
    </div>
<!-- Modal -->
				<div id="background_img" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Update Cover Background</h4>
					  </div>
					  <div class="modal-body">
						<form id="avtar" action="" method="post" enctype="multipart/form-data">
							<div class="cs-img-detail">

                                <div class="upload-btn-div" style="margin-left: 80px;">

                                    <div class="fileUpload uplaod-btn btn cs-color csborder-color">
										<input type="file" required="" id="user_img_bg" name="user_img_bg">
                                        <input type="submit"class="acc-submit cs-section-update cs-bgcolor csborder-color cs-color" name="user_img_bg_btn" value="Upload Picture">				

                                    </div>

                                    <br />

                                    <span id="cs_candidate_profile_img_msg"><?php esc_html_e('Please upload cover image 1200x300 resolution ', 'jobhunt'); ?></span>

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
				<!--company profile image-->
				
				<div id="company_profile_img" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Upload Company Photo</h4>
					  </div>
					  <div class="modal-body">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="cs-img-detail">

                                <div class="upload-btn-div" style="margin-left: 80px;">

                                    <div class="fileUpload uplaod-btn btn cs-color csborder-color">
										<input type="file" required="" id="upload_image" name="upload_image">
                                        <input type="submit"class="acc-submit cs-section-update cs-bgcolor csborder-color cs-color" id="company_profile_image" name="company_profile_image" value="Upload Picture">				

                                    </div>

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
				
<?php } else { ?>
<?php wp_redirect( site_url() ); ?>
<?php } ?>

<script>
function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Link copied");
//alert("Link copied: " + copyText.value);
}
jQuery(document).ready(function(){
jQuery('#company_bg').css('display','block');
	jQuery('#company_bg').click(function(){
		jQuery('#background_img').modal('show');
	});
jQuery('#company_profile_click').css('display','block');
	jQuery('#company_profile_click').click(function(){
		jQuery('#company_profile_img').modal('show');
	});	
});

</script>
	<style>
	.dashboard-div-wrapper{padding: 60px 10px;}
#upload_cover{ display:block !important;}
.company_info_wrap{
font-family: "Montserrat", sans-serif !important;
	font-size: 14px;
}
.company_info_wrap h3{
font: 700 Normal 24px/24px "Raleway", sans-serif !important;
    letter-spacing: 1px !important;
    text-transform: uppercase !important;
    color: #424242 !important;

	</style>
<?php get_footer(); ?>