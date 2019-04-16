<?php
/*
  Template Name: Company Register
 */

get_header();
global $wpdb;
$message ='';
if(isset($_POST['first_name'])){
   
global $reg_errors;
$reg_errors = new WP_Error;

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$full_name = $first_name.' '.$last_name;
$company_name = $_POST['company_name'];

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$department = $_POST['department'];
$bio = $_POST['bio'];
$role = $_POST['user_role'];
$website = $_POST['website'];
$location = $_POST['location'];
$pitch = $_POST['pitch'];
$number_of_employees = $_POST['number_of_employees'];
$company_offer = $_POST['company_offer'];

$username = '';
if(!empty( $email )){
$email_ex = explode('@',$email);
$username = $email_ex[0];
}

if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
    $reg_errors->add('field', 'Required form field is missing');
}
if ( $_POST['t_c'] ) {
	$reg_errors->add('field', 'Select terms and conditions');
}
if ( username_exists( $username ) ){
    $reg_errors->add('user_name', 'Email Already in use');
}

if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', 'Password length must be greater than 5' );
    }
if ($password != $confirm_password) {
        $reg_errors->add( 'Confirm Password', 'Confirm Password Not Matched' );
    }
if ( !is_email( $email ) ) {
    $reg_errors->add( 'email_invalid', 'Email is not valid' );
}
if ( email_exists( $email ) ) {
    $reg_errors->add( 'email', 'Email Already in use' );
}



if ( is_wp_error( $reg_errors ) ) {
    foreach ( $reg_errors->get_error_messages() as $error ) {
        $message = '<div class="res_error" style="text-align: center; margin: 20px 0px; font-size: 18px; color:red"><strong>ERROR</strong> : '. $error . '<br/></div>';
     }
}

if ( 1 > count( $reg_errors->get_error_messages() ) ) {
	
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name,
        );
        if($user_id = wp_insert_user( $userdata )){
			
			
			$user1 = get_user_by('id',$user_id);
			$user1->set_role($role);
			
			
			update_user_meta( $user_id, 'department', $department );
			update_user_meta( $user_id, 'location', $location );
			update_user_meta( $user_id, 'description', $bio );
			update_user_meta( $user_id, 'url', $website );
			update_user_meta( $user_id, 'number_of_employees', $number_of_employees );
			update_user_meta( $user_id, 'company_name', $company_name );
			update_user_meta( $user_id, 'edit_profile', '1' );
			update_user_meta( $user_id, 'pitch', $pitch );
			update_user_meta( $user_id, 'perks', $company_offer);



			

				wp_set_current_user( $user1->ID, $user1->user_login );
							   
				wp_set_auth_cookie( $user1->ID );
			   
				do_action( 'wp_login', $user1->user_login );
			   

			   if($role == 'cs_employer'){
				   $rec = 'company-dashboard/';
				   
			   }else{
				   $rec = '';
			   }
				
				$location = home_url().'/'.$rec; 
			   ob_start();
				wp_redirect( $location );
				
				exit;
			}
	
      
}
}
?>
<div class="main-section background_color">
<div class="page-section">
<div class="container">
<div class="row">
<div class="col-md-12 lightbox">
<form id="regForm" action="" method="post">
<!-- One "tabregister" for each step in the form: -->
<div class="tabregister">
<h2><center>Let's start with your:</center></h2><?php echo $message; ?>
<p><label>First name<sup class="required">&nbsp;*</sup></label></label><input type="text" value="<?php echo $_POST['first_name']; ?>" oninput="this.className = ''" name="first_name"></p>
    <p><label>Last name<sup class="required">&nbsp;*</sup></label><input type="text" value="<?php echo $_POST['last_name']; ?>" oninput="this.className = ''" name="last_name"></p>
    <p><label>Company name<sup class="required">&nbsp;*</sup></label><input type="text" oninput="this.className = ''" value="<?php echo $_POST['company_name']; ?>" name="company_name"></p>
	<p><label>Email<sup class="required">&nbsp;*</sup></label><input type="email" value="<?php echo $_POST['email']; ?>" oninput="this.className = ''" id="email_check" name="email"><!--<label id="email_error" class="rm-form-field-invalid-msg" style="display: inline-block;">Please enter a valid email address.</label>--></p>
	<p><label>Password<sup class="required">&nbsp;*</sup></label><input type="password" value="<?php echo $_POST['password']; ?>"  oninput="this.className = ''" name="password"></p>
	<p><label>Confirm Password<sup class="required">&nbsp;*</sup></label><input type="password" value="<?php echo $_POST['confirm_password']; ?>"  oninput="this.className = ''" name="confirm_password"></p>
	<p><label>What position are you recruiting from?</label><select name="department">
	<option value="">Select an option</option>
	<option <?php if($_POST['department'] == 'Recruiter'){ echo 'selected="selected"';} ?> value="Recruiter">Recruiter</option>
	<option <?php if($_POST['department'] == 'Manager'){ echo 'selected="selected"';} ?> value="Manager">Manager</option>
	<option <?php if($_POST['department'] == 'Hiring Manager'){ echo 'selected="selected"';} ?> value="Hiring Manager">Hiring Manager</option>
	<option <?php if($_POST['department'] == 'Director'){ echo 'selected="selected"';} ?> value="Director">Director</option>																											
	</select>
	</p>
	<p><label>Bio</label><textarea class="textarea_style" name="bio"><?php echo $_POST['bio']; ?></textarea></p>
</div>
<div class="tabregister">
<h2><center>Almost Done</center></h2>
 <p><label>Website<sup class="required">&nbsp;*</sup></label></label><input type="text" oninput="this.className = ''" value="<?php echo $_POST['website']; ?>" name="website"></p>
  
    <p><label>What neighborhood is the company in?<sup class="required">&nbsp;*</sup></label><?php echo do_shortcode('[custom_texnomoy_location selected="'.$_POST['location'].'"]');?></p>
	
	 <p><label>Pitch<sup class="required">&nbsp;*</sup></label><input type="text" value="<?php echo $_POST['pitch']; ?>" placeholder="A one-liner about your company" name="pitch"></p>
	 
	<p><label>How many employees work for the company?</label><select name="number_of_employees">
	<option value="">Select an option</option>
	<option <?php if($_POST['number_of_employees'] == 'Small (1-49)'){ echo 'selected="selected"';} ?> value="Small (1-49)">Small (1-49)</option>
	<option <?php if($_POST['number_of_employees'] == 'Medium (50-249)'){ echo 'selected="selected"';} ?> value="Medium (50-249)">Medium (50-249)</option>
	<option <?php if($_POST['number_of_employees'] == 'Large (250+)'){ echo 'selected="selected"';} ?> value="Large (250+)">Large (250+)</option></select></p>
	
    <p><label>What perks does the company offer?</label></label><textarea class="textarea_style" name="company_offer"><?php echo $_POST['company_offer']; ?></textarea></p>
	
	<p><label>I have read and acknowledge the Terms and Conditions for recruiting on ReferLink<sup class="required">&nbsp;*</sup></label></p><div class="check_tc"><input oninput="this.className = ''" type="checkbox" id="t_c" name="t_c" value="yes" style="width: 20px;"> I have read and acknowledge the <a target="_blank" href="https://app.termly.io/document/terms-of-use-for-saas/1134cfe0-0845-428f-9ed4-90fdd046e14b">Terms and Conditions</a> for recruiting on ReferLink</div>
</div>	
<input type="hidden" value="cs_employer" name="user_role" />
<div class="pagi_button" style="">
  <div style="float:right;">
    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
  </div>
</div>

<!-- Circles which indicates the steps of the form: -->
<div style="text-align:center;margin-top:40px;">
  <span class="step"></span>
  <span class="step"></span>
</div>

</form>
</div>
</div>
</div>
</div>
</div>
<style>
.background_color
{
	background: #46b6f6;
    padding:0px !important;
}
.pagi_button{
	overflow:auto;
	margin-top: 30px;
}
#regForm {
  background-color: #fffc;
  padding: 40px;
  width: 70%;
  margin: 40px auto;
  border-radius:20px;

}
#regForm h2 {
    font: 700 Normal 22px/44px "Raleway", sans-serif !important;
    letter-spacing: 1px !important;
    text-transform: none !important;
    color: #424242 !important;
}
.textarea_style{
	min-height: 180px;
}
.check_tc {
    font-size: 14px;
    color: #000;
}
.required{
	
	color: #ff0000;
    font-weight: bold;
}
#regForm p label{
	
	font:600  16px/23px "Montserrat", sans-serif !important;letter-spacing: 0px !important;text-transform: none !important;color: #000 !important;            
}
/* Style the input fields */
input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
	border: 1px solid red !important;
}

/* Hide all steps by default: */
.tabregister {
  display: none;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none; 
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

/* Mark the active step: */
.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}
</style>
<script>
var currentTab = 0; // Current tabregister is set to be the first tabregister (0)
showTab(currentTab); // Display the current tabregister

function showTab(n) {
  // This function will display the specified tabregister of the form ...
  var x = document.getElementsByClassName("tabregister");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tabregister to display
  var x = document.getElementsByClassName("tabregister");
  // Exit the function if any field in the current tabregister is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tabregister:
if(currentTab == 0){
  x[currentTab].style.display = "none";
}
  // Increase or decrease the current tabregister by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tabregister:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tabregister");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tabregister:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
</script>
<?php  get_footer(); ?>