 <?php
/*
  Template Name: Home Page
 */


if ( is_user_logged_in() ) {
   get_header();
} else {
   get_header();
}


global $wpdb;
?>
<div class="main-section">
<div class="container">
		<div class="page-title-wrap">
			<h1 class="page-title">How  Referlink Works</h1>
		</div>
		
		<div class="content-wrap">
			<!-- Row - 1 -->
			<div id="finance" class="content-row">
				<h2 class="sub-heading">For Finance Professionals</h2>
				<div class="column-wrap">
					<!-- Column - 1 -->
					<div class="column">
						<div class="column-image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/howitworks/046-resume.png" alt="">
						</div>
						<div class="column-content">
							<h3 class="column-title">Create Free Profile</h3>
							<p>You can create a profile with your own candidate card. When Active, you will be seen by companies looking to hire. <br><br>
								1) Answer a few questions about yourself<br>
								2) A Personalized Summary is auto-created: this is specific to finance<br>
								3) Upload a photo & career experience<br>
							</p>
						</div>
					</div>
					<!-- Column - 2 -->
					<div class="column">
						<div class="column-image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/howitworks/036-graph-analysis.png" alt="">
						</div>
						<div class="column-content">
							<h3 class="column-title">Browse Jobs</h3>
							<p>Finance is broad; no one knows that better than Financial Professionals that have careers in it. Referlink is one of the first to bring you jobs that will match your personal & career interests like never before...
							</p>							
						</div>
					</div>
					<!-- Column - 3 -->
					<div class="column">
						<div class="column-image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/howitworks/037-business-agreement.png" alt="">
						</div>
						<div class="column-content">
							<h3 class="column-title">Connect Directly with Recruiters</h3>
							<p>Expand your network with recruiters looking to fill roles. You can either apply, or let recruiters know your open for them to reach out. You also have the ability to send a "Referlink" to someone else that you may find a good fit.
							</p>							
						</div>
					</div>
				</div>
			</div>

			<!-- Row - 2 -->
			<div id="finance" class="content-row">
				<h2 class="sub-heading">For Companies</h2>
				<div class="column-wrap">
					<!-- Column - 1 -->
					<div class="column">
						<div class="column-image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/howitworks/046-resume.png" alt="">
						</div>
						<div class="column-content">
							<h3 class="column-title">Create Company Profile</h3>
							<p>Easily customize your company profile. This will serve as an admin portal for you to:<br><br>
								+ Sign Up & Manage Team<br>
								+ Create a Company Page<br>
								+ Monitor Candidate Pipeline
							</p>							
						</div>
					</div>
					<!-- Column - 2 -->
					<div class="column">
						<div class="column-image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/howitworks/044-collaboration.png" alt="">
						</div>
						<div class="column-content">
							<h3 class="column-title">Easy Team Setup</h3>
							<p>Add your recruiters with a simple link, where they can quickly sign up and start posting jobs. They can also:<br><br>
							+ Reach out to active candidates<br>
							+ View candidate cards (summary of interests & skills)<br>
							+ Post Jobs<br>
							+ Monitor pipeline of candidates<br>
							+ Manage Job Inventory<br>
							</p>							
						</div>
					</div>
					<!-- Column - 3 -->
					<div class="column">
						<div class="column-image">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/howitworks/045-manager.png" alt="">
						</div>
						<div class="column-content">
							<h3 class="column-title">Find Great Candidates</h3>
							<p>Connect & place finance candidates with jobs they will flourish in. Referlink aims to connect Financial Professionals with the "right" fit. We curate our questions specifically; for finance related skillsets & interests. We also encourage the leverage of networking. Candidates can quickly send a Referlink, to pass on a job that they might know someone for. It will auto email them the link, where that person can sign up and apply.
							</p>							
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer -->
		<div class="footer-title-wrap">
			<h3 class="footer-title">Post Current Jobs & Build Candidate Pipeline for the Future</h3>
		</div>
	</div>
	</div>
<style>
h3, h3 a {
    font: none;
    letter-spacing: 0 !important;
    text-transform: none !important;
    color: #424242 !important;
}
html, body, h1, h2, h3, h4, h5, h6, p, a, ul, ol, li{
    margin: 0;
    padding: 0;
    border: 0;
	font-family: Verdana, sans-serif !important;
	color: #fff !important;
}
body{
    font-family: Verdana, sans-serif !important;
    color: #fff !important;
    font-size: 14px !important;
}
body *{
    box-sizing: border-box;
    max-width: 100%;
}
body{
    background-color: #509bc7 !important;
}
.wp-jobhunt .main-section p {
    color: #ffffff !important;
}

.wp-jobhunt .user-account .login .modal-header h4  {
    color: #000 !important;
    font: 700 18px/18px "Raleway", sans-serif !important;
    font-size: 14px !important;
    letter-spacing: 1px !important;
    text-transform: capitalize !important;
}
.wp-jobhunt .user-account .forget-password a {
    background: none !important;
    border-bottom: 1px dotted #999 !important;
    color: #999 !important;
    cursor: pointer;
    font-size: 11px !important;;
    line-height: 17px !important;;
    padding: 0;
    text-transform: capitalize;
    width: auto;
}
.wp-jobhunt .user-account .forget-password a:hover {
    color: #000 !important;
}
.modal-title{
	
}
p{
    line-height: 1.5em !important;
}


.page-title{
    font-size: 3em !important;
    padding-bottom: 4rem;
    margin-top: 1rem;
    margin-bottom: 2rem;
    padding-right: 90px;
    background-image: url('https://referlink.io/wp-content/themes/referlink-child/images/howitworks/034-creative-1.png');
    background-repeat: no-repeat;
    background-size: 80px;
    background-position: top 0 right 10px;
	color:#fff !important;
    padding-top: 20px;
}

.sub-heading{
    font-size: 1.75em;
    margin-bottom: 3rem;
}
.content-row{
    padding-bottom: 3rem;
    margin-bottom: 3rem;
    border-bottom: 1px solid #fff;
}
.content-row:last-child{
    margin-bottom: 0;
    border: none;
}

.column-wrap{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: stretch;
    align-content: stretch;
}
.column{
    width: 28%;
    padding: 0 15px;
    position: relative;
}
.column:not(:last-child):after{
    display: block;
    content: '';
    height: 50px;
    width: 50px;
    position: absolute;
    top: 15px;
    left: 110%;
    background-image: url('https://referlink.io/wp-content/themes/referlink-child/images/howitworks/arrow-right.png');
    background-repeat: no-repeat;
    background-size: contain;
}
.column-image{
    text-align: center;
    margin-bottom: 2rem;
}
.column-image img{
    height: 75px;
    width: auto;
}
.column-title{
    line-height: 1.5em;
    text-align: center;
    margin-bottom: 1rem;
	font-size: 1.17em !important;
}

.footer-title-wrap{
    padding: 20px 0 50px;
}
.footer-title{
    text-align: center;
	font-size: 1.17em !important;
}

.user-account .alert.alert-danger p {
    color: #e0704a !important;
}
.user-account .alert.alert-success p {
    color: #45b39d !important;
}
.wp-jobhunt .user-account .modal-header .close{
  color: #999999 !important;
}
.wp-jobhunt .cs-login-dropdown ul li a {
    color: #707070 !important;
}
.wp-jobhunt .cs-login-dropdown ul li a:hover {
    color: #707070 !important;
}
@media all and (max-width: 1200px) {
    .column:not(:last-child):after{
       left: 100%; 
    }
}
@media all and (max-width: 979px) {}
@media all and (max-width: 767px) {
    .page-title{
     font-size: 2em !important;
    }
    .sub-heading{
        text-align: center;
    }
    .column{
        width: 100%;
        padding-bottom: 50px;
        padding-top: 50px;
    }
    .column:first-child{
        padding-top: 0px;
    }
    .column:last-child{
        padding-bottom: 0;
    }
    .column:not(:last-child):after{
        background-image: url('https://referlink.io/wp-content/themes/referlink-child/images/howitworks/arrow-down.png');
        width: 30px;
        height: 30px;
       left: 50%;
       top: unset;
       bottom: -15px;
       transform: translateX(-50%);
    }
    
}
@media all and (max-width: 479px) {
.page-title{
     font-size: 1.5em !important;
    }
}
</style>
<?php 
get_footer();
?>