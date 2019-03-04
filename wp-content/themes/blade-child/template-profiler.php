<?php
/*
Template Name: Uni Profiler
*/
?>
<?php get_header(); ?>

<?php the_post(); ?>

<?php blade_grve_print_header_title( 'page' ); ?>
<?php blade_grve_print_header_breadcrumbs( 'page' ); ?>
<?php blade_grve_print_anchor_menu( 'page' ); ?>
		
<?php
	if ( 'yes' == blade_grve_post_meta( 'grve_disable_content' ) ) {
		get_footer();
	} else {
?>

<?php
include 'country-codes.php';
global $wpdb;
$country_code = "";
$user = "";
$alert_msg = false;
$unis_array=array();
$additional_unis=array();
$results = array();
if(isset($_GET['country']) && isset ($_GET['user'])){
 $country_code = $_GET['country'];
 $user = $_GET['user'];
 if($wpdb !=null) {
 $unis_array = $wpdb->get_results( "SELECT * FROM universities where country= '".$country_code."' ORDER BY id ASC LIMIT 10", ARRAY_A );
 if(count($unis_array) <10) {
	 //echo count($unis_array);
	 //TO DO: avoid repetition
 $difference = 10 - count($unis_array);
 $additional_unis = $wpdb->get_results("SELECT  * FROM universities ORDER BY id ASC LIMIT ".$difference, ARRAY_A);
 $alert_msg = true;
 }//end count adjust
 $results = array_merge($unis_array, $additional_unis);
}//end db check
}


?>

<?php if(is_user_logged_in()) {
	
	?>

		<!-- CONTENT -->
		<div id="grve-content" class="clearfix <?php echo blade_grve_sidebar_class( 'page' ); ?>">
			<div class="grve-content-wrapper">
				<!-- MAIN CONTENT -->
				<div id="grve-main-content">
					<div class="grve-main-content-wrapper clearfix">

						<!-- PAGE CONTENT -->
						<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php the_content(); 
							if($alert_msg) {
								echo '<div class="alert-msg grve-section grve-fullwidth-background grve-bg-none"><div class="grve-container"><div class="grve-row grve-bookmark"><div class="wpb_column grve-column grve-column-1"><strong>We did not have enough universities from the country you selected, so we added some others!</strong></div></div></div></div>';
							}
							?>
                            
                            <?php if(!empty($results)) {?>
                       
                            <div class="universities-2-rate">
							<div class="grve-section grve-fullwidth-background grve-bg-none grve-headings-light grve-equal-column grve-custom-height rating" id="rate2" style="color:#ffffff;margin-bottom: 0px;">  <div class="grve-container">    
			  <form method="post" action="<?php echo get_stylesheet_directory_uri();?>/rate.php">			
						<div id="unis-to-rate" title="<?php echo $country_code;?>">
                        
                        
							<?php foreach ($results as $uni) { ?>
						
							<div id="<?php echo $uni['id'];?>" class="wpb_column single-uni uni_<?php echo $uni['id'];?> grve-column grve-column-1-4">
                           <div class="single-uni-bg"> 
                            
                           <div class="grve-element grve-slogan grve-align-center" style="">
                           <p>(<?php echo $abbr_country[strtolower($uni['country'])];?>)</p>
                           <h3 class="grve-slogan-title grve-align-center grve-h6"><span><?php echo $uni['name'];?><span class="grve-title-line grve-bg-primary-1" style="width: 50px;height: 2px;"></span></span></h3>  
                           
                           
                           </div>
	<div class="center stars">
		
        
       <fieldset class="star-rating">
        <input type="radio" id="star5_<?php echo $uni['id'];?>" name="uniradio[<?php echo $uni['id'];?>]" value="5" class="star">
        <label for="star5_<?php echo $uni['id'];?>" title="Excellent"></label>
  <input type="radio" id="star4_<?php echo $uni['id'];?>" name="uniradio[<?php echo $uni['id'];?>]" value="4" class="star">
    <label for="star4_<?php echo $uni['id'];?>" title="Good"></label>
  <input type="radio" id="star3_<?php echo $uni['id'];?>" name="uniradio[<?php echo $uni['id'];?>]" value="3" class="star">
    <label for="star3_<?php echo $uni['id'];?>" title="Ok"></label>
   <input type="radio" id="star2_<?php echo $uni['id'];?>" name="uniradio[<?php echo $uni['id'];?>]" value="2" class="star">
     <label for="star2_<?php echo $uni['id'];?>" title="Soso"></label>
  <input type="radio" id="star1_<?php echo $uni['id'];?>" name="uniradio[<?php echo $uni['id'];?>]" value="1" class="star">
    <label for="star1_<?php echo $uni['id'];?>" title="Poor"></label>
 
     </fieldset>
			


		
	</div>
    <div class="grve-btn-wrapper"><a href="<?php echo $uni['uni_url'];?>" target="_blank" rel="noopener" class="grve-btn grve-btn-small grve-round grve-bg-primary-1 grve-bg-hover-white"><span>More Info</span></a>
                           </div>
    </div>
</div><!-- end single uni-->
							
						<?php	}//end foreach
							
							?>
                           </div> <!-- end unis to rate main div-->
                           
                           
                            <div class="gform_footer top_label">
                            <div class="grve-element"><p>Want to see universities from another country? Select it here! Or leave as is.</p>
                            <p><em>(We will show random universities as soon as we don't have any more schools in your selected country.)</em></p></div>
                            <div class="ginput_container ginput_container_select"><select name="input_1" id="country_select" class="medium gfield_select" aria-required="true" aria-invalid="false"><option value="none" selected="selected">Select a country</option><option value="us">United States</option><option value="af">Afghanistan</option><option value="al">Albania</option><option value="dz">Algeria</option><option value="as">American Samoa</option><option value="ad">Andorra</option><option value="ao">Angola</option><option value="ag">Antigua and Barbuda</option><option value="ar">Argentina</option><option value="am">Armenia</option><option value="au">Australia</option><option value="at">Austria</option><option value="az">Azerbaijan</option><option value="bs">Bahamas</option><option value="bh">Bahrain</option><option value="bd">Bangladesh</option><option value="bb">Barbados</option><option value="by">Belarus</option><option value="be">Belgium</option><option value="bz">Belize</option><option value="bj">Benin</option><option value="bm">Bermuda</option><option value="bt">Bhutan</option><option value="bo">Bolivia</option><option value="ba">Bosnia and Herzegovina</option><option value="bw">Botswana</option><option value="br">Brazil</option><option value="bn">Brunei</option><option value="bg">Bulgaria</option><option value="bf">Burkina Faso</option><option value="kh">Cambodia</option><option value="cm">Cameroon</option><option value="ca">Canada</option><option value="cv">Cape Verde</option><option value="ky">Cayman Islands</option><option value="cl">Chile</option><option value="cn">China</option><option value="co">Colombia</option><option value="cd">Congo</option><option value="cr">Costa Rica</option><option value="ci">Côte d'Ivoire</option><option value="hr">Croatia</option><option value="cu">Cuba</option><option value="cy">Cyprus</option><option value="cz">Czech Republic</option><option value="dk">Denmark</option><option value="dj">Djibouti</option><option value="dm">Dominica</option><option value="do">Dominican Republic</option><option value="ec">Ecuador</option><option value="eg">Egypt</option><option value="sv">El Salvador</option><option value="er">Eritrea</option><option value="ee">Estonia</option><option value="et">Ethiopia</option><option value="fo">Faroe Islands</option><option value="fj">Fiji</option><option value="fi">Finland</option><option value="fr">France</option><option value="pf">French Polynesia</option><option value="ga">Gabon</option><option value="ge">Georgia</option><option value="de">Germany</option><option value="gh">Ghana</option><option value="gr">Greece</option><option value="gl">Greenland</option><option value="gd">Grenada</option><option value="gu">Guam</option><option value="gt">Guatemala</option><option value="gy">Guyana</option><option value="ht">Haiti</option><option value="hn">Honduras</option><option value="hk">Hong Kong</option><option value="hu">Hungary</option><option value="is">Iceland</option><option value="in">India</option><option value="id">Indonesia</option><option value="ir">Iran</option><option value="iq">Iraq</option><option value="ie">Ireland</option><option value="im">Isle of Man</option><option value="il">Israel</option><option value="it">Italy</option><option value="jm">Jamaica</option><option value="jp">Japan</option><option value="jo">Jordan</option><option value="kz">Kazakhstan</option><option value="ke">Kenya</option><option value="kr">South Korea</option><option value="kw">Kuwait</option><option value="kg">Kyrgyzstan</option><option value="la">Laos</option><option value="lv">Latvia</option><option value="lb">Lebanon</option><option value="ls">Lesotho</option><option value="lr">Liberia</option><option value="ly">Libya</option><option value="li">Liechtenstein</option><option value="lt">Lithuania</option><option value="lu">Luxembourg</option><option value="mo">Macau</option><option value="mk">Macedonia</option><option value="mg">Madagascar</option><option value="mw">Malawi</option><option value="my">Malaysia</option><option value="mv">Maldives</option><option value="mt">Malta</option><option value="mh">Marshall Islands</option><option value="mr">Mauritania</option><option value="mu">Mauritius</option><option value="mx">Mexico</option><option value="fm">Micronesia</option><option value="md">Moldova</option><option value="mc">Monaco</option><option value="mn">Mongolia</option><option value="me">Montenegro</option><option value="ma">Morocco</option><option value="mz">Mozambique</option><option value="mm">Myanmar</option><option value="na">Namibia</option><option value="np">Nepal</option><option value="nl">Netherlands</option><option value="an">Netherlands Antilles</option><option value="nc">New Caledonia</option><option value="nz">New Zealand</option><option value="ni">Nicaragua</option><option value="ng">Nigeria</option><option value="mp">Northern Mariana Islands</option><option value="no">Norway</option><option value="om">Oman</option><option value="pk">Pakistan</option><option value="ps">Palestine, State of</option><option value="pa">Panama</option><option value="pg">Papua New Guinea</option><option value="py">Paraguay</option><option value="pe">Peru</option><option value="ph">Philippines</option><option value="pl">Poland</option><option value="pt">Portugal</option><option value="pr">Puerto Rico</option><option value="qa">Qatar</option><option value="ro">Romania</option><option value="ru">Russia</option><option value="rw">Rwanda</option><option value="ws">Samoa</option><option value="sm">San Marino</option><option value="sa">Saudi Arabia</option><option value="sn">Senegal</option><option value="rs">Serbia</option><option value="sg">Singapore</option><option value="sk">Slovakia</option><option value="si">Slovenia</option><option value="so">Somalia</option><option value="za">South Africa</option><option value="es">Spain</option><option value="lk">Sri Lanka</option><option value="sd">Sudan</option><option value="sr">Suriname</option><option value="sz">Swaziland</option><option value="se">Sweden</option><option value="ch">Switzerland</option><option value="sy">Syria</option><option value="tw">Taiwan</option><option value="tz">Tanzania</option><option value="th">Thailand</option><option value="tg">Togo</option><option value="tt">Trinidad and Tobago</option><option value="tn">Tunisia</option><option value="tr">Turkey</option><option value="ug">Uganda</option><option value="ua">Ukraine</option><option value="ae">United Arab Emirates</option><option value="uk">United Kingdom</option><option value="uy">Uruguay</option><option value="uz">Uzbekistan</option><option value="ve">Venezuela</option><option value="vn">Vietnam</option><option value="vg">Virgin Islands, British</option><option value="vi">Virgin Islands, U.S.</option><option value="ye">Yemen</option><option value="zm">Zambia</option><option value="zw">Zimbabwe</option></select></div>
                             <div class="grve-btn-wrapper"><a class="grve-btn grve-btn-small grve-round grve-bg-primary-1 grve-bg-hover-white" id="more-unis">SHOW ME MORE UNIVERSITIES</a></div>
                            <div id="unis-served"></div>
                            <input type="hidden" id="user-id" name="user_id" value="<?php echo $current_user->ID;?>">
                            <input id="rate-btn" type="submit" name="rate" value="SUBMIT MY RATINGS">
                            </div>
                            
                             </form>  
                             
                            
                             
						</div></div> <!-- closing section divs-->			
						</div>
                        <?php } //if results are not empty
						else {
							?>
                            <div class="grve-section" style="padding-top:100px; padding-bottom:100px; margin-bottom:0;">
                            <div class="grve-container">
                            <div class="grve-row">
                            <h3 class="center"> Whoops, you did not select a country, <a href="/country-select/" style="font-weight:bold" class="blue">try again</a></h3>
                            </div>
                            </div>
                            </div>
                            <?php }//end else ?>
						</div>
						<!-- END PAGE CONTENT -->

						<?php if ( blade_grve_visibility( 'page_comments_visibility' ) ) { ?>
							<?php comments_template(); ?>
						<?php } ?>

					</div>
				</div>
				<!-- END MAIN CONTENT -->

				<?php blade_grve_set_current_view( 'page' ); ?>
				<?php get_sidebar(); ?>

			</div>
		</div>
		<!-- END CONTENT -->
        <?php } ?>

	<?php get_footer(); ?>

<?php
	}

//Omit closing PHP tag to avoid accidental whitespace output errors.
