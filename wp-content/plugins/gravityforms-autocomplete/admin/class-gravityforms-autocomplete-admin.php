<?php
if (!class_exists('Gravityforms_Autocomplete_Admin')) {

    class Gravityforms_Autocomplete_Admin {

        private $plugin_name;
        private $version;
        public $ptype = array();
        public $tax = array();

        public function __construct($plugin_name, $version) {

            $this->plugin_name = $plugin_name;
            $this->version = $version;
        }
        
        public function add_routing_field_types($supported_fields){
            $supported_fields[] =  "autocomplete";
            return $supported_fields;
        }

        public function gravityforms_settings() {
            GFForms::add_settings_page(
                    array(
                        'name' => "gravityforms_autocomplete",
                        'tab_label' => "GF Autocomplete",
                        'title' => "GF Autocomplete",
                        'handler' => array($this, 'gravityforms_autocomplete_settings'),
                    )
            );
        }

        public function gravityforms_autocomplete_settings() {
            if (isset($_POST['submit'])) {
                check_admin_referer('gf_autocomplete_update_settings', 'gf_autocomplete_update_settings');

                if (!GFCommon::current_user_can_any('gravityforms_edit_settings')) {
                    die(esc_html__("You don't have adequate permission to edit settings.", 'gravityforms'));
                }

                update_option('gfautocomplete_google_place_api_key', sanitize_text_field(rgpost('gfautocomplete_google_place_api_key')));
                ?>
                <div class="updated fade" style="padding:6px;">Settings Updated.</div>
                <?php
            }
            ?>
            <form id="gf_autocomplete_settings" method="post">
                <?php wp_nonce_field('gf_autocomplete_update_settings', 'gf_autocomplete_update_settings') ?>
                <h3><span><i class="fa fa-cogs"></i> GF Autocomplete</span></h3>
                <p style="text-align: left;">
                    In certain cases google browser API key may be required. In that case please obtain the google browser API key from <a href="http://console.developers.google.com/" target="_blank">http://console.developers.google.com/</a>. and add it to the settings
                </p>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <label for="gfautocomplete_google_place_api_key">Google Places API Key</label>
                        </th>
                        <td>
                            <input type="text" id="gfautocomplete_google_place_api_key" name="gfautocomplete_google_place_api_key" style="width:350px;" value="<?php echo esc_attr(get_option('gfautocomplete_google_place_api_key')); ?>" />
                        </td>
                    </tr>
                </table>

                <p class="submit" style="text-align: left;">
                    <input type="submit" name="submit" value="Save Settings" class="button-primary gfbutton" id="save" />
                </p>

            </form>
            <?php
        }

        public function enqueue_styles() {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/gravityforms-autocomplete-admin.css', array(), $this->version, 'all');
        }

        public function enqueue_scripts() {
            //wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gravityforms-autocomplete-admin.js', array( 'jquery' ), $this->version, false );
        }

        public function add_autocomplete_editor_js() {

            echo '<script type="text/javascript">
				jQuery(document).ready(function() {
					fieldSettings["autocomplete"] = ".label_setting, .description_setting, .admin_label_setting, .size_setting, .default_value_textarea_setting, .error_message_setting, .css_class_setting, .visibility_setting,.conditional_logic_field_setting, .placeholder_setting, .label_placement_setting, .prepopulate_field_setting, .duplicate_setting, .rules_setting, .l35_auto, .l35_from"; 
				});
							
				jQuery(document).bind("gform_load_field_settings", function(event, field, form){
					if(field["type"] == "autocomplete") {
						if(field["field_auto"]) { jQuery("#field_auto option[value=" + field["field_auto"] + "").attr("selected","selected");}
						
						if(field["field_from"]) {jQuery("#field_from option[value=" + field["field_from"] + "").attr("selected","selected");}
						jQuery("#field_manual").val(field["field_manual"]);
						jQuery("#field_manual_add").val(field["field_manual_add"]);
						jQuery("#field_manual_add").prop("checked", field["field_manual_add"]);
                        
                        jQuery("#field_multiple").val(field["field_multiple"]);
                        jQuery("#field_multiple").prop("checked", field["field_multiple"]);
                        
						jQuery("#field_ajax").val(field["field_ajax"]);
						
						jQuery(".l35_options").hide();
							jQuery(".l35_"+field["field_from"]+"").show();
						
						jQuery("#field_from").change(function() {
							jQuery(".l35_options").hide();
							var el = jQuery(this);
							el.parent().parent().find(".l35_"+el.val()+"").show();
						});
					}
				});
				jQuery(document).bind( "gform_field_added", function( event, form, field ) {
					if(field["type"] == "autocomplete") {
						jQuery("#field_from option[value=from]").attr("selected","selected");
					}
				} );
				
				
			
			</script>';
        }

        function add_autocomplete_custom_settings($position, $form_id) {
            if ($position == 50) {
                ?>
                <li class="l35_auto l35_options field_setting">
                    <label for="field_autocomplete_data">
                        Select Data for Autocomplete
                <?php
                gform_tooltip(
                        "<h6>Select Data for Autocomplete</h6>Get options for autocomplete using WordPress sources. You can use WordPress taxonomies, posts or users."
                );
                ?>
                    </label>
                    <select class="fieldwidth-3"  id="field_auto" onchange="SetFieldProperty('field_auto', jQuery(this).val());" >
                        <option value="auto">Select Data Source</option>
                        <option value="user">User</option>
                <?php
                $type_ignore = array('revision', 'attachment', 'nav_menu_item');
                $post_types = get_post_types();
                foreach ($post_types as $type):
                    if (!in_array($type, $type_ignore)):
                        ?>
                                <option value="<?php echo $type ?>"><?php echo ucfirst($type) ?> (Post Type)</option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php
                        $taxonomy_ignore = array('revision', 'attachment', 'nav_menu_item');
                        $taxonomies = get_taxonomies();
                        foreach ($taxonomies as $taxonomy):
                            if (!in_array($taxonomy, $taxonomy_ignore)):
                                ?>
                                <option value="<?php echo $taxonomy ?>"><?php echo ucwords(str_replace('_', ' ', $taxonomy)) ?> (Taxonomy)</option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </li>
                <?php
            }
            if ($position == 75) {
                ?>
                <li class="l35_manual l35_options field_setting">
                    <label for="field_manual">
                        Enter Data for Autocomplete
                <?php
                gform_tooltip(
                        "<h6>Enter Data for Autocomplete</h6>Enter options for autocomplete. Enter only one option per line. "
                );
                ?>
                    </label>
                    <textarea id="field_manual" onkeyup="SetFieldProperty('field_manual', jQuery(this).val());" class="fieldwidth-3 fieldheight-2"></textarea>
                </li>
                <li class="l35_manual l35_options field_setting">
                    <input type="checkbox" id="field_manual_add" onclick="SetFieldProperty('field_manual_add', this.checked);" onkeypress="SetFieldProperty('field_manual_add', this.checked);">
                    <label for="field_manual_add" class="inline">
                        Allow adding new option
                <?php
                gform_tooltip(
                        "<h6>Allow adding new option</h6>Tick a checkbox to let users adding new option to Autocomplete data. "
                );
                ?>
                    </label>
                </li>
                <?php
            }

            if ($position == 100) {
                ?>
                <li class="l35_ajax l35_options field_setting">
                    <label for="field_ajax">
                        Enter URL for Autocomplete
                <?php
                gform_tooltip(
                        "<h6>Enter URL for Autocomplete</h6>Get options for autocomplete using AJAX. Enter  url which returns data in json format."
                );
                ?>
                    </label>
                    <input class="fieldwidth-3" type="text" id="field_ajax" onkeyup="SetFieldProperty('field_ajax', jQuery(this).val());">
                </li>
                <?php
            }

            if ($position == 25) {
                ?>
                <li class="l35_from field_setting">
                    <label for="field_from">
                        Where to Get Options? <?php gform_tooltip("<h6>Where to get options?</h6>Select where to get options you want. WordPress, URL or Manually."); ?>
                    </label>
                    <select class="fieldwidth-3"  id="field_from" onchange="SetFieldProperty('field_from', jQuery(this).val());" >
                        <option value="from">Select From</option>
                        <option value="auto">WordPress</option>
                        <option value="ajax">URL (json)</option>
                        <option value="manual">Manually</option>
                        <option value="address">Address</option>
                    </select>
                </li>
                <li class="l35_from field_setting">
                    <input type="checkbox" id="field_multiple" onclick="SetFieldProperty('field_multiple', this.checked);" onkeypress="SetFieldProperty('field_multiple', this.checked);">
                    <label for="field_multiple" class="inline">
                        Allow multi-value mode
                <?php
                gform_tooltip(
                        "Allow adding several options from auto-complete field. "
                );
                ?>
                    </label>
                </li>
                <?php
            }
        }

        public function add_autocomplete_scripts($form, $ajax) {

            $data = array();
            $data['ajaxurl'] = admin_url('admin-ajax.php');
            $data['sources'] = array();
            foreach ($form['fields'] as $field) {
                if ($field['type'] == 'autocomplete' || $field['type'] == 'autocomplete2') {
                    $url = plugin_dir_url(__FILE__) . 'js/gravityforms-autocomplete-admin.js';
                  //  $plugin = plugin_dir_url(__FILE__) . 'js/jquery.auto-complete.min.js';
                //    wp_enqueue_script("gf_autocomplete-plugin", $plugin, array("jquery"), '1.0', true);
                    wp_enqueue_script("gf_autocomplete", $url, array("jquery"), '1.0', true);
                    break;
                }
            }
            
            wp_enqueue_style('gf_autocomplete_select2',"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css", array(), $this->version, 'all');
            wp_enqueue_script('gf_autocomplete_select2', "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js", array('jquery'), $this->version, false );


            $post_types = get_post_types();
            foreach ($post_types as $type):
                $this->ptype[] = $type;
            endforeach;


            $taxonomies = get_taxonomies();
            foreach ($taxonomies as $taxonomy):
                $this->tax[] = $taxonomy;
            endforeach;


            foreach ($form['fields'] as $field) {
                if (isset($field['field_auto'])) {
                    
                    if (in_array($field['field_auto'], $this->ptype)) {
                        if (!array_key_exists($field['field_auto'], $data['sources'])) {
                            $data['sources'][$field['field_auto']] = true; 
                            continue;
                        }
                    }
                    
                    if (in_array($field['field_auto'], $this->tax)) {
                        if (!array_key_exists($field['field_auto'], $data['sources'])) {
                            $data['sources'][$field['field_auto']] = true; 
                            continue;
                        }
                    }
                    
                    if ( $field['field_auto'] == 'user') {
                        $data['sources']['user'] =  true;
                        continue; 
                    }
                }
            }
            wp_localize_script('gf_autocomplete', 'l35', $data);
        }

    }

}