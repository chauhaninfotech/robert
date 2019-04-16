<?php
/*
  Template Name: Sign Up Recruiter
 */

get_header();
?>

<script>
jQuery(document).ready(function(){
	
	<?php
		$value = $_REQUEST['ref_company'];
		$id = $_REQUEST['ref_id'];
	?>
	jQuery('.recruitersignup1 .refer_by_com #refer_by_com_2366').val('<?php echo $value; ?>');
	jQuery('.recruitersignup1 .refer_by #refer_by_2366').val('<?php echo $id; ?>');
	
});
</script>

<div class="main-section">
    <section class="page-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <!-- Col Md 12 -->
                <div class="col-md-12">
                    <div class="recruitersignup1">
<div class="tile">
                        <div class="letu2019sstartwithyou">Let’s start with your information </div>

<?php echo do_shortcode('[wpuf_profile type="registration" id="2366"]'); ?>
                  </div>          
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php 
get_footer();
?>