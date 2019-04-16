<?php
/*
  Template Name: Post a Job
 */

get_header();
?>
<link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/bootstrap.css" rel="stylesheet" />
<!-- FONT AWESOME ICONS  -->
<link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/font-awesome.css" rel="stylesheet" />
<!-- CUSTOM STYLE  -->
<link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css" rel="stylesheet" />
<div class="content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h4 class="page-head-line">Post a Job<a href="<?php echo site_url(); ?>" class="btn btn-info btn-md" style="float: right;font-size: 14px !important;color: #fff !important;">Dashboard</a></h4>

			</div>

		</div>
		<div class="row">
                <!-- Col Md 12 -->
                <div class="col-md-12">
                    <div class="recruitersignup1">
						<div class="tile">
                        <div class="letu2019sstartwithyou">Complete this form to post a job</div>
							<?php echo do_shortcode('[wpuf_form id="2393"]'); ?>
						</div>          
                    </div>
                </div>
            </div>
	</div>
</div>


<?php 
get_footer();
?>