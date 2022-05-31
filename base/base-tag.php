<?php

namespace ElementorProto\Base;

use Elementor\Core\DynamicTags\Tag;
use ElementorProto\Core\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

abstract class Base_Tag extends Tag {

    public $is_data = false;

    use \ElementorProto\Base\Traits\Base;

    public function get_group() {
        return 'elementor';
    }

    public static function _group() {
        return self::_groups('elementor');
    }

    public static function _groups($group = '') {
        $groups = array(
            'elementor' => array('name' => 'elementor', 'title' => 'elementor'),
            'user' => array('name' => 'user', 'title' => esc_html__('User', 'elementor')),
            'term' => array('name' => 'term', 'title' => esc_html__('Term', 'elementor')),
            'post' => array('name' => 'post', 'title' => esc_html__('Post', 'elementor')),
            'author' => array('name' => 'author', 'title' => esc_html__('Author', 'elementor')),
            'site' => array('name' => 'site', 'title' => esc_html__('Site', 'elementor')),
            'form' => array('name' => 'form', 'title' => esc_html__('Form', 'elementor')),
            'archive' => array('name' => 'archive', 'title' => esc_html__('Archive', 'elementor')),
            'repeater' => array('name' => 'repeater', 'title' => esc_html__('Repeater', 'elementor')),
            'woocommerce' => array('name' => 'woocommerce', 'title' => esc_html__('WooCommerce', 'elementor')),
        );
        if ($group) {
            if (isset($groups[$group])) {
                return $groups[$group];
            }
            return reset($groups);
        }
        return $groups;
    }

    public function get_categories() {
        return Utils::get_dynamic_tags_categories();
    }

    /**
     * @since 2.0.0
     * @access public
     *
     * @param array $options
     *
     * @return string
     * 
     * Extend Tag
     * /elementor/core/dynamic-tags/tag.php
     */
    public function get_content(array $options = []) {
        $settings = $this->get_settings();

        if ($this->is_data) {
            $value = $this->get_value($options);
            //$value = Utils::maybe_media($value, $this);
        } else {
            ob_start();
            $this->render();
            $value = ob_get_clean();
        }

        if (Utils::empty($value)) {
            if (!Utils::empty($settings, 'fallback')) {
                $value = $settings['fallback'];
                $value = Utils::get_dynamic_data($value);
            }
        }

        if (!Utils::empty($value) && !$this->is_data) {

            // TODO: fix spaces in `before`/`after` if WRAPPED_TAG ( conflicted with .elementor-tag { display: inline-flex; } );
            if (!Utils::empty($settings, 'before')) {
                $value = wp_kses_post($settings['before']) . $value;
            }

            if (!Utils::empty($settings, 'after')) {
                $value .= wp_kses_post($settings['after']);
            }
            
        }

        return $value;
    }

    public function get_value(array $options = []) {
        return false;
    }

}
