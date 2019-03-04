<?php
if (!class_exists('Gravityforms_Autocomplete_Public')) {

    class Gravityforms_Autocomplete_Public {

        private $plugin_name;
        private $version;

        public function __construct($plugin_name, $version) {

            $this->plugin_name = $plugin_name;
            $this->version = $version;
        }

        public function enqueue_styles() {
          //  wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/gravityforms-autocomplete-public.css', array(), $this->version, 'all');
          wp_enqueue_style('gf_autocomplete_select2',"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css");
        }

        public function enqueue_scripts() {
          //  wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/gravityforms-autocomplete-public.js', array('jquery'), $this->version, false);
          wp_enqueue_script('gf_autocomplete_select2', "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js", array('jquery'));
        }

        public function gform_after_submission($entry, $form) {
    
            foreach ($form['fields'] as $key => $field) {
                if (($field->type == "autocomplete" || $field->type == "autocomplete2") && $field->field_from == "manual" && $field->field_manual_add && isset($entry[$field->id]) && !empty($entry[$field->id])) {

                    $values = preg_split('/\r\n|[\r\n]/', $field->field_manual);
                    if (!in_array($entry[$field->id], $values, true)) {
                        $values[] = $entry[$field->id];

                        $form['fields'][$key]->field_manual = implode(PHP_EOL, $values);

                        GFAPI::update_form($form);
                    }
                }
            }
        }
        
        public function get_choices_ajax(){
 
            $choices = array();
   
            if (isset($_GET['query']) && isset($_GET['type'])){
                
                $search_term = strtolower($_GET['query']);
                $search_term = $this->normalizeStr($search_term);
                
                if ($_GET['type'] === 'json'){
                    $choices = $this->autocomplete_json($search_term, $_GET['url']);    
                }
                else if ($_GET['type'] === 'user')  $choices = $this->autocomplete_users($search_term); 
                else {
                     $post_types = get_post_types();
                
                     if (in_array($_GET['type'], $post_types)) $choices = $this->autocomplete_post_types($_GET['type'], $search_term);
                     else {
                        $taxonomies = get_taxonomies();
                        if (in_array($_GET['type'], $taxonomies)) $choices = $this->autocomplete_taxonomies($_GET['type'], $search_term);    
                     }    
                }
               
      
            }
            
            $choices = $this->normalizeAjaxResponse($choices);
            
            echo json_encode(array('results'=>$choices));
            die;
            
            
        }
        
        private function normalizeAjaxResponse($data){
            
            $result = array();
            $id = 0;
            
            foreach( $data as $value ){
                $result[] = array("id"=>$value, "text" => $value );    
            }   
            
            return $result; 
        }
        
        private function autocomplete_json($search_term, $url){
       
            $result = array();
            
            $json_data = $this->get_remote_data($url, http_build_query(array("search_term"=>$search_term)));
            $json_data = str_replace(array("\n","\r","\t","\0"), '', $json_data);
      
            $json_data = preg_replace("/^".pack('H*','EFBBBF')."/", '', $json_data);
       
            //try todo
            $choices = json_decode($json_data);
            
            foreach ($choices as $choice){
                if (strstr(strtolower($choice), $search_term)) 
                    $result[] = $choice;  
            }
            
            return $result;       
        }
        
        private function normalizeStr($str){
            $replace = array (
                "'"=> ' ', '-' => ' ', "\\'"=> ' ',
                'Ă'=>'A', 'À'=>'A', 'Ã'=>'A', 'Á'=>'A', 'Æ'=>'A', 'Â'=>'A', 'Å'=>'A', 'Ä'=>'Ae',
                'Þ'=>'B',
                'Ć'=>'C', 'ץ'=>'C', 
                'È'=>'E',  'É'=>'E', 'Ë'=>'E', 'Ê'=>'E',
                'Ğ'=>'G',
                'İ'=>'I', 'Ï'=>'I', 'Î'=>'I', 'Í'=>'I', 'Ì'=>'I',
                'Ł'=>'L',
                'Ñ'=>'N', 'Ń'=>'N',
                'Ø'=>'O', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'Oe',
                'Ş'=>'S', 'Ś'=>'S', 'Ș'=>'S', 'Š'=>'S',
                'Ț'=>'T',
                'Ù'=>'U', 'Û'=>'U', 'Ú'=>'U', 'Ü'=>'Ue',
                'Ý'=>'Y',
                'Ź'=>'Z', 'Ž'=>'Z', 'Ż'=>'Z',
                'â'=>'a', 'ǎ'=>'a', 'ą'=>'a', 'á'=>'a', 'ă'=>'a', 'ã'=>'a', 'Ǎ'=>'a', 'А'=>'a', 'å'=>'a', 'à'=>'a', 'א'=>'a', 'Ǻ'=>'a', 'Ā'=>'a', 'ǻ'=>'a', 'ā'=>'a', 'ä'=>'ae', 'æ'=>'ae', 'Ǽ'=>'ae', 'ǽ'=>'ae',
                'б'=>'b', 'ב'=>'b', 'þ'=>'b',
                'ĉ'=>'c', 'Ĉ'=>'c', 'Ċ'=>'c', 'ć'=>'c', 'צ'=>'c', 'ċ'=>'c', 'Ц'=>'c', 'Č'=>'c', 'č'=>'c', 'Ч'=>'ch',
                'ד'=>'d', 'ď'=>'d', 'Đ'=>'d', 'Ď'=>'d', 'đ'=>'d', 'ð'=>'d',
                'є'=>'e', 'ע'=>'e', 'Ə'=>'e', 'ę'=>'e', 'ĕ'=>'e', 'ē'=>'e', 'Ē'=>'e', 'Ė'=>'e', 'ė'=>'e', 'ě'=>'e', 'Ě'=>'e', 'Є'=>'e', 'Ĕ'=>'e', 'ê'=>'e', 'ə'=>'e', 'è'=>'e', 'é'=>'e',
                'ƒ'=>'f',
                'ġ'=>'g', 'Ģ'=>'g', 'Ġ'=>'g', 'Ĝ'=>'g', 'Г'=>'g', 'г'=>'g', 'ĝ'=>'g', 'ğ'=>'g', 'ג'=>'g', 'ґ'=>'g', 'ģ'=>'g',
                'ח'=>'h', 'ħ'=>'h', 'Ħ'=>'h', 'Ĥ'=>'h', 'ĥ'=>'h', 'ה'=>'h',
                'î'=>'i', 'ï'=>'i', 'í'=>'i', 'ì'=>'i', 'į'=>'i', 'ĭ'=>'i', 'ı'=>'i', 'Ĭ'=>'i', 'И'=>'i', 'ĩ'=>'i', 'ǐ'=>'i', 'Ĩ'=>'i', 'Ǐ'=>'i', 'Į'=>'i', 'י'=>'i', 'Ї'=>'i', 'Ī'=>'i', 'І'=>'i', 'ї'=>'i', 'і'=>'i', 'ī'=>'i', 'ĳ'=>'ij', 'Ĳ'=>'ij',
                'Ĵ'=>'j', 'ĵ'=>'j', 'я'=>'ja', 
                'כ'=>'k', 'ך'=>'k',
                'Ŀ'=>'l', 'ŀ'=>'l', 'Л'=>'l', 'ł'=>'l', 'ļ'=>'l', 'ĺ'=>'l', 'Ĺ'=>'l', 'Ļ'=>'l', 'Ľ'=>'l', 'ľ'=>'l', 'ל'=>'l',
                'מ'=>'m',  'ם'=>'m', 
                'ñ'=>'n', 'Ņ'=>'n', 'ן'=>'n', 'ŋ'=>'n', 'נ'=>'n', 'Н'=>'n', 'ń'=>'n', 'Ŋ'=>'n', 'ņ'=>'n', 'ŉ'=>'n', 'Ň'=>'n', 'ň'=>'n',
                'ő'=>'o', 'õ'=>'o', 'ô'=>'o', 'Ő'=>'o', 'ŏ'=>'o', 'Ŏ'=>'o', 'Ō'=>'o', 'ō'=>'o', 'ø'=>'o', 'ǿ'=>'o', 'ǒ'=>'o', 'ò'=>'o', 'Ǿ'=>'o', 'Ǒ'=>'o', 'ơ'=>'o', 'ó'=>'o', 'Ơ'=>'o', 'œ'=>'oe', 'Œ'=>'oe', 'ö'=>'oe',
                'פ'=>'p', 'ף'=>'p',
                'ק'=>'q',
                'ŕ'=>'r', 'ř'=>'r', 'Ř'=>'r', 'ŗ'=>'r', 'Ŗ'=>'r', 'ר'=>'r', 'Ŕ'=>'r', 
                'ș'=>'s', 'Ŝ'=>'s', 'š'=>'s', 'ś'=>'s', 'ס'=>'s', 'ş'=>'s', 'ŝ'=>'s', 'ß'=>'ss',
                'ט'=>'t', 'ŧ'=>'t', 'ת'=>'t', 'ť'=>'t', 'ţ'=>'t',  'ț'=>'t', 'Ŧ'=>'t', 'Ť'=>'t', '™'=>'tm',
                'ū'=>'u', 'у'=>'u', 'Ũ'=>'u', 'ũ'=>'u', 'Ư'=>'u', 'ư'=>'u', 'Ū'=>'u', 'Ǔ'=>'u', 'ų'=>'u', 'Ų'=>'u', 'ŭ'=>'u', 'Ŭ'=>'u', 'Ů'=>'u', 'ů'=>'u', 'ű'=>'u', 'Ű'=>'u', 'Ǖ'=>'u', 'ǔ'=>'u', 'Ǜ'=>'u', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'У'=>'u', 'ǚ'=>'u', 'ǜ'=>'u', 'Ǚ'=>'u', 'Ǘ'=>'u', 'ǖ'=>'u', 'ǘ'=>'u', 'ü'=>'ue',
                'ו'=>'v', 
                'ש'=>'w', 'ŵ'=>'w', 'Ŵ'=>'w',
                'ŷ'=>'y', 'ý'=>'y', 'ÿ'=>'y', 'Ÿ'=>'y', 'Ŷ'=>'y',
               'ž'=>'z', 'З'=>'z',  'ź'=>'z', 'ז'=>'z', 'ż'=>'z', 'ſ'=>'z' 
            );
    
            return strtr($str, $replace);
        }
        
        
        private function get_remote_data($url, $post_paramtrs = false) {
            $c = curl_init();
            curl_setopt( $c, CURLOPT_ENCODING, "UTF-8" );
            curl_setopt($c, CURLOPT_URL, $url);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            if ($post_paramtrs) {
                curl_setopt($c, CURLOPT_POST, TRUE);
                curl_setopt($c, CURLOPT_POSTFIELDS, "var1=bla&" . $post_paramtrs);
            } curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
            curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');
            curl_setopt($c, CURLOPT_MAXREDIRS, 10);
            $follow_allowed = ( ini_get('open_basedir') || ini_get('safe_mode')) ? false : true;
            if ($follow_allowed) {
                curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
            }curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
            curl_setopt($c, CURLOPT_REFERER, $url);
            curl_setopt($c, CURLOPT_TIMEOUT, 60);
            curl_setopt($c, CURLOPT_AUTOREFERER, true);
            curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
            $data = curl_exec($c);
            $status = curl_getinfo($c);
            curl_close($c);
            preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si', $status['url'], $link);
            $data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si', '$1=$2' . $link[0] . '$3$4$5', $data);
            $data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si', '$1=$2' . $link[1] . '://' . $link[3] . '$3$4$5', $data);
            if ($status['http_code'] == 200) {
                return $data;
            } elseif ($status['http_code'] == 301 || $status['http_code'] == 302) {
                if (!$follow_allowed) {
                    if (empty($redirURL)) {
                        if (!empty($status['redirect_url'])) {
                            $redirURL = $status['redirect_url'];
                        }
                    } if (empty($redirURL)) {
                        preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
                        if (!empty($m[2])) {
                            $redirURL = $m[2];
                        }
                    } if (empty($redirURL)) {
                        preg_match('/href\=\"(.*?)\"(.*?)here\<\/a\>/si', $data, $m);
                        if (!empty($m[1])) {
                            $redirURL = $m[1];
                        }
                    } if (!empty($redirURL)) {
                        $t = debug_backtrace();
                        return call_user_func($t[0]["function"], trim($redirURL), $post_paramtrs);
                    }
                }
            } return "ERRORCODE22 with $url!!<br/>Last status codes<b/>:" . json_encode($status) . "<br/><br/>Last data got<br/>:$data";
        }
        
        private function autocomplete_post_types($type, $search_term) {

            global $wpdb;
            $dataArray = array();

            $args = array(
                'posts_per_page' => 100,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_type' => $type,
                'post_status' => 'publish',
                'post_title1147' => $search_term,            
            );
                                       
            add_filter( 'posts_where', array($this,'post_title_filter'), 10, 2 );
            $query = new WP_Query;
            $data = $query->query($args);

            remove_filter( 'posts_where', array($this,'post_title_filter'), 10, 2 );
            
            foreach( $data as $my_post ){
                $dataArray[] = $my_post->post_title;
            }
        
          
            if (($type == 'product' || $type == 'product_variation') 
                && defined('GFAC_ALLOW_SKU_SEARCH') && GFAC_ALLOW_SKU_SEARCH == true ) 
            {
      
                $args['meta_key'] = '_sku';
                $args['meta_value'] = $search_term;
                $args['meta_compare'] = 'LIKE';
                unset( $args['post_title1147'] ) ;
                
                $query = new WP_Query;
                $data = $query->query($args);
                
                foreach( $data as $my_post ){
                    $dataArray[] = $my_post->post_title;
                }
                 
            }

            return $dataArray;
        }

        private function autocomplete_taxonomies($type, $search_term) {
         
            $dataArray = array();

            $args = array('taxonomy' => array($type), 'orderby' => 'count', 'hide_empty' => false, 'name__like'=>$search_term);

            $data = get_terms($args);

            foreach ($data as $item) {
                $dataArray[] = $item->name;
            }

            return $dataArray;
        }
        
        private function autocomplete_users($search_term) {

            $dataArray = array();

            $data = get_users(array( 'search' => '*' . $search_term . '*' ));
            foreach ($data as $item) {
                $dataArray[] = $item->display_name;
            }

            return $dataArray;
        }
        
        public function post_title_filter( $where, &$wp_query )
        {
            global $wpdb;
            if ( $search_term = $wp_query->get( 'post_title1147' ) ) {
                $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $search_term ) ) . '%\'';
            }
            return $where;
        }

    }

}
