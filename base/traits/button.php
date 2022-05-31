<?php

namespace ElementorProto\Base\Traits;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

trait Button {
    
    /**
     * Get button sizes.
     *
     * Retrieve an array of button sizes for the button widget.
     *
     * @since 3.4.0
     * @access public
     * @static
     *
     * @return array An array containing button sizes.
     */
    public static function get_button_sizes() {
        return [
            'xs' => esc_html__('Extra Small', 'elementor'),
            'sm' => esc_html__('Small', 'elementor'),
            'md' => esc_html__('Medium', 'elementor'),
            'lg' => esc_html__('Large', 'elementor'),
            'xl' => esc_html__('Extra Large', 'elementor'),
        ];
    }

    /**
     * @since 3.4.0
     *
     * @param array $args {
     *     An array of values for the button adjustments.
     *
     *     @type array  $section_condition  Set of conditions to hide the controls.
     *     @type string $button_text  Text contained in button.
     *     @type string $text_control_label  Name for the label of the text control.
     *     @type string $alignment_control_prefix_class  Prefix class name for the button alignment control.
     *     @type string $alignment_default  Default alignment for the button.
     *     @type array $icon_exclude_inline_options  Set of icon types to exclude from icon controls.
     * }
     */
    protected function register_button_content_controls($args = []) {
        
        $prefix = $this->get_prefix();
        
        $default_args = [
            'section_condition' => [],
            'button_default_text' => esc_html__('Click here', 'elementor'),
            'text_control_label' => esc_html__('Text', 'elementor'),
            'alignment_control_prefix_class' => 'elementor%s-align-',
            'alignment_default' => '',
            'icon_exclude_inline_options' => [],
        ];

        $args = wp_parse_args($args, $default_args);

        $this->add_control(
                'button_type',
                [
                    'label' => esc_html__('Type', 'elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        '' => esc_html__('Default', 'elementor'),
                        'info' => esc_html__('Info', 'elementor'),
                        'success' => esc_html__('Success', 'elementor'),
                        'warning' => esc_html__('Warning', 'elementor'),
                        'danger' => esc_html__('Danger', 'elementor'),
                    ],
                    'prefix_class' => 'elementor-button-',
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_control(
                'button_text',
                [
                    'label' => $args['text_control_label'],
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => $args['button_default_text'],
                    'placeholder' => $args['button_default_text'],
                    'condition' => $args['section_condition'],
                ]
        );
/*
        $this->add_control(
                'button_link',
                [
                    'label' => esc_html__('Link', 'elementor'),
                    'type' => Controls_Manager::URL,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'placeholder' => esc_html__('https://your-link.com', 'elementor'),
                    'default' => [
                        'url' => '#',
                    ],
                    'condition' => $args['section_condition'],
                ]
        );
*/
        $this->add_responsive_control(
                'button_align',
                [
                    'label' => esc_html__('Alignment', 'elementor'),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__('Left', 'elementor'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'elementor'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__('Right', 'elementor'),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'justify' => [
                            'title' => esc_html__('Justified', 'elementor'),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'prefix_class' => $args['alignment_control_prefix_class'],
                    'default' => $args['alignment_default'],
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_control(
                'button_size',
                [
                    'label' => esc_html__('Size', 'elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'sm',
                    'options' => self::get_button_sizes(),
                    'style_transfer' => true,
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_control(
                'button_selected_icon',
                [
                    'label' => esc_html__('Icon', 'elementor'),
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'skin' => 'inline',
                    'label_block' => false,
                    'condition' => $args['section_condition'],
                    'icon_exclude_inline_options' => $args['icon_exclude_inline_options'],
                ]
        );

        $this->add_control(
                'button_icon_align',
                [
                    'label' => esc_html__('Icon Position', 'elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'left',
                    'options' => [
                        'left' => esc_html__('Before', 'elementor'),
                        'right' => esc_html__('After', 'elementor'),
                    ],
                    'condition' => array_merge($args['section_condition'], [$prefix.'button_selected_icon[value]!' => '']),
                ]
        );

        $this->add_control(
                'button_icon_indent',
                [
                    'label' => esc_html__('Icon Spacing', 'elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 50,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_control(
                'button_view',
                [
                    'label' => esc_html__('View', 'elementor'),
                    'type' => Controls_Manager::HIDDEN,
                    'default' => 'traditional',
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_control(
                'button_css_id',
                [
                    'label' => esc_html__('Button ID', 'elementor'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => '',
                    'title' => esc_html__('Add your custom id WITHOUT the Pound key. e.g: my-id', 'elementor'),
                    /* translators: %1$s Code open tag, %2$s: Code close tag. */
                    'description' => esc_html__('Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'elementor'),
                    'separator' => 'before',
                    'condition' => $args['section_condition'],
                ]
        );
    }

    protected function register_button_style_controls($args = []) {
        $default_args = [
            'section_condition' => [],
        ];

        $args = wp_parse_args($args, $default_args);

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'button_typography',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                    ],
                    'selector' => '{{WRAPPER}} .elementor-button',
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'button_text_shadow',
                    'selector' => '{{WRAPPER}} .elementor-button',
                    'condition' => $args['section_condition'],
                ]
        );

        $this->start_controls_tabs('tabs_button_style', [
            'condition' => $args['section_condition'],
        ]);

        $this->start_controls_tab(
                'tab_button_normal',
                [
                    'label' => esc_html__('Normal', 'elementor'),
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_control(
                'button_text_color',
                [
                    'label' => esc_html__('Text Color', 'elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    ],
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'button_background',
                    'label' => esc_html__('Background', 'elementor'),
                    'types' => ['classic', 'gradient'],
                    'exclude' => ['image'],
                    'selector' => '{{WRAPPER}} .elementor-button',
                    'fields_options' => [
                        'background' => [
                            'default' => 'classic',
                        ],
                        'color' => [
                            'global' => [
                                'default' => Global_Colors::COLOR_ACCENT,
                            ],
                        ],
                    ],
                    'condition' => $args['section_condition'],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_button_hover',
                [
                    'label' => esc_html__('Hover', 'elementor'),
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_control(
                'button_hover_color',
                [
                    'label' => esc_html__('Text Color', 'elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
                    ],
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'button_background_hover',
                    'label' => esc_html__('Background', 'elementor'),
                    'types' => ['classic', 'gradient'],
                    'exclude' => ['image'],
                    'selector' => '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus',
                    'fields_options' => [
                        'background' => [
                            'default' => 'classic',
                        ],
                    ],
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_control(
                'button_hover_border_color',
                [
                    'label' => esc_html__('Border Color', 'elementor'),
                    'type' => Controls_Manager::COLOR,
                    'condition' => [
                        'border_border!' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
                    ],
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_control(
                'button_hover_animation',
                [
                    'label' => esc_html__('Hover Animation', 'elementor'),
                    'type' => Controls_Manager::HOVER_ANIMATION,
                    'condition' => $args['section_condition'],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'button_border',
                    'selector' => '{{WRAPPER}} .elementor-button',
                    'separator' => 'before',
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_control(
                'button_border_radius',
                [
                    'label' => esc_html__('Border Radius', 'elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'button_box_shadow',
                    'selector' => '{{WRAPPER}} .elementor-button',
                    'condition' => $args['section_condition'],
                ]
        );

        $this->add_responsive_control(
                'button_text_padding',
                [
                    'label' => esc_html__('Padding', 'elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                    'condition' => $args['section_condition'],
                ]
        );
    }

    /**
     * Render button widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @param \Elementor\Widget_Base|null $instance
     *
     * @since  3.4.0
     * @access protected
     */
    protected function render_button($instance = null) {
        if (empty($instance)) {
            $instance = $this;
        }
        
        if ($instance instanceof \Elementor\Skin_Base) {
            $instance = $this->parent;
            $prefix = $this->get_id().'_';
        }

        $settings = $instance->get_settings_for_display();
        $settings = $this->skin_settings($settings);
        
        $instance->add_render_attribute('wrapper', 'class', 'elementor-button-wrapper');

        if (!empty($settings['button_link']['url'])) {
            $instance->add_link_attributes('button', $settings['button_link']);
            $instance->add_render_attribute('button', 'class', 'elementor-button-link');
        }

        $instance->add_render_attribute('button', 'class', 'elementor-button');
        $instance->add_render_attribute('button', 'role', 'button');

        if (!empty($settings['button_css_id'])) {
            $instance->add_render_attribute('button', 'id', $settings['button_css_id']);
        }

        if (!empty($settings['button_size'])) {
            $instance->add_render_attribute('button', 'class', 'elementor-size-' . $settings['button_size']);
        }

        if (!empty($settings['button_hover_animation'])) {
            $instance->add_render_attribute('button', 'class', 'elementor-animation-' . $settings['button_hover_animation']);
        }
        ?>
        <div <?php $instance->print_render_attribute_string('wrapper'); ?>>
            <a <?php $instance->print_render_attribute_string('button'); ?>>
        <?php $this->render_text($instance); ?>
            </a>
        </div>
        <?php
    }

    /**
     * Render button widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since  3.4.0
     * @access protected
     */
    protected function content_template() {
        ?>
        <#
        view.addRenderAttribute( 'button_text', 'class', 'elementor-button-text' );
        view.addInlineEditingAttributes( 'button_text', 'none' );
        var iconHTML = elementor.helpers.renderIcon( view, settings.button_selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
        migrated = elementor.helpers.isIconMigrated( settings, 'button_selected_icon' );
        #>
        <div class="elementor-button-wrapper">
            <a id="{{ settings.button_css_id }}" class="elementor-button elementor-size-{{ settings.button_size }} elementor-animation-{{ settings.button_hover_animation }}" href="{{ settings.button_link.url }}" role="button">
                <span class="elementor-button-content-wrapper">
                    <# if ( settings.button_icon || settings.button_selected_icon ) { #>
                    <span class="elementor-button-icon elementor-align-icon-{{ settings.button_icon_align }}">
                        <# if ( ( migrated || ! settings.button_icon ) && iconHTML.rendered ) { #>
                        {{{ iconHTML.value }}}
                        <# } else { #>
                        <i class="{{ settings.button_icon }}" aria-hidden="true"></i>
                        <# } #>
                    </span>
                    <# } #>
                    <span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.button_text }}}</span>
                </span>
            </a>
        </div>
        <?php
    }

    /**
     * Render button text.
     *
     * Render button widget text.
     *
     * @param \Elementor\Widget_Base|null $instance
     *
     * @since  3.4.0
     * @access protected
     */
    protected function render_text(Widget_Base $instance = null) {
        // The default instance should be `$this` (a Button widget), unless the Trait is being used from outside of a widget (e.g. `Skin_Base`) which should pass an `$instance`.
        if (empty($instance)) {
            $instance = $this;
        }

        $settings = $instance->get_settings_for_display();
        $settings = $this->skin_settings($settings);

        $migrated = isset($settings['__fa4_migrated']['button_selected_icon']);
        $is_new = empty($settings['button_icon']) && Icons_Manager::is_migration_allowed();

        if (!$is_new && empty($settings['button_icon_align'])) {
            // @todo: remove when deprecated
            // added as bc in 2.6
            //old default
            $settings['button_icon_align'] = $instance->get_settings('button_icon_align');
        }

        $instance->add_render_attribute([
            'content-wrapper' => [
                'class' => 'elementor-button-content-wrapper',
            ],
            'icon-align' => [
                'class' => [
                    'elementor-button-icon',
                    'elementor-align-icon-' . $settings['button_icon_align'],
                ],
            ],
            'text' => [
                'class' => 'elementor-button-text',
            ],
        ]);

        // TODO: replace the protected with public
        //$instance->add_inline_editing_attributes( 'text', 'none' );
        ?>
        <span <?php $instance->print_render_attribute_string('content-wrapper'); ?>>
                <?php if (!empty($settings['button_icon']) || !empty($settings['button_selected_icon']['value'])) : ?>
                <span <?php $instance->print_render_attribute_string('icon-align'); ?>>
                    <?php
                    if ($is_new || $migrated) :
                        Icons_Manager::render_icon($settings['button_selected_icon'], ['aria-hidden' => 'true']);
                    else :
                        ?>
                        <i class="<?php echo esc_attr($settings['button_icon']); ?>" aria-hidden="true"></i>
            <?php endif; ?>
                </span>
        <?php endif; ?>
            <span <?php $instance->print_render_attribute_string('text'); ?>><?php _e($settings['button_text']); ?></span>
        </span>
        <?php
    }

    public function on_import($element) {
        return Icons_Manager::on_import_migration($element, 'button_icon', 'selected_icon');
    }
    
    public function skin_settings($settings) {
        $prefix = $this->get_prefix();
        if ($prefix) {
            foreach($settings as $key => $value) {
                if (substr($key,0,strlen($prefix)) == $prefix) {
                    $skey = substr($key,strlen($prefix));
                    $settings[$skey] = $value;
                    //$instance->set_settings($skey, $value);
                }
            }
        }
        return $settings;
    }
    
    public function get_prefix() {
        $prefix = '';
        if ($this instanceof \Elementor\Skin_Base) {
            $prefix = $this->get_id().'_';
        }
        return $prefix;
    }

}
