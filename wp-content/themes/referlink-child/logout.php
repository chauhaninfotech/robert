<?php
   /*
     Template Name: Logout
    */
   
   get_header();
   
   ?>
<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

<?php endwhile; ?>

<?php endif; ?>
<script>jQuery(document).ready(function(){ window.location.href = "https://referlink.io/"; });</script>
<?php 
//get_footer();
?>
</body></html>