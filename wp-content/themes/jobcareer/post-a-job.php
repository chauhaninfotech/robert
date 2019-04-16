<?php
/*
  Template Name: Post a Job
 */

get_header();
?>
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
                        <div class="letu2019sstartwithyou">Complete this form to post a job listing</div>
							<?php echo do_shortcode('[wpuf_form id="2393"]'); ?>
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