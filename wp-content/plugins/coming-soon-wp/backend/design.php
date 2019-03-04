<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
$dazz_cs_design = unserialize(get_option('dazz_cs_design'));	
?>
<Script>
	// Title Font Size Slider	
	jQuery(function() {
		jQuery( "#button-size-slider" ).slider({
			orientation: "horizontal",
			range: "min",
			max: 120,
			min:10,
			slide: function( event, ui ) {
			jQuery( "#dazz_headline_ft_size" ).val( ui.value );
			}
		});
			
		jQuery( "#button-size-slider" ).slider("value",<?php if($dazz_cs_design['dazz_headline_ft_size']!=""){ echo  $dazz_cs_design['dazz_headline_ft_size']; } else { echo "18"; }?>  );
		jQuery( "#dazz_headline_ft_size" ).val( jQuery( "#button-size-slider" ).slider( "value") );

	});
</script>

<Script>
	//Description Fonts Size Slider
	jQuery(function() {
		jQuery( "#button-size-slider3" ).slider({
			orientation: "horizontal",
			range: "min",
			max: 50,
			min:10,
			slide: function( event, ui ) {
			jQuery( "#dazz_desc_ft_size" ).val( ui.value );
			}
		});

	jQuery( "#button-size-slider3" ).slider("value",<?php if($dazz_cs_design['dazz_desc_ft_size']!=""){ echo $dazz_cs_design['dazz_desc_ft_size']; } else { echo "16"; }?> );
	jQuery( "#dazz_desc_ft_size" ).val( jQuery( "#button-size-slider3" ).slider( "value") );

	});
</script>


<table class="form-table">
	<tr>
		<th><?php _e('Select Background','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
			<span style="margin-bottom:10px;display: block;">
				<input type="radio" name="dazz_cs_select_bg" value="0" id="dazz_cs_select_bg" <?php if($dazz_cs_design['dazz_cs_select_bg'] == "0") { echo "checked"; } ?> />&nbsp;<?php _e('Color Background','DAZZ_CSW_TEXT_DOMAIN'); ?><br>
			</span>
			<span>	
				<input type="radio" name="dazz_cs_select_bg" value="1" id="dazz_cs_select_bg" <?php if($dazz_cs_design['dazz_cs_select_bg'] == "1") { echo "checked"; } ?>  />&nbsp;<?php _e('Image Background','DAZZ_CSW_TEXT_DOMAIN'); ?><br>
			</span>
		</td>
	</tr>
	<tr>
		<th><?php _e('Background Color','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				
			<input id="dazz_cs_bg_clr" name="dazz_cs_bg_clr" type="text" value="<?php echo $dazz_cs_design['dazz_cs_bg_clr']; ?>" class="my-color-field" data-default-color="#ffffff" />

		</td>
		
	</tr>

	<tr>
		<th><?php _e('Background Image','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				
				<img src="<?php echo $dazz_cs_design['dazz_cs_bg_img'] ?>" class="csw-admin-img" />
				
				<input type="button" id="upload-background" name="upload-background" value="Upload Image" class="button-primary rcsp_media_upload"  />
				<input type="hidden" id="dazz_cs_bg_img" name="dazz_cs_bg_img" class="rcsp_label_text"  value="<?php echo $dazz_cs_design['dazz_cs_bg_img'] ?>"  readonly="readonly" placeholder="No Media Selected" />
				
		</td>
		
	</tr>
	<tr>
		<th><?php _e('Headline Color','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				
			<input id="dazz_headeline_ft_clr" name="dazz_headeline_ft_clr" type="text" value="<?php echo $dazz_cs_design['dazz_headeline_ft_clr'] ?>" class="my-color-field" data-default-color="#ffffff" />

		</td>
		
	</tr>

	<tr>
		<th><?php _e('Description Color','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				
			<input id="dazz_desc_ft_clr" name="dazz_desc_ft_clr" type="text" value="<?php echo $dazz_cs_design['dazz_desc_ft_clr'] ?>" class="my-color-field" data-default-color="#ffffff" />

		</td>
		
	</tr>	

	<tr>
		<th><?php _e('Social Icon Color','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				
			<input id="dazz_social_clr" name="dazz_social_clr" type="text" value="<?php echo $dazz_cs_design['dazz_social_clr'] ?>" class="my-color-field" data-default-color="#ffffff" />

		</td>
		
	</tr>	

	<tr>
		<th><?php _e('Headline Font Size','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr  >
		<td class="text-and-color-panel">
			<div id="button-size-slider" class="size-slider" style="width: 25%;display:inline-block"></div>
			<input type="text" class="range-slider-font" id="dazz_headline_ft_size" name="dazz_headline_ft_size"  readonly="readonly">
			<span class="slider-text-span">Px</span>
		</td>
		
	</tr>
	<tr>
		<th><?php _e('Description Font Size','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr>
		<td class="text-and-color-panel">
			<div id="button-size-slider3" class="size-slider" style="width: 25%;display:inline-block"></div>
			<input type="text" class="range-slider-font" id="dazz_desc_ft_size" name="dazz_desc_ft_size"  readonly="readonly">
			<span class="slider-text-span">Px</span>
		</td>
		
	</tr>

	<tr>
		<th> <?php _e('Font Family','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr>
		<?php $dazz_ft_st = $dazz_cs_design['dazz_ft_st']; ?>

		<td class="text-and-color-panel">
			<label class="dazz-dropdown">
				<select id="dazz_ft_st" class="dazz-standard-dropdown" name="dazz_ft_st"  >
					<optgroup label="Default Fonts">
						<option value="Arial"           <?php if($dazz_ft_st == 'Arial' ) { echo "selected"; } ?>>Arial</option>
						<option value="Arial Black"    <?php if($dazz_ft_st == 'Arial Black' ) { echo "selected"; } ?>>Arial Black</option>
						<option value="Courier New"     <?php if($dazz_ft_st == 'Courier New' ) { echo "selected"; } ?>>Courier New</option>
						<option value="Georgia"         <?php if($dazz_ft_st == 'Georgia' ) { echo "selected"; } ?>>Georgia</option>
						<option value="Grande"          <?php if($dazz_ft_st == 'Grande' ) { echo "selected"; } ?>>Grande</option>
						<option value="Helvetica" 	<?php if($dazz_ft_st == 'Helvetica' ) { echo "selected"; } ?>>Helvetica Neue</option>
						<option value="Impact"         <?php if($dazz_ft_st == 'Impact' ) { echo "selected"; } ?>>Impact</option>
						<option value="Lucida"         <?php if($dazz_ft_st == 'Lucida' ) { echo "selected"; } ?>>Lucida</option>
						<option value="Lucida Grande"         <?php if($dazz_ft_st == 'Lucida Grande' ) { echo "selected"; } ?>>Lucida Grande</option>
						<option value="Open Sans"   <?php if($dazz_ft_st == 'Open Sans' ) { echo "selected"; } ?>>Open Sans</option>
						<option value="OpenSansBold"   <?php if($dazz_ft_st == 'OpenSansBold' ) { echo "selected"; } ?>>OpenSansBold</option>
						<option value="Palatino Linotype"       <?php if($dazz_ft_st == 'Palatino Linotype' ) { echo "selected"; } ?>>Palatino</option>
						<option value="Sans"           <?php if($dazz_ft_st == 'Sans' ) { echo "selected"; } ?>>Sans</option>
						<option value="sans-serif"           <?php if($dazz_ft_st == 'sans-serif' ) { echo "selected"; } ?>>Sans-Serif</option>
						<option value="Tahoma"         <?php if($dazz_ft_st == 'Tahoma' ) { echo "selected"; } ?>>Tahoma</option>
						<option value="Times New Roman"          <?php if($dazz_ft_st == 'Times New Roman' ) { echo "selected"; } ?>>Times New Roman</option>
						<option value="Trebuchet"      <?php if($dazz_ft_st == 'Trebuchet' ) { echo "selected"; } ?>>Trebuchet</option>
						<option value="Verdana"        <?php if($dazz_ft_st == 'Verdana' ) { echo "selected"; } ?>>Verdana</option>
					</optgroup>
				</select>
			</label>	
		</td>
		
	</tr>
<tr>
		<th> <?php _e('Custom Css','DAZZ_CSW_TEXT_DOMAIN'); ?></th>
	</tr>
	<tr class="radio-span" >
		<td>
				<textarea rows="6"  class="pro_text" id="dazz_cs_custom_css" name="dazz_cs_custom_css" placeholder="<?php _e('Enter Your custom css Here',''); ?>"><?php echo $dazz_cs_design['dazz_cs_custom_css']; ?></textarea>
	
		</td>
		
	</tr>	
	<tr class="radio-span" >
		<td>
				<button class="portfolio_read_more_btn "  onclick="dazz_save_data_design()"><?php _e('Save Settings','DAZZ_CSW_TEXT_DOMAIN'); ?></button>
				<button class="portfolio_demo_btn" onclick="dazz_reset_data_design()" ><?php _e('Reset Default Setting','DAZZ_CSW_TEXT_DOMAIN'); ?></button>
		</td>
		
	</tr>	


</table>

						
<script>
function dazz_save_data_design(){
	jQuery("#dazz_loding_image").show();
	var dazz_cs_select_bg = jQuery('input:radio[name="dazz_cs_select_bg"]:checked').val();
	var dazz_cs_bg_clr = jQuery("#dazz_cs_bg_clr").val();
	var dazz_cs_bg_img = jQuery("#dazz_cs_bg_img").val();
	var dazz_headeline_ft_clr = jQuery("#dazz_headeline_ft_clr").val();
	var dazz_desc_ft_clr = jQuery("#dazz_desc_ft_clr").val();
	var dazz_social_clr = jQuery("#dazz_social_clr").val();
	var dazz_headline_ft_size = jQuery("#dazz_headline_ft_size").val();
	var dazz_desc_ft_size = jQuery("#dazz_desc_ft_size").val();
	var dazz_cs_custom_css = jQuery("#dazz_cs_custom_css").val();
	var dazz_ft_st = jQuery('#dazz_ft_st option:selected').val();

 
 
 	jQuery.ajax(
            {
	    	    type: "POST",
		        url: location.href,
	
		        data : {
			    'action_design':'dazz_csp_design',
			    'dazz_cs_select_bg':dazz_cs_select_bg,
			    'dazz_cs_bg_clr':dazz_cs_bg_clr,
			    'dazz_cs_bg_img':dazz_cs_bg_img,
			    'dazz_headeline_ft_clr':dazz_headeline_ft_clr,
			    'dazz_desc_ft_clr':dazz_desc_ft_clr,
			    'dazz_social_clr':dazz_social_clr,
			    'dazz_headline_ft_size':dazz_headline_ft_size,
			    'dazz_desc_ft_size':dazz_desc_ft_size,
			    'dazz_ft_st':dazz_ft_st,
			    'dazz_cs_custom_css':dazz_cs_custom_css,
			   
			   
			        },
                success : function(data){
					jQuery("#dazz_loding_image").fadeOut();
					jQuery(".dialog-button").click();
					// location.href='?page=dazz_coming_soon_wp';
			  
			   }			
            });
 
}
</script>
<?php
if(isset($_POST['action_design'])=="dazz_csp_design") {
$dazz_cs_select_bg       = sanitize_option('dazz_cs_select_bg', $_POST['dazz_cs_select_bg']);
$dazz_cs_bg_clr          = sanitize_text_field($_POST['dazz_cs_bg_clr']);
$dazz_cs_bg_img          = sanitize_text_field($_POST['dazz_cs_bg_img']);
$dazz_headeline_ft_clr          = sanitize_text_field($_POST['dazz_headeline_ft_clr']);
$dazz_desc_ft_clr          = sanitize_text_field($_POST['dazz_desc_ft_clr']);
$dazz_social_clr          = sanitize_text_field($_POST['dazz_social_clr']);
$dazz_headline_ft_size          = sanitize_text_field($_POST['dazz_headline_ft_size']);
$dazz_desc_ft_size          = sanitize_text_field($_POST['dazz_desc_ft_size']);
$dazz_ft_st          = sanitize_text_field($_POST['dazz_ft_st']);
$dazz_cs_custom_css          = stripslashes($_POST['dazz_cs_custom_css']);

			
			
$design = serialize( array(
	'dazz_cs_select_bg' 		       => $dazz_cs_select_bg,
	'dazz_cs_bg_clr' 		       => $dazz_cs_bg_clr,
	'dazz_cs_bg_img' 		       => $dazz_cs_bg_img,
	'dazz_headeline_ft_clr' 		       => $dazz_headeline_ft_clr,
	'dazz_desc_ft_clr' 		       => $dazz_desc_ft_clr,
	'dazz_social_clr' 		       => $dazz_social_clr,
	'dazz_headline_ft_size' 		       => $dazz_headline_ft_size,
	'dazz_desc_ft_size' 		       => $dazz_desc_ft_size,
	'dazz_ft_st' 		       => $dazz_ft_st,
	'dazz_cs_custom_css' 		       => $dazz_cs_custom_css,
	
	) );

update_option('dazz_cs_design', $design);
}
 ?>
 
 
 <script>
 
	function dazz_reset_data_design(){
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
			'reset_action_design':'action_design_reset',
			
		   
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
if(isset($_POST['reset_action_design'])=="action_design_reset") {
	
	$default_url =  DAZZ_CSW_PLUGIN_URL.'assets/img/bg.jpg'; 
	
	$dazz_design = serialize( array(
	'dazz_cs_select_bg' 		       => "1",
	'dazz_cs_bg_clr' 		       => "#1e73be",
	'dazz_cs_bg_img' 		       => $default_url,
	'dazz_headeline_ft_clr' 		       => "#ffffff",
	'dazz_desc_ft_clr' 		       => "#ffffff",
	'dazz_social_clr' 		       => "#ffffff",
	'dazz_headline_ft_size' 		       => "80",
	'dazz_desc_ft_size' 		       => "21",
	'dazz_ft_st' 		       => "Verdana",
	'dazz_cs_custom_css' 		       => "",
	
	) );

	update_option('dazz_cs_design', $dazz_design);
}
 ?>