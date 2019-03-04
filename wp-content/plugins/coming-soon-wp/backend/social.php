<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
$dazz_cs_social = unserialize(get_option('dazz_cs_social'));	
?>
<table class="form-table">
		<tr>
			<th><?php _e('Facbook','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
		</tr>
		<tr class="radio-span" >
			<td>
					
				
				<input type="text" class="pro_text" id="dazz_cs_fb" name="dazz_cs_fb" placeholder="<?php _e('Enter Facebook profile url','DAZZ_CSW_TEXT_DOMAIN'); ?>" size="56" value="<?php echo $dazz_cs_social['dazz_cs_fb']; ?>" />
					<span style="color: #8e8e8e;"> Note : enter complete profile url with "http://" example  : https://www.facebook.com/wpshopmart/</span>		
								
			</td>
			
		</tr>
		<tr>
			<th><?php _e('Twitter','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
		</tr>
		<tr class="radio-span" >
			<td>
					
				
				<input type="text" class="pro_text" id="dazz_cs_twit" name="dazz_cs_twit" placeholder="<?php _e('Enter Twitter profile url','DAZZ_CSW_TEXT_DOMAIN'); ?>" size="56" value="<?php echo $dazz_cs_social['dazz_cs_twit']; ?>" />
				<span style="color: #8e8e8e;">Note : enter complete profile url with "http://" example  :https://twitter.com/wpshopmart1</span>			
								
			</td>
			
		</tr>
		
		<tr>
			<th><?php _e('LinkedIn','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
		</tr>
		<tr class="radio-span" >
			<td>
					
				
				<input type="text" class="pro_text" id="dazz_cs_ln" name="dazz_cs_ln" placeholder="<?php _e('Enter LinkedIn profile url','DAZZ_CSW_TEXT_DOMAIN'); ?>" size="56" value="<?php echo $dazz_cs_social['dazz_cs_ln']; ?>" />
							
					<span style="color: #8e8e8e;">Note : enter complete profile url with "http://" example  : https://www.linkedin.com/</span>			
			</td>
			
		</tr>
		
		<tr>
			<th> <?php _e('Google+','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
		</tr>
		<tr class="radio-span" >
			<td>
					
				
				<input type="text" class="pro_text" id="dazz_cs_gp" name="dazz_cs_gp" placeholder="<?php _e('Enter Google Plus profile url ','DAZZ_CSW_TEXT_DOMAIN'); ?>" size="56" value="<?php echo $dazz_cs_social['dazz_cs_gp']; ?>" />
				<span style="color: #8e8e8e;">Note : enter complete profile url with "http://" example  : https://plus.google.com/u/0/108719707535083220625</span>			
								
			</td>
			
		</tr>
		<tr class="radio-span" >
		<td>
				<button class="portfolio_read_more_btn "  onclick="dazz_save_data_social()"><?php _e('Save Settings','DAZZ_CSW_TEXT_DOMAIN'); ?></button>
				<button class="portfolio_demo_btn" onclick="dazz_reset_data_social()" ><?php _e('Reset Default Setting','DAZZ_CSW_TEXT_DOMAIN'); ?></button>
		</td>
		
	</tr>	
</table>

<script>
function dazz_save_data_social(){
 jQuery("#dazz_loding_image").show();
 var dazz_cs_fb = jQuery("#dazz_cs_fb").val();
 var dazz_cs_twit = jQuery("#dazz_cs_twit").val();
 var dazz_cs_ln = jQuery("#dazz_cs_ln").val();
 var dazz_cs_gp = jQuery("#dazz_cs_gp").val();
 
 
 	jQuery.ajax(
            {
	    	    type: "POST",
		        url: location.href,
	
		        data : {
			    'action_social':'dazz_csp_social',
			    'dazz_cs_fb':dazz_cs_fb,
			    'dazz_cs_twit':dazz_cs_twit,
			    'dazz_cs_ln':dazz_cs_ln,
			    'dazz_cs_gp':dazz_cs_gp,
			    
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
if(isset($_POST['action_social'])=="dazz_csp_social") {
$dazz_cs_fb          = sanitize_text_field($_POST['dazz_cs_fb']);
$dazz_cs_twit          = sanitize_text_field($_POST['dazz_cs_twit']);
$dazz_cs_ln          = sanitize_text_field($_POST['dazz_cs_ln']);
$dazz_cs_gp          = sanitize_text_field($_POST['dazz_cs_gp']);
			
			
$social = serialize( array(
	'dazz_cs_fb' 		       => $dazz_cs_fb,
	'dazz_cs_twit' 		       => $dazz_cs_twit,
	'dazz_cs_ln' 		       => $dazz_cs_ln,
	'dazz_cs_gp'    		   => $dazz_cs_gp,
	
	) );

update_option('dazz_cs_social', $social);
}
 ?>
 
 
 <script>
 
	function dazz_reset_data_social(){
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
			'reset_action_social':'action_social_reset',
			
		   
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
if(isset($_POST['reset_action_social'])=="action_social_reset") {
	
	
	$dazz_social = serialize( array(
	'dazz_cs_fb' 		       => "#",
	'dazz_cs_twit' 		       => "#",
	'dazz_cs_ln' 		       => "#",
	'dazz_cs_gp'    		   => "#",
	
	) );

	update_option('dazz_cs_social', $dazz_social);
}
 ?>