<?php
/*
Template Name: Uni Results
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
//results step (#5)
include 'country-codes.php';
global $wpdb;
//$step_id = 4;
//include 'progress.php';
$country = "";
$user = "";
$unis_array="";
if(isset($_GET['country']) && isset ($_GET['user'])){
 $country = $abbr_country[$_GET['country']];
 $user = $_GET['user'];
}
  global $wpdb;
  $current_user = wp_get_current_user();
  $user_id = esc_html( $current_user->ID );

?>

<?php if(is_user_logged_in()) {
	
	
//SVD RECOMMENDATIONS
$rcount = $wpdb ->get_var("SELECT COUNT(list_id) from lists_universities where list_id = '".$user_id."_1'");
if($rcount == 0) {
//$url = "https://unirecom-api.herokuapp.com/unirecom/api/v1.0/getrecom/?target_user_id=".$user_id."&recom_alg=SVD&recom_size=5";
$url = "http://46.18.25.118:8080/unirecom/api/v1.0/getrecom?target_user_id=".$user_id."&recom_alg=SVD&recom_size=5";
$unidata = file_get_contents($url);
$svd_results = json_decode($unidata);
if(!empty($svd_results) && count($svd_results) == 5) {
$svd_ids = array($svd_results[0][0], $svd_results[1][0], $svd_results[2][0], $svd_results[3][0], $svd_results[4][0]);


 if($wpdb !=null) { 
$wpdb->insert( 
	'users_suggestions', 
	array( 
		'user_id' => $user_id,
		'list_id' => $user_id.'_1'
	), 
	array( 
		'%s', 
		'%s'
	) 
);


foreach ($svd_ids as $id) {
	$wpdb->insert(
	'lists_universities',
	array(
		'list_id' => $user_id.'_1',
		'uni_id' => $id
	),
	array( 
		'%s', 
		'%s'
	) );	
}
}//insert SVD list 1
}
}//end of if Rcount of SVD


//KNN RECOMMENDATIONS -> LIST 2
$rcount = $wpdb ->get_var("SELECT COUNT(list_id) from lists_universities where list_id = '".$user_id."_2'");
if($rcount == 0) {
//$url = "https://unirecom-api.herokuapp.com/unirecom/api/v1.0/getrecom?target_user_id=".$user_id."&recom_alg=KNNBaseline&recom_size=5";
$url = "http://46.18.25.118:8080/unirecom/api/v1.0/getrecom?target_user_id=".$user_id."&recom_alg=KNNBasic&recom_size=5";
$unidata = file_get_contents($url);
$knn_results = json_decode($unidata);	

if(!empty($knn_results) && count($knn_results) == 5) {
$knn_ids = array($knn_results[0][0], $knn_results[1][0], $knn_results[2][0], $knn_results[3][0], $knn_results[4][0]);


if($wpdb !=null) { 
$wpdb->insert( 
	'users_suggestions', 
	array( 
		'user_id' => $user_id,
		'list_id' => $user_id.'_2'
	), 
	array( 
		'%s', 
		'%s'
	) 
);
foreach ($knn_ids as $id) {
	$wpdb->insert(
	'lists_universities',
	array(
		'list_id' => $user_id.'_2',
		'uni_id' => $id
	),
	array( 
		'%s', 
		'%s'
	) );	
}
}//insert KNN list 2
}
}

//KNN USER RECOMMENDATIONS -> List 3
$rcount = $wpdb ->get_var("SELECT COUNT(list_id) from lists_universities where list_id = '".$user_id."_3'");
if($rcount == 0) {

//$url = "https://unirecom-api.herokuapp.com/unirecom/api/v1.0/getrecom?target_user_id=".$user_id."&recom_alg=KNNBaseline_user&recom_size=5";
$url = "http://46.18.25.118:8080/unirecom/api/v1.0/getrecom?target_user_id=".$user_id."&recom_alg=KNNBaseline_user&recom_size=5";
$unidata = file_get_contents($url);
$knn2_results = json_decode($unidata);	

if(!empty($knn2_results) && count($knn2_results) == 5) {
$knn2_ids = array($knn2_results[0][0], $knn2_results[1][0], $knn2_results[2][0], $knn2_results[3][0], $knn2_results[4][0]);	


if($wpdb !=null) { 
$wpdb->insert( 
	'users_suggestions', 
	array( 
		'user_id' => $user_id,
		'list_id' => $user_id.'_3'
	), 
	array( 
		'%s', 
		'%s'
	) 
);
foreach ($knn2_ids as $id) {
	$wpdb->insert(
	'lists_universities',
	array(
		'list_id' => $user_id.'_3',
		'uni_id' => $id
	),
	array( 
		'%s', 
		'%s'
	) );	
}
}//insert KNN2 list 3
}
}

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
							
							?>
							<div id="uni-results" class="grve-section grve-fullwidth grve-bg-none grve-headings-light">  
                            <div class="grve-container">    
                            <div class="grve-row grve-bookmark">
			 		
						
							
						
							<div class="wpb_column grve-column grve-column-1-3 grve-tablet-sm-column-1" style="padding-top: 32.5px; padding-bottom: 32.5px;"><div class="grve-element grve-pricing-table grve-animated-item grve-fadeInUp grve-style-1 grve-animated" style="" data-delay="200"> <div class="grve-pricing-header"> <div class="grve-subtitle grve-pricing-title grve-bg-primary-1">Recommended List 1</div> </div> 
                            <ul>
                            <?php 
							$svd_array = $wpdb->get_results("SELECT  * FROM universities  where id in (SELECT uni_id FROM lists_universities  where list_id ='".$user_id."_1')", ARRAY_A);
							if (isset($svd_array)) { 
							foreach ($svd_array as $uni) { ?>
                            
                            <li>
                             <p>(<?php echo $abbr_country[strtolower($uni['country'])];?>)</p>
                            <strong><?php echo $uni['name'];?></strong></li>
                            <?php	}//end foreach 
							}//end if?>
                            
                            </ul></div></div>
							
						
				<div class="wpb_column grve-column grve-column-1-3 grve-tablet-sm-column-1" style="padding-top: 32.5px; padding-bottom: 32.5px;"><div class="grve-element grve-pricing-table grve-animated-item grve-fadeInUp grve-style-1 grve-animated" style="" data-delay="200"> <div class="grve-pricing-header"> <div class="grve-subtitle grve-pricing-title grve-bg-primary-1">Recommended List 2</div> </div> 
                            
                            <ul>
                            <?php 
							$knn_array = $wpdb->get_results("SELECT  * FROM universities  where id in (SELECT uni_id FROM lists_universities  where list_id ='".$user_id."_2')", ARRAY_A);
							if (isset($knn_array)) { 
							foreach ($knn_array as $uni) { ?>
                            
                            <li>
                             <p>(<?php echo $abbr_country[strtolower($uni['country'])];?>)</p>
                            <strong><?php echo $uni['name'];?></strong></li>
                            <?php	}//end foreach 
							}//end if?>
                            
                            </ul></div></div>
                            
            <div class="wpb_column grve-column grve-column-1-3 grve-tablet-sm-column-1" style="padding-top: 32.5px; padding-bottom: 32.5px;"><div class="grve-element grve-pricing-table grve-animated-item grve-fadeInUp grve-style-1 grve-animated" style="" data-delay="200"> <div class="grve-pricing-header"> <div class="grve-subtitle grve-pricing-title grve-bg-primary-1">Recommended List 3</div> </div> 
                               
                            <ul>
                            <?php 
							$knn2_array = $wpdb->get_results("SELECT  * FROM universities  where id in (SELECT uni_id FROM lists_universities  where list_id ='".$user_id."_3')", ARRAY_A);
							if (isset($knn2_array)) { 
							foreach ($knn2_array as $uni) { ?>
                            
                            <li>
                             <p>(<?php echo $abbr_country[strtolower($uni['country'])];?>)</p>
                            <strong><?php echo $uni['name'];?></strong></li>
                            <?php	}//end foreach
							}//end if?>
                            
                            </ul></div></div> 
                            </div>       
						</div></div> <!-- closing section divs-->
                  <div class="grve-section grve-fullwidth-background grve-bg-none" id="evaluation-survey">  <div class="grve-container">    <div class="grve-row grve-bookmark"><div class="wpb_column grve-column grve-column-1">
                    <h3 style="text-align: center" class="vc_custom_heading">Let us know how we did!</h3>  
                    <?php  echo do_shortcode( '[gravityform id="11" title="false" description="false" ajax="false"]');?>
                    </div>
                    </div>
                    </div>
                    </div>
                        
                        
        		
						
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
