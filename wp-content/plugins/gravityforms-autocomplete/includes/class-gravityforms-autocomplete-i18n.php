<?php

if (!class_exists('Gravityforms_Autocomplete_i18n')) {

    /**
     * Define the internationalization functionality
     *
     * Loads and defines the internationalization files for this plugin
     * so that it is ready for translation.
     */
    class Gravityforms_Autocomplete_i18n {

        private $domain;

        public function load_plugin_textdomain() {

            load_plugin_textdomain(
                    $this->domain, false, dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
            );
        }

        public function set_domain($domain) {
            $this->domain = $domain;
        }

    }

}