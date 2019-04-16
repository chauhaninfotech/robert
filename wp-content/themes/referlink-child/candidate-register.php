<?php
/*
  Template Name: Candidate Register
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
$area_of_finance = implode(',',$_POST['area_of_finance']);
$familiar_excel = $_POST['familiar_excel'];
$experience_level = $_POST['experience_level'];
$prefer_job = $_POST['prefer_job'];
$location = $_POST['location'];
$salary_from = $_POST['salary_from'];
$role = $_POST['user_role'];
$account_status = 'approved';

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
			
			
			
			update_user_meta( $user_id, 'experience_level', $experience_level );
			update_user_meta( $user_id, 'how_familiar_are_you_with_excel_', $familiar_excel );
			update_user_meta( $user_id, 'what_area_of_finance_is_your_experience_in_', $area_of_finance );
			update_user_meta( $user_id, 'full_name', $full_name );
			update_user_meta( $user_id, 'prefer_job', $prefer_job );
			update_user_meta( $user_id, 'salary_from', $salary_from );
			update_user_meta( $user_id, 'location', $location );
			update_user_meta( $user_id, 'account_status', $account_status);
			update_user_meta( $user_id, 'wpuf_user_status', $account_status);



			

				wp_set_current_user( $user1->ID, $user1->user_login );
							   
				wp_set_auth_cookie( $user1->ID );
			   
				do_action( 'wp_login', $user1->user_login );
			   

			   if($role == 'cs_candidate'){
				   $rec = 'candidate-dashboard/';
				   
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
<form id="regForm" class="regForm_can" action="" method="post">
<!-- One "tabregister" for each step in the form: -->
<div class="tabregister">
<h2><center>Let's start with your:</center></h2>
<?php echo $message; ?>
<p><label>First name<sup class="required">&nbsp;*</sup></label><input type="text" oninput="this.className = ''" name="first_name" value="<?php echo $_POST['first_name']; ?>"></p>
    <p><label>Last name<sup class="required">&nbsp;*</sup></label><input type="text" value="<?php echo $_POST['last_name']; ?>" oninput="this.className = ''" name="last_name"></p>
    
	<p><label>Email<sup class="required">&nbsp;*</sup></label><input type="email" value="<?php echo $_POST['email']; ?>" oninput="this.className = ''" id="email_check" name="email"><!--<label id="email_error" class="rm-form-field-invalid-msg" style="display: inline-block;">Please enter a valid email address.</label>--></p>
	<p><label>Password<sup class="required">&nbsp;*</sup></label><input type="password" value="<?php echo $_POST['password']; ?>" oninput="this.className = ''" name="password"></p>
	<p><label>Confirm Password<sup class="required">&nbsp;*</sup></label><input type="password" value="<?php echo $_POST['confirm_password']; ?>" oninput="this.className = ''" name="confirm_password"></p>
</div>
<div class="tabregister">
<h2><center>Tell us about your experience</center></h2>
 <p><label>What area of finance is your experience in?<sup class="required">&nbsp;*</sup></label><div class="wpuf-fields" data-required="yes" data-type="radio">

 <?php $array = array('accounting'=>'Accounting', 'i-banking'=>'I-Banking', 'FP&A'=>'FP&A', 'private_equity'=>'Private Equity', 'consulting'=>'Consulting'); ?>

 <?php foreach($array as $key => $value){  if($_POST['area_of_finance'][$key] == $key){ $selected = 'checked="checked"'; }else{  $selected =  ''; }?>
 <label class="wpuf-checkbox-block">
                        <input type="checkbox" <?php echo $selected; ?> class="area_of_finance" name="area_of_finance[<?php echo $key; ?>]" value="<?php echo $key; ?>"><?php echo $value; ?></label>
 <?php } ?>
 
                    
                                        
                    
            
        </div></p>
	<p><label>How familiar are you with Excel?</label><div class="wpuf-fields" data-required="yes" data-type="radio">


            
                    <label class="wpuf-radio-block">
                        <input name="familiar_excel" <?php if ($_POST['familiar_excel'] == '_can_understand/maintain_models_through_excel,_pulling_data_through_systems'){ echo 'checked="checked"'; } ?> class="" type="radio" value="_can_understand/maintain_models_through_excel,_pulling_data_through_systems">
                         Can understand/maintain models through excel, pulling data through systems                    </label>
                    
                    <label class="wpuf-radio-block">
                        <input name="familiar_excel" class="" <?php if ($_POST['familiar_excel'] == 'can_build_models_through_excel,_strong_understanding_of_databases'){ echo 'checked="checked"'; } ?> type="radio" value="can_build_models_through_excel,_strong_understanding_of_databases">
                        Can build models through excel, strong understanding of databases                    </label>
                    
                    <label class="wpuf-radio-block">
                        <input name="familiar_excel" class="" <?php if ($_POST['familiar_excel'] == 'can_build_complex_models_leveraging_vba_for_automation_&_visualization'){ echo 'checked="checked"'; } ?> type="radio" value="can_build_complex_models_leveraging_vba_for_automation_&_visualization">
                        Can build complex models leveraging VBA for automation &amp; visualization                    </label>
                    
                    </div></p>
	<p><label>How much experience do you have in Finance?<sup class="required">&nbsp;*</sup></label><div class="wpuf-fields" data-required="yes" data-type="radio">

            <?php $array_experience = array('intern'=>'Intern', 'entry_level'=>'Entry Level', 'mid-senior'=>'Mid-Senior', 'management'=>'Management'); ?>
			
			<?php foreach($array_experience as $kexp => $exp){ ?>
			
                    <label class="wpuf-radio-block">
                        <input name="experience_level" <?php if($_POST['experience_level'] == $kexp) { echo 'checked="checked"'; } ?> class="wpuf_experience_level_2341" type="radio" value="<?php echo $kexp; ?>"><?php echo $exp; ?></label>
                    
			<?php } ?>       
                    
                    </div></p>
					
					<p><label>When it comes to your day-to-day, which do you prefer? <img src="<?php echo site_url(); ?>/wp-content/uploads/2018/12/tooltip.png" class="hits_icon"><sup class="required">&nbsp;*</sup></label><div class="wpuf-fields" data-required="yes" data-type="radio">

					<?php $prefer_job = array('back-end_candidate'=>'Back-End Candidate', 'hybrid_candidate'=>'Hybrid Candidate', 'front-end_candidate'=>'Front-End Candidate'); ?>
			
			<?php foreach($prefer_job as $kexp => $exp){ ?>
			
                    <label class="wpuf-radio-block">
                        <input name="prefer_job" <?php if($_POST['prefer_job'] == $kexp) { echo 'checked="checked"'; } ?> class="wpuf_experience_level_2341" type="radio" value="<?php echo $kexp; ?>"><?php echo $exp; ?></label>
                    
			<?php } ?>   
            
                   
                    </div></p>
					
	
</div>	
<div class="tabregister">
<h2><center>Almost Done</center></h2>
<p><label>NOBODY LIKES A LONG COMMUTE, WHERE DO YOU CALL HOME?<sup class="required">&nbsp;*</sup></label><?php echo do_shortcode('[custom_texnomoy_location selected="'.$_POST['location'].'"]');?></p>
	
	 <p><label>WHAT IS YOUR TARGET SALARY?</label><select class="wpuf_salary_from_2341" name="salary_from" data-required="no" data-type="select">
	 <option value="">--Select--</option>
<?php $salary_from = array('60K','70K', '80K', '90K', '100K', '125K', '150K', '200K', '300K', '400K', '500K', '600K', '700K', '800K', '900K'); ?>	 
<?php foreach($salary_from as $sal){ ?>
			
                    <option <?php if($_POST['salary_from'] == $sal) { echo 'selected="selected"'; } ?>  value="<?php echo $sal; ?>"><?php echo $sal; ?></option>
					
                    
			<?php } ?>  
 </select></p>
	
   
	
	<div class="check_tc"><input required type="checkbox" name="t_c" value="yes" style="width: 20px;"> I have read and agreed to the <a target="_blank" href="https://app.termly.io/document/terms-of-use-for-saas/1134cfe0-0845-428f-9ed4-90fdd046e14b">Terms and Conditions</a> </div>
</div>	


<input type="hidden" value="cs_candidate" name="user_role" />
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

.wpuf-checkbox-block, .wpuf-radio-block {
	display: inline-block !important;
    margin-bottom: 0 !important;
    margin-right: 5px;
    padding: 5px 20px 5px 10px;
    color: #000;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    font-weight: normal !important;
    font-size: 14px;
}
.wpuf-checkbox-block input, .wpuf-radio-block input{
    outline: none;
    float: left;
    width: 12px;
    margin-right: 5px;
    margin-top: 7px;
}
.wpuf-radio-block{
	position: relative;
}
#regForm h2{
    font: 700 Normal 22px/44px "Raleway", sans-serif !important;
    letter-spacing: 1px !important;
    text-transform: none !important;
    color: #424242 !important;
}
#regForm h3{
    font-size: 16px !important;
    line-height: 24px !important;
    font-family: inherit !important;
}
.regForm_can h3{
	    text-align: center;
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
  if(currentTab < 2){
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
<?php 
get_footer();
?>