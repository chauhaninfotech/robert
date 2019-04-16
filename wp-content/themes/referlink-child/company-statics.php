<?php
   /*
     Template Name: Company Statics
    */
get_header();
?>
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css" rel="stylesheet" />

<script type="text/javascript">
    var timeoutHandle;
    function count() {

    var startTime = document.getElementById('hms').innerHTML;
    var pieces = startTime.split(":");
    var time = new Date();    time.setHours(pieces[0]);
    time.setMinutes(pieces[1]);
    time.setSeconds(pieces[2]);
    var timedif = new Date(time.valueOf() - 1000);
    var newtime = timedif.toTimeString().split(" ")[0];
    document.getElementById('hms').innerHTML=newtime;
    timeoutHandle=setTimeout(count, 1000);
}
count();

</script>
	
<?php
   $user = wp_get_current_user();
   //print_r($user);
   
	$id = $user->ID;
   
	$all_meta_for_user = get_user_meta($user->ID);
	//print_r( $all_meta_for_user );
  
	$user = wp_get_current_user();
    $role = ( array ) $user->roles;
    //echo $role[0];
	
  $company_name = get_user_meta($user->ID,'company_name', true);
  //$ref_id = get_user_meta($user->ID,'company_name', true);
  
  $ref_url = site_url().'/recruiter-register/?ref_id='.$id.'&ref_company='.$company_name;
  $ref_name = 'Recruiter Registration by '.$company_name;
  
  
  //if ( in_array( 'um_company', (array) $user->roles ) ) {
  if ( in_array( 'cs_employer', (array) $user->roles ) ) {
?>


<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Company Statics <a href="<?php echo site_url(); ?>/company-dashboard/" class="btn btn-info btn-md" style="float: right;font-size: 14px !important;color: #fff !important;">Dashboard</a></h4>

                </div>

            </div>
			
			
			<div class="row">
                <div class="col-md-6">
                  <!--   Kitchen Sink -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Recruiter Refer by You
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            

							<table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Reg. No.</th>
                                            <th>Registration Date</th>
                                            <th>Recruiter Name</th>
                                            <th>Status</th>
                                            <th>Pitch</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
										<?php 
										$blogusers = get_users(array('meta_key' => 'refer_by', 'meta_value' => $id, 'role'=>'recruiter'));
										foreach ( $blogusers as $user ) {
										?>
                                        <tr>
                                            <td># <?php echo $user->ID; ?></td>
                                            <td><?php 
											echo $registered = $user->user_registered;
											
											?>
											</td>
                                            <td>
                                                <span><?php echo esc_html( $user->display_name ); ?></span>
                                            </td>
                                            <td>
                                                <label class="label label-success">Active</label></td>
                                            <td><?php echo get_user_meta($user->ID,'pitch', true);?> </td>
                                            
                                        </tr>
                                        
										<?php } ?>
										
										
                                    </tbody>
                            </table>
                          
							
							</div>
                        </div>
                    </div>
                     <!-- End  Kitchen Sink -->
                </div>
                <div class="col-md-6">
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Candidate List
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                
								
								
								
								<table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Candidate Name</th>
                                            <th>E-Mail</th>
                                            <th>Job</th>
											<th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									
										<?php 
										$candidate = get_users(array('role'=>'cs_candidate'));
										$i = 1;
										foreach ( $candidate as $can ) {
										//echo '<pre>'.print_r($can).'</pre>';	
										?>
										
										
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo esc_html( $can->display_name ); ?></td>
                                            <td><?php echo esc_html( $can->user_email );?></td>
                                            <td>@mdo</td>
											<td><a href="<?php echo site_url(); ?>/candidate/<?php echo $can->user_login; ?>">View</a></td>
                                        </tr>
                                        <?php $i++; ?>
										<?php } ?>
										
                                    </tbody>
                                </table>
								
								
								
								
								
								
								
								
								
								
								
								
                            </div>
                        </div>
                    </div>
                      <!-- End  Basic Table  -->
                </div>
            </div>
            
			
			<div class="row">
                <div class="col-md-12">
                     <!--    Hover Rows  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Affiliate Candidate
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>E-Mail</th>
											<th>Refer Candidate</th>
											<th>Refer Candidate Job</th>
											<th>Refer Candidate Date</th>
                                            <th>Total Pay</th>
											<th>Status</th>
											<th>Time Remaining</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>David Watkins</td>
                                            <td>dum19@chimpgroup.com</td>
                                            <td>Annette Cox</td>
											<td>Computer and Information Tech</td>
											<td>12/7/2018</td>
											<td>$20</td>
											<td><label class="label label-info">Panding</label></td>
											<td><div id="hms">00:10:10</div></td>
											
											
											
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Jacob</td>
                                            <td>Jacob@chimpgroup.com</td>
                                            <td>Annette Cox</td>
											<td>Graduate Inside Sales Executive Job</td>
											<td>18/7/2018</td>
											<td>$30</td>
											<td><label class="label label-success">Paid</label></td>
											<td><div id="hms">00:00:00</div></td>
											
											
                                        </tr>
                                       
                                    
									
									
									</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End  Hover Rows  -->
                </div>
            </div>    
			
		
		
		</div>
    </div>

<?php } else { ?>
<?php wp_redirect( site_url() ); ?>
<?php } ?>
	
<?php get_footer(); ?>