<?php

namespace ElementorProto\Core;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Utils.
 *
 * @since 1.0.1
 */
class Utils {

    use \ElementorProto\Core\Traits\Plugin;
    use \ElementorProto\Core\Traits\Wordpress;
    use \ElementorProto\Core\Traits\Post;
    use \ElementorProto\Core\Traits\User;
    use \ElementorProto\Core\Traits\Term;
    use \ElementorProto\Core\Traits\Comment;
    use \ElementorProto\Core\Traits\Elementor;
    use \ElementorProto\Core\Traits\Data;    
    use \ElementorProto\Core\Traits\Path;
    use \ElementorProto\Core\Traits\Pagination;
    
    public static function get_dynamic_data($value, $fields = array(), $var = '') {
        if (!empty($value)) {
            if (is_array($value)) {
                foreach ($value as $key => $setting) {                    
                    $value[$key] = self::get_dynamic_data($setting, $fields, $var);
                }
            } else if (is_string($value)) {
                $value = apply_filters('elementor/proto/dynamic', $value, $fields, $var); 
                $value = do_shortcode($value);
            }
        }
        return $value;
    }

    static public function get_plugin_path($file) {
        return Helper::get_plugin_path($file);
    }

    public static function camel_to_slug($title, $separator = '-') {
        return Helper::camel_to_slug($title, $separator);
    }

    public static function slug_to_camel($title, $separator = '') {
        return Helper::slug_to_camel($title, $separator);
    }

}
