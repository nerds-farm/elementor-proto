<?php

namespace ElementorProto\Base;

use ElementorProto\Core\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (class_exists('\ElementorPro\Modules\Forms\Fields\Field_Base')) {

    class Base_Field extends \ElementorPro\Modules\Forms\Fields\Field_Base {

        use \ElementorProto\Base\Traits\Base;

        /**
         * Field base constructor.
         *
         * @since 1.0.0
         * @access public
         */
        public function __construct() {
            parent::__construct();
        }

        public function get_type() {
            return 'field';
        }
        
        public function get_label() {
            return $this->get_name();
        }
        
        /**
         * Register Settings Section
         *
         * Registers the Action controls
         *
         * @access public
         * @param \Elementor\Widget_Base $widget
         */
        public function register_settings_section($widget) {

        }

        public function render($item, $item_index, $form) {

        }

        public function _render_form($content, $widget) {
            return $content;
        }

        public function start_section($element, $tab = 'style') {
            $element->start_controls_section(
                    'e_' . $this->get_type() . '_section_' . $tab,
                    [
                        'label' => esc_html__($this->get_name(), 'elementor'),
                        'tab' => $tab,
                    ]
            );
        }

    }

} else {

    class Base_Field {

        use \ElementorProto\Base\Traits\Base;

        /**
         * Field base constructor.
         *
         * @since 1.0.0
         * @access public
         */
        public function __construct() {

        }

    }

}
