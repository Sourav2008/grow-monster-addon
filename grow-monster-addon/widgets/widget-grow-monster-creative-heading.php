<?php
namespace GrowMonsterAddon\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Grow_Monster_Creative_Heading_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'grow_monster_creative_heading';
	}

	public function get_title() {
		return __( 'Creative Heading', 'grow-monster-addon' );
	}

	public function get_icon() {
		return 'eicon-heading';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {

		// ----------------- CONTENT TAB ----------------- //
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'grow-monster-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'prefix_heading',
			[
				'label'   => __( 'Prefix Heading', 'grow-monster-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Hello', 'grow-monster-addon' ),
			]
		);

		$this->add_control(
			'animated_heading',
			[
				'label'   => __( 'Animated Heading', 'grow-monster-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'World', 'grow-monster-addon' ),
			]
		);

		$this->add_control(
			'suffix_heading',
			[
				'label'   => __( 'Suffix Heading', 'grow-monster-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( '!', 'grow-monster-addon' ),
			]
		);

		$this->add_control(
			'animation_effect',
			[
				'label'   => __( 'Animation Effect', 'grow-monster-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'dancing-shadow',
				'options' => [
					'dancing-shadow'    => __( 'Dancing Shadow', 'grow-monster-addon' ),
					'melting-text'      => __( 'Melting Text', 'grow-monster-addon' ),
					'matrix'            => __( 'Matrix', 'grow-monster-addon' ),
					'text-masking'      => __( 'Text Masking', 'grow-monster-addon' ),
					'3d-spin'           => __( '3D Spin', 'grow-monster-addon' ),
					'glitch-effect'     => __( 'Glitch Effect', 'grow-monster-addon' ),
					'neon-glow'         => __( 'Neon Glow', 'grow-monster-addon' ),
					'wavy-text'         => __( 'Wavy Text', 'grow-monster-addon' ),
					'split-text'        => __( 'Split Text', 'grow-monster-addon' ),
					'3d-text-marquee'   => __( '3D Text Marquee', 'grow-monster-addon' ),
					'nabla-color-font'  => __( 'Nabla Color Font', 'grow-monster-addon' ),
					'3d-rotate'         => __( '3D Rotate', 'grow-monster-addon' ),
					'slide-in-text'     => __( 'Slide-in Text w/ BG', 'grow-monster-addon' ),
					'gooey-marquee'     => __( 'Gooey Marquee', 'grow-monster-addon' ),
					'ghosts-and-ghouls' => __( 'Ghosts and Ghouls', 'grow-monster-addon' ),
					'typewriter'        => __( 'Typewriter', 'grow-monster-addon' ),
				],
			]
		);

		$this->end_controls_section();

		// ------------- STYLE TAB: ADVANCED ANIMATION SETTINGS ------------- //
		// Hidden if "Ghosts and Ghouls" is selected
		$this->start_controls_section(
			'section_advanced_settings',
			[
				'label'     => __( 'Advanced Animation Settings', 'grow-monster-addon' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'animation_effect!' => 'ghosts-and-ghouls' ],
			]
		);

		// ----- Existing controls for Dancing Shadow, Melting Text, Matrix, etc. ----- //

		// Dancing Shadow
		$this->add_control(
			'dancing_shadow_color_1',
			[
				'label'     => __( 'Dancing Shadow Color 1', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff1177',
				'condition' => [ 'animation_effect' => 'dancing-shadow' ],
			]
		);
		$this->add_control(
			'dancing_shadow_color_2',
			[
				'label'     => __( 'Dancing Shadow Color 2', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#00d4ff',
				'condition' => [ 'animation_effect' => 'dancing-shadow' ],
			]
		);

		// Melting Text
		$this->add_control(
			'melting_gradient_color_1',
			[
				'label'     => __( 'Melting Gradient Color 1', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff6f61',
				'condition' => [ 'animation_effect' => 'melting-text' ],
			]
		);
		$this->add_control(
			'melting_gradient_color_2',
			[
				'label'     => __( 'Melting Gradient Color 2', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffbd44',
				'condition' => [ 'animation_effect' => 'melting-text' ],
			]
		);

		// Matrix
		$this->add_control(
			'matrix_font_size',
			[
				'label'     => __( 'Matrix Font Size (px)', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => [ 'animation_effect' => 'matrix' ],
			]
		);
		$this->add_control(
			'matrix_text_color',
			[
				'label'     => __( 'Matrix Text Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#04FD00',
				'condition' => [ 'animation_effect' => 'matrix' ],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'matrix_typography',
				'label'     => __( 'Matrix Typography', 'grow-monster-addon' ),
				'selector'  => '{{WRAPPER}} .gm-effect-matrix',
				'condition' => [ 'animation_effect' => 'matrix' ],
			]
		);
		$this->add_control(
			'matrix_rain_color_1',
			[
				'label'     => __( 'Matrix Rain Color 1', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,255,0,0.1)',
				'condition' => [ 'animation_effect' => 'matrix' ],
			]
		);
		$this->add_control(
			'matrix_rain_color_2',
			[
				'label'     => __( 'Matrix Rain Color 2', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,255,0,0.2)',
				'condition' => [ 'animation_effect' => 'matrix' ],
			]
		);

		// Text Masking
		$this->add_control(
			'mask_image',
			[
				'label'     => __( 'Mask Image', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => [ 'url' => '' ],
				'condition' => [ 'animation_effect' => 'text-masking' ],
			]
		);

		// 3D Spin
		// (Uses default behavior if no advanced controls are added.)

		// Glitch Effect
		$this->add_control(
			'glitch_color_1',
			[
				'label'     => __( 'Glitch Color 1', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff005e',
				'condition' => [ 'animation_effect' => 'glitch-effect' ],
			]
		);
		$this->add_control(
			'glitch_color_2',
			[
				'label'     => __( 'Glitch Color 2', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#00d4ff',
				'condition' => [ 'animation_effect' => 'glitch-effect' ],
			]
		);

		// Neon Glow (3 colors)
		$this->add_control(
			'neon_glow_color_1',
			[
				'label'     => __( 'Neon Glow Color 1', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff005e',
				'condition' => [ 'animation_effect' => 'neon-glow' ],
			]
		);
		$this->add_control(
			'neon_glow_color_2',
			[
				'label'     => __( 'Neon Glow Color 2', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#00d4ff',
				'condition' => [ 'animation_effect' => 'neon-glow' ],
			]
		);
		$this->add_control(
			'neon_glow_color_3',
			[
				'label'     => __( 'Neon Glow Color 3', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#00ff00',
				'condition' => [ 'animation_effect' => 'neon-glow' ],
			]
		);

		// Split Text
		$this->add_control(
			'split_left_text_color',
			[
				'label'     => __( 'Left Part Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [ 'animation_effect' => 'split-text' ],
			]
		);
		$this->add_control(
			'split_right_text_color',
			[
				'label'     => __( 'Right Part Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [ 'animation_effect' => 'split-text' ],
			]
		);
		$this->add_control(
			'split_left_font_size',
			[
				'label'     => __( 'Left Part Font Size (px)', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 50,
				'condition' => [ 'animation_effect' => 'split-text' ],
			]
		);
		$this->add_control(
			'split_right_font_size',
			[
				'label'     => __( 'Right Part Font Size (px)', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 50,
				'condition' => [ 'animation_effect' => 'split-text' ],
			]
		);

		// 3D Text Marquee
		$this->add_control(
			'marquee_text',
			[
				'label'     => __( 'Marquee Text', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => __( 'Hello World', 'grow-monster-addon' ),
				'condition' => [ 'animation_effect' => '3d-text-marquee' ],
			]
		);
		$this->add_control(
			'marquee_box_color',
			[
				'label'     => __( 'Marquee Box Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#b200ff',
				'condition' => [ 'animation_effect' => '3d-text-marquee' ],
			]
		);
		$this->add_control(
			'marquee_text_color',
			[
				'label'     => __( 'Marquee Text Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [ 'animation_effect' => '3d-text-marquee' ],
			]
		);
		$this->add_control(
			'marquee_font_size',
			[
				'label'     => __( 'Marquee Font Size (px)', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 40,
				'condition' => [ 'animation_effect' => '3d-text-marquee' ],
			]
		);

		// Nabla Color Font
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'nabla_typography',
				'label'     => __( 'Nabla Typography', 'grow-monster-addon' ),
				'selector'  => '{{WRAPPER}} .gm-effect-nabla-color-font',
				'condition' => [ 'animation_effect' => 'nabla-color-font' ],
			]
		);
		$this->add_control(
			'nabla_color',
			[
				'label'     => __( 'Nabla Base Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [ 'animation_effect' => 'nabla-color-font' ],
			]
		);

		// 3D Rotate
		$this->add_control(
			'rotate_text',
			[
				'label'     => __( '3D Rotate Text (Separate words by comma)', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => __( 'EAT,SLEEP,RAVE', 'grow-monster-addon' ),
				'condition' => [ 'animation_effect' => '3d-rotate' ],
			]
		);

		// Slide-in Text
		$this->add_control(
			'slidein_enable_bg',
			[
				'label'        => __( 'Enable Background', 'grow-monster-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'grow-monster-addon' ),
				'label_off'    => __( 'No', 'grow-monster-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [ 'animation_effect' => 'slide-in-text' ],
			]
		);
		$this->add_control(
			'slidein_texts',
			[
				'label'     => __( 'Slide-in Texts (comma separated)', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => __( 'Developers,Designers,Coders,EVERYONE!', 'grow-monster-addon' ),
				'condition' => [ 'animation_effect' => 'slide-in-text' ],
			]
		);
		$this->add_control(
			'slidein_bg_color',
			[
				'label'     => __( 'Slide-in Background Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F44336',
				'condition' => [
					'animation_effect'  => 'slide-in-text',
					'slidein_enable_bg' => 'yes',
				],
			]
		);

		// Gooey Marquee
		$this->add_control(
			'gooey_text_color',
			[
				'label'     => __( 'Gooey Text Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [ 'animation_effect' => 'gooey-marquee' ],
			]
		);
		$this->add_control(
			'gooey_font_size',
			[
				'label'     => __( 'Gooey Font Size (px)', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 50,
				'condition' => [ 'animation_effect' => 'gooey-marquee' ],
			]
		);

		// -------------------- Typewriter Settings -------------------- //
		// These controls only show when the Typewriter effect is chosen.
		$this->add_control(
			'typewriter_text_color',
			[
				'label'     => __( 'Typewriter Text Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [ 'animation_effect' => 'typewriter' ],
			]
		);
		$this->add_control(
			'typewriter_speed',
			[
				'label'      => __( 'Typewriter Letter Delay (seconds)', 'grow-monster-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [
					's' => [ 'min' => 0.05, 'max' => 1, 'step' => 0.05 ],
				],
				'default'    => [ 'size' => 0.1, 'unit' => 's' ],
				'condition'  => [ 'animation_effect' => 'typewriter' ],
			]
		);
		$this->add_control(
			'typewriter_repeat',
			[
				'label'        => __( 'Repeat Animation', 'grow-monster-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'grow-monster-addon' ),
				'label_off'    => __( 'No', 'grow-monster-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'animation_effect' => 'typewriter' ],
			]
		);
		$this->add_control(
			'typewriter_cursor',
			[
				'label'        => __( 'Show Typewriter Cursor', 'grow-monster-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'grow-monster-addon' ),
				'label_off'    => __( 'No', 'grow-monster-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'animation_effect' => 'typewriter' ],
			]
		);
		$this->add_control(
			'typewriter_cursor_thickness',
			[
				'label'      => __( 'Typewriter Cursor Thickness (px)', 'grow-monster-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 1, 'max' => 10, 'step' => 1 ],
				],
				'default'    => [ 'size' => 2, 'unit' => 'px' ],
				'condition'  => [ 'animation_effect' => 'typewriter' ],
			]
		);
		// New: Repeater control for multiple typewriter headings
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'heading_text',
			[
				'label'   => __( 'Typewriter Heading', 'grow-monster-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Welcome', 'grow-monster-addon' ),
			]
		);
		$this->add_control(
			'typewriter_headings',
			[
				'label'       => __( 'Typewriter Headings', 'grow-monster-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'heading_text' => __( 'Welcome', 'grow-monster-addon' ),
					],
				],
				'condition' => [ 'animation_effect' => 'typewriter' ],
				'title_field' => '{{{ heading_text }}}',
			]
		);

		$this->end_controls_section();

		// ------------- STYLE TAB: GHOST OPTIONS ------------- //
		$this->start_controls_section(
			'ghost_options',
			[
				'label'     => __( 'Ghost Options', 'grow-monster-addon' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'animation_effect' => 'ghosts-and-ghouls' ],
			]
		);

		$this->add_control(
			'ghost_icon',
			[
				'label'   => __( 'Ghost Icon', 'grow-monster-addon' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-ghost',
					'library' => 'fa-solid',
				],
			]
		);
		$this->add_control(
			'ghost_svg',
			[
				'label'       => __( 'Ghost SVG', 'grow-monster-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'default'     => [ 'url' => '' ],
				'media_types' => [ 'svg' ],
			]
		);
		$this->add_control(
			'ghost_icon_size',
			[
				'label'      => __( 'Ghost Size (px)', 'grow-monster-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vmin' ],
				'range'      => [
					'px'   => [ 'min' => 10, 'max' => 300 ],
					'vmin' => [ 'min' => 1, 'max' => 20 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .ghost i'              => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ghost .ghost-svg img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);
		$this->add_control(
			'ghost_rotation',
			[
				'label'   => __( 'Ghost Rotation (degrees)', 'grow-monster-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 0,
			]
		);
		$this->add_control(
			'ghost_movement',
			[
				'label'   => __( 'Ghost Movement', 'grow-monster-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'left_to_right',
				'options' => [
					'left_to_right' => __( 'Left to Right', 'grow-monster-addon' ),
					'right_to_left' => __( 'Right to Left', 'grow-monster-addon' ),
				],
			]
		);
		$this->add_control(
			'ghost_color',
			[
				'label'     => __( 'Ghost Icon Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#EDEDED',
				'selectors' => [
					'{{WRAPPER}} .ghost i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ------------- STYLE TAB: HEADING ------------- //
		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => __( 'Heading', 'grow-monster-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_alignment',
			[
				'label'     => __( 'Text Alignment', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => __( 'Left', 'grow-monster-addon' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => __( 'Center', 'grow-monster-addon' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => __( 'Right', 'grow-monster-addon' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .gm-creative-heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => __( 'Typography', 'grow-monster-addon' ),
				'selector' => '{{WRAPPER}} .gm-creative-heading h2',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Heading Color', 'grow-monster-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gm-creative-heading h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings         = $this->get_settings_for_display();
		$prefix_heading   = $settings['prefix_heading'];
		$animated_heading = $settings['animated_heading'];
		$suffix_heading   = $settings['suffix_heading'];
		$animation_effect = $settings['animation_effect'];

		$uid = uniqid('gm-');
		$effect_class = 'gm-effect-' . $animation_effect;
		?>
		<div id="<?php echo esc_attr($uid); ?>" class="gm-creative-heading">
			<h2 style="margin:0; padding:0; line-height:1; display:block;">
				<span class="gm-prefix"><?php echo esc_html($prefix_heading); ?></span>

				<?php
				// If Typewriter is selected, check if multiple headings were added.
				if ( 'typewriter' === $animation_effect ) {
					// Use the repeater values if set; otherwise fallback to animated_heading.
					$typewriterTexts = [];
					if ( ! empty( $settings['typewriter_headings'] ) && is_array( $settings['typewriter_headings'] ) ) {
						foreach ( $settings['typewriter_headings'] as $item ) {
							$typewriterTexts[] = $item['heading_text'];
						}
					}
					if ( empty( $typewriterTexts ) ) {
						$typewriterTexts[] = $animated_heading;
					}
					// Output container for the typewriter text.
					?>
					<span class="gm-animated gm-effect-typewriter cursor">
						<span class="typewriter-animation" style="color:<?php echo esc_attr($settings['typewriter_text_color']); ?>;"></span>
					</span>
					<?php
				}
				// Wavy Text
				elseif ( 'wavy-text' === $animation_effect ) {
					$letters = preg_split('//u', $animated_heading, -1, PREG_SPLIT_NO_EMPTY);
					echo '<span class="gm-animated ' . esc_attr($effect_class) . '">';
					$i = 0;
					foreach ( $letters as $letter ) {
						$delay = $i * 0.2;
						printf(
							'<span style="animation-delay: %.1fs;">%s</span>',
							$delay,
							esc_html($letter)
						);
						$i++;
					}
					echo '</span>';
				}
				// Glitch, Melting Text, Matrix
				elseif ( in_array($animation_effect, ['glitch-effect','melting-text','matrix'], true) ) {
					printf(
						'<span class="gm-animated %1$s" data-text="%2$s">%2$s</span>',
						esc_attr($effect_class),
						esc_html($animated_heading)
					);
				}
				// Split Text
				elseif ( 'split-text' === $animation_effect ) {
					$parts = explode(',', $animated_heading);
					if ( count($parts) >= 2 ) {
						printf(
							'<span class="gm-animated %1$s">
								<span class="text-part left" style="font-size:%2$spx; color:%3$s;">%4$s</span>
								<span class="text-part right" style="font-size:%5$spx; color:%6$s;">%7$s</span>
							</span>',
							esc_attr($effect_class),
							intval($settings['split_left_font_size']),
							esc_attr($settings['split_left_text_color']),
							esc_html(trim($parts[0])),
							intval($settings['split_right_font_size']),
							esc_attr($settings['split_right_text_color']),
							esc_html(trim($parts[1]))
						);
					} else {
						echo '<span class="gm-animated ' . esc_attr($effect_class) . '">' . esc_html($animated_heading) . '</span>';
					}
				}
				// 3D Rotate
				elseif ( '3d-rotate' === $animation_effect ) {
					$words = explode(',', $settings['rotate_text']);
					echo '<span class="gm-animated ' . esc_attr($effect_class) . '">';
					foreach ( $words as $word ) {
						printf('<span class="rotate-word">%s</span> ', esc_html(trim($word)));
					}
					echo '</span>';
				}
				// Slide-in Text
				elseif ( 'slide-in-text' === $animation_effect ) {
					$texts = explode(',', $settings['slidein_texts']);
					echo '<span class="gm-animated ' . esc_attr($effect_class) . '">';
					foreach ( $texts as $text ) {
						printf('<div>%s</div>', esc_html(trim($text)));
					}
					echo '</span>';
				}
				// 3D Text Marquee
				elseif ( '3d-text-marquee' === $animation_effect ) {
					printf('<span class="gm-animated %1$s">%2$s</span>', esc_attr($effect_class), esc_html($settings['marquee_text']));
				}
				// Ghosts & Ghouls
				elseif ( 'ghosts-and-ghouls' === $animation_effect ) {
					printf(
						'<span class="gm-animated %1$s" data-text="%2$s">%2$s</span>',
						esc_attr($effect_class),
						esc_html($animated_heading)
					);
				}
				// Default: Other animations
				else {
					echo '<span class="gm-animated ' . esc_attr($effect_class) . '">' . esc_html($animated_heading) . '</span>';
				}
				?>

				<span class="gm-suffix"><?php echo esc_html($suffix_heading); ?></span>

				<?php
				if ( 'ghosts-and-ghouls' === $animation_effect ) {
					?>
					<div class="ghost">
						<?php
						if ( ! empty($settings['ghost_svg']['url']) ) {
							echo '<div class="ghost-svg">';
							echo '<img src="' . esc_url($settings['ghost_svg']['url']) . '" alt="Ghost SVG" style="transform: rotate(' . intval($settings['ghost_rotation']) . 'deg);" />';
							echo '</div>';
						} else {
							printf(
								'<i class="%s" style="transform: rotate(%ddeg);"></i>',
								esc_attr($settings['ghost_icon']['value']),
								intval($settings['ghost_rotation'])
							);
						}
						?>
					</div>
					<?php
				}
				if ( 'matrix' === $animation_effect ) {
					echo '<div class="rain"></div>';
				}
				?>
			</h2>
		</div>

		<style>
		/* Container styling */
		#<?php echo esc_attr($uid); ?> .gm-creative-heading {
			text-align: center;
			font-family: Arial, sans-serif;
		}
		#<?php echo esc_attr($uid); ?> .gm-creative-heading h2 {
			position: relative;
			margin: 0;
			padding: 0;
			line-height: 1;
			display: block;
		}
		#<?php echo esc_attr($uid); ?> h2 span {
			display: inline-block;
			margin: 0 5px;
		}

		/* Ghosts & Ghouls keyframe */
		@keyframes ghostMove-<?php echo esc_attr($uid); ?> {
			<?php if ( isset($settings['ghost_movement']) && $settings['ghost_movement'] === 'right_to_left' ) : ?>
				0% { left: 100%; }
				100% { left: 0%; }
			<?php else : ?>
				0% { left: 0%; }
				100% { left: 100%; }
			<?php endif; ?>
		}
		#<?php echo esc_attr($uid); ?> .ghost {
			position: absolute;
			top: 45%;
			transform: translateY(-55%);
			z-index: 1;
			opacity: 0.9;
			mix-blend-mode: exclusion;
			animation: ghostMove-<?php echo esc_attr($uid); ?> 5s linear infinite;
		}

		/* =============== Animation CSS for each effect =============== */

		/* Dancing Shadow */
		@keyframes gm-dancing-shadow-<?php echo esc_attr($uid); ?> {
			0% { text-shadow: 10px 5px 0 <?php echo esc_attr($settings['dancing_shadow_color_1']); ?>; }
			50% { text-shadow: -10px -5px 0 <?php echo esc_attr($settings['dancing_shadow_color_2']); ?>; }
			100% { text-shadow: 10px 5px 0 <?php echo esc_attr($settings['dancing_shadow_color_1']); ?>; }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-dancing-shadow {
			animation: gm-dancing-shadow-<?php echo esc_attr($uid); ?> 2s infinite;
		}

		/* Melting Text */
		@keyframes melt-<?php echo esc_attr($uid); ?> {
			0%, 100% { transform: translateY(0); }
			50% { transform: translateY(20px); }
		}
		@keyframes drip-<?php echo esc_attr($uid); ?> {
			0%, 100% { transform: scaleY(1); opacity: 0.5; }
			50% { transform: scaleY(1.5); opacity: 0.7; }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-melting-text {
			color: transparent;
			background: linear-gradient(90deg, <?php echo esc_attr($settings['melting_gradient_color_1']); ?>, <?php echo esc_attr($settings['melting_gradient_color_2']); ?>, <?php echo esc_attr($settings['melting_gradient_color_1']); ?>);
			-webkit-background-clip: text;
			position: relative;
			animation: melt-<?php echo esc_attr($uid); ?> 3s infinite ease-in-out;
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-melting-text::before,
		#<?php echo esc_attr($uid); ?> .gm-effect-melting-text::after {
			content: attr(data-text);
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: linear-gradient(90deg, <?php echo esc_attr($settings['melting_gradient_color_1']); ?>, <?php echo esc_attr($settings['melting_gradient_color_2']); ?>, <?php echo esc_attr($settings['melting_gradient_color_1']); ?>);
			-webkit-background-clip: text;
			color: transparent;
			z-index: -1;
			opacity: 0.5;
			animation: drip-<?php echo esc_attr($uid); ?> 3s infinite ease-in-out;
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-melting-text::after {
			filter: blur(10px);
			opacity: 0.3;
		}

		/* Matrix */
		@keyframes glitch-<?php echo esc_attr($uid); ?> {
			0%, 100% {
				clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
				transform: translate(0);
			}
			33% {
				clip-path: polygon(0 0, 100% 0, 100% 15%, 0 15%);
				transform: translate(-5px, -5px);
			}
			66% {
				clip-path: polygon(0 85%, 100% 85%, 100% 100%, 0 100%);
				transform: translate(5px, 5px);
			}
		}
		@keyframes rain-<?php echo esc_attr($uid); ?> {
			0% { transform: translateY(-100%); }
			100% { transform: translateY(100%); }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-matrix {
			color: <?php echo esc_attr($settings['matrix_text_color']); ?>;
			font-size: <?php echo ($settings['matrix_font_size'] > 0 ? esc_attr($settings['matrix_font_size']).'px' : 'inherit'); ?>;
			position: relative;
			text-shadow: 0 0 2px <?php echo esc_attr($settings['matrix_text_color']); ?>, 0 0 10px <?php echo esc_attr($settings['matrix_text_color']); ?>;
			z-index: 2;
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-matrix::before {
			content: attr(data-text);
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			animation: glitch-<?php echo esc_attr($uid); ?> 2.5s infinite;
			clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
			transform: translate(-2px, -2px);
			color: <?php echo esc_attr($settings['matrix_text_color']); ?>;
			text-shadow: 0 0 10px <?php echo esc_attr($settings['matrix_text_color']); ?>, 0 0 15px <?php echo esc_attr($settings['matrix_text_color']); ?>;
		}
		#<?php echo esc_attr($uid); ?> .rain {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: repeating-linear-gradient(0deg, <?php echo esc_attr($settings['matrix_rain_color_1']); ?> 0, <?php echo esc_attr($settings['matrix_rain_color_2']); ?> 2px, transparent 4px);
			animation: rain-<?php echo esc_attr($uid); ?> 10s linear infinite;
			z-index: 1;
		}

		/* Text Masking */
		@keyframes textmask-<?php echo esc_attr($uid); ?> {
			0% { mask-position: 0% 50%; }
			100% { mask-position: 100% 50%; }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-text-masking {
			-webkit-mask-image: url(<?php echo esc_url($settings['mask_image']['url']); ?>);
			-webkit-mask-size: cover;
			animation: textmask-<?php echo esc_attr($uid); ?> 4s infinite linear;
		}

		/* 3D Spin */
		@keyframes gm-3dspin-<?php echo esc_attr($uid); ?> {
			0% { transform: rotateY(0deg); }
			100% { transform: rotateY(360deg); }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-3d-spin {
			display: inline-block;
			transform-style: preserve-3d;
			animation: gm-3dspin-<?php echo esc_attr($uid); ?> 3s linear infinite;
		}

		/* Glitch Effect */
		@keyframes gm-glitch-<?php echo esc_attr($uid); ?> {
			0% { transform: translate(0); }
			20% { transform: translate(-2px, 2px); }
			40% { transform: translate(2px, -2px); }
			60% { transform: translate(-1px, 1px); }
			80% { transform: translate(1px, -1px); }
			100% { transform: translate(0); }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-glitch-effect {
			position: relative;
			animation: gm-glitch-<?php echo esc_attr($uid); ?> 2s infinite;
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-glitch-effect::before,
		#<?php echo esc_attr($uid); ?> .gm-effect-glitch-effect::after {
			content: attr(data-text);
			position: absolute;
			top: 0;
			left: 0;
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-glitch-effect::before {
			color: <?php echo esc_attr($settings['glitch_color_1']); ?>;
			clip-path: polygon(0 0, 100% 0, 100% 30%, 0 30%);
			animation: gm-glitch-<?php echo esc_attr($uid); ?> 2s infinite;
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-glitch-effect::after {
			color: <?php echo esc_attr($settings['glitch_color_2']); ?>;
			clip-path: polygon(0 70%, 100% 70%, 100% 100%, 0 100%);
		}

		/* Neon Glow */
		@keyframes neonGlow-<?php echo esc_attr($uid); ?> {
			0% { text-shadow: 0 0 5px <?php echo esc_attr($settings['neon_glow_color_1']); ?>, 0 0 10px <?php echo esc_attr($settings['neon_glow_color_1']); ?>, 0 0 20px <?php echo esc_attr($settings['neon_glow_color_1']); ?>; }
			33% { text-shadow: 0 0 5px <?php echo esc_attr($settings['neon_glow_color_2']); ?>, 0 0 10px <?php echo esc_attr($settings['neon_glow_color_2']); ?>, 0 0 20px <?php echo esc_attr($settings['neon_glow_color_2']); ?>; }
			66% { text-shadow: 0 0 5px <?php echo esc_attr($settings['neon_glow_color_3']); ?>, 0 0 10px <?php echo esc_attr($settings['neon_glow_color_3']); ?>, 0 0 20px <?php echo esc_attr($settings['neon_glow_color_3']); ?>; }
			100% { text-shadow: 0 0 5px <?php echo esc_attr($settings['neon_glow_color_1']); ?>, 0 0 10px <?php echo esc_attr($settings['neon_glow_color_1']); ?>, 0 0 20px <?php echo esc_attr($settings['neon_glow_color_1']); ?>; }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-neon-glow {
			animation: neonGlow-<?php echo esc_attr($uid); ?> 3s infinite;
		}

		/* Wavy Text */
		@keyframes gm-wave-<?php echo esc_attr($uid); ?> {
			0%, 100% { transform: translateY(0); }
			50% { transform: translateY(-20px); }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-wavy-text span {
			animation: gm-wave-<?php echo esc_attr($uid); ?> 2s ease-in-out infinite;
			display: inline-block;
		}

		/* Split Text */
		@keyframes slide-in-left-<?php echo esc_attr($uid); ?> {
			0% { transform: translateX(-200%); }
			100% { transform: translateX(0); }
		}
		@keyframes slide-in-right-<?php echo esc_attr($uid); ?> {
			0% { transform: translateX(200%); }
			100% { transform: translateX(0); }
		}
		#<?php echo esc_attr($uid); ?> .text-part.left {
			animation: slide-in-left-<?php echo esc_attr($uid); ?> 2s ease-out forwards;
		}
		#<?php echo esc_attr($uid); ?> .text-part.right {
			animation: slide-in-right-<?php echo esc_attr($uid); ?> 2s ease-out forwards;
		}

		/* 3D Text Marquee */
		@keyframes marquee-<?php echo esc_attr($uid); ?> {
			from { transform: translateX(70%); }
			to   { transform: translateX(-70%); }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-3d-text-marquee {
			background-color: <?php echo esc_attr($settings['marquee_box_color']); ?>;
			color: <?php echo esc_attr($settings['marquee_text_color']); ?>;
			font-size: <?php echo intval($settings['marquee_font_size']); ?>px;
			overflow: hidden;
			position: relative;
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-3d-text-marquee span {
			animation: marquee-<?php echo esc_attr($uid); ?> 5s linear infinite;
			display: inline-block;
		}

		/* Nabla Color Font */
		@keyframes depth-<?php echo esc_attr($uid); ?> {
			0% { transform: translate(0,0); }
			100% { transform: translate(0.15em,0.1em); }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-nabla-color-font {
			animation: depth-<?php echo esc_attr($uid); ?> 1s ease-in-out alternate infinite;
			color: <?php echo esc_attr($settings['nabla_color']); ?>;
		}

		/* 3D Rotate */
		@keyframes rotate3d-<?php echo esc_attr($uid); ?> {
			0% { transform: rotateY(0deg); }
			100% { transform: rotateY(360deg); }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-3d-rotate {
			animation: rotate3d-<?php echo esc_attr($uid); ?> 3s infinite linear;
		}

		/* Slide-in Text */
		@keyframes roll-<?php echo esc_attr($uid); ?> {
			0% {
				font-size: 0;
				opacity: 0;
				margin-left: -30px;
				transform: rotate(-25deg);
			}
			5% {
				font-size: inherit;
				opacity: 1;
				margin-left: 0;
				transform: rotate(0deg);
			}
			27% {
				font-size: 0;
				opacity: 0.5;
				margin-left: 20px;
				margin-top: 100px;
			}
			100% {
				font-size: 0;
				opacity: 0;
				margin-left: -30px;
				transform: rotate(15deg);
			}
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-slide-in-text div {
			animation: roll-<?php echo esc_attr($uid); ?> 5s linear infinite;
			<?php if ( isset($settings['slidein_enable_bg']) && $settings['slidein_enable_bg'] === 'yes' ) : ?>
				background-color: <?php echo esc_attr($settings['slidein_bg_color']); ?>;
				padding: 5px 10px;
				display: inline-block;
				margin: 5px;
			<?php endif; ?>
		}

		/* Gooey Marquee */
		@keyframes gooey-marquee-<?php echo esc_attr($uid); ?> {
			from { transform: translateX(70%); }
			to   { transform: translateX(-70%); }
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-gooey-marquee {
			position: relative;
			overflow: hidden;
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-gooey-marquee .marquee_text {
			color: <?php echo esc_attr($settings['gooey_text_color']); ?>;
			font-size: <?php echo intval($settings['gooey_font_size']); ?>px;
			animation: gooey-marquee-<?php echo esc_attr($uid); ?> 16s infinite linear;
			display: inline-block;
		}

		/* Typewriter Effect - Using JS for typing, but we still add a blinking cursor via CSS */
		#<?php echo esc_attr($uid); ?> .gm-effect-typewriter .typewriter-animation {
			display: inline-block;
			white-space: nowrap;
			overflow: hidden;
		}
		#<?php echo esc_attr($uid); ?> .gm-effect-typewriter.cursor {
			<?php if ( isset($settings['typewriter_cursor']) && 'yes' === $settings['typewriter_cursor'] ) : ?>
				border-right: <?php echo esc_attr($cursor_thickness . $cursor_thickness_unit); ?> solid <?php echo esc_attr($settings['typewriter_text_color']); ?>;
				animation: blink 1s step-end infinite;
			<?php else : ?>
				border-right: none;
			<?php endif; ?>
		}
		@keyframes blink {
			0%, 50% { border-right-color: <?php echo esc_attr($settings['typewriter_text_color']); ?>; }
			51%, 100% { border-right-color: transparent; }
		}
		</style>

		<?php
		// If Typewriter effect is selected, add the inline JavaScript to cycle through headings.
		if ( 'typewriter' === $animation_effect ) :
			// Prepare an array of headings.
			$typewriterTexts = [];
			if ( ! empty( $settings['typewriter_headings'] ) && is_array( $settings['typewriter_headings'] ) ) {
				foreach ( $settings['typewriter_headings'] as $item ) {
					$typewriterTexts[] = $item['heading_text'];
				}
			}
			if ( empty( $typewriterTexts ) ) {
				$typewriterTexts[] = $animated_heading;
			}
			// Convert slider value (in seconds) to milliseconds.
			$letterDelay = (float)$settings['typewriter_speed']['size'] * 1000;
			?>
			<script>
			(function(){
				var container = document.getElementById('<?php echo esc_js($uid); ?>');
				var textElement = container.querySelector('.typewriter-animation');
				var headings = <?php echo json_encode( $typewriterTexts ); ?>;
				var letterDelay = <?php echo esc_js($letterDelay); ?>;
				var betweenDelay = 1500; // pause between texts in ms
				var currentTextIndex = 0;
				var currentLetterIndex = 0;
				var isDeleting = false;
				
				function type() {
					var currentText = headings[currentTextIndex];
					if (!isDeleting) {
						textElement.textContent = currentText.substring(0, currentLetterIndex + 1);
						currentLetterIndex++;
						if (currentLetterIndex === currentText.length) {
							setTimeout(function(){
								isDeleting = true;
								type();
							}, betweenDelay);
							return;
						}
					} else {
						textElement.textContent = currentText.substring(0, currentLetterIndex - 1);
						currentLetterIndex--;
						if (currentLetterIndex === 0) {
							isDeleting = false;
							currentTextIndex = (currentTextIndex + 1) % headings.length;
						}
					}
					setTimeout(type, letterDelay);
				}
				type();
			})();
			</script>
		<?php
		endif;
	}

	/**
	 * Render widget output in the Elementor editor (JS-based).
	 */
	protected function _content_template() {
		?>
		<#
		var prefix_heading   = settings.prefix_heading;
		var animated_heading = settings.animated_heading;
		var suffix_heading   = settings.suffix_heading;
		var animation_effect = settings.animation_effect;
		#>
		<div class="gm-creative-heading">
			<h2 style="margin:0; padding:0; line-height:1; display:block;">
				<span class="gm-prefix">{{{ prefix_heading }}}</span>

				<# if ( animation_effect === 'wavy-text' ) { #>
					<span class="gm-animated gm-effect-{{ animation_effect }}">
						<#
						var chars = animated_heading.split('');
						for ( var i = 0; i < chars.length; i++ ) { #>
							<span style="animation-delay: {{ (i * 0.2).toFixed(1) }}s;">{{{ chars[i] }}}</span>
						<# } #>
					</span>
				<# } else if ( animation_effect === 'glitch-effect' || animation_effect === 'melting-text' || animation_effect === 'matrix' ) { #>
					<span class="gm-animated gm-effect-{{ animation_effect }}" data-text="{{ animated_heading }}">{{ animated_heading }}</span>
				<# } else if ( animation_effect === 'typewriter' ) { #>
					<span class="gm-animated gm-effect-typewriter cursor">
						<span class="typewriter-animation" style="color: {{{ settings.typewriter_text_color }}};"></span>
					</span>
				<# } else { #>
					<span class="gm-animated gm-effect-{{ animation_effect }}">{{ animated_heading }}</span>
				<# } #>

				<span class="gm-suffix">{{{ suffix_heading }}}</span>

				<# if ( animation_effect === 'ghosts-and-ghouls' ) { #>
					<div class="ghost"></div>
				<# } #>
			</h2>
		</div>
		<?php
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Grow_Monster_Creative_Heading_Widget() );
