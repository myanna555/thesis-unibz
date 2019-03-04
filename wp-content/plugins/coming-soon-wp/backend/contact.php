<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
$dazz_cs_contact = unserialize(get_option('dazz_cs_contact'));	
?>
<table class="form-table">
		<tr>
			<th><?php _e('Address','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
		</tr>
		<tr class="radio-span">
			<td>	
				<input type="text" class="pro_text" id="dazz_cs_address" name="dazz_cs_address" placeholder="<?php _e('Enter your Address','DAZZ_CSW_TEXT_DOMAIN'); ?>" size="56" value="<?php echo $dazz_cs_contact['dazz_cs_address']; ?>" />
								
			</td>
			
		</tr>
		<tr>
			<th><?php _e('Contact No.','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
		</tr>
		<tr class="radio-span">
			<td>		
				<input type="text" class="pro_text" id="dazz_cs_no" name="dazz_cs_no" placeholder="<?php _e('Enter your contact No.','DAZZ_CSW_TEXT_DOMAIN'); ?>" size="56" value="<?php echo $dazz_cs_contact['dazz_cs_no']; ?>" />
			</td>			
		</tr>
		
		<tr>
			<th><?php _e('Email Address','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
		</tr>
		<tr class="radio-span">
			<td>	
				<input type="text" class="pro_text" id="dazz_cs_email" name="dazz_cs_email" placeholder="<?php _e('Enter your contact email','DAZZ_CSW_TEXT_DOMAIN'); ?>" size="56" value="<?php echo $dazz_cs_contact['dazz_cs_email']; ?>" />
			</td>			
		</tr>
		<tr class="radio-span" >
			<td>
				<button class="portfolio_read_more_btn "  onclick="dazz_save_data_contact()"><?php _e('Save Settings','DAZZ_CSW_TEXT_DOMAIN'); ?></button>
				<button class="portfolio_demo_btn" onclick="dazz_reset_data_contact()" ><?php _e('Reset Default Setting','DAZZ_CSW_TEXT_DOMAIN'); ?></button>
			</td>		
		</tr>	
		
</table>


<script>
function dazz_save_data_contact(){
 jQuery("#dazz_loding_image").show();
 var dazz_cs_address = jQuery("#dazz_cs_address").val();
 var dazz_cs_no = jQuery("#dazz_cs_no").val();
 var dazz_cs_email = jQuery("#dazz_cs_email").val();
 
 
 	jQuery.ajax(
            {
	    	    type: "POST",
		        url: location.href,
	
		        data : {
			    'action_contact':'dazz_csp_contact',
			    'dazz_cs_address':dazz_cs_address,
			    'dazz_cs_no':dazz_cs_no,
			    'dazz_cs_email':dazz_cs_email,
			    
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
if(isset($_POST['action_contact'])=="dazz_csp_contact") {
$dazz_cs_address          = sanitize_text_field($_POST['dazz_cs_address']);
$dazz_cs_no          = sanitize_text_field($_POST['dazz_cs_no']);
$dazz_cs_email          = sanitize_text_field($_POST['dazz_cs_email']);
			
			
$contact = serialize( array(
	'dazz_cs_address' 		       => $dazz_cs_address,
	'dazz_cs_no' 		       => $dazz_cs_no,
	'dazz_cs_email'    		   => $dazz_cs_email,
	
	) );

update_option('dazz_cs_contact', $contact);
}
 ?>
 
  <script>
 
	function dazz_reset_data_contact(){
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
			'reset_action_contact':'action_contact_reset',
			
		   
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
if(isset($_POST['reset_action_contact'])=="action_contact_reset") {
	
	
	$dazz_contact = serialize( array(
	'dazz_cs_address' 		       => "123 Street, City",
	'dazz_cs_no' 		       => "(00) 123-4567890",
	'dazz_cs_email'    		   => "email@example.com",
	
	) );

	update_option('dazz_cs_contact', $dazz_contact);
	
}
 ?>