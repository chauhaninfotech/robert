 <?php
/*
  Template Name: Home Page
 */


if ( is_user_logged_in() ) {
   get_header('banner');
} else {
   get_header();
}


global $wpdb;
?>
<!-- Banner -->
		<section class="banner section">
			<div class="container">	
				<div class="banner-text-container">
					<h1 class="banner-title">
						Connecting Great Finance Talent In LA
					</h1>
				</div>
			</div>
		</section>

		<section class="section features">
			<div class="container">
				<div class="row">
					<div class="col-md-5 col-sm-12">
						<h2 class="feature-title">Find your next job in 3 simple steps</h2>
						<p>Referlink empowers candidates to find a connection in their next move. Not just through the “right” position, but also the type of finance role that they enjoy. This is greatly overlooked, and we are here to change that.</p>
						<a href="#" class="test-button">Take the Test</a>
					</div>
					<div class="col-md-5 col-sm-12 col-md-offset-1 feature-steps">
							<h3>1. Sign-up and answer a few questions.</h3>
							<h3>2. Customize your profile.</h3>
							<h3>3. Find your next team.</h3>
					</div>
				</div>
			</div>
		</section>

		<section class="connect section">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<h2 class="connect-title">Connect with managers from companies all over LA</h2>
						<h3 class="connect-sub-title">Seen enough? Join our community!</h3>
						<a href="#" class="connect-button">Contact Sales</a>
					</div>
				</div>
			</div>
			
		</section>
<style>
@import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

body{
	font-family: 'Raleway', sans-serif;
}
body *{
	-webkit-box-sizing: border-box;
	        box-sizing: border-box;
	-webkit-transition: all .2s ease-in-out;
}
h1, h2, h3, h4, h5, h6{
	font-weight: bold;
}
.section{
	padding: 80px 0;
}
a,
a:hover{
	text-decoration: none;
}
/* Banner */
.banner{
	background-image: url('https://referlink.io/wp-content/uploads/2018/07/referlink-bg-2.png'), url(https://referlink.io/wp-content/uploads/2018/07/referlink-bg.jpeg);
	background-size: cover;
	background-position: center;
	min-height: calc(100vh - 81px);
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: horizontal;
	-webkit-box-direction: normal;
	    -ms-flex-direction: row;
	        flex-direction: row;
	-ms-flex-wrap: wrap;
	    flex-wrap: wrap;
	-webkit-box-pack: start;
	    -ms-flex-pack: start;
	        justify-content: flex-start;
	-webkit-box-align: center;
	    -ms-flex-align: center;
	        align-items: center;
	-ms-flex-line-pack: center;
	    align-content: center;
}

.banner .banner-title{
	color: #fff;
	max-width: 600px;
	font-size: 44px;
	line-height: 1.2em;
}
.navbar{
	background-color: #fff;
	margin: 0;
	border: none;
}
.navbar-brand{
	height: auto;
}
.navbar-brand img{
		max-height: 50px;
}
.features{
	background-color: #46b6f6;
	color: #fff;
}
.feature-title{
	font-size: 32px;
	font-weight: normal;
    margin-bottom: 50px;
    line-height: 1.5em;
}
.features p{
	font-size: 20px;
	line-height: 32px;;
}
.test-button{
    display: inline-block;
    margin-top: 1em;
    font-size: 14px;
    padding: 14px 20px;
    color: #FFF;
    border-color: #08c;
    background-color: #08c;
    border-radius: 24px;
}
.test-button:hover{
	color: #f7f7f7;
    border-color: #0074ad;
    background-color: #0074ad;
}
.connect-title{
	font-size: 32px;
	line-height: 48px;
    margin-bottom: 80px;
    margin-top: 0;
}
.connect-sub-title{
	font-size: 24px;
	line-height: 64px;
    margin-bottom: 10px;
    margin-top: 0;
}
.connect-button{
	color: #fff;
	border-color: #46b6f6 !important;
    background-color: #46b6f6 !important;
    font-size: 24px;
    padding: 15px 50px;
	border-radius: 2em;
	display: inline-block;
}
.feature-steps h3{
	font-weight: normal;
}
@media all and (min-width: 768px) {
	.navbar-nav>li>a{
		line-height: 80px;
		padding-top: 0;
		padding-bottom: 0;
	}
}
@media all and (max-width: 767px) {
	.navbar-brand{
		height: auto;
		border-bottom: 1px solid rgba(255,255,255,0.1);
	}
	.navbar-brand img{
		max-height: 50px;
	}
	
	button.navbar-toggle {
	    top: 10px;
	    background: #46b6f6;
	    border-radius: 0;
	}
	button.navbar-toggle span {
	    background: #fff;
	}
	.navbar-nav{
	    background-color: #222;
	    margin-top: 0;
	    margin-bottom: 0;
	}
	.navbar-nav>li>a{
		color: #fff;
	}
	.banner-text-container{
	max-width: 300px;
	}
	.banner .container{
		margin: 0;
	}
	.feature-steps{
		margin-top: 50px;
	}
	.connect-title{
		margin-bottom: 40px;
	}
	.banner .banner-title{
		font-size: 24px;
		line-height: 30px;
	}

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



</style>
<?php 
get_footer();
?>