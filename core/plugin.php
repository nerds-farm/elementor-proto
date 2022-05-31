<?php

namespace ElementorProto;

use ElementorProto\Core\Utils;
use ElementorProto\Core\Managers\Modules;
use ElementorProto\Core\Managers\Assets;
//use ElementorProto\Core\Managers\Version;
use ElementorProto\Core\Managers\Template;
use ElementorProto\Core\Managers\Controls;
use ElementorProto\Core\Managers\License;

/**
 * Main Plugin Class
 *
 * Register new elementor Extension
 *
 * @since 1.0.1
 */
class Plugin {

    /**
     * Instance.
     *
     * Holds the plugin instance.
     *
     * @since 1.0.1
     * @access public
     * @static
     *
     * @var Plugin
     */
    public static $instance = null;

    /**
     * Modules manager.
     *
     * Holds the modules manager.
     *
     * @since 1.0.0
     * @access public
     *
     * @var Modules_Manager
     */
    public $modules_manager;
    public $assets_manager;
    public $version_manager;
    public $template_manager;
    public $licenses_manager;
    public $ajax_manager;
    public $addons_manager = [];

    /**
     * Constructor
     *
     * @since 1.0.1
     *
     * @access public
     */
    public function __construct() {
        
        $plugin_class_name = get_class($this);

        require_once(ELEMENTOR_PROTO_PATH . 'core' . DIRECTORY_SEPARATOR . 'helper.php');

        spl_autoload_register([$this, 'autoload']);

        $this->setup_hooks();

        $this->licenses_manager = new License();
    }

    /**
     * Instance.
     *
     * Ensures only one instance of the plugin class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return Plugin An instance of the class.
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();

            /**
             * on loaded.
             *
             * Fires when was fully loaded and instantiated.
             *
             * @since 1.0.1
             */
            do_action('elementor/proto/instance', self::$instance);
        }

        return self::$instance;
    }

    public function autoload($class) {
        $self = explode('\\', get_class($this));
        $other = explode('\\', $class);
        if (reset($other) != reset($self)) {
            return;
        }
        if (!class_exists($class)) {
            $filename = \ElementorProto\Core\Helper::class_to_path($class);
            if (is_readable($filename)) {
                include_once( $filename );
            } else {
                // fallback
                $plugin_path = \ElementorProto\Core\Helper::get_plugin_path($class);
                $tmp = explode(DIRECTORY_SEPARATOR, $plugin_path);
                $tmp = array_filter($tmp);
                $plugin_name = end($tmp);
                $filename = str_replace(DIRECTORY_SEPARATOR . $plugin_name . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR, $filename);
                $plugin_search = glob($filename);
                $filename = reset($plugin_search);
                if (is_readable($filename)) {
                    include_once( $filename );
                } else {
                    //var_dump($class); var_dump($plugin_path); var_dump($filename); //die();                    
                }
            }
        }
    }

    public function setup_hooks() {
        // fire actions
        add_action('elementor/init', [$this, 'on_elementor_init'], 0); // 9
    }

    /**
     * Add Actions
     *
     * @since 0.0.1
     *
     * @access private
     */
    public function on_elementor_init() {

        $this->assets_manager = new Assets();
        $this->controls_manager = new Controls();
        $this->modules_manager = new Modules();
        $this->template_manager = new Template();

        $this->ajax_manager = new \ElementorProto\Core\Ajax\Actions();

        do_action('elementor/proto/init');
    }

    public function get_name() {
        list($class, $none) = explode("\\", get_class($this), 2);
        $slug = \ElementorProto\Core\Helper::camel_to_slug($class);
        return $slug;
    }

    public function maybe_vendor_autoload($TextDomain = '') {
        $addon = $this->get_addon($TextDomain);
        if ($this->has_vendors($TextDomain)) {
            $file = $addon['path'] . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

    public function has_vendors($TextDomain = '') {
        $addon = $this->get_addon($TextDomain);
        if (empty($addon['path'])) {
            return false;
        }
        $composer = $addon['path'] . DIRECTORY_SEPARATOR . 'composer.json';
        return file_exists($composer);
    }

}
