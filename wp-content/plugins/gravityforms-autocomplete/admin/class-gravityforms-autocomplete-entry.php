<?php
if (!class_exists('Gravityforms_Autocomplete_Entry')) {

    /**
    * @author Mikhail
    */
    class Gravityforms_Autocomplete_Entry {
        private $plugin_name;
        private $version;
    

        public function __construct($plugin_name, $version) {

            $this->plugin_name = $plugin_name;
            $this->version = $version;
        }
        
        public function gform_field_content($content, $field, $value, $lead_id, $form_id ){
  
          if ( GFCommon::is_entry_detail_edit() ) {
              if ( $field->type == 'autocomplete' ) {
              
                $label = esc_html( GFCommon::get_label( $field ) );
                $value = esc_attr( $value );
               
                $id = esc_attr( $field->id );
                $name  = 'input_' . $id;
 
                return             
                "<tr valign='top'><td class='detail-view' id='field_{$form_id}_{$id}'><label class='detail-label'>{$label}</label><div class='ginput_container ginput_container_text'><input type='text' name='{$name}' value='{$value}'>
                </div></td></tr>";
              }
          } 
            
            return $content;  
        }
        
   
    }

}