<?php
namespace GrowMonsterAddon\Widgets;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Grow_Monster_Button extends Widget_Base {

    public function get_name() {
        return 'grow_monster_button';
    }

    public function get_title() {
        return __( 'Grow Monster Button', 'grow-monster-addon' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {

        // CONTENT TAB
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'grow-monster-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'circle_text',
            [
                'label'   => __( 'Outer Circle Text', 'grow-monster-addon' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => 'Grow Monster Addon',
            ]
        );

        $this->add_control(
            'middle_content_type',
            [
                'label'   => __( 'Middle Content Type', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'icon'  => __( 'Icon', 'grow-monster-addon' ),
                    'image' => __( 'Image', 'grow-monster-addon' ),
                    'text'  => __( 'Text', 'grow-monster-addon' ),
                ],
                'default' => 'icon',
            ]
        );

        $this->add_control(
            'middle_icon',
            [
                'label'     => __( 'Icon', 'grow-monster-addon' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'middle_content_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'middle_image',
            [
                'label'     => __( 'Choose Image', 'grow-monster-addon' ),
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'middle_content_type' => 'image',
                ],
            ]
        );

        $this->add_control(
            'middle_text',
            [
                'label'     => __( 'Middle Text', 'grow-monster-addon' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Grow Monster Addon', 'grow-monster-addon' ),
                'condition' => [
                    'middle_content_type' => 'text',
                ],
            ]
        );

        // URL control for the button (dynamic tags enabled)
        $this->add_control(
            'button_link',
            [
                'label'         => __( 'Button URL', 'grow-monster-addon' ),
                'type'          => Controls_Manager::URL,
                'placeholder'   => __( 'https://your-link.com', 'grow-monster-addon' ),
                'default'       => [
                    'url' => '',
                ],
                'show_external' => true,
                'dynamic'       => [ 'active' => true ],
            ]
        );

        $this->end_controls_section();

        // STYLE TAB
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'grow-monster-addon' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Overall SVG Width (controls both width and height)
        $this->add_control(
            'circle_width',
            [
                'label'     => __( 'SVG Width (px)', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [ 'size' => 250 ],
                'range'     => [ 'px' => [ 'min' => 100, 'max' => 500 ] ],
                'selectors' => [
                    '{{WRAPPER}} .grow-monster-widget svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                ],
            ]
        );

        /* --- Outer Circle Customizations --- */
        $this->add_control(
            'outer_circle_heading',
            [
                'label' => __( 'Outer Circle', 'grow-monster-addon' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        // Select background type for outer circle.
        $this->add_control(
            'outer_background_type',
            [
                'label'   => __( 'Outer Background Type', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'color',
                'options' => [
                    'color'    => __( 'Color', 'grow-monster-addon' ),
                    'gradient' => __( 'Gradient', 'grow-monster-addon' ),
                ],
            ]
        );

        // Outer circle background color (if type = color)
        $this->add_control(
            'outer_circle_bg_color',
            [
                'label'     => __( 'Outer Circle Background Color', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'condition' => [
                    'outer_background_type' => 'color',
                ],
            ]
        );

        // Outer gradient controls (if type = gradient)
        $this->add_control(
            'outer_gradient_color1',
            [
                'label'     => __( 'Outer Gradient Color 1', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'condition' => [
                    'outer_background_type' => 'gradient',
                ],
            ]
        );

        $this->add_control(
            'outer_gradient_color2',
            [
                'label'     => __( 'Outer Gradient Color 2', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'condition' => [
                    'outer_background_type' => 'gradient',
                ],
            ]
        );

        $this->add_control(
            'outer_gradient_angle',
            [
                'label'     => __( 'Outer Gradient Angle', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [ 'size' => 90 ],
                'range'     => [ 'px' => [ 'min' => 0, 'max' => 360 ] ],
                'condition' => [
                    'outer_background_type' => 'gradient',
                ],
            ]
        );

        // Outer circle border controls
        $this->add_control(
            'outer_border_width',
            [
                'label'      => __( 'Outer Border Width', 'grow-monster-addon' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 0 ],
                'selectors'  => [
                    '{{WRAPPER}} .outer-circle' => 'stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'outer_border_color',
            [
                'label'     => __( 'Outer Border Color', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .outer-circle' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        // Outer circle text (on the path) styling
        $this->add_control(
            'circle_text_color',
            [
                'label'     => __( 'Outer Circle Text Color', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .circle-text' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'circle_text_typography',
                'label'    => __( 'Outer Circle Text Typography', 'grow-monster-addon' ),
                'selector' => '{{WRAPPER}} .circle-text',
            ]
        );

        /* --- Middle Circle Customizations --- */
        $this->add_control(
            'middle_circle_heading',
            [
                'label' => __( 'Middle Circle', 'grow-monster-addon' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        // Select background type for middle circle.
        $this->add_control(
            'middle_background_type',
            [
                'label'   => __( 'Middle Background Type', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'color',
                'options' => [
                    'color'    => __( 'Color', 'grow-monster-addon' ),
                    'gradient' => __( 'Gradient', 'grow-monster-addon' ),
                ],
            ]
        );

        // Middle circle background color (if type = color)
        $this->add_control(
            'middle_circle_bg_color',
            [
                'label'     => __( 'Middle Circle Background Color', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ed1c24',
                'condition' => [
                    'middle_background_type' => 'color',
                ],
            ]
        );

        // Middle gradient controls (if type = gradient)
        $this->add_control(
            'middle_gradient_color1',
            [
                'label'     => __( 'Middle Gradient Color 1', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ed1c24',
                'condition' => [
                    'middle_background_type' => 'gradient',
                ],
            ]
        );

        $this->add_control(
            'middle_gradient_color2',
            [
                'label'     => __( 'Middle Gradient Color 2', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ff0000',
                'condition' => [
                    'middle_background_type' => 'gradient',
                ],
            ]
        );

        $this->add_control(
            'middle_gradient_angle',
            [
                'label'     => __( 'Middle Gradient Angle', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [ 'size' => 90 ],
                'range'     => [ 'px' => [ 'min' => 0, 'max' => 360 ] ],
                'condition' => [
                    'middle_background_type' => 'gradient',
                ],
            ]
        );

        // Middle circle border controls
        $this->add_control(
            'middle_border_width',
            [
                'label'      => __( 'Middle Border Width', 'grow-monster-addon' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 0 ],
                'selectors'  => [
                    '{{WRAPPER}} .middle-circle' => 'stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'middle_border_color',
            [
                'label'     => __( 'Middle Border Color', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .middle-circle' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        // Middle content styling (for icon/image/text inside the middle circle)
        $this->add_control(
            'middle_icon_size',
            [
                'label'     => __( 'Icon Size', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px' ],
                'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
                'default'   => [ 'size' => 36 ],
                'condition' => [
                    'middle_content_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'middle_icon_color',
            [
                'label'     => __( 'Icon Color', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'condition' => [
                    'middle_content_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'middle_image_size',
            [
                'label'     => __( 'Image Size', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px' ],
                'range'     => [ 'px' => [ 'min' => 20, 'max' => 200 ] ],
                'default'   => [ 'size' => 80 ],
                'condition' => [
                    'middle_content_type' => 'image',
                ],
            ]
        );

        // For middle text, allow text color to be set.
        $this->add_control(
            'middle_text_color',
            [
                'label'     => __( 'Middle Text Color', 'grow-monster-addon' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .middle-text' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'middle_content_type' => 'text',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'middle_text_typography',
                'label'     => __( 'Middle Text Typography', 'grow-monster-addon' ),
                'selector'  => '{{WRAPPER}} .middle-text',
                'condition' => [
                    'middle_content_type' => 'text',
                ],
            ]
        );

        // Rotation Controls
        $this->add_control(
            'outer_rotation_direction',
            [
                'label'   => __( 'Outer Rotation Direction', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'clockwise'    => __( 'Clockwise', 'grow-monster-addon' ),
                    'anticlockwise' => __( 'Anticlockwise', 'grow-monster-addon' ),
                ],
                'default' => 'clockwise',
            ]
        );

        $this->add_control(
            'outer_rotation_duration',
            [
                'label'   => __( 'Outer Rotation Duration (s)', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [ 'size' => 15 ],
                'range'   => [ 's' => [ 'min' => 5, 'max' => 30 ] ],
            ]
        );

        $this->add_control(
            'middle_rotation_direction',
            [
                'label'   => __( 'Middle Rotation Direction', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'clockwise'    => __( 'Clockwise', 'grow-monster-addon' ),
                    'anticlockwise' => __( 'Anticlockwise', 'grow-monster-addon' ),
                ],
                'default' => 'anticlockwise',
            ]
        );

        $this->add_control(
            'middle_rotation_duration',
            [
                'label'   => __( 'Middle Rotation Duration (s)', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [ 'size' => 6 ],
                'range'   => [ 's' => [ 'min' => 2, 'max' => 20 ] ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Rotation calculations.
        $outer_from  = $settings['outer_rotation_direction'] === 'clockwise' ? 0 : 360;
        $outer_to    = $settings['outer_rotation_direction'] === 'clockwise' ? 360 : 0;
        $middle_from = $settings['middle_rotation_direction'] === 'clockwise' ? 0 : 360;
        $middle_to   = $settings['middle_rotation_direction'] === 'clockwise' ? 360 : 0;

        // Calculate center for icon rendering (if needed).
        $icon_size = isset( $settings['middle_icon_size']['size'] ) ? $settings['middle_icon_size']['size'] : 36;
        $icon_x = 100 - ( $icon_size / 2 );
        $icon_y = 100 - ( $icon_size / 2 );

        // Prepare link attributes if a URL is set.
        $this->add_render_attribute( 'button_link', 'class', 'grow-monster-button-link' );
        if ( ! empty( $settings['button_link']['url'] ) ) {
            $this->add_render_attribute( 'button_link', 'href', $settings['button_link']['url'] );
            if ( $settings['button_link']['is_external'] ) {
                $this->add_render_attribute( 'button_link', 'target', '_blank' );
            }
            if ( $settings['button_link']['nofollow'] ) {
                $this->add_render_attribute( 'button_link', 'rel', 'nofollow' );
            }
            $link_html = sprintf( '<a %s>', $this->get_render_attribute_string( 'button_link' ) );
            $link_close = '</a>';
        } else {
            $link_html = $link_close = '';
        }

        // Start SVG output.
        // If either outer or middle background type is gradient, output <defs> with the gradients.
        $defs = '';
        if ( 'gradient' === $settings['outer_background_type'] ) {
            // Compute gradient stops for outer circle.
            $angle = $settings['outer_gradient_angle']['size'];
            // Convert angle to coordinates for a linear gradient.
            $x1 = 50 + cos(deg2rad($angle + 180)) * 50;
            $y1 = 50 + sin(deg2rad($angle + 180)) * 50;
            $x2 = 50 + cos(deg2rad($angle)) * 50;
            $y2 = 50 + sin(deg2rad($angle)) * 50;
            $defs .= '<linearGradient id="outer_gradient" gradientUnits="userSpaceOnUse" x1="' . $x1 . '%" y1="' . $y1 . '%" x2="' . $x2 . '%" y2="' . $y2 . '%">';
            $defs .= '<stop offset="0%" stop-color="' . esc_attr($settings['outer_gradient_color1']) . '"/>';
            $defs .= '<stop offset="100%" stop-color="' . esc_attr($settings['outer_gradient_color2']) . '"/>';
            $defs .= '</linearGradient>';
        }
        if ( 'gradient' === $settings['middle_background_type'] ) {
            $angle = $settings['middle_gradient_angle']['size'];
            $x1 = 50 + cos(deg2rad($angle + 180)) * 50;
            $y1 = 50 + sin(deg2rad($angle + 180)) * 50;
            $x2 = 50 + cos(deg2rad($angle)) * 50;
            $y2 = 50 + sin(deg2rad($angle)) * 50;
            $defs .= '<linearGradient id="middle_gradient" gradientUnits="userSpaceOnUse" x1="' . $x1 . '%" y1="' . $y1 . '%" x2="' . $x2 . '%" y2="' . $y2 . '%">';
            $defs .= '<stop offset="0%" stop-color="' . esc_attr($settings['middle_gradient_color1']) . '"/>';
            $defs .= '<stop offset="100%" stop-color="' . esc_attr($settings['middle_gradient_color2']) . '"/>';
            $defs .= '</linearGradient>';
        }
        ?>

        <?php echo $link_html; ?>
        <div class="grow-monster-widget">
            <svg viewBox="0 0 200 200"
                 xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink"
                 onmouseover="this.pauseAnimations();"
                 onmouseout="this.unpauseAnimations();">
                <?php if ( ! empty( $defs ) ) : ?>
                <defs>
                    <?php echo $defs; ?>
                </defs>
                <?php endif; ?>

                <!-- Outer Circle -->
                <circle class="outer-circle"
                        cx="100"
                        cy="100"
                        r="90"
                        <?php
                        // Set fill based on outer background type.
                        if ( 'gradient' === $settings['outer_background_type'] ) {
                            echo 'fill="url(#outer_gradient)"';
                        } else {
                            echo 'fill="' . esc_attr( $settings['outer_circle_bg_color'] ) . '"';
                        }
                        ?>
                />

                <!-- Outer Text Path -->
                <path id="circlePath"
                      d="M100,100 m -70,0 a 70,70 0 1,1 140,0 a 70,70 0 1,1 -140,0"
                      fill="none"/>

                <!-- Outer Text Animation -->
                <g>
                    <text class="circle-text"
                          text-anchor="middle"
                          dominant-baseline="middle">
                        <textPath href="#circlePath" startOffset="50%">
                            <?php echo esc_html( $settings['circle_text'] ); ?>
                        </textPath>
                    </text>
                    <animateTransform attributeName="transform"
                                      type="rotate"
                                      from="<?php echo esc_attr( $outer_from ); ?> 100 100"
                                      to="<?php echo esc_attr( $outer_to ); ?> 100 100"
                                      dur="<?php echo esc_attr( $settings['outer_rotation_duration']['size'] ); ?>s"
                                      repeatCount="indefinite"/>
                </g>

                <!-- Middle Circle -->
                <circle class="middle-circle"
                        cx="100"
                        cy="100"
                        r="40"
                        <?php
                        // Set fill for middle circle.
                        if ( 'gradient' === $settings['middle_background_type'] ) {
                            echo 'fill="url(#middle_gradient)"';
                        } else {
                            echo 'fill="' . esc_attr( $settings['middle_circle_bg_color'] ) . '"';
                        }
                        ?>
                />

                <!-- Middle Content -->
                <g class="middle-content">
                    <?php if ( 'icon' === $settings['middle_content_type'] ) : ?>
                        <!-- Use foreignObject with overflow visible for the icon -->
                        <foreignObject x="<?php echo esc_attr( $icon_x ); ?>"
                                       y="<?php echo esc_attr( $icon_y ); ?>"
                                       width="<?php echo esc_attr( $icon_size ); ?>"
                                       height="<?php echo esc_attr( $icon_size ); ?>"
                                       style="overflow: visible;">
                            <div xmlns="http://www.w3.org/1999/xhtml"
                                 style="width:100%; height:100%; display: flex; align-items: center; justify-content: center;">
                                <?php 
                                if ( ! empty( $settings['middle_icon'] ) && is_array( $settings['middle_icon'] ) && ! empty( $settings['middle_icon']['value'] ) ) {
                                    ob_start();
                                    Icons_Manager::render_icon( $settings['middle_icon'], [
                                        'aria-hidden' => 'true',
                                        'class'       => 'middle-icon',
                                        'style'       => sprintf(
                                            'font-size: %spx; color: %s; fill: %s !important;',
                                            $icon_size,
                                            $settings['middle_icon_color'],
                                            $settings['middle_icon_color']
                                        )
                                    ] );
                                    $icon_output = ob_get_clean();
                                    if ( empty( $icon_output ) ) {
                                        echo '<i class="'.esc_attr($settings['middle_icon']['value']).'" style="font-size: '.esc_attr($icon_size).'px; color: '.esc_attr($settings['middle_icon_color']).'; fill: '.esc_attr($settings['middle_icon_color']).' !important;"></i>';
                                    } else {
                                        echo $icon_output;
                                    }
                                }
                                ?>
                            </div>
                        </foreignObject>
                    <?php elseif ( 'image' === $settings['middle_content_type'] && ! empty( $settings['middle_image']['url'] ) ) : ?>
                        <image x="<?php echo 100 - ($settings['middle_image_size']['size'] / 2); ?>"
                               y="<?php echo 100 - ($settings['middle_image_size']['size'] / 2); ?>"
                               width="<?php echo esc_attr( $settings['middle_image_size']['size'] ); ?>"
                               height="<?php echo esc_attr( $settings['middle_image_size']['size'] ); ?>"
                               xlink:href="<?php echo esc_url( $settings['middle_image']['url'] ); ?>"/>
                    <?php elseif ( 'text' === $settings['middle_content_type'] ) : ?>
                        <text x="100"
                              y="100"
                              text-anchor="middle"
                              dominant-baseline="central"
                              class="middle-text"
                              fill="<?php echo esc_attr( $settings['middle_text_color'] ); ?>">
                            <?php echo esc_html( $settings['middle_text'] ); ?>
                        </text>
                    <?php endif; ?>
                    <animateTransform attributeName="transform"
                                      type="rotate"
                                      from="<?php echo esc_attr( $middle_from ); ?> 100 100"
                                      to="<?php echo esc_attr( $middle_to ); ?> 100 100"
                                      dur="<?php echo esc_attr( $settings['middle_rotation_duration']['size'] ); ?>s"
                                      repeatCount="indefinite"/>
                </g>
            </svg>
        </div>
        <?php echo $link_close; ?>
        <?php
    }

    protected function _content_template() {}
}
