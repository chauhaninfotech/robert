<?php
   /*
     Template Name: Candidate Refer
    */
   
   get_header();
   
   ?>


<?php
   $user = wp_get_current_user();
   //print_r($user)
   if ( in_array( 'cs_candidate', (array) $user->roles ) ) {
?>
<div class="main-section">
    <section class="page-section">
        <div class="container-fluid post-details">
            <div class="row">
                <div class="col-md-12 tab-container">
                    <div class="tab">
                        <button class="tablinks" onclick="openCity(event, 'Paris')" id="defaultOpen">Jobs</button>
                        <button class="tablinks" onclick="openCity(event, 'Tokyo')">Inbox</button>
                        
                    </div>
                    
                    <div id="Paris" class="tabcontent">
                        <?php
                        $query = array(
                        'post_type' => 'jobs',
                        'meta_key' => 'cs_job_status',
                        'meta_value' => 'active'
                        );
                        $loop = new WP_Query($query);
                        
                        while ( $loop->have_posts() ) : $loop->the_post();
                        
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
                                      $content = apply_filters( 'the_content', get_the_content() );
                                      $text = substr( $content, 0, strpos( $content, '</p>' ) + 4 );
                                      echo $text = preg_replace("/<img[^>]+\>/i", "", $text);
                                    ?>
                                  </div>
                                <div class="more-prt" style="display:none;">
                                  <div id="requirment" class="panel-inner">
                                      <div class="inner">
                                          <div class="cs-element-title cs-color csborder-color">
                                              <h4><?php esc_html_e('Requirments', 'jobhunt') ?></h4>
                                          </div>
                                          <div class="cs-requirment">
                                              <ul>
                                                <li>BS In Finance</li>
                                                <li>BS In Finance</li>
                                                <li>BS In Finance</li>
                                                <li>BS In Finance</li>
                                              </ul>
                                          </div>
                                          
                                        </div>
                                   </div>
                                </div>
								
								<div class="more-field">
									<ul>
									
										<li><?php echo get_post_meta($ID,'cs_job_username', true); ?> | </li>
										<li><?php 
											$now = time(); // or your date as well
											$your_date = get_post_meta($ID,'cs_job_expired', true);											
											$datediff = $now - $your_date;
											echo round($datediff / (60 * 60 * 24));
											?> | </li>
										<li><?php echo get_post_meta($ID,'cs_job_status', true); ?></li>
									</ul>
								</div>
								
                              </div>
                              <div class="col-md-4 col-lg-4">
									<div class="refer">
										<a class="btn" href="<?php echo site_url(); ?>/refer-job/?job-id=<?php echo $ID; ?>&refer-id=<?php echo $user->ID; ?>"><i class="fa fa-random" aria-hidden="true"></i> Refer This Candidate</a>
									</div>
									<div class="social">
										<div class="glassdoor-btn"><a href="<?php echo get_user_meta($user->ID, 'cs_linkedin', true); ?>"><i class="fa fa-linkedin-square" aria-hidden="true"></i> Glassdoor</a></div>									
										<div class="linkedin-btn"><a href="<?php echo get_user_meta($user->ID, 'cs_linkedin', true); ?>"><i class="fa fa-linkedin-square" aria-hidden="true"></i> Linkedin </a></div>
									</div>
									<span class="more">Show More...</span>
								</div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
					
					
					
                    <div id="Tokyo" class="tabcontent">
                      <div class="col-md-12 col-lg-12 can-post bg-inherit">
                            <div class="listing-wrap clearfix">
                              <?php echo do_shortcode('[front-end-pm]'); ?>
                            </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

   jQuery(document).ready(function() {
       jQuery("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
           e.preventDefault();
           jQuery(this).siblings('a.active').removeClass("active");
           jQuery(this).addClass("active");
           var index = jQuery(this).index();
           jQuery("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
           jQuery("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
       });
   });
</script>
<script>
   jQuery(".more").toggle(function(){
       jQuery(this).text("less..").parent().addClass('active-show');
   	jQuery('.more-prt').hide();
   	jQuery('.active-show .more-prt').show();
   }, function(){
       jQuery(this).text("more..").parent().removeClass('active-show');
   	jQuery('.more-prt').hide();
   });
</script>
<?php get_footer(); ?>