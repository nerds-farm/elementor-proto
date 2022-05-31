<?php

namespace ElementorProto\Core\Managers;

use ElementorProto\Base\Base_Global;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Update extenstion
 *
 * @since 1.0.1
 */
class License {

    public $updaters = [];

    public function __construct() {
        //$addons = \ElementorProto\Plugin::instance()->get_addons();
        //add_action('elementor/proto/init_license', [$this, 'init_license']);
        add_action('elementor/proto/dash/action', [$this, 'execute_action']);
        add_action('elementor/proto/dash/addon_license', [$this, 'dash_addon_license']);
    }

    /**
     * Licenses init
     *
     * @since 1.0.1
     *
     * @access private
     */
    public function init_license($plugin) {
        if (is_admin()) {
            if (!$plugin->is_free()) {
                $addon = $plugin->get_addon();
                $this->updaters = new \ElementorProto\Modules\Update\Edd\Edd($addon);
            }
        }
    }

    public function execute_action($action) {
        $licenses_manager = \ElementorProto\Plugin::instance()->licenses_manager;
        if (!empty($licenses_manager->updaters)) {
            foreach ($licenses_manager->updaters as $license) {
                $license->do_actions($action);
            }
        }
    }

    public function dash_addon_license($e_plugin) {
            ?>
            <div class="my_e_addon_license_wrapper<?php echo (!empty($e_plugin['license']) && !empty($e_plugin['license_status'])) ? ' my_e_addon_license_status__' . $e_plugin['license_status'] : ''; ?>">
                <a class="my_e_addon_license_closed" href="#"><span class="dashicons dashicons-admin-network"></span></a>
                <div class="my_e_addon_license">
                    <a class="my_e_addon_license_close" href="#"><span class="dashicons dashicons-no-alt"></span></a>

                    <div class="my_e_addoons_license-wrap">
                        <p class="my_e_addon_license_status">
                            <span class="dashicons dashicons-admin-network"></span>
                            <?php _e('License status:', 'elementor'); ?>
                            <?php if (!empty($e_plugin['license']) && !empty($e_plugin['license_status'])) { ?><b><?php _e($e_plugin['license_status']); ?></b><?php } else { ?><b><?php _e('inactive'); ?></b><?php } ?>
                        </p>
                        <?php
                        if (!empty($e_plugin['license']) && !empty($e_plugin['license_expires'])) {
                            echo '<p class="my_e_addon_license_expires">' . esc_html__('Expiration:', 'elementor') . ' ' . $e_plugin['license_expires'] . '</p>';
                        }
                        ?>
                        <input class="license_key" type="text" placeholder="Insert here the License Key" name="<?php echo $e_plugin['TextDomain']; ?>" value="<?php echo!empty($e_plugin['license']) ? esc_attr_e($e_plugin['license']) : ''; ?>">
                        <?php if (!empty($e_plugin['license'])) { ?>
                            <a title="Check License" class="my_e_addon_check_license" href="?page=<?php echo esc_attr($_GET['page']); ?>&action=check_license&e_addon=<?php echo $e_plugin['TextDomain']; ?>"><i class="eicon-info-circle-o"></i></a>
                            <?php if ($e_plugin['license'] && $e_plugin['license_status']) { ?>
                                <a title="Deactivate License" class="my_e_addon_deactivate_license" href="?page=<?php echo esc_attr($_GET['page']); ?>&action=deactivate_license&e_addon=<?php echo $e_plugin['TextDomain']; ?>" onclick="return confirm('Deactivate and Remove this license key?');"><i class="eicon-close-circle"></i></a>
                                    <?php
                                }
                            }
                            ?>
                    </div>
                </div>
            </div><?php
    }

}
