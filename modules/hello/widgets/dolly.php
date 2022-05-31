<?php

namespace ElementorProto\Modules\Hello\Widgets;

use ElementorProto\Base\Base_Widget;
use ElementorProto\Core\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Elementor Hello Dolly
 *
 */
class Dolly extends Base_Widget {

    /**
     * Get widget name.
     *
     * Retrieve heading widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'dolly';
    }

    /**
     * Get widget title.
     *
     * Retrieve heading widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Hello Dolly', 'elementor');
    }

    /**
     * Get widget icon.
     *
     * Retrieve heading widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-posts-ticker';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the heading widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['basic'];
    }
    
    public function get_style_depends() {
        return ['hello-dolly'];
    }

    /**
     * Register heading widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
                'section_dolly', [
            'label' => esc_html__('Hello Dolly', 'elementor'),
                ]
        );

        $this->add_responsive_control(
                'align',
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
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                    ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_title_style',
                [
                    'label' => esc_html__('Title', 'elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'title_color',
                [
                    'label' => esc_html__('Text Color', 'elementor'),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => Global_Colors::COLOR_PRIMARY,
                    ],
                    'selectors' => [
                        '{{WRAPPER}}' => 'color: {{VALUE}};',
                    ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'typography',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                    ],
                    'selector' => '{{WRAPPER}}',
                ]
        );

        $this->add_group_control(
                Group_Control_Text_Stroke::get_type(),
                [
                    'name' => 'text_stroke',
                    'selector' => '{{WRAPPER}}',
                ]
        );

        $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'text_shadow',
                    'selector' => '{{WRAPPER}}',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        if (empty($settings))
            return;

        $this->hello_dolly();
    }

    public function hello_dolly_get_lyric() {
        /** These are the lyrics to Hello Dolly */
        $lyrics = "Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
I feel the room swayin'
While the band's playin'
One of our old favorite songs from way back when
So, take her wrap, fellas
Dolly, never go away again
Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
I feel the room swayin'
While the band's playin'
One of our old favorite songs from way back when
So, golly, gee, fellas
Have a little faith in me, fellas
Dolly, never go away
Promise, you'll never go away
Dolly'll never go away again";

        // Here we split it into lines.
        $lyrics = explode("\n", $lyrics);

        // And then randomly choose a line.
        return wptexturize($lyrics[mt_rand(0, count($lyrics) - 1)]);
    }

// This just echoes the chosen line, we'll position it later.
    public function hello_dolly() {
        $chosen = $this->hello_dolly_get_lyric();
        $lang = '';
        if ('en_' !== substr(get_user_locale(), 0, 3)) {
            $lang = ' lang="en"';
        }

        printf(
                '<p id="dolly"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>',
                __('Quote from Hello Dolly song, by Jerry Herman:', 'hello-dolly'),
                $lang,
                $chosen
        );
    }

}
