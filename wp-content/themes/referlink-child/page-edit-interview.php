<?php 
get_header(); 
?>

<?php 
$post_id = $_REQUEST['post-id'];

$content_post = get_post($post_id);
$content_post->post_title;

$value = '';
if ( $post_id ) {
	$value = get_post_meta( $post_id, 'eventStartDate', true );
}

$end = '';
if ( $post_id ) {
	$end = get_post_meta( $post_id, 'eventEndDate', true );
}

$eventStartTime = '';
if ( $post_id ) {
	$eventStartTime = get_post_meta( $post_id, 'eventStartTime', true );
}

$eventEndTime = '';
if ( $post_id ) {
	$eventEndTime = get_post_meta( $post_id, 'eventEndTime', true );
}



$candidate_name = '';
if ( $post_id ) {
	$candidate_name = get_post_meta( $post_id, 'candidate_name', true );
}




if(isset($_POST['submit']) && !empty($_POST['submit'])) {

	if ( isset( $_POST['eventStartDate'] ) ) {
        update_post_meta( $post_id, 'eventStartDate', $_POST['eventStartDate'] );
    }
	
	if ( isset( $_POST['eventEndDate'] ) ) {
        update_post_meta( $post_id, 'eventEndDate', $_POST['eventEndDate'] );
    }
	
	if ( isset( $_POST['eventStartTime'] ) ) {
        update_post_meta( $post_id, 'eventStartTime', $_POST['eventStartTime'] );
    }
	
	if ( isset( $_POST['eventEndTime'] ) ) {
        update_post_meta( $post_id, 'eventEndTime', $_POST['eventEndTime'] );
    }
	
}
	
?>
<div class="edit-interview">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Edit Interview</h2>
				<div class="rmcontent">
					<form id="post" class="post-edit front-end-form edit-interview-form" method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="post_title">Title</label>
								<input type="text" id="post_title" name="post_title" value="<?php echo $content_post->post_title; ?>" />
							</li>
							<li>
								<label for="post_title">Select Job</label>
								<select name="job" class="form-control">
									<?php 
									//$artist_name = get_field('artist');
									global $post;
									$posts = get_posts( array( 'post_type' => 'jobs', 'numberposts' => -1, 'meta_key' => 'cs_job_status', 'meta_value' => 'active') );
									if( $posts ):
										foreach( $posts as $post ) :   
											echo '<option value="'.get_the_title().'">'.get_the_title().'</option>';
										endforeach;
										wp_reset_postdata(); 
									endif; ?>
								</select>
							</li>
							<li>
								<label class="control-label">Select Candidate</label>
								<select name="candidate_name" class="form-control">
								<?php 
									
									$blogusers = get_users( 'role=cs_candidate' );
									foreach ( $blogusers as $user ) {
										echo '<option value="'.$user->ID.'">'.esc_html($user->display_name).'</option>';
									}
								?>
								</select>
							</li>
							<li class="date-time-fields">
								<div class="date-time-field">
									<label>Start Date</label>
									<input type="text" name="eventStartDate" id="eventStartDate" value="<?php echo esc_attr( $value ); ?>">
								</div>
								<div class="date-time-field">
									<label>End Date</label>
									<input type="text" name="eventEndDate" id="eventEndDate" value="<?php echo esc_attr( $end ); ?>">
								</div>
								
							</li>
			
			
			
							<li class="date-time-fields">
								<div class="date-time-field">
									<label>Start Time</label>
									<input type="text" name="eventStartTime" id="eventStartTime" value="<?php echo esc_attr( $eventStartTime ); ?>">
								</div>
								<div class="date-time-field">
									<label>End Time</label>
									<input type="text" name="eventEndTime" id="eventEndTime" value="<?php echo esc_attr( $eventEndTime ); ?>">
								</div>
							</li>
							<li class="submit">
								<input type="submit" id="submit" value="Update" />
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>