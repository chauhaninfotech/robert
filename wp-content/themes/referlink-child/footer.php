<?php
/**
 * The template for displaying Footer
 */


$jobcareer_options = CS_JOBCAREER_GLOBALS()->theme_options();
$cs_footer_back_to_top = isset($jobcareer_options['cs_footer_back_to_top']) ? $jobcareer_options['cs_footer_back_to_top'] : '';
$cs_sub_footer_social_icons = isset($jobcareer_options['cs_sub_footer_social_icons']) ? $jobcareer_options['cs_sub_footer_social_icons'] : '';
$cs_footer_back_to_top_color = isset($jobcareer_options['$cs_footer_back_to_top_color']) ? $jobcareer_options['$cs_footer_back_to_top_color'] : '';
?>
<div class="clear"></div>
<!-- Footer -->
<?php
$cs_footer_switch = isset($jobcareer_options['cs_footer_switch']) ? $jobcareer_options['cs_footer_switch'] : '';
$cs_footer_style = isset($jobcareer_options['cs_footer_style']) ? $jobcareer_options['cs_footer_style'] : '';
$footer_background_color = isset($jobcareer_options['cs_copyright_bg_color']) ? $jobcareer_options['cs_copyright_bg_color'] : '';
$cs_sub_footer_menu = isset($jobcareer_options['cs_sub_footer_menu']) ? $jobcareer_options['cs_sub_footer_menu'] : '';
$cs_copy_right = isset($jobcareer_options['cs_copy_right']) ? $jobcareer_options['cs_copy_right'] : '';
$cs_copyright_color = isset($jobcareer_options['$cs_copyright_color']) ? $jobcareer_options['$cs_copyright_color'] : '';
$cs_ftr_class = $cs_footer_style;
$cs_ftr_class = 'footer-v1 ' . $cs_footer_style;
if ( $cs_footer_style == 'modern-footer' ) {
    $cs_ftr_class = 'footer-v1 ' . $cs_footer_style;
}
if ( $cs_footer_style == 'modern-footer2' ) {
    $cs_ftr_class = 'footer-v3 default-footer';
}
if ( $cs_footer_style == 'classic-footer' ) {
    $cs_ftr_class = 'classic-footer';
}
if ( (isset($cs_footer_switch) && $cs_footer_switch == 'on' ) ) {
    ?> 	
<div class="load_img_domain"></div>
<div class="tooltip_wrap" style="display:none;"><ul><li>Front End:<br>Presenting results/forecasts, business partnering & supporting the business using analysis & insights. Less data crunching, more facetime.</li><li>Hybrid:<br>A mix of backend & front end responsibilities.</li><li>Backend:<br>More data mining type roles, working more on systems & with IT, and producing standard reporting. Less facetime.</li></ul></div>
<div class="tooltip_jobwrap" style="display:none;"><ul><li>Front End:<br>Presenting results/forecasts, business partnering & supporting the business using analysis & insights. Less data crunching, more facetime.</li><li>Hybrid:<br>A mix of backend & front end responsibilities.</li><li>Backend:<br>More data mining type roles, working more on systems & with IT, and producing standard reporting. Less facetime.</li></ul></div>
<div class="tooltip_jobwrap_edit" style="display:none;"><ul><li>Front End:<br>Presenting results/forecasts, business partnering & supporting the business using analysis & insights. Less data crunching, more facetime.</li><li>Hybrid:<br>A mix of backend & front end responsibilities.</li><li>Backend:<br>More data mining type roles, working more on systems & with IT, and producing standard reporting. Less facetime.</li></ul></div>
    <footer id="footer">
        <div class="cs-footer <?php echo force_balance_tags($cs_ftr_class); ?>">
            <?php
            if ( $cs_footer_style == 'modern-footer' ) {
                echo get_template_part('frontend/templates/footers/modern');
            } else if ( $cs_footer_style == 'modern-footer2' ) {
                echo get_template_part('frontend/templates/footers/modern2');
            } else if ( $cs_footer_style == 'classic-footer' ) {
                echo get_template_part('frontend/templates/footers/classic');
            } elseif ( $cs_footer_style == 'fancy-footer' ) {
                echo '<div class="container">';
                echo get_template_part('frontend/templates/footers/fancy');
                echo '</div>';
            } else {
                echo get_template_part('frontend/templates/footers/default');
            }
            ?>
        </div>
    </footer>
    <?php
}
cs_facebook_cache_clear();
/*
$url = parse_url('https://www.referlink.io/company-register/');
print_r($url);
if($url['host']){
$url_link = $url['host'];
}else{
$url_link = $url['path'];
}
if(strpos($url_link, 'www') == false ){

echo 'yes';
}else{
echo 'no';
}
 */
?>


<!-- Wrapper End -->   

<style>
.signup-form .nav-tabs-page{
	display:none !important;
}
.tooltip_wrap {
    position: absolute;
    top: 32%;
    right: 7%;
    width: 210px;
    background: #00a0d2;
    padding: 8px;
    border-radius: 10px;
    color: #fff;
    text-align: center;
	display:none;
}
.tooltip_wrap ul li {
    margin-top: 25px;
}
.tooltip_jobwrap {
    position: absolute;
    top: 790px;
    left: 52%;
    width: 38%;
    background: #00a0d2;
    padding: 8px;
    color: #fff;
    text-align: center;
    display: none;
    font-size: 14px;
}
.tooltip_jobwrap ul li {
    margin-top: 25px;
}
.tooltip_jobwrap_edit ul li {
    margin-top: 25px;
}
.tooltip_jobwrap_edit {
    position: absolute;
    top: 400px;
    left: 24%;
    width: 38%;
    background: #00a0d2;
    padding: 8px;
    color: #fff;
    text-align: center;
    display: none;
    font-size: 14px;
}
.hits_icon_job{
width:25px;
cursor:pointer;
}
.hits_icon{
width:25px;
cursor:pointer;
}
</style>
<script>
jQuery(document).ready(function(){

jQuery('.location_select').change(function(){
var loc = jQuery(this).val();
jQuery('input[name="location"]').val(loc);
});
	jQuery('.wpuf-multistep-progressbar ul.wpuf-step-wizard li:nth-child(1)').text('Step-1');
	jQuery('.wpuf-multistep-progressbar ul.wpuf-step-wizard li:nth-child(2)').text('Step-2');
	jQuery('.wpuf-multistep-progressbar ul.wpuf-step-wizard li:nth-child(3)').text('Step-3');

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

var refid = getUrlParameter('ref_id');
var refcomp = getUrlParameter('ref_company');

jQuery('#refer_by_com_2366').val(refcomp);
jQuery('#refer_by_com_2366').attr('readonly','readonly');
jQuery('#refer_by_2366').val(refid);
jQuery('#refer_by_2366').attr('readonly','readonly');


jQuery('.wpuf-step-wizard li').each(function(){
var step = jQuery(this).html();
jQuery(this).html(step.replace('-',' '));

});

jQuery(".hits_icon").hover(function(){
    jQuery('.tooltip_wrap').show();
    }, function(){
    jQuery('.tooltip_wrap').hide();
  });



jQuery('#website_54').blur(function(){
var web = jQuery(this).val();

if(web){

jQuery('.load_img_domain').html('<div class="load_img_wrap"><div class="load_img_subwrap"><img src="http://referlink.io/wp-content/uploads/2018/08/load.gif" /><div style="text-align:center"></div></div></div>');

var urll = location.protocol + "//" + location.host;
var ajax_url = urll+'/wp-admin/admin-ajax.php/';

jQuery.ajax({
	type: 'POST',
	url: ajax_url,
	data:  {action:'website_url_link',website_url:web},
	success: function (responseData) {
		jQuery('#website_url').val(responseData);
		jQuery('#website_54').val(responseData);
jQuery('.load_img_domain').html('');
	}
});  
}			

});

jQuery('#location_143').change(function(){
var loc = jQuery(this).val();
jQuery('#location').val(loc);
});

}); // document close

</script>

<?php wp_footer() ?>

</body>
</html>