<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
$dazz_cs_seo = unserialize(get_option('dazz_cs_seo'));	
?>
<table class="form-table">
							
	<tr>
		<th><?php _e('Favicon Icon','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				
				<img src="<?php echo $dazz_cs_seo['dazz_cs_favicon']; ?>" class="csw-admin-img" />
				
				<input type="button" id="upload-background" name="upload-background" value="Upload Image" class="button-primary rcsp_media_upload"  />
				<input type="hidden" id="dazz_cs_favicon" name="dazz_cs_favicon" class="rcsp_label_text"  value="<?php echo $dazz_cs_seo['dazz_cs_favicon']; ?>"  readonly="readonly" placeholder="No Media Selected" />
				
		</td>
		
	</tr>
	
	
	<tr>
		<th><?php _e('SEO Title','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				<input type="text" class="pro_text" id="dazz_cs_seo_title" name="dazz_cs_seo_title" placeholder="<?php _e('Enter Your SEO Title Here...','DAZZ_CSW_TEXT_DOMAIN'); ?>" size="56" value="<?php echo $dazz_cs_seo['dazz_cs_seo_title']; ?>" />
	
		</td>
		
	</tr>

	<tr>
		<th><?php _e('SEO Description','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				<textarea rows="6"  class="pro_text" id="dazz_cs_seo_desc" name="dazz_cs_seo_desc" placeholder="<?php _e('Enter Your SEO Description Here...','DAZZ_CSW_TEXT_DOMAIN'); ?>"><?php echo $dazz_cs_seo['dazz_cs_seo_desc']; ?></textarea>
	
		</td>
		
	</tr>

	<tr>
		<th><?php _e('Google Analytics Script','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				<textarea rows="6"  class="pro_text" id="dazz_cs_seo_analytics" name="dazz_cs_seo_analytics" placeholder="<?php _e('Enter Your Google Analytics Script Here','DAZZ_CSW_TEXT_DOMAIN'); ?>"><?php echo $dazz_cs_seo['dazz_cs_seo_analytics']; ?></textarea>
	
		</td>
		
	</tr>
<tr class="radio-span" >
		<td>
				<button class="portfolio_read_more_btn "  onclick="dazz_save_data_seo()"><?php _e('Save Settings','DAZZ_CSW_TEXT_DOMAIN'); ?></button>
				<button class="portfolio_demo_btn" onclick="dazz_reset_data_seo()" ><?php _e('Reset Default Setting','DAZZ_CSW_TEXT_DOMAIN'); ?></button>
		</td>
		
	</tr>		
	
</table>



<script>
function dazz_save_data_seo(){
 jQuery("#dazz_loding_image").show();
 var dazz_cs_favicon = jQuery("#dazz_cs_favicon").val();
 var dazz_cs_seo_title = jQuery("#dazz_cs_seo_title").val();
 var dazz_cs_seo_desc = jQuery("#dazz_cs_seo_desc").val();
 var dazz_cs_seo_analytics = jQuery("#dazz_cs_seo_analytics").val();
 
 
 	jQuery.ajax(
            {
	    	    type: "POST",
		        url: location.href,
	
		        data : {
			    'action_seo':'dazz_csp_seo',
			    'dazz_cs_favicon':dazz_cs_favicon,
			    'dazz_cs_seo_title':dazz_cs_seo_title,
			    'dazz_cs_seo_desc':dazz_cs_seo_desc,
			    'dazz_cs_seo_analytics':dazz_cs_seo_analytics,
			   
			        },
                success : function(data){
									jQuery("#dazz_loding_image").fadeOut();	
									jQuery(".dialog-button").click();
                                   //location.href='?page=dazz_coming_soon_wp';
								  
                                   }			
            });
 
}
</script>
<?php
if(isset($_POST['action_seo'])=="dazz_csp_seo") {
$dazz_cs_favicon          = sanitize_text_field($_POST['dazz_cs_favicon']);
$dazz_cs_seo_title          = stripslashes(sanitize_text_field($_POST['dazz_cs_seo_title']));
$dazz_cs_seo_desc          = stripslashes($_POST['dazz_cs_seo_desc']);
$dazz_cs_seo_analytics          = stripslashes($_POST['dazz_cs_seo_analytics']);
			
			
$seo = serialize( array(
	'dazz_cs_favicon' 		       => $dazz_cs_favicon,
	'dazz_cs_seo_title' 		       => $dazz_cs_seo_title,
	'dazz_cs_seo_desc' 		       => $dazz_cs_seo_desc,
	'dazz_cs_seo_analytics' 		       => $dazz_cs_seo_analytics,
	
	) );

update_option('dazz_cs_seo', $seo);
}
 ?>
 
 
  <script>
 
	function dazz_reset_data_seo(){
		if (confirm('Are you sure you want to reste this setting?')) {
    
		} else {
		   return;
		}
		jQuery("#dazz_loding_image").show();
		jQuery.ajax(
		{
			type: "POST",
			url: location.href,

			data : {
			'reset_action_seo':'action_seo_reset',
			
		   
				},
			success : function(data){
				jQuery("#dazz_loding_image").fadeOut();
				jQuery(".dialog-button").click();
				location.href='?page=dazz_coming_soon_wp';
		  
		   }			
		});
	 
	}
	
</script>

<?php
if(isset($_POST['reset_action_seo'])=="action_seo_reset") {
	
	$default_url2 =  DAZZ_CSW_PLUGIN_URL.'assets/img/logo.png'; 
	
	
	$dazz_seo = serialize( array(
	'dazz_cs_favicon' 		       => $default_url2,
	'dazz_cs_seo_title' 		   => "Coming Soon",
	'dazz_cs_seo_desc' 		       => "",
	'dazz_cs_seo_analytics' 	   => "",
	
	) );

	update_option('dazz_cs_seo', $dazz_seo);
}
 ?>