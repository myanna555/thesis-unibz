<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
$dazz_cs_dashboard = unserialize(get_option('dazz_cs_dashboard'));	
?>
<table class="form-table">
	<tr>
		<th><?php _e('Enable Coming Soon Mode','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
			<span style="margin-bottom:10px;display: block;">
				<input type="radio" name="dazz_cs_status" value="0" id="dazz_cs_status" <?php if($dazz_cs_dashboard['dazz_cs_status'] == "0") { echo "checked"; } ?>  />&nbsp;<?php _e('Disabled','DAZZ_CSW_TEXT_DOMAIN'); ?><br>
			</span>
			<span>	
				<input type="radio" name="dazz_cs_status" value="1" id="dazz_cs_status" <?php if($dazz_cs_dashboard['dazz_cs_status'] == "1") { echo "checked"; } ?>  />&nbsp;<?php _e('Enable Coming Soon Mode','DAZZ_CSW_TEXT_DOMAIN'); ?><br>
			</span>
		</td>
	</tr>
	<tr>
		<th><?php _e('Coming Soon Logo','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
			<img src="<?php echo $dazz_cs_dashboard['cs_logo_url']; ?>" class="csw-admin-img" />
			<input type="button" id="upload-background" name="upload-background" value="Upload Image" class="button-primary rcsp_media_upload"  />
			<input type="hidden" id="cs_logo_url" name="cs_logo_url" class="rcsp_label_text"  value="<?php echo $dazz_cs_dashboard['cs_logo_url']; ?>"  readonly="readonly" placeholder="No Media Selected" />
		</td>
		
	</tr>
	
	<tr>
		<th><?php _e('Display Logo','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
			<span style="margin-bottom:10px;display: block;">
				<input type="radio" name="display_logo" value="0" id="display_logo" <?php if($dazz_cs_dashboard['display_logo'] == "0") { echo "checked"; } ?> />&nbsp;<?php _e('Yes','DAZZ_CSW_TEXT_DOMAIN'); ?><br>
			</span>
			<span>	
				<input type="radio" name="display_logo" value="1" id="display_logo" <?php if($dazz_cs_dashboard['display_logo'] == "1") { echo "checked"; } ?>   />&nbsp;<?php _e('No','DAZZ_CSW_TEXT_DOMAIN'); ?><br>
			</span>
		</td>
	</tr>
	<tr>
		<th><?php _e('Coming Soon Headline','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				<input type="text" class="pro_text" id="cs_headline" name="cs_headline" placeholder="<?php _e('Enter coming soon Title/Headline Here..','DAZZ_CSW_TEXT_DOMAIN'); ?>" size="56" value="<?php echo $dazz_cs_dashboard['cs_headline']; ?>" />
	
		</td>
		
	</tr>

	<tr>
		<th><?php _e('Coming Soon Description','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				<textarea rows="6"  class="pro_text" id="cs_description" name="cs_description" placeholder="<?php _e('Enter Your Coming Soon Description Here...','DAZZ_CSW_TEXT_DOMAIN'); ?>"><?php echo $dazz_cs_dashboard['cs_description']; ?></textarea>
	
		</td>
		
	</tr>
	
	<tr class="radio-span" >
		<td>
				<button class="portfolio_read_more_btn "  onclick="dazz_save_data_dashboard()"><?php _e('Save Settings','DAZZ_CSW_TEXT_DOMAIN'); ?></button>
				<button class="portfolio_demo_btn"  onclick="dazz_reset_data_dashboard()"><?php _e('Reset Default Setting','DAZZ_CSW_TEXT_DOMAIN'); ?></button>
		</td>
		
	</tr>							
	
</table>

<script>
function dazz_save_data_dashboard(){

 jQuery("#dazz_loding_image").show();
 var cs_headline = jQuery("#cs_headline").val();
 var cs_description = jQuery("#cs_description").val();
 var dazz_cs_status = jQuery('input:radio[name="dazz_cs_status"]:checked').val();
 var display_logo = jQuery('input:radio[name="display_logo"]:checked').val();
var cs_logo_url = jQuery("#cs_logo_url").val();
 
 
 	jQuery.ajax(
            {
	    	    type: "POST",
		        url: location.href,
	
		        data : {
			    'action_dashboard':'dazz_csp_dashboard',
			    'dazz_cs_status':dazz_cs_status,
			    'cs_headline':cs_headline,
			    'cs_description':cs_description,
			    'display_logo':display_logo,
			    'cs_logo_url':cs_logo_url,
			   
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
if(isset($_POST['action_dashboard'])=="dazz_csp_dashboard") {
$dazz_cs_status       = sanitize_option('dazz_cs_status', $_POST['dazz_cs_status']);
$cs_headline          = stripslashes(sanitize_text_field($_POST['cs_headline']));
$cs_description          = stripslashes($_POST['cs_description']);
$display_logo          = sanitize_option('display_logo', $_POST['display_logo']);
$cs_logo_url          = sanitize_text_field($_POST['cs_logo_url']);
			
			
$dashboard = serialize( array(
	'dazz_cs_status' 		       => $dazz_cs_status,
	'cs_headline' 		       => $cs_headline,
	'cs_description' 		       => $cs_description,
	'display_logo' 		       => $display_logo,
	'cs_logo_url' 		       => $cs_logo_url,
	
	) );

update_option('dazz_cs_dashboard', $dashboard);
}
 ?>
 
<script>
 
	function dazz_reset_data_dashboard(){
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
			'reset_action_dashboard':'action_dashboard_reset',
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
if(isset($_POST['reset_action_dashboard'])=="action_dashboard_reset") {
	$default_url2 =  DAZZ_CSW_PLUGIN_URL.'assets/img/logo.png'; 
	$dazz_dashboard = serialize( array(
	'dazz_cs_status' 		       => "0",
	'cs_headline' 		       => "Coming Soon",
	'cs_description' 		       => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vel fermentum dui. Pellentesque vitae porttitor ex, euismod sodales magna. Nunc sed felis sed dui pellentesque sodales porta a magna. Donec dui augue, dignissim faucibus lorem nec, fringilla molestie massa. Sed blandit dapibus bibendum. Sed interdum commodo laoreet. Sed mi orci.",
	'display_logo' 		       => "0",
	'cs_logo_url' 		       => $default_url2,
	
	) );
	update_option('dazz_cs_dashboard', $dazz_dashboard);
}
 ?>