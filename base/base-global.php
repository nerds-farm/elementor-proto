<?php

namespace ElementorProto\Base;

use ElementorProto\Core\Utils;
use Elementor\Element_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

abstract class Base_Global extends Element_Base {

    use \ElementorProto\Base\Traits\Base;

    public function get_icon() {
        return 'eicon-globe';
    }

}
