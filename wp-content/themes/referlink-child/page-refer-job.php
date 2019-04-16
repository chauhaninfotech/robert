<?php
get_header();
?>

<div class="refer-section">
        <div class="container">
            <div class="row">
			
			
			
			<?php
	
if(isset($_POST['candidate']) && !empty($_POST['candidate'])) {
    
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = $_POST['email'];
    $email_subject = "Your email subject line";
 
	
    $can_id = $_POST['candidate']; 
	
	$can_info = get_userdata($can_id);
	
	$can_mail = $can_info->user_email;
				
    $job_title = $_POST['job_title']; // required
    $post_id = $_POST['post_id']; // required
    $email_from = $can_mail; // required
    $telephone = $_POST['telephone']; // not required
    
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "Job Title: ".clean_string($job_title)."\n";
    $email_message .= "Job ID: ".clean_string($post_id)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- include your own success html here -->

<div class="col-md-12 text-center refer-success">
	<h2>Thank you for contacting us. We will be in touch with you very soon.</h2>
	<div class="tile-wrap active">
		<div class="tile-register">
			<div class="tile-image">
				<img src="<?php echo site_url(); ?>/wp-content/uploads/2018/07/confirmation.jpg" alt="" width="150" height="150" class="alignnone size-full wp-image-2665"></div>
			</div>
	</div>

	<a class="btn">Proceed To Deshboard</a>
</div> 

<?php

$entries = get_post_meta( get_the_ID(), 'candidate_refer', true );



?>
<?php
 
} else { 
?>



			<?php 
				$post_id = $_REQUEST['job-id'];
				$employee_id = $_REQUEST['employee-id'];
				$employee_id = $_REQUEST['refer-id'];
				
				$user_info = get_userdata($employee_id);
				
				$nicename = $user_info->user_nicename;
				$email = $user_info->user_email;
				
				$content_post = get_post($post_id);
				$content_post->post_title;
				
			?>
	
			<form name="contactform" method="post" action="">
				
				
				
				<table width="450px">
				<tr>
				<td valign="top">
				<label for="first_name">Job Title*</label>
				</td>
				<td valign="top">
				<input  type="text" value="<?php echo get_the_title( $post_id ); ?>" name="job_title" disabled>
				</td>
				</tr>
				
				<tr>
				<td valign="top">
				<label for="first_name">Job ID*</label>
				</td>
				<td valign="top">
				<input type="text" value="<?php echo $post_id; ?>" name="post_id" disabled>
				</td>
				</tr>
				
				<tr>
				<td valign="top">
				<label for="first_name">Refer By*</label>
				</td>
				<td valign="top">
				<input type="hidden" value="<?php echo $employee_id; ?>" name="employee_id" disabled>
				<input type="text" value="<?php echo $nicename; ?>" name="employee_name" disabled>
				</td>
				</tr>
				
				
				<tr>
				<td valign="top">
				<label for="first_name">Refer Email*</label>
				</td>
				<td valign="top">
				<input type="text" value="<?php echo $email; ?>" name="email" disabled>
				</td>
				</tr>
				
				
				
				<tr>
				<td valign="top"">
				<label for="last_name">Candidate Name*</label>
				</td>
				<td valign="top">
				<select name="candidate">
					<?php 
					$blogusers = get_users(array('role'=>'cs_candidate'));
					foreach ( $blogusers as $user ) {
					?>
						<option value="<?php echo $user->ID; ?>"><?php echo esc_html( $user->display_name ); ?></option>
					<?php } ?>
				</select>
				</td>
				</tr>
				
				<tr>
				<td valign="top">
				<label for="comments">Additional Info *</label>
				</td>
				<td valign="top">
				<textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
				</td>
				</tr>
				<tr>
				<td colspan="2" style="text-align:center">
				<input type="submit" value="Submit">   
				</td>
				</tr>
				</table>
			</form>
   
   
   
   
   
   
<?php } ?>   
   
   
   
   
   
			</div>
		</div>
</div>
<?php get_footer(); ?>