<?php
/*
Template Name: Dashboard
*/
?>
<?php get_header(); ?>
<?php include 'country-codes.php';?>
<?php the_post(); ?>

<?php blade_grve_print_header_title( 'page' ); ?>
<?php blade_grve_print_header_breadcrumbs( 'page' ); ?>
<?php blade_grve_print_anchor_menu( 'page' ); ?>
		
<?php
	if ( 'yes' == blade_grve_post_meta( 'grve_disable_content' ) ) {
		get_footer();
	} else {
?>
		<!-- CONTENT -->
		<div id="grve-content" class="clearfix <?php echo blade_grve_sidebar_class( 'page' ); ?>">
			<div class="grve-content-wrapper">
				<!-- MAIN CONTENT -->
				<div id="grve-main-content">
					<div class="grve-main-content-wrapper clearfix">

						<!-- PAGE CONTENT -->
						<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                        
                        <div class="grve-section grve-fullwidth-background grve-bg-none grve-feature-header grve-feature-footer" id="dashboard-section" style="padding-top: 60px;padding-bottom: 60px;margin-bottom: 0px;">  <div class="grve-container">    <div class="grve-row grve-bookmark">
                        
                       
                        
                        <div class="wpb_column grve-column grve-column-2-3">
                        <?php global $wpdb;
$current_user = wp_get_current_user();
$user_id = esc_html( $current_user->ID );
$list1 = $wpdb->get_results("SELECT * from universities WHERE id IN (SELECT uni_id from lists_universities WHERE list_id ='".$user_id."_1')", ARRAY_A);
$list2 = $wpdb->get_results("SELECT * from universities WHERE id IN (SELECT uni_id from lists_universities WHERE list_id ='".$user_id."_2')", ARRAY_A);
$list3 = $wpdb->get_results("SELECT * from universities WHERE id IN (SELECT uni_id from lists_universities WHERE list_id ='".$user_id."_3')", ARRAY_A);
if(!empty($list1)) {

echo "<h3>Suggestions List 1</h3><ul>";
 foreach ($list1 as $uni) { 
echo "<li><p><strong>";
echo $uni['name']." (".$abbr_country[strtolower($uni['country'])].")";
echo "</strong> ";?><a href="<?php echo $uni['uni_url'];?>" target="_blank" rel="noopener"><span><i class="fa fa-info-circle" aria-hidden="true"></i></span></a><?php echo "</p></li>";
}
echo "</ul>";
}

if(!empty($list2)) {

echo "<h3>Suggestions List 2</h3><ul>";
 foreach ($list2 as $uni) { 
echo "<li><p><strong>";
echo $uni['name']." (".$abbr_country[strtolower($uni['country'])].")";
echo "</strong> ";?><a href="<?php echo $uni['uni_url'];?>" target="_blank" rel="noopener"><span><i class="fa fa-info-circle" aria-hidden="true"></i></span></a><?php echo "</p></li>";
}
echo "</ul>";
}

if(!empty($list3)) {

echo "<h3>Suggestions List 3</h3><ul>";
 foreach ($list3 as $uni) { 
echo "<li><p><strong>";
echo $uni['name']." (".$abbr_country[strtolower($uni['country'])].")";
echo "</strong> ";?><a href="<?php echo $uni['uni_url'];?>" target="_blank" rel="noopener"><span><i class="fa fa-info-circle" aria-hidden="true"></i></span></a><?php echo "</p></li>";
}
echo "</ul>";
}

?>


                        
                        </div>    
                         <div id="profile-contents" class="wpb_column grve-column grve-column-1-3">
                        <?php the_content(); ?>
                        
                        </div>
                        
                        
                        </div>  </div>  <div class="grve-background-wrapper">  </div></div>
                        
							
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

	<?php get_footer(); ?>

<?php
	}

//Omit closing PHP tag to avoid accidental whitespace output errors.