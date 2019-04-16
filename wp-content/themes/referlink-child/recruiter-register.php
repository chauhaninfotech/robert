<?php
/*
  Template Name: Recruiter Register
 */

get_header();

global $wpdb;
$message ='';
if(isset($_POST['ref_id'])){
   
global $reg_errors;
$reg_errors = new WP_Error;

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$full_name = $first_name.' '.$last_name;
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$department = $_POST['department'];
$bio = $_POST['bio'];
$role = $_POST['user_role'];

$company_name = $_POST['company_name'];
$ref_id = $_POST['ref_id'];
$username = '';
if(!empty( $email )){
$email_ex = explode('@',$email);
$username = $email_ex[0];
}

if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
    $reg_errors->add('field', 'Required form field is missing');
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
			
			
			update_user_meta( $user_id, 'refer_by_com', $company_name );
			update_user_meta( $user_id, 'refer_by', $ref_id );
			update_user_meta( $user_id, 'description', $bio );
			update_user_meta( $user_id, 'full_name', $full_name );
			update_user_meta( $user_id, 'account_status', 'approved' );
			update_user_meta( $user_id, 'department', $department );



			

				wp_set_current_user( $user1->ID, $user1->user_login );
							   
				wp_set_auth_cookie( $user1->ID );
			   
				do_action( 'wp_login', $user1->user_login );
			   

			   if($role == 'recruiter'){
				   $rec = 'recruiter-dashboard/';
				   
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
<h2><center>Recruiter Registration Form</center></h2><?php echo $message; ?>
<p><label>First name<sup class="required">&nbsp;*</sup></label></label><input type="text" value="<?php echo $_POST['first_name']; ?>" oninput="this.className = ''" name="first_name"></p>
    <p><label>Last name<sup class="required">&nbsp;*</sup></label><input type="text" value="<?php echo $_POST['last_name']; ?>" oninput="this.className = ''" name="last_name"></p>
	<p><label>Email<sup class="required">&nbsp;*</sup></label><input type="email" value="<?php echo $_POST['email']; ?>" oninput="this.className = ''" id="email_check" name="email"><!--<label id="email_error" class="rm-form-field-invalid-msg" style="display: inline-block;">Please enter a valid email address.</label>--></p>
	<p><label>Password<sup class="required">&nbsp;*</sup></label><input type="password" value="<?php echo $_POST['password']; ?>"  oninput="this.className = ''" name="password"></p>
	<p><label>Confirm Password<sup class="required">&nbsp;*</sup></label><input type="password" value="<?php echo $_POST['confirm_password']; ?>"  oninput="this.className = ''" name="confirm_password"></p>
	<p><label>Company<sup class="required">&nbsp;*</sup></label><input value="<?php echo $_REQUEST['ref_company']; ?>" type="text" readonly="readonly"  name="company_name"></p>
	<p><label>Ref ID<sup class="required">&nbsp;*</sup></label><input value="<?php echo $_REQUEST['ref_id']; ?>" type="text" readonly="readonly"  name="ref_id"></p>
	<p><label>Department(s) you recruit for</label><select class="wpuf_department_2366" name="department" data-required="no" data-type="select"><option value="">--Select--</option><option <?php if($_POST['department'] == 'finance'){ echo 'selected="selected"';} ?> value="finance">Finance</option></select></p>
	<p><label>Bio</label><textarea class="textarea_style" name="bio"><?php echo $_POST['bio']; ?></textarea></p>
</div>

<input type="hidden" value="recruiter" name="user_role" />
<div class="pagi_button" style="">
    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
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
.pagi_button button {
    margin: 0 auto !important;
    width: 160px;
    display: block;
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
    //document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  //fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tabregister to display
  var x = document.getElementsByClassName("tabregister");
  // Exit the function if any field in the current tabregister is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tabregister:
 // x[currentTab].style.display = "none";
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
    //document.getElementsByClassName("step")[currentTab].className += " finish";
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
<?php 
get_footer();
?>