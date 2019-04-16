<?php
/*
  Template Name: Login
 */

get_header();

global $wpdb;

$msg_forget =  'no';
$user = wp_get_current_user();

if(isset($_POST['submit'])){
  $msg = login_frm($_POST);
}
if(isset($_POST['submit_forget'])){
  $msg = forget_password_frm($_POST);
  $msg_forget = 'yes';
}
if($msg_forget == 'yes'){
	$form2 = 'display:block;';
	$form1 = 'display:none;';
}else{
	$form1 = 'display:block;';
	$form2 = 'display:none;';
}
if(!is_user_logged_in()) {    
?>
<div class="main-section">
	<div class="content-wrapper">
        <div class="container">
                  <div class="col-md-12">
					<div class="row">
                      <div class="login_wrap">
					  <?php if($msg){ echo '<p>'.$msg.'</p>'; }else{ $msg = '';} ?>
						<form id="login_form" action="" style="<?php echo $form1; ?>" method="post">
							<div class="form-group">
							  <label for="usr">Username or Email Address</label>
							  <input type="text" required class="form-control" name="username" id="usr" value="<?php echo $_POST['username']; ?>" />
							</div>
							<div class="form-group">
							  <label for="pwd">Password:</label>
							  <input type="password" required class="form-control" name="password" id="pwd">
							</div>
							<div class="form-group">
								<input type="submit" name="submit" value="Log In" class=" vc_btn3-shape-round vc_btn3-style-modern vc_btn3-color-primary" /><a href="javascript:void(0);" class="forget_password">Forget Password</a>
							</div>
						</form>
						<form id="forget_form" action="" style="<?php echo $form2; ?>" method="post">
							<div class="form-group">
							  <label for="usr">Username or Email Address</label>
							  <input type="text" required class="form-control" name="username_forget" id="usr" value="<?php echo $_POST['username_forget'] ?>" />
							</div>
							
							<div class="form-group">
								<input type="submit" name="submit_forget" value="Send Email" class=" vc_btn3-shape-round vc_btn3-style-modern vc_btn3-color-primary" /><a href="javascript:void(0);" class="login_back">Login Here</a>
							</div>
						</form>
					  </div>
                    </div>      
                </div>
<div class="clearfix"></div>
        </div>
    </div>
</div>
<?php } else { ?>
<?php wp_redirect( site_url() ); ?>
<?php } ?>
<style>
.login_wrap{
width:420px;
margin:50px auto;
    border: 1px solid #ccc;
    padding: 15px;

}
.login_wrap label{ font-size:16px !important;}
.forget_password, .login_back {
    float: right;
    font-size: 14px;
    color: #000;
    font-weight: bold;
    margin-top: 5px;
}
.login_wrap p{
	    font-size: 16px;
}
</style>
<script>
jQuery(document).ready(function(){
	jQuery('.forget_password').click(function(){
		jQuery('#login_form').hide();
		jQuery('#forget_form').show();
	});
	jQuery('.login_back').click(function(){
		jQuery('#forget_form').hide();
		jQuery('#login_form').show();
	});
});
</script>
<?php 
get_footer();
?>