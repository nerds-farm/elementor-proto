<?php

namespace ElementorProto\Base;

use Elementor\Element_Base;
use ElementorProto\Core\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

abstract class Base_Token extends Element_Base {

    use \ElementorProto\Base\Traits\Base;

    static public function replace_tokens($text) {
        return $text;
    }

    static public function do_tokens($text) {
        return \EAddonsTokens\Modules\Tokens\Tokens::do_tokens($text);
    }

    static public function do_var_tokens($text, $name, $value) {
        return \EAddonsTokens\Modules\Tokens\Tokens::do_var_tokens($text, $name, $value);
    }

}
