<?php

if (!class_exists('GFForms')) {
    die();
}

class GF_Field_Autocomplete extends GF_Field {

    public $type = 'autocomplete';

    public function get_entry_inputs() {
        if ($this->field_from == "address") {
            $this->inputs = array(array('id' => intval($this->id) + 0.1, 'label' => 'Street Address', 'name' => ''),
                array('id' => intval($this->id) + 0.2, 'label' => 'Address Line 2', 'name' => ''),
                array('id' => intval($this->id) + 0.3, 'label' => 'City', 'name' => ''),
                array('id' => intval($this->id) + 0.4, 'label' => 'State / Province / Region', 'name' => ''),
                array('id' => intval($this->id) + 0.5, 'label' => 'ZIP / Postal Code', 'name' => ''),
                array('id' => intval($this->id) + 0.6, 'label' => 'Country', 'name' => ''),
                array('id' => intval($this->id) + 0.7, 'label' => 'Search', 'name' => ''),);
            return $this->inputs;
        } else {
            $this->inputs = '';
            return $this->inputs;
        }
    }

    public function get_form_editor_field_title() {
        return esc_attr__('Auto Complete', 'gravityforms');
    }

    public function get_form_editor_button() {
        return array(
            'group' => 'advanced_fields',
            'text' => $this->get_form_editor_field_title()
        );
    }

    function get_form_editor_field_settings() {
        return array(
            'conditional_logic_field_setting',
            'prepopulate_field_setting',
            'error_message_setting',
            'enable_enhanced_ui_setting',
            'label_setting',
            'label_placement_setting',
            'admin_label_setting',
            'size_setting',
            'rules_setting',
            'placeholder_setting',
            //'default_value_setting',
            'visibility_setting',
            'duplicate_setting',
            'description_setting',
            'css_class_setting',
            'l35_from',
        );
    }

    public function is_conditional_logic_supported() {
        return true;
    }

    public function get_field_input($form, $value = '', $entry = null) {

        $is_entry_detail = GFCommon::is_entry_detail();
        $is_form_editor = GFCommon::is_form_editor();
        $is_admin = $is_entry_detail || $is_form_editor;

        $disabled_text = $is_form_editor ? "disabled='disabled'" : '';
        $class_suffix = $is_entry_detail ? '_admin' : '';

        $form_id = absint($form['id']);

        $id = $this->id;
        $field_id = $is_admin || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";

        $form_sub_label_placement = rgar($form, 'subLabelPlacement');
        $field_sub_label_placement = rgar($this, 'subLabelPlacement');
        $is_sub_label_above = $field_sub_label_placement == 'above' || ( empty($field_sub_label_placement) && $form_sub_label_placement == 'above' );

        if ($this->field_from != "address") {
            $data_choices = '';
            $data_ajax = '';
            $data_class = '';
            $data_multiple = '';

            $data_manual_add = '';

            if (isset($this->field_manual) && $this->field_from == "manual") {
                $data_choices = "data-choices='" . json_encode(preg_split('/\r\n|[\r\n]/', htmlspecialchars($this->field_manual, ENT_QUOTES))) . "'";

                if ($this->field_manual_add)
                    $data_manual_add = "data-tags='" . $this->field_manual_add . "'";
            }

            if (isset($this->field_multiple) && $this->field_multiple)
                $data_multiple = "multiple='multiple'";


            if (isset($this->field_ajax) && $this->field_from == "ajax") {
                $data_ajax = "data-ajax='" . $this->field_ajax . "'";
            }

            if (isset($this->field_auto) && $this->field_from == "auto") {
                $data_class = isset($this->field_auto) ? esc_attr($this->field_auto) : '';
            }

            if (isset($this->placeholder)) {
                $data_placeholder = "data-placeholder='" . $this->placeholder . "'";
            }

            $size = $this->size;
            $class = $size . $class_suffix;
            $css_class = esc_attr($class) . ' gfield_text gform_autocomplete ' . $this->field_from;
            $css_class.=isset($this['cssClass']) ? ' ' . esc_attr($this['cssClass']) : '';
            $css_class.=' ' . $data_class;

            $css_class = trim($css_class);

            $tabindex = $this->get_tabindex();

            $name = "input_" . $id . (isset($this->field_multiple) && $this->field_multiple ? "[]" : "");

            if (!empty($value))
                $value = '<option value="' . $value . '" selected="selected">' . $value . '</option>';

            return sprintf("<div class='ginput_container ginput_container_text'><select name='%s' id='%s' class='%s' $tabindex %s %s %s %s %s %s> $value </select></div>", $name, $field_id, $css_class, $disabled_text, $data_choices, $data_ajax, $data_placeholder, $data_manual_add, $data_multiple);
        } else {
            $street_value = '';
            $street2_value = '';
            $city_value = '';
            $state_value = '';
            $zip_value = '';
            $country_value = '';
            if (is_array($value)) {
                $street_value = esc_attr(rgget($this->id . '.1', $value));
                $street2_value = esc_attr(rgget($this->id . '.2', $value));
                $city_value = esc_attr(rgget($this->id . '.3', $value));
                $state_value = esc_attr(rgget($this->id . '.4', $value));
                $zip_value = esc_attr(rgget($this->id . '.5', $value));
                $country_value = esc_attr(rgget($this->id . '.6', $value));
            }

            $css_class = isset($this->cssClass) ? esc_attr($this->cssClass) : '';
            $css_class.=' has_street has_street2 has_city has_state has_zip has_country ginput_container_address';

            $search_line = '';
            $tabindex = $this->get_tabindex();

            $search_line_placeholder_attribute = 'placeholder="' . esc_html__('Enter a location', 'gravityforms') . '"';

            $search_line = " <span class='ginput_full gform_autocomplete autocomplete_search_line' id='{$field_id}_0_container'><input type='text' style='margin-bottom: 20px;' name='input_{$id}.7' id='{$field_id}_7' value='' {$tabindex} {$disabled_text} {$search_line_placeholder_attribute}/></span>";

            //address field
            $street_address = '';
            $tabindex = $this->get_tabindex();
            if (!$is_admin) {

                if ($is_sub_label_above) {
                    $street_address = " <span class='ginput_full{$class_suffix} address_line_1' id='{$field_id}_1_container'><label for='{$field_id}_1' id='{$field_id}_1_label'>" . esc_html__('Street Address', 'gravityforms') . "</label><input type='text' name='input_{$id}.1' id='{$field_id}_1' value='{$street_value}' {$tabindex} {$disabled_text}/></span>";
                } else {
                    $street_address = " <span class='ginput_full{$class_suffix} address_line_1' id='{$field_id}_1_container'><input type='text' name='input_{$id}.1' id='{$field_id}_1' value='{$street_value}' {$tabindex} {$disabled_text}/><label for='{$field_id}_1' id='{$field_id}_1_label'>" . esc_html__('Street Address', 'gravityforms') . "</label></span>";
                }
            }


            //address line 2 field
            $street_address2 = '';
            $tabindex = $this->get_tabindex();
            if (!$is_admin) {
                if ($is_sub_label_above) {
                    $street_address2 = "<span class='ginput_full{$class_suffix} address_line_2' id='{$field_id}_2_container'><label for='{$field_id}_2' id='{$field_id}_2_label'>" . esc_html__('Address Line 2', 'gravityforms') . "</label><input type='text' name='input_{$id}.2' id='{$field_id}_2' value='{$street2_value}' {$tabindex} {$disabled_text}/></span>";
                } else {
                    $street_address2 = "<span class='ginput_full{$class_suffix} address_line_2' id='{$field_id}_2_container'><input type='text' name='input_{$id}.2' id='{$field_id}_2' value='{$street2_value}' {$tabindex} {$disabled_text}/><label for='{$field_id}_2' id='{$field_id}_2_label'>" . esc_html__('Address Line 2', 'gravityforms') . "</label></span>";
                }
            }


            //city field
            $city = '';
            $tabindex = $this->get_tabindex();
            if (!$is_admin) {
                if ($is_sub_label_above) {
                    $city = "<span class='ginput_left{$class_suffix} address_city' id='{$field_id}_3_container'><label for='{$field_id}_3' id='{$field_id}_3_label'>" . esc_html__('City', 'gravityforms') . "</label><input type='text' name='input_{$id}.3' id='{$field_id}_3' value='{$city_value}' {$tabindex} {$disabled_text}/></span>";
                } else {
                    $city = "<span class='ginput_left{$class_suffix} address_city' id='{$field_id}_3_container'><input type='text' name='input_{$id}.3' id='{$field_id}_3' value='{$city_value}' {$tabindex} {$disabled_text}/><label for='{$field_id}_3' id='{$field_id}_3_label'>" . esc_html__('City', 'gravityforms') . "</label></span>";
                }
            }

            //state field
            $state = '';
            $tabindex = $this->get_tabindex();
            if (!$is_admin) {
                if ($is_sub_label_above) {
                    $state = "<span class='ginput_right{$class_suffix} address_state' id='{$field_id}_4_container'><label for='{$field_id}_4' id='{$field_id}_4_label'>" . esc_html__('State / Province / Region', 'gravityforms') . "</label><input type='text' name='input_{$id}.4' id='{$field_id}_4' value='{$state_value}' {$tabindex} {$disabled_text}/>    </span>";
                } else {
                    $state = "<span class='ginput_right{$class_suffix} address_state' id='{$field_id}_4_container'><input type='text' name='input_{$id}.4' id='{$field_id}_4' value='{$state_value}' {$tabindex} {$disabled_text}/><label for='{$field_id}_4' id='{$field_id}_4_label'>" . esc_html__('State / Province / Region', 'gravityforms') . "</label></span>";
                }
            }

            //zip field
            $zip = '';
            $tabindex = $this->get_tabindex();
            if (!$is_admin) {
                if ($is_sub_label_above) {
                    $zip = "<span class='ginput_left{$class_suffix} address_zip' id='{$field_id}_5_container'><label for='{$field_id}_5' id='{$field_id}_5_label'>" . esc_html__('ZIP / Postal Code', 'gravityforms') . "</label><input type='text' name='input_{$id}.5' id='{$field_id}_5' value='{$zip_value}' {$tabindex} {$disabled_text}/></span>";
                } else {
                    $zip = "<span class='ginput_left{$class_suffix} address_zip' id='{$field_id}_5_container'><input type='text' name='input_{$id}.5' id='{$field_id}_5' value='{$zip_value}' {$tabindex} {$disabled_text}/><label for='{$field_id}_5' id='{$field_id}_5_label'>" . esc_html__('ZIP / Postal Code', 'gravityforms') . "</label></span>";
                }
            }

            $country = "";
            $tabindex = $this->get_tabindex();
            if (!$is_admin) {
                $country_list = $this->get_country_dropdown($country_value, '');
                if ($is_sub_label_above) {
                    $country = "<span class='ginput_right{$class_suffix} address_country' id='{$field_id}_6_container'><label for='{$field_id}_6' id='{$field_id}_6_label'>" . esc_html__('Country', 'gravityforms') . "</label><select name='input_{$id}.6' id='{$field_id}_6' {$tabindex} {$disabled_text}>{$country_list}</select></span>";
                } else {
                    $country = "<span class='ginput_right{$class_suffix} address_country' id='{$field_id}_6_container'><select name='input_{$id}.6' id='{$field_id}_6' {$tabindex} {$disabled_text}>{$country_list}</select><label for='{$field_id}_6' id='{$field_id}_6_label'>" . esc_html__('Country', 'gravityforms') . "</label></span>";
                }
            }



            $inputs = '<div class="ginput_complex' . $class_suffix . ' ginput_container ' . $css_class . ' gfield_trigger_change gform_autocomplete_container" id="' . $field_id . '">'
                    . $search_line
                    . $street_address
                    . $street_address2
                    . $city
                    . $state
                    . $zip
                    . $country
                    . '<div class="gf_clear gf_clear_complex"></div></div>';

            $place_api_key = get_option('gfautocomplete_google_place_api_key', false);
            if ($place_api_key && !$is_admin) {

                $handle = 'maps.googleapis.com/maps/api/js';
                $list = 'enqueued';
                if (wp_script_is($handle, $list)) {
                    return $inputs;
                } else {
                    wp_register_script('maps.googleapis.com/maps/api/js', 'https://maps.googleapis.com/maps/api/js?key=' . $place_api_key . '&libraries=places&callback=initAutocomplete');
                    wp_enqueue_script('maps.googleapis.com/maps/api/js');
                }

                //  $inputs .= '<script src="https://maps.googleapis.com/maps/api/js?key=' . $place_api_key . '&libraries=places&callback=initAutocomplete" async defer></script>';
            }

            return $inputs;
        }
    }

    public function get_form_inline_script_on_page_render($form) {
        $is_entry_detail = GFCommon::is_entry_detail();
        $is_form_editor = GFCommon::is_form_editor();
        $is_admin = $is_entry_detail || $is_form_editor;
        $form_id = absint($form['id']);
        $id = $this->id;
        $field_id = $is_admin || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";

        $script = "";
        if ($this->field_from === "auto") {
            $script = "jQuery.each( l35.sources, function( key, value ) {
                        jQuery('#$field_id').each(function(){
                            var el = jQuery(this);
                            el.select2({
                                  minimumInputLength : 3,
                                  ajax: {
                                    url: l35.ajaxurl,
                                    dataType: 'json',
                                    data: function (params) {
                                      var query = {
                                        action: 'ga_get_choices_ajax',
                                        query: params.term,
                                        type: key
                                      }

                                      return query;
                                    }
                                  }
                            });
                        });
                      });";
        } else if ($this->field_from === "manual") {
            $script = "jQuery('#$field_id').each(function(){
                            var el = jQuery(this),
                            choices = jQuery(this).data('choices');


                            el.select2({
                               minimumInputLength : 3,
                               createTag: function (params) {
                                   var term = jQuery.trim(params.term);

                                   if (term === '') {
                                     return null;
                                   }

                                   return {
                                     id: term,
                                     text: term,
                                     newTag: true
                                   }
                               },
                               templateResult: function (data) {
                                   var _result = jQuery('<span></span>');

                                   _result.text(data.text);

                                   if (data.newTag) {
                                     _result.append(' <em>(new)</em>');
                                   }

                                   return _result;
                               }, 
                               data: choices
                            });   

                       });";
        } else if ($this->field_from === "ajax") {
            $script = "jQuery('#$field_id').each(function(){
                            var el = jQuery(this);
                            el.select2({
                               minimumInputLength : 3,
                               ajax: {
                                   url: l35.ajaxurl,
                                   dataType: 'json',
                                   data: function (params) {
                                     var query = {
                                       action: 'ga_get_choices_ajax',
                                       query: params.term,
                                       type: 'json',
                                       delay: 250,
                                       'url' : el.data('ajax')
                                     }

                                     return query;
                                   }
                               }
                            });   

                       }); ";
        }

        return $script;
    }

    public function get_value_entry_detail($value, $currency = '', $use_text = false, $format = 'html', $media = 'screen') {
        if ($this->field_from != "address") {

            if (isset($this->field_multiple) && $this->field_multiple) {


                if (empty($value) || $format == 'text') {
                    return $value;
                }

                $value = $this->to_array($value);

                $items = '';
                foreach ($value as $item) {
                    $item_value = GFCommon::selection_display($item, $this, $currency, $use_text);
                    $items .= '<li>' . esc_html($item_value) . '</li>';
                }

                return "<ul class='bulleted'>{$items}</ul>";
            } else {
                return parent::get_value_entry_detail($value, $currency, $use_text, $format, $media);
            }
        } else {
            if (is_array($value)) {
                $street_value = trim(rgget($this->id . '.1', $value));
                $street2_value = trim(rgget($this->id . '.2', $value));
                $city_value = trim(rgget($this->id . '.3', $value));
                $state_value = trim(rgget($this->id . '.4', $value));
                $zip_value = trim(rgget($this->id . '.5', $value));
                $country_value = $this->get_country_name(trim(rgget($this->id . '.6', $value)));

                if ($format === 'html') {
                    $street_value = esc_html($street_value);
                    $street2_value = esc_html($street2_value);
                    $city_value = esc_html($city_value);
                    $state_value = esc_html($state_value);
                    $zip_value = esc_html($zip_value);
                    $country_value = esc_html($country_value);

                    $line_break = '<br />';
                } else {
                    $line_break = "\n";
                }

                $address_display_format = apply_filters('gform_address_display_format', 'default', $this);
                if ($address_display_format == 'zip_before_city') {
                    /*
                      Sample:
                      3333 Some Street
                      suite 16
                      2344 City, State
                      Country
                     */

                    $addr_ary = array();
                    $addr_ary[] = $street_value;

                    if (!empty($street2_value)) {
                        $addr_ary[] = $street2_value;
                    }

                    $zip_line = trim($zip_value . ' ' . $city_value);
                    $zip_line .=!empty($zip_line) && !empty($state_value) ? ", {$state_value}" : $state_value;
                    $zip_line = trim($zip_line);
                    if (!empty($zip_line)) {
                        $addr_ary[] = $zip_line;
                    }

                    if (!empty($country_value)) {
                        $addr_ary[] = $country_value;
                    }

                    $address = implode('<br />', $addr_ary);
                } else {
                    $address = $street_value;
                    $address .=!empty($address) && !empty($street2_value) ? $line_break . $street2_value : $street2_value;
                    $address .=!empty($address) && (!empty($city_value) || !empty($state_value) ) ? $line_break . $city_value : $city_value;
                    $address .=!empty($address) && !empty($city_value) && !empty($state_value) ? ", $state_value" : $state_value;
                    $address .=!empty($address) && !empty($zip_value) ? ", $zip_value" : $zip_value;
                    $address .=!empty($address) && !empty($country_value) ? $line_break . $country_value : $country_value;
                }

                //adding map link
                /**
                 * Disables the Google Maps link from displaying in the address field.
                 *
                 * @since 1.9
                 *
                 * @param bool false Determines if the map link should be disabled. Set to true to disable. Defaults to false.
                 */
                $map_link_disabled = apply_filters('gform_disable_address_map_link', false);
                if (!empty($address) && $format == 'html' && !$map_link_disabled) {
                    $address_qs = str_replace($line_break, ' ', $address); //replacing <br/> and \n with spaces
                    $address_qs = urlencode($address_qs);
                    $address .= "<br/><a href='http://maps.google.com/maps?q={$address_qs}' target='_blank' class='map-it-link'>Map It</a>";
                }

                return $address;
            } else {
                return '';
            }
        }
    }

    public function get_value_export($entry, $input_id = '', $use_text = false, $is_csv = false) {

        if ($this->field_from != "address") {
            if (isset($this->field_multiple) && $this->field_multiple) {
                if (empty($input_id)) {
                    $input_id = $this->id;
                }

                $value = rgar($entry, $input_id);

                if (!empty($value) && !$is_csv) {
                    $items = $this->to_array($value);

                    foreach ($items as &$item) {
                        $item = GFCommon::selection_display($item, $this, rgar($entry, 'currency'), $use_text);
                    }
                    $value = GFCommon::implode_non_blank(', ', $items);
                } elseif ($this->storageType === 'json') {

                    $items = json_decode($value);
                    $value = GFCommon::implode_non_blank(', ', $items);
                }

                return $value;
            } else {
                return parent::get_value_export($entry, $input_id, $use_text, $is_csv);
            }
        } else {
            if (empty($input_id)) {
                $input_id = $this->id;
            }

            if (absint($input_id) == $input_id) {
                $street_value = str_replace('  ', ' ', trim(rgar($entry, $input_id . '.1')));
                $street2_value = str_replace('  ', ' ', trim(rgar($entry, $input_id . '.2')));
                $city_value = str_replace('  ', ' ', trim(rgar($entry, $input_id . '.3')));
                $state_value = str_replace('  ', ' ', trim(rgar($entry, $input_id . '.4')));
                $zip_value = trim(rgar($entry, $input_id . '.5'));
                $country_value = $this->get_country_code(trim(rgar($entry, $input_id . '.6')));
                //$country_value = $this->get_country_name(trim(rgar($entry, $input_id . '.6')));

                $address = $street_value;
                $address .=!empty($address) && !empty($street2_value) ? "  $street2_value" : $street2_value;
                $address .=!empty($address) && (!empty($city_value) || !empty($state_value) ) ? ", $city_value," : $city_value;
                $address .=!empty($address) && !empty($city_value) && !empty($state_value) ? "  $state_value" : $state_value;
                $address .=!empty($address) && !empty($zip_value) ? "  $zip_value," : $zip_value;
                $address .=!empty($address) && !empty($country_value) ? "  $country_value" : $country_value;

                return $address;
            } else {

                return rgar($entry, $input_id);
            }
        }
    }

    public function get_country_dropdown($selected_country = '', $placeholder = '') {
        $str = '';
        $selected_country = strtolower($selected_country);
        $countries = array_merge(array(''), $this->get_countries());
        foreach ($countries as $code => $country) {
            if (is_numeric($code)) {
                $code = $this->get_country_code($country);
            }
            if (empty($country)) {
                $country = $placeholder;
            }
            $selected = strtolower($code) == $selected_country ? "selected='selected'" : '';
            $str .= "<option value='" . esc_attr($code) . "' $selected>" . esc_html($country) . '</option>';
        }

        return $str;
    }

    public function get_countries() {
        return apply_filters(
                'gform_countries', array(
            esc_html__('Afghanistan', 'gravityforms'), esc_html__('Albania', 'gravityforms'), esc_html__('Algeria', 'gravityforms'), esc_html__('American Samoa', 'gravityforms'), esc_html__('Andorra', 'gravityforms'), esc_html__('Angola', 'gravityforms'), esc_html__('Antigua and Barbuda', 'gravityforms'), esc_html__('Argentina', 'gravityforms'), esc_html__('Armenia', 'gravityforms'), esc_html__('Australia', 'gravityforms'), esc_html__('Austria', 'gravityforms'), esc_html__('Azerbaijan', 'gravityforms'), esc_html__('Bahamas', 'gravityforms'), esc_html__('Bahrain', 'gravityforms'), esc_html__('Bangladesh', 'gravityforms'), esc_html__('Barbados', 'gravityforms'), esc_html__('Belarus', 'gravityforms'), esc_html__('Belgium', 'gravityforms'), esc_html__('Belize', 'gravityforms'), esc_html__('Benin', 'gravityforms'), esc_html__('Bermuda', 'gravityforms'), esc_html__('Bhutan', 'gravityforms'), esc_html__('Bolivia', 'gravityforms'), esc_html__('Bosnia and Herzegovina', 'gravityforms'), esc_html__('Botswana', 'gravityforms'), esc_html__('Brazil', 'gravityforms'), esc_html__('Brunei', 'gravityforms'), esc_html__('Bulgaria', 'gravityforms'), esc_html__('Burkina Faso', 'gravityforms'), esc_html__('Burundi', 'gravityforms'), esc_html__('Cambodia', 'gravityforms'), esc_html__('Cameroon', 'gravityforms'), esc_html__('Canada', 'gravityforms'), esc_html__('Cape Verde', 'gravityforms'), esc_html__('Cayman Islands', 'gravityforms'), esc_html__('Central African Republic', 'gravityforms'), esc_html__('Chad', 'gravityforms'), esc_html__('Chile', 'gravityforms'), esc_html__('China', 'gravityforms'), esc_html__('Colombia', 'gravityforms'), esc_html__('Comoros', 'gravityforms'), esc_html__('Congo, Democratic Republic of the', 'gravityforms'), esc_html__('Congo, Republic of the', 'gravityforms'), esc_html__('Costa Rica', 'gravityforms'), esc_html__("Côte d'Ivoire", 'gravityforms'), esc_html__('Croatia', 'gravityforms'), esc_html__('Cuba', 'gravityforms'), esc_html__('Curaçao', 'gravityforms'), esc_html__('Cyprus', 'gravityforms'), esc_html__('Czech Republic', 'gravityforms'), esc_html__('Denmark', 'gravityforms'), esc_html__('Djibouti', 'gravityforms'), esc_html__('Dominica', 'gravityforms'), esc_html__('Dominican Republic', 'gravityforms'), esc_html__('East Timor', 'gravityforms'), esc_html__('Ecuador', 'gravityforms'), esc_html__('Egypt', 'gravityforms'), esc_html__('El Salvador', 'gravityforms'), esc_html__('Equatorial Guinea', 'gravityforms'), esc_html__('Eritrea', 'gravityforms'), esc_html__('Estonia', 'gravityforms'), esc_html__('Ethiopia', 'gravityforms'), esc_html__('Faroe Islands', 'gravityforms'), esc_html__('Fiji', 'gravityforms'), esc_html__('Finland', 'gravityforms'), esc_html__('France', 'gravityforms'), esc_html__('Gabon', 'gravityforms'),
            esc_html__('Gambia', 'gravityforms'), _x('Georgia', 'Country', 'gravityforms'), esc_html__('Germany', 'gravityforms'), esc_html__('Ghana', 'gravityforms'), esc_html__('Greece', 'gravityforms'), esc_html__('Greenland', 'gravityforms'), esc_html__('Grenada', 'gravityforms'), esc_html__('Guam', 'gravityforms'), esc_html__('Guatemala', 'gravityforms'), esc_html__('Guinea', 'gravityforms'), esc_html__('Guinea-Bissau', 'gravityforms'), esc_html__('Guyana', 'gravityforms'), esc_html__('Haiti', 'gravityforms'), esc_html__('Honduras', 'gravityforms'), esc_html__('Hong Kong', 'gravityforms'), esc_html__('Hungary', 'gravityforms'), esc_html__('Iceland', 'gravityforms'), esc_html__('India', 'gravityforms'), esc_html__('Indonesia', 'gravityforms'), esc_html__('Iran', 'gravityforms'), esc_html__('Iraq', 'gravityforms'), esc_html__('Ireland', 'gravityforms'), esc_html__('Israel', 'gravityforms'), esc_html__('Italy', 'gravityforms'), esc_html__('Jamaica', 'gravityforms'), esc_html__('Japan', 'gravityforms'), esc_html__('Jordan', 'gravityforms'), esc_html__('Kazakhstan', 'gravityforms'), esc_html__('Kenya', 'gravityforms'), esc_html__('Kiribati', 'gravityforms'), esc_html__('North Korea', 'gravityforms'), esc_html__('South Korea', 'gravityforms'), esc_html__('Kosovo', 'gravityforms'), esc_html__('Kuwait', 'gravityforms'), esc_html__('Kyrgyzstan', 'gravityforms'), esc_html__('Laos', 'gravityforms'), esc_html__('Latvia', 'gravityforms'), esc_html__('Lebanon', 'gravityforms'), esc_html__('Lesotho', 'gravityforms'), esc_html__('Liberia', 'gravityforms'), esc_html__('Libya', 'gravityforms'), esc_html__('Liechtenstein', 'gravityforms'), esc_html__('Lithuania', 'gravityforms'), esc_html__('Luxembourg', 'gravityforms'), esc_html__('Macedonia', 'gravityforms'), esc_html__('Madagascar', 'gravityforms'), esc_html__('Malawi', 'gravityforms'), esc_html__('Malaysia', 'gravityforms'), esc_html__('Maldives', 'gravityforms'), esc_html__('Mali', 'gravityforms'), esc_html__('Malta', 'gravityforms'), esc_html__('Marshall Islands', 'gravityforms'), esc_html__('Mauritania', 'gravityforms'), esc_html__('Mauritius', 'gravityforms'), esc_html__('Mexico', 'gravityforms'), esc_html__('Micronesia', 'gravityforms'), esc_html__('Moldova', 'gravityforms'), esc_html__('Monaco', 'gravityforms'), esc_html__('Mongolia', 'gravityforms'), esc_html__('Montenegro', 'gravityforms'), esc_html__('Morocco', 'gravityforms'), esc_html__('Mozambique', 'gravityforms'), esc_html__('Myanmar', 'gravityforms'), esc_html__('Namibia', 'gravityforms'), esc_html__('Nauru', 'gravityforms'), esc_html__('Nepal', 'gravityforms'), esc_html__('Netherlands', 'gravityforms'), esc_html__('New Zealand', 'gravityforms'),
            esc_html__('Nicaragua', 'gravityforms'), esc_html__('Niger', 'gravityforms'), esc_html__('Nigeria', 'gravityforms'), esc_html__('Northern Mariana Islands', 'gravityforms'), esc_html__('Norway', 'gravityforms'), esc_html__('Oman', 'gravityforms'), esc_html__('Pakistan', 'gravityforms'), esc_html__('Palau', 'gravityforms'), esc_html__('Palestine, State of', 'gravityforms'), esc_html__('Panama', 'gravityforms'), esc_html__('Papua New Guinea', 'gravityforms'), esc_html__('Paraguay', 'gravityforms'), esc_html__('Peru', 'gravityforms'), esc_html__('Philippines', 'gravityforms'), esc_html__('Poland', 'gravityforms'), esc_html__('Portugal', 'gravityforms'), esc_html__('Puerto Rico', 'gravityforms'), esc_html__('Qatar', 'gravityforms'), esc_html__('Romania', 'gravityforms'), esc_html__('Russia', 'gravityforms'), esc_html__('Rwanda', 'gravityforms'), esc_html__('Saint Kitts and Nevis', 'gravityforms'), esc_html__('Saint Lucia', 'gravityforms'), esc_html__('Saint Vincent and the Grenadines', 'gravityforms'), esc_html__('Samoa', 'gravityforms'), esc_html__('San Marino', 'gravityforms'), esc_html__('Sao Tome and Principe', 'gravityforms'), esc_html__('Saudi Arabia', 'gravityforms'), esc_html__('Senegal', 'gravityforms'), esc_html__('Serbia', 'gravityforms'), esc_html__('Seychelles', 'gravityforms'), esc_html__('Sierra Leone', 'gravityforms'), esc_html__('Singapore', 'gravityforms'), esc_html__('Sint Maarten', 'gravityforms'), esc_html__('Slovakia', 'gravityforms'), esc_html__('Slovenia', 'gravityforms'), esc_html__('Solomon Islands', 'gravityforms'), esc_html__('Somalia', 'gravityforms'), esc_html__('South Africa', 'gravityforms'), esc_html__('Spain', 'gravityforms'), esc_html__('Sri Lanka', 'gravityforms'), esc_html__('Sudan', 'gravityforms'), esc_html__('Sudan, South', 'gravityforms'), esc_html__('Suriname', 'gravityforms'), esc_html__('Swaziland', 'gravityforms'), esc_html__('Sweden', 'gravityforms'), esc_html__('Switzerland', 'gravityforms'), esc_html__('Syria', 'gravityforms'), esc_html__('Taiwan', 'gravityforms'), esc_html__('Tajikistan', 'gravityforms'), esc_html__('Tanzania', 'gravityforms'), esc_html__('Thailand', 'gravityforms'), esc_html__('Togo', 'gravityforms'), esc_html__('Tonga', 'gravityforms'), esc_html__('Trinidad and Tobago', 'gravityforms'), esc_html__('Tunisia', 'gravityforms'), esc_html__('Turkey', 'gravityforms'), esc_html__('Turkmenistan', 'gravityforms'), esc_html__('Tuvalu', 'gravityforms'), esc_html__('Uganda', 'gravityforms'), esc_html__('Ukraine', 'gravityforms'), esc_html__('United Arab Emirates', 'gravityforms'), esc_html__('United Kingdom', 'gravityforms'),
            esc_html__('United States', 'gravityforms'), esc_html__('Uruguay', 'gravityforms'), esc_html__('Uzbekistan', 'gravityforms'), esc_html__('Vanuatu', 'gravityforms'), esc_html__('Vatican City', 'gravityforms'), esc_html__('Venezuela', 'gravityforms'), esc_html__('Vietnam', 'gravityforms'), esc_html__('Virgin Islands, British', 'gravityforms'), esc_html__('Virgin Islands, U.S.', 'gravityforms'), esc_html__('Yemen', 'gravityforms'), esc_html__('Zambia', 'gravityforms'), esc_html__('Zimbabwe', 'gravityforms'),
                )
        );
    }

    public function get_country_code($country_name) {
        $codes = $this->get_country_codes();

        return rgar($codes, GFCommon::safe_strtoupper($country_name));
    }

    public function get_country_name($country_code) {
        $codes = $this->get_country_codes();
        foreach ($codes as $name => $codes) {
            if ($codes == $country_code) {
                return ucfirst(strtolower($name));
            }
        }
        return $country_code;
    }

    public function get_country_codes() {
        $codes = array(
            esc_html__('AFGHANISTAN', 'gravityforms') => 'AF',
            esc_html__('ALBANIA', 'gravityforms') => 'AL',
            esc_html__('ALGERIA', 'gravityforms') => 'DZ',
            esc_html__('AMERICAN SAMOA', 'gravityforms') => 'AS',
            esc_html__('ANDORRA', 'gravityforms') => 'AD',
            esc_html__('ANGOLA', 'gravityforms') => 'AO',
            esc_html__('ANTIGUA AND BARBUDA', 'gravityforms') => 'AG',
            esc_html__('ARGENTINA', 'gravityforms') => 'AR',
            esc_html__('ARMENIA', 'gravityforms') => 'AM',
            esc_html__('AUSTRALIA', 'gravityforms') => 'AU',
            esc_html__('AUSTRIA', 'gravityforms') => 'AT',
            esc_html__('AZERBAIJAN', 'gravityforms') => 'AZ',
            esc_html__('BAHAMAS', 'gravityforms') => 'BS',
            esc_html__('BAHRAIN', 'gravityforms') => 'BH',
            esc_html__('BANGLADESH', 'gravityforms') => 'BD',
            esc_html__('BARBADOS', 'gravityforms') => 'BB',
            esc_html__('BELARUS', 'gravityforms') => 'BY',
            esc_html__('BELGIUM', 'gravityforms') => 'BE',
            esc_html__('BELIZE', 'gravityforms') => 'BZ',
            esc_html__('BENIN', 'gravityforms') => 'BJ',
            esc_html__('BERMUDA', 'gravityforms') => 'BM',
            esc_html__('BHUTAN', 'gravityforms') => 'BT',
            esc_html__('BOLIVIA', 'gravityforms') => 'BO',
            esc_html__('BOSNIA AND HERZEGOVINA', 'gravityforms') => 'BA',
            esc_html__('BOTSWANA', 'gravityforms') => 'BW',
            esc_html__('BRAZIL', 'gravityforms') => 'BR',
            esc_html__('BRUNEI', 'gravityforms') => 'BN',
            esc_html__('BULGARIA', 'gravityforms') => 'BG',
            esc_html__('BURKINA FASO', 'gravityforms') => 'BF',
            esc_html__('BURUNDI', 'gravityforms') => 'BI',
            esc_html__('CAMBODIA', 'gravityforms') => 'KH',
            esc_html__('CAMEROON', 'gravityforms') => 'CM',
            esc_html__('CANADA', 'gravityforms') => 'CA',
            esc_html__('CAPE VERDE', 'gravityforms') => 'CV',
            esc_html__('CAYMAN ISLANDS', 'gravityforms') => 'KY',
            esc_html__('CENTRAL AFRICAN REPUBLIC', 'gravityforms') => 'CF',
            esc_html__('CHAD', 'gravityforms') => 'TD',
            esc_html__('CHILE', 'gravityforms') => 'CL',
            esc_html__('CHINA', 'gravityforms') => 'CN',
            esc_html__('COLOMBIA', 'gravityforms') => 'CO',
            esc_html__('COMOROS', 'gravityforms') => 'KM',
            esc_html__('CONGO, DEMOCRATIC REPUBLIC OF THE', 'gravityforms') => 'CD',
            esc_html__('CONGO, REPUBLIC OF THE', 'gravityforms') => 'CG',
            esc_html__('COSTA RICA', 'gravityforms') => 'CR',
            esc_html__("CÔTE D'IVOIRE", 'gravityforms') => 'CI',
            esc_html__('CROATIA', 'gravityforms') => 'HR',
            esc_html__('CUBA', 'gravityforms') => 'CU',
            esc_html__('CURAÇAO', 'gravityforms') => 'CW',
            esc_html__('CYPRUS', 'gravityforms') => 'CY',
            esc_html__('CZECH REPUBLIC', 'gravityforms') => 'CZ',
            esc_html__('DENMARK', 'gravityforms') => 'DK',
            esc_html__('DJIBOUTI', 'gravityforms') => 'DJ',
            esc_html__('DOMINICA', 'gravityforms') => 'DM',
            esc_html__('DOMINICAN REPUBLIC', 'gravityforms') => 'DO',
            esc_html__('EAST TIMOR', 'gravityforms') => 'TL',
            esc_html__('ECUADOR', 'gravityforms') => 'EC',
            esc_html__('EGYPT', 'gravityforms') => 'EG',
            esc_html__('EL SALVADOR', 'gravityforms') => 'SV',
            esc_html__('EQUATORIAL GUINEA', 'gravityforms') => 'GQ',
            esc_html__('ERITREA', 'gravityforms') => 'ER',
            esc_html__('ESTONIA', 'gravityforms') => 'EE',
            esc_html__('ETHIOPIA', 'gravityforms') => 'ET',
            esc_html__('FAROE ISLANDS', 'gravityforms') => 'FO',
            esc_html__('FIJI', 'gravityforms') => 'FJ',
            esc_html__('FINLAND', 'gravityforms') => 'FI',
            esc_html__('FRANCE', 'gravityforms') => 'FR',
            esc_html__('GABON', 'gravityforms') => 'GA',
            esc_html__('GAMBIA', 'gravityforms') => 'GM',
            esc_html(_x('GEORGIA', 'Country', 'gravityforms')) => 'GE',
            esc_html__('GERMANY', 'gravityforms') => 'DE',
            esc_html__('GHANA', 'gravityforms') => 'GH',
            esc_html__('GREECE', 'gravityforms') => 'GR',
            esc_html__('GREENLAND', 'gravityforms') => 'GL',
            esc_html__('GRENADA', 'gravityforms') => 'GD',
            esc_html__('GUAM', 'gravityforms') => 'GU',
            esc_html__('GUATEMALA', 'gravityforms') => 'GT',
            esc_html__('GUINEA', 'gravityforms') => 'GN',
            esc_html__('GUINEA-BISSAU', 'gravityforms') => 'GW',
            esc_html__('GUYANA', 'gravityforms') => 'GY',
            esc_html__('HAITI', 'gravityforms') => 'HT',
            esc_html__('HONDURAS', 'gravityforms') => 'HN',
            esc_html__('HONG KONG', 'gravityforms') => 'HK',
            esc_html__('HUNGARY', 'gravityforms') => 'HU',
            esc_html__('ICELAND', 'gravityforms') => 'IS',
            esc_html__('INDIA', 'gravityforms') => 'IN',
            esc_html__('INDONESIA', 'gravityforms') => 'ID',
            esc_html__('IRAN', 'gravityforms') => 'IR',
            esc_html__('IRAQ', 'gravityforms') => 'IQ',
            esc_html__('IRELAND', 'gravityforms') => 'IE',
            esc_html__('ISRAEL', 'gravityforms') => 'IL',
            esc_html__('ITALY', 'gravityforms') => 'IT',
            esc_html__('JAMAICA', 'gravityforms') => 'JM',
            esc_html__('JAPAN', 'gravityforms') => 'JP',
            esc_html__('JORDAN', 'gravityforms') => 'JO',
            esc_html__('KAZAKHSTAN', 'gravityforms') => 'KZ',
            esc_html__('KENYA', 'gravityforms') => 'KE',
            esc_html__('KIRIBATI', 'gravityforms') => 'KI',
            esc_html__('NORTH KOREA', 'gravityforms') => 'KP',
            esc_html__('SOUTH KOREA', 'gravityforms') => 'KR',
            esc_html__('KOSOVO', 'gravityforms') => 'KV',
            esc_html__('KUWAIT', 'gravityforms') => 'KW',
            esc_html__('KYRGYZSTAN', 'gravityforms') => 'KG',
            esc_html__('LAOS', 'gravityforms') => 'LA',
            esc_html__('LATVIA', 'gravityforms') => 'LV',
            esc_html__('LEBANON', 'gravityforms') => 'LB',
            esc_html__('LESOTHO', 'gravityforms') => 'LS',
            esc_html__('LIBERIA', 'gravityforms') => 'LR',
            esc_html__('LIBYA', 'gravityforms') => 'LY',
            esc_html__('LIECHTENSTEIN', 'gravityforms') => 'LI',
            esc_html__('LITHUANIA', 'gravityforms') => 'LT',
            esc_html__('LUXEMBOURG', 'gravityforms') => 'LU',
            esc_html__('MACEDONIA', 'gravityforms') => 'MK',
            esc_html__('MADAGASCAR', 'gravityforms') => 'MG',
            esc_html__('MALAWI', 'gravityforms') => 'MW',
            esc_html__('MALAYSIA', 'gravityforms') => 'MY',
            esc_html__('MALDIVES', 'gravityforms') => 'MV',
            esc_html__('MALI', 'gravityforms') => 'ML',
            esc_html__('MALTA', 'gravityforms') => 'MT',
            esc_html__('MARSHALL ISLANDS', 'gravityforms') => 'MH',
            esc_html__('MAURITANIA', 'gravityforms') => 'MR',
            esc_html__('MAURITIUS', 'gravityforms') => 'MU',
            esc_html__('MEXICO', 'gravityforms') => 'MX',
            esc_html__('MICRONESIA', 'gravityforms') => 'FM',
            esc_html__('MOLDOVA', 'gravityforms') => 'MD',
            esc_html__('MONACO', 'gravityforms') => 'MC',
            esc_html__('MONGOLIA', 'gravityforms') => 'MN',
            esc_html__('MONTENEGRO', 'gravityforms') => 'ME',
            esc_html__('MOROCCO', 'gravityforms') => 'MA',
            esc_html__('MOZAMBIQUE', 'gravityforms') => 'MZ',
            esc_html__('MYANMAR', 'gravityforms') => 'MM',
            esc_html__('NAMIBIA', 'gravityforms') => 'NA',
            esc_html__('NAURU', 'gravityforms') => 'NR',
            esc_html__('NEPAL', 'gravityforms') => 'NP',
            esc_html__('NETHERLANDS', 'gravityforms') => 'NL',
            esc_html__('NEW ZEALAND', 'gravityforms') => 'NZ',
            esc_html__('NICARAGUA', 'gravityforms') => 'NI',
            esc_html__('NIGER', 'gravityforms') => 'NE',
            esc_html__('NIGERIA', 'gravityforms') => 'NG',
            esc_html__('NORTHERN MARIANA ISLANDS', 'gravityforms') => 'MP',
            esc_html__('NORWAY', 'gravityforms') => 'NO',
            esc_html__('OMAN', 'gravityforms') => 'OM',
            esc_html__('PAKISTAN', 'gravityforms') => 'PK',
            esc_html__('PALAU', 'gravityforms') => 'PW',
            esc_html__('PALESTINE, STATE OF', 'gravityforms') => 'PS',
            esc_html__('PANAMA', 'gravityforms') => 'PA',
            esc_html__('PAPUA NEW GUINEA', 'gravityforms') => 'PG',
            esc_html__('PARAGUAY', 'gravityforms') => 'PY',
            esc_html__('PERU', 'gravityforms') => 'PE',
            esc_html__('PHILIPPINES', 'gravityforms') => 'PH',
            esc_html__('POLAND', 'gravityforms') => 'PL',
            esc_html__('PORTUGAL', 'gravityforms') => 'PT',
            esc_html__('PUERTO RICO', 'gravityforms') => 'PR',
            esc_html__('QATAR', 'gravityforms') => 'QA',
            esc_html__('ROMANIA', 'gravityforms') => 'RO',
            esc_html__('RUSSIA', 'gravityforms') => 'RU',
            esc_html__('RWANDA', 'gravityforms') => 'RW',
            esc_html__('SAINT KITTS AND NEVIS', 'gravityforms') => 'KN',
            esc_html__('SAINT LUCIA', 'gravityforms') => 'LC',
            esc_html__('SAINT VINCENT AND THE GRENADINES', 'gravityforms') => 'VC',
            esc_html__('SAMOA', 'gravityforms') => 'WS',
            esc_html__('SAN MARINO', 'gravityforms') => 'SM',
            esc_html__('SAO TOME AND PRINCIPE', 'gravityforms') => 'ST',
            esc_html__('SAUDI ARABIA', 'gravityforms') => 'SA',
            esc_html__('SENEGAL', 'gravityforms') => 'SN',
            esc_html__('SERBIA', 'gravityforms') => 'RS',
            esc_html__('SEYCHELLES', 'gravityforms') => 'SC',
            esc_html__('SIERRA LEONE', 'gravityforms') => 'SL',
            esc_html__('SINGAPORE', 'gravityforms') => 'SG',
            esc_html__('SINT MAARTEN', 'gravityforms') => 'SX',
            esc_html__('SLOVAKIA', 'gravityforms') => 'SK',
            esc_html__('SLOVENIA', 'gravityforms') => 'SI',
            esc_html__('SOLOMON ISLANDS', 'gravityforms') => 'SB',
            esc_html__('SOMALIA', 'gravityforms') => 'SO',
            esc_html__('SOUTH AFRICA', 'gravityforms') => 'ZA',
            esc_html__('SPAIN', 'gravityforms') => 'ES',
            esc_html__('SRI LANKA', 'gravityforms') => 'LK',
            esc_html__('SUDAN', 'gravityforms') => 'SD',
            esc_html__('SUDAN, SOUTH', 'gravityforms') => 'SS',
            esc_html__('SURINAME', 'gravityforms') => 'SR',
            esc_html__('SWAZILAND', 'gravityforms') => 'SZ',
            esc_html__('SWEDEN', 'gravityforms') => 'SE',
            esc_html__('SWITZERLAND', 'gravityforms') => 'CH',
            esc_html__('SYRIA', 'gravityforms') => 'SY',
            esc_html__('TAIWAN', 'gravityforms') => 'TW',
            esc_html__('TAJIKISTAN', 'gravityforms') => 'TJ',
            esc_html__('TANZANIA', 'gravityforms') => 'TZ',
            esc_html__('THAILAND', 'gravityforms') => 'TH',
            esc_html__('TOGO', 'gravityforms') => 'TG',
            esc_html__('TONGA', 'gravityforms') => 'TO',
            esc_html__('TRINIDAD AND TOBAGO', 'gravityforms') => 'TT',
            esc_html__('TUNISIA', 'gravityforms') => 'TN',
            esc_html__('TURKEY', 'gravityforms') => 'TR',
            esc_html__('TURKMENISTAN', 'gravityforms') => 'TM',
            esc_html__('TUVALU', 'gravityforms') => 'TV',
            esc_html__('UGANDA', 'gravityforms') => 'UG',
            esc_html__('UKRAINE', 'gravityforms') => 'UA',
            esc_html__('UNITED ARAB EMIRATES', 'gravityforms') => 'AE',
            esc_html__('UNITED KINGDOM', 'gravityforms') => 'GB',
            esc_html__('UNITED STATES', 'gravityforms') => 'US',
            esc_html__('URUGUAY', 'gravityforms') => 'UY',
            esc_html__('UZBEKISTAN', 'gravityforms') => 'UZ',
            esc_html__('VANUATU', 'gravityforms') => 'VU',
            esc_html__('VATICAN CITY', 'gravityforms') => 'VA',
            esc_html__('VENEZUELA', 'gravityforms') => 'VE',
            esc_html__('VIRGIN ISLANDS, BRITISH', 'gravityforms') => 'VG',
            esc_html__('VIRGIN ISLANDS, U.S.', 'gravityforms') => 'VI',
            esc_html__('VIETNAM', 'gravityforms') => 'VN',
            esc_html__('YEMEN', 'gravityforms') => 'YE',
            esc_html__('ZAMBIA', 'gravityforms') => 'ZM',
            esc_html__('ZIMBABWE', 'gravityforms') => 'ZW',
        );

        return $codes;
    }

    /**
     * Helper for retrieving the markup for the choices.
     *
     * @since  Unknown
     * @access public
     *
     * @uses GFCommon::get_select_choices()
     *
     * @param string|array $value The field value. From default/dynamic population, $_POST, or a resumed incomplete submission.
     *
     * @return string Returns the choices available within the multi-select field.
     */
    public function get_choices($value) {

        if (isset($this->field_multiple) && $this->field_multiple) {
            $value = $this->to_array($value);

            return GFCommon::get_select_choices($this, $value, false);
        } else {
            return $value;
        }
    }

    /**
     * Format the entry value for display on the entries list page.
     *
     * @since  Unknown
     * @access public
     *
     * @param string|array $value    The field value.
     * @param array        $entry    The Entry Object currently being processed.
     * @param string       $field_id The field or input ID currently being processed.
     * @param array        $columns  The properties for the columns being displayed on the entry list page.
     * @param array        $form     The Form Object currently being processed.
     *
     * @return string $value The value of the field. Escaped.
     */
    public function get_value_entry_list($value, $entry, $field_id, $columns, $form) {
        if (isset($this->field_multiple) && $this->field_multiple) {
            // Add space after comma-delimited values.
            $value = implode(', ', $this->to_array($value));
            return esc_html($value);
        } else {
            return parent::get_value_entry_list($value, $entry, $field_id, $columns, $form);
        }
    }

    /**
     * Format the value before it is saved to the Entry Object.
     *
     * @since  Unknown
     * @access public
     *
     * @uses GF_Field_MultiSelect::sanitize_entry_value()
     *
     * @param array|string $value      The value to be saved.
     * @param array        $form       The Form Object currently being processed.
     * @param string       $input_name The input name used when accessing the $_POST.
     * @param int          $lead_id    The ID of the Entry currently being processed.
     * @param array        $lead       The Entry Object currently being processed.
     *
     * @return string $value The field value. Comma separated if an array.
     */
    public function get_value_save_entry($value, $form, $input_name, $lead_id, $lead) {
        if (isset($this->field_multiple) && $this->field_multiple) {
            if (is_array($value)) {
                foreach ($value as &$v) {
                    $v = $this->sanitize_entry_value($v, $form['id']);
                }
            } else {
                $value = $this->sanitize_entry_value($value, $form['id']);
            }

            return empty($value) ? '' : $this->to_string($value);
        } else {
            return parent::get_value_save_entry($value, $form, $input_name, $lead_id, $lead);
        }
    }

    /**
     * Format the entry value for when the field/input merge tag is processed.
     *
     * @since  Unknown
     * @access public
     *
     * @uses GFCommon::format_post_category()
     * @uses GFCommon::format_variable_value()
     * @uses GFCommon::selection_display()
     * @uses GFCommon::implode_non_blank()
     *
     * @param string|array $value      The field value. Depending on the location the merge tag is being used the following functions may have already been applied to the value: esc_html, nl2br, and urlencode.
     * @param string       $input_id   The field or input ID from the merge tag currently being processed.
     * @param array        $entry      The Entry Object currently being processed.
     * @param array        $form       The Form Object currently being processed.
     * @param string       $modifier   The merge tag modifier. e.g. value
     * @param string|array $raw_value  The raw field value from before any formatting was applied to $value.
     * @param bool         $url_encode Indicates if the urlencode function may have been applied to the $value.
     * @param bool         $esc_html   Indicates if the esc_html function may have been applied to the $value.
     * @param string       $format     The format requested for the location the merge is being used. Possible values: html, text or url.
     * @param bool         $nl2br      Indicates if the nl2br function may have been applied to the $value.
     *
     * @return string $return The merge tag value.
     */
    public function get_value_merge_tag($value, $input_id, $entry, $form, $modifier, $raw_value, $url_encode, $esc_html, $format, $nl2br) {

        if (isset($this->field_multiple) && $this->field_multiple) {
            // TODO has parent::example();
            $items = $this->to_array($raw_value);

            if ($this->type == 'post_category') {
                $use_id = $modifier == 'id';

                if (is_array($items)) {
                    foreach ($items as &$item) {
                        $cat = GFCommon::format_post_category($item, $use_id);
                        $item = GFCommon::format_variable_value($cat, $url_encode, $esc_html, $format);
                    }
                }
            } elseif ($modifier != 'value') {

                foreach ($items as &$item) {
                    $item = GFCommon::selection_display($item, $this, rgar($entry, 'currency'), true);
                    $item = GFCommon::format_variable_value($item, $url_encode, $esc_html, $format);
                }
            }

            $return = GFCommon::implode_non_blank(', ', $items);

            if ($format == 'html' || $esc_html) {
                $return = esc_html($return);
            }

            return $return;
        } else {
            return parent::get_value_merge_tag($value, $input_id, $entry, $form, $modifier, $raw_value, $url_encode, $esc_html, $format, $nl2br);
        }
    }

    /**
     * Converts an array to a string.
     *
     * @since 2.2.3.7 Changed access to public.
     * @since 2.2
     * @access public
     *
     * @uses \GF_Field_MultiSelect::$storageType
     *
     * @param array $value The array to convert to a string.
     *
     * @return string The converted string.
     */
    public function to_string($value) {
        if ($this->storageType === 'json') {
            return json_encode($value);
        } else {
            return is_array($value) ? implode(',', $value) : $value;
        }
    }

    /**
     * Converts a string to an array.
     *
     * @since 2.2.3.7 Changed access to public.
     * @since 2.2
     * @access public
     *
     * @uses \GF_Field_MultiSelect::$storageType
     *
     * @param string $value A comma-separated or JSON string to convert.
     *
     * @return array The converted array.
     */
    public function to_array($value) {
        if (empty($value)) {
            return array();
        } elseif (is_array($value)) {
            return $value;
        } elseif ($this->storageType !== 'json' || $value[0] !== '[') {
            return array_map('trim', explode(',', $value));
        } else {
            $json = json_decode($value, true);

            return $json == null ? array() : $json;
        }
    }

    /**
     * Forces settings into expected values while saving the form object.
     *
     * No escaping should be done at this stage to prevent double escaping on output.
     *
     * Currently called only for forms created after version 1.9.6.10.
     *
     * @since  Unknown
     * @access public
     *
     * @return void
     *
     */
    public function sanitize_settings() {
        parent::sanitize_settings();
        $this->enableEnhancedUI = (bool) $this->enableEnhancedUI;

        $this->storageType = empty($this->storageType) || $this->storageType === 'json' ? $this->storageType : 'json';

        if ($this->type === 'post_category') {
            $this->displayAllCategories = (bool) $this->displayAllCategories;
        }
    }

}

GF_Fields::register(new GF_Field_Autocomplete());
