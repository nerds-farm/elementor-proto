<?php

namespace ElementorProto\Core\Controls;

use \Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * FileSelect control.
 *
 * A control for selecting any type of files.
 *
 * @since 1.0.0
 */
class Form_Fields extends \Elementor\Control_Select {

    use Traits\Base;

    const CONTROL_TYPE = 'form_fields';

    /**
     * Get control type.
     *
     * Retrieve the control type, in this case `form_fields`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type() {
        return self::CONTROL_TYPE;
    }

    /**
     * Get select control default settings.
     *
     * Retrieve the default settings of the select control. Used to return the
     * default settings while initializing the select control.
     *
     * @since 2.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings() {
        return [
            'options' => [],
            'field_type' => '',
        ];
    }

    /**
     * Enqueue control scripts and styles.
     *
     * Used to register and enqueue custom scripts and styles
     * for this control.
     *
     * @since 1.0.0
     * @access public
     */
    public function enqueue() {
        wp_enqueue_style('editor-control-form-fields', ELEMENTOR_PROTO_URL . 'assets/css/editor-control-form-fields.css');
        // Scripts
        wp_enqueue_script('editor-control-form-fields', ELEMENTOR_PROTO_URL . 'assets/js/editor-control-form-fields.js');
    }

    /**
     * Render e-query control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.1
     * @access public
     */
    public function content_template() {
        ob_start();
        parent::content_template();
        $template = ob_get_clean();
        $template = str_replace('<select ', '<# var multiple = ( data.multiple ) ? \'multiple\' : \'\'; #><# var select_type = ( data.multiple ) ? \'select2\' : \'select\'; #><select class="elementor-{{ select_type }}" type="{{ select_type }}" {{ multiple }} ', $template);
        $template = str_replace('<select ', '<select data-field_type="{{ data.field_type }}"', $template);
        echo $template;
    }

}
