<?php
   /*
     Template Name: Employee Dashboard 
    */
   
   get_header();
   
   ?>
<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/optionalStyling.css">
<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/web2cal.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo get_template_directory_uri(); ?>/js/Web2Cal-Basic-2.0-min.js">  </script>
<script src="<?php echo get_template_directory_uri(); ?>/js/web2cal.support.js">  </script>
<script src="<?php echo get_template_directory_uri(); ?>/js/web2cal.default.template.js">  </script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<script>

jQuery( function() {
    jQuery( "#eventStartDate, #eventEndDate" ).datepicker(
			{ dateFormat: 'yy-mm-dd' }
	);
} );
  
function getCalendarData()
{
    var d = new Array();
    var events = new Array();
	
	
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
	
    events.push(createEvent("<?php the_title(); ?>", <?php echo get_the_ID(); ?>, "Conf 201 ( 35th Floor )", "John Smith, Sue, James, Dan, Lisa", "<?php echo $date_n; ?>", "<?php echo $date_e; ?>", "<?php echo $desc; ?>", false));
    /*events.push(createEvent("Discuss Application Design", 2, "Conf 805, 300 Pine St, 8th Fl", "App Design Team, John, Joe, Jane, Lisa", createDateTime(23, 0, -13), createDateTime(23, 30, -8), "Discuss design and refractor of Application interface", true));
    events.push(createEvent("Sample Event ", 3, "Test Location", "John Smith", createDateTime(23, 0, -4), createDateTime(23, 30, 0), "Yoga is good for health", true));
    events.push(createEvent("Event can span for many days", 5, "My Desk", "John Smith", createDateTime(23, 0, -4), createDateTime(23, 30, 1), "Yoga is good for health", true));
    events.push(createEvent("Web2Cal Supports any number of attributes", 6, "yoga aud", "John Smith", createDateTime(23, 0, -18), createDateTime(23, 30, -18), "Yoga is good for health", true));
    events.push(createEvent("Web2Cal use in all business", 7, "yoga aud", "John Smith", createDateTime(0, 30, -2), createDateTime(3, 30, -2), "Yoga is good for health", false));
 	events.push(createEvent("Test Event 200", 8, "yoga aud", "John Smith", createDateTime(5, 0, 1), createDateTime(8, 30, 1), "Yoga is good for health", false));
    events.push(createEvent("Another Event 300", 9, "yoga aud", "John Smith", createDateTime(9, 0, 2), createDateTime(12, 30, 2), "Yoga is good for health", false));*/
    
	<?php endwhile; wp_reset_postdata(); ?>
	<!-- show pagination here -->
	<?php endif; ?>
	
	
    var group = {
        name: "Interviews",
        groupId: "100",
		show:true,
        events: events 
    };
   d.push(group);
    var events = new Array();
    
	
	/*
	events.push(createEvent("Morning Yoga", 10, "Yoga Auditorium", "Instructor1", createDateTime(15, 0, 1), createDateTime(19, 30, 1), "Morning Yoga is good for health"));
    events.push(createEvent("Event <b>HTML</b> 2", 11, "Event Location 2", "Instructor2", createDateTime(8, 0, -1), createDateTime(10, 30, -1), "Event Description ...", 'dsds', 'dsd', 'wewq'));
    events.push(createEvent("<div style='color:red'>Event 3</div>", 12, "Event Location 3", "Instructor3", createDateTime(11, 0, 0), createDateTime(15, 45, 0), "Event Description ..."));
    events.push(createEvent("Customizable with Templates....", 13, "Event Location 4", "Instructor4", createDateTime(6, 0), createDateTime(10, 0), "Event Description ..."));
    events.push(createEvent("Event 5", 14, "Event Location 5", "Instructor5", createDateTime(7, 0), createDateTime(10, 0), "Event Description ..."));
    
    events.push(createEvent("Event 6", 15, "Event Location 6", "Instructor6", createDateTime(16, 0, -2), createDateTime(20, 0, -2), "Event Description ..."));
    events.push(createEvent("Event 7", 16, "Event Location 7", "Instructor7", createDateTime(10, 0, -3), createDateTime(15, 0, -3), "Event Description ..."));
    events.push(createEvent("Event 8", 17, "Event Location 8", "Instructor8", createDateTime(9, 0, -5), createDateTime(11, 15, -5), "Event Description ..."));
    events.push(createEvent("Event 9", 18, "Event Location 9", "Instructor9", createDateTime(9, 0, 1), createDateTime(11, 15, 1), "Event Description ..."));
    */

    var group = {
        name: "Meeting",
        groupId: "200",
        events: events 
    }; 
   d.push(group);
    return d;
    
} 
function createDateTime(ti, h, numofDays)
{
    var dd = new Date();
    dd.setHours(ti);
    dd.setMinutes(h);
    
    var x = new UTC(dd.getTime());
    
    if (numofDays) 
    {
        x = new UTC();
		x.addDays(numofDays);
    } 
    return x;
}

function createEvent(name, id, location, instructor, timestart, timeend, desc, allDay, repeatObject)
{

    if (allDay == undefined) 
        allDay = false;
    
    return {
        name: name,
        eventId: id,
        location: location,
        instructor: instructor,
        startTime: timestart,
        endTime: timeend,
        description: desc,
        allDay: allDay,
        repeatEvent: repeatObject
    };
} 

</script>

<?php
   $user = wp_get_current_user();
   //print_r($user)
   if ( in_array( 'cs_employer', (array) $user->roles ) ) {
?>
<div class="main-section">
    <section class="page-section">
        <div class="container-fluid interview-calendar">
        <!-- Row -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Col Md 12 -->
                    <div id="calendarContainer">
                    </div>
                    <!-- Preview Template... -->
                    <div id="customPTemplate"  class="calendarTemplate fullPreviewTemplate " style="display:none">
                        <div class="aPointer p-left" style="display: block; z-index: 2; "></div>
                        <div id="ds-right" class="dshadow ds-right"></div>
                        <div id="ds-bottom" class="dshadow ds-bottom"></div>
                        <div id="ds-corner" class="dshadow ds-corner"></div>
                        <div class="header">
                            <?php $sss = '${eventId}';
                            //echo get_the_title('27');
                            
                            echo $eventStartDate =  get_post_meta($sss, 'eventStartDate', true );
                            echo $eventEndDate = get_post_meta($sss, 'eventEndDate', true );
                            echo $eventStartTime = get_post_meta($sss, 'eventStartTime', true );
                            echo $eventEndTime = get_post_meta($sss, 'eventEndTime', true );
                            
                            echo $candidate_name = get_post_meta( $sss, 'candidate_name', true );
                            echo $job = get_post_meta($sss, 'job', true );
                            ?>
                        </div>
                        <div class="prevRow">
                            <label>From: </label>
                            <div class="value">${_formattedStartDate} ${formattedStartTime}</div>
                        </div>
                        <div class="prevRow">
                            <label>To: </label>
                            <div class="value">${_formattedEndDate} ${formattedEndTime}</div>
                        </div>
                        <div class="prevRow">
                            <label>Description: </label>
                            <div class="value">${description}</div>
                        </div>
                        <div class="prevRow">
                            <label>Movable: </label>
                            <div class="value">${movable}</div>
                        </div>
                        <div class="prevRow">
                            <label>Resizable: </label>
                            <div class="value">${resizable}</div>
                        </div>
                        
                        <br/>
                        <ul class="actions">
                            <li> <a href="#" onclick="editMyEvent('${eventId}');" name="edit" class="buttonSmall btn btn btn-success"> Edit Interview </a> </li>
                            <li> <a href="" onclick="deleteMyEvent('${eventId}');" name="delete" class="buttonSmall btn btn-danger"> Delete Interview </a> </li>
                        </ul>
                    </div>
                    <!-- New Form -->
                    <div id="customNewEventTemplate" class="calendarTemplate newEventTemplate">
                        <div class="close-icn" id="close"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
						<div class="aPointer p-left " ></div>
                        <div class="header" >
                            Schedule Interview
                        </div>
                        
                        <?php echo do_shortcode('[wpuf_form id="2458"]'); ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="container-fluid post-details">
            <div class="row">
                <div class="col-md-12 tab-container">
                    <div class="tab">
                        <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">Candidates</button>
                        <button class="tablinks" onclick="openCity(event, 'Paris')">Jobs</button>
                        <button class="tablinks" onclick="openCity(event, 'Tokyo')">Inbox</button>
                        <a href="<?php echo site_url(); ?>/post-job">Post a Job</a>
                    </div>
                    <div id="London" class="tabcontent">
                        <?php
                        $blogusers = get_users( [ 'role__in' => [ 'cs_candidate' ] ] );
                        // Array of WP_User objects.
                        $i = 0;
                        foreach ( $blogusers as $user ) {
                        
                        $cs_get_edu_list = get_user_meta($user->ID, 'cs_edu_list_array', true);
                        $cs_edu_titles = get_user_meta($user->ID, 'cs_edu_title_array', true);
                        $cs_edu_from_dates = get_user_meta($user->ID, 'cs_edu_from_date_array', true);
                        $cs_edu_to_dates = get_user_meta($user->ID, 'cs_edu_to_date_array', true);
                        $cs_edu_institutes = get_user_meta($user->ID, 'cs_edu_institute_array', true);
                        $cs_edu_descs = get_user_meta($user->ID, 'cs_edu_desc_array', true);
                        
                        
                        ?>
                        <div class="col-md-12 col-lg-12 can-post bg-inherit">
                            <div class="listing-wrap clearfix">  
                              <div class="col-md-8 col-lg-8">
                                  <h2><?php echo esc_html( $user->display_name ); ?></h2>
                                  - <span><?php echo get_user_meta($user->ID, 'cs_job_title', true); ?></span>
                                  <div class="summery">
                                      <span>Generated Summery</span>
                                      <?php echo get_user_meta($user->ID, 'description', true); ?>
                                  </div>
                                  <div class="more-prt" style="display:none;">
                                      <div id="education" class="panel-inner">
                                          <div class="inner">
                                              <div class="cs-element-title cs-color csborder-color">
                                                  <h4><?php esc_html_e('Education', 'jobhunt') ?></h4>
                                              </div>
                                              <div class="cs-education">
                                                  <ul>
                                                      <li>
                                                          <span>XYZ University</span>
                                                          <p>BCA</p>
                                                          <p>1999-2003</p>
                                                          <p>
                                                              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                                                          </p>
                                                      </li>
                                                  </ul>
                                              </div>
                                              <div class="skill-set">
                                                  <ul>
                                                      <li>Really Good a Stuff</li>
                                                      <li>Really Good a Stuff</li>
                                                      <li>Really Good a Stuff</li>
                                                      <li>Really Good a Stuff</li>
                                                  </ul>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                  <div class="social">
										<div class="linkedin btn btn-info btn-lg"><a href="<?php echo get_user_meta($user->ID, 'cs_linkedin', true); ?>"><i class="fa fa-linkedin-square" aria-hidden="true"></i> Linkedin </a></div>
									</div>
									
                                  <!--<div class="refer">
                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal-refer"><i class="fa fa-random" aria-hidden="true"></i> Refer This Candidate</button>
									<div id="myModal-refer" class="modal fade" role="dialog">
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
												$blogusers = get_users(array('role'=>'um_company'));
												foreach ( $blogusers as $user ) {
												?>
													<option name="<?php echo $user->ID; ?>"><?php echo esc_html( $user->display_name ); ?></option>
												<?php } ?>
												</select>												
												<label>Candidate</label>
												<input type="text" class="form-control" value="<?php echo esc_html($user->display_name); ?>" disabled/>
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
                                      <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Send a Message</button>
                                    <div id="myModal" class="modal fade" role="dialog">
									  <div class="modal-dialog">

										<!-- Modal content-->
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Send a Message to <?php echo esc_html($user->display_name); ?></h4>
										  </div>
										  <div class="modal-body">
											 <div class="panel-body">
												<?php echo do_shortcode('[contact-form-7 id="5" title="Contact form 1"]'); ?>
											</div>
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										  </div>
										</div>

									  </div>
									</div>


                                  </div>
                                  <span class="more">more...</span>
                              </div>
                            </div>
                        </div>
                        <?php
                        if ($i == 3) { break; }
                        $i++;
                        }
                        ?>
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
                              </div>
                              <div class="col-md-4 col-lg-4">
									<div class="social">
										<div class="linkedin btn btn-info btn-lg"><a href="<?php echo get_user_meta($user->ID, 'cs_linkedin', true); ?>"><i class="fa fa-linkedin-square" aria-hidden="true"></i> Linkedin </a></div>
									</div>
									<div class="refer">
										<a class="refer-btn" href="<?php echo site_url(); ?>/refer-job/?job-id=<?php echo $ID; ?>&refer-id=<?php echo $user->ID; ?>"><i class="fa fa-random" aria-hidden="true"></i> Refer This Candidate</a>
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

   var ical;     
   
   /*
    Create the Calendar.
    */
   function drawCalendar()
   {
        ical = new Web2Cal('calendarContainer', {
           loadEvents: 		loadCalendarEvents,
           onUpdateEvent: 		updateEvent,
           onNewEvent: 		onNewEvent,
		   previewTemplate: 	"customPTemplate",
		   newEventTemplate:	"customNewEventTemplate"
       });
       ical.build();
   } 
   
   /*
    Method invoked when event is moved or resized
    @param event object containing eventID and newly updated Times
    */
   function updateEvent(event)
   { 
       ical.updateEvent(event);
   }
   
   /*
    Method invoked when creating a new event, before showing the new event form.
    @param obj - Object containing (startTime, endTime)
    @param groups - List of Group objects ({groupId, name})
    @param allday - boolean to indicate if the event created is allday event.
    */
   function onNewEvent(obj, groups, allday)
   {
   var st = new UTC(obj.startTime);
   var ed = new UTC(obj.endTime);
   var newevt=jQuery("#customNewEventTemplate"); 
   //Clear out and reset form
   newevt.find("#eventDesc").val("").end()
   .find("#eventName").val("").focus().end()
   .find("#eventStartDate").val( st.toStandardFormat()).end() 
   .find("#eventEndDate").val(ed.toStandardFormat() ).end();
    
   if(allday) 
   newevt.find("#allDayEvent").attr("checked", true).end()				
   	  .find("#eventStartTime").val("").end()
   	  .find("#eventEndTime").val(""); 
   else 
   newevt.find("#allDayEvent").attr("checked", false).end()
   	.find("#eventStartTime").val( st.toNiceTime() ).end()
   	.find("#eventEndTime").val( ed.toNiceTime() ); 
   
   //display a list of groups to select from.
   var groupDD=newevt.find("#eventGroup").get(0);
   removeAllOptions(groupDD);
   for(var g in groups)
   {	
   if(!groups.hasOwnProperty(g))continue;
   var gId = groups[g].groupId;
   addOption(groupDD, groups[g].groupName,groups[g].groupId,false);
   } 
   if(obj.group && obj.group.groupId)	
   newevt.find("#eventGroup").val(obj.group.groupId); 
   
   newevt.find("#newEvAddEventBtn").show().end()
   .find("#newEvUpdateEventBtn").hide();
   } 
   
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
   var start	=	getDateFromStrings(startDate, strtTime);
   var end		=	getDateFromStrings(endDate, endTime);			 
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
   jQuery(document).ready(function()
   { 
   drawCalendar(); 
   
   new Web2Cal.TimeControl(jQuery("#eventStartTime").get(0));
       new Web2Cal.TimeControl(jQuery("#eventEndTime").get(0), jQuery("#eventStartTime").get(0), {
           onTimeSelect: updateDateForTime,
           dateField: "eventEndDate"
       });
   });

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

   jQuery(".more").toggle(function(){
       jQuery(this).text("Show Less").closest('.listing-wrap').addClass('active-show');
      jQuery('.more-prt').hide();
      jQuery('.active-show .more-prt').show();
   }, function(){
       jQuery(this).text("Show More").closest('.listing-wrap').removeClass('active-show');
      jQuery('.more-prt').hide();
   });
   
   
   jQuery('.close-icn').click(function(){
		jQuery('#customNewEventTemplate').hide();
   });

   
   
</script>
<?php get_footer(); ?>