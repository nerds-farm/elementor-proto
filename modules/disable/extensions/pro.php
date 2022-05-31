<?php
namespace ElementorProto\Modules\Disable\Extensions;

use ElementorProto\Base\Base_Extension;
use ElementorProto\Core\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Pro extends Base_Extension {
    
    public function get_icon() {
        return 'eicon-pro-icon';
    }
    
    /**
     * Get Label
     *
     * Returns the action label
     *
     * @access public
     * @return string
     */
    public function get_label() {
        return esc_html__('Disable PRO in Editor Free', 'elementor');
    }
    
    public function __construct() {
        parent::__construct();
        if (!Utils::is_plugin_active('elementor-pro')) {
            add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_editor_assets']);
        }
    }

    /**
     * Enqueue admin styles
     *
     * @since 0.7.0
     *
     * @access public
     */
    public function enqueue_editor_assets() {
        wp_enqueue_style('editor-no-pro');
    }

}
