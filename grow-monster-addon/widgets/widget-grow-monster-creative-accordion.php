<?php

namespace GrowMonsterAddon\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Plugin;
use Elementor\Icons_Manager;

class Grow_Monster_Creative_Accordion extends Widget_Base {

	public function get_name() {
		return 'grow_monster_creative_accordion';
	}

	public function get_title() {
		return __( 'Grow Monster Creative Accordion', 'plugin-name' );
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Retrieve local Elementor templates.
	 */
	protected function get_elementor_templates() {
		$templates = Plugin::$instance->templates_manager->get_source( 'local' )->get_items();
		$options   = [ '' => __( '— Select a Template —', 'plugin-name' ) ];
		if ( is_array( $templates ) ) {
			foreach ( $templates as $tpl ) {
				if ( isset( $tpl['template_id'], $tpl['title'] ) ) {
					$options[ $tpl['template_id'] ] = $tpl['title'];
				}
			}
		}
		return $options;
	}

	protected function register_controls() {

		/* ----------------------------------------------------
		 * ACCORDION STYLE: Choose Creative, Image or Video
		 * ---------------------------------------------------- */
		$this->start_controls_section(
			'section_accordion_style',
			[
				'label' => __( 'Accordion Style', 'plugin-name' ),
			]
		);

		$this->add_control(
			'accordion_style',
			[
				'label'       => __( 'Accordion Style', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'creative',
				'options'     => [
					'creative' => __( 'Creative Accordion', 'plugin-name' ),
					'image'    => __( 'Image Accordion', 'plugin-name' ),
					'video'    => __( 'Video Accordion', 'plugin-name' ),
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* ----------------------------------------------------
		 * CREATIVE ACCORDION SETTINGS
		 * ---------------------------------------------------- */
		$this->start_controls_section(
			'section_creative_settings',
			[
				'label'     => __( 'Creative Accordion Settings', 'plugin-name' ),
				'condition' => [ 'accordion_style' => 'creative' ],
			]
		);

		$this->add_control(
			'trigger_type',
			[
				'label'       => __( 'Trigger Type', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'click',
				'options'     => [
					'click' => __( 'On Click', 'plugin-name' ),
					'hover' => __( 'On Hover', 'plugin-name' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'accordion_type',
			[
				'label'       => __( 'Accordion Type', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'accordion',
				'options'     => [
					'accordion' => __( 'Accordion (One Open)', 'plugin-name' ),
					'toggle'    => __( 'Toggle (Multiple Open)', 'plugin-name' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'       => __( 'Tab Title Tag', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'span',
				'options'     => [
					'span' => 'Span',
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'enable_toggle_icon',
			[
				'label'       => __( 'Enable Toggle Icon', 'plugin-name' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'toggle_opened_icon',
			[
				'label'       => __( 'Opened Toggle Icon', 'plugin-name' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [ 'value' => 'fas fa-minus', 'library' => 'fa-solid' ],
				'condition'   => [ 'enable_toggle_icon' => 'yes' ],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'toggle_closed_icon',
			[
				'label'       => __( 'Closed Toggle Icon', 'plugin-name' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [ 'value' => 'fas fa-plus', 'library' => 'fa-solid' ],
				'condition'   => [ 'enable_toggle_icon' => 'yes' ],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'toggle_icon_position',
			[
				'label'       => __( 'Toggle Icon Position', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'right',
				'options'     => [
					'right' => __( 'Right', 'plugin-name' ),
					'left'  => __( 'Left', 'plugin-name' ),
				],
				'condition'   => [ 'enable_toggle_icon' => 'yes' ],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'scroll_speed',
			[
				'label'       => __( 'Scroll/Animation Speed (ms)', 'plugin-name' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [ 'size' => 300, 'unit' => 'ms' ],
				'range'       => [ 'ms' => [ 'min' => 0, 'max' => 2000 ] ],
				'condition'   => [ 'trigger_type' => 'click' ],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'custom_id_offset',
			[
				'label'       => __( 'Custom ID Offset', 'plugin-name' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'description' => __( 'Adjust scrolling position for anchor links.', 'plugin-name' ),
				'condition'   => [ 'trigger_type' => 'click' ],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'scroll_on_click',
			[
				'label'       => __( 'Scroll on Click', 'plugin-name' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
				'condition'   => [ 'trigger_type' => 'click' ],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'enable_faq_schema',
			[
				'label'       => __( 'Enable FAQ Schema', 'plugin-name' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* ----------------------------------------------------
		 * IMAGE ACCORDION SETTINGS
		 * ---------------------------------------------------- */
		$this->start_controls_section(
			'section_image_settings',
			[
				'label'     => __( 'Image Accordion Settings', 'plugin-name' ),
				'condition' => [ 'accordion_style' => 'image' ],
			]
		);

		$this->add_control(
			'img_trigger',
			[
				'label'       => __( 'Trigger Type', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'on-hover',
				'options'     => [
					'on-hover' => __( 'On Hover', 'plugin-name' ),
					'on-click' => __( 'On Click', 'plugin-name' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'img_direction',
			[
				'label'       => __( 'Direction', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'horizontal',
				'options'     => [
					'horizontal' => __( 'Horizontal', 'plugin-name' ),
					'vertical'   => __( 'Vertical', 'plugin-name' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'img_accordion_height',
			[
				'label'       => __( 'Height (px)', 'plugin-name' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '400',
				'description' => __( 'Container height in px', 'plugin-name' ),
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'img_horizontal_align',
			[
				'label'       => __( 'Horizontal Alignment', 'plugin-name' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'   => [ 'title' => __( 'Left', 'plugin-name' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => __( 'Center', 'plugin-name' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => __( 'Right', 'plugin-name' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'     => 'center',
				'toggle'      => true,
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'img_vertical_align',
			[
				'label'       => __( 'Vertical Alignment', 'plugin-name' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'top'    => [ 'title' => __( 'Top', 'plugin-name' ), 'icon' => 'fa fa-arrow-circle-up' ],
					'center' => [ 'title' => __( 'Center', 'plugin-name' ), 'icon' => 'eicon-text-align-center' ],
					'bottom' => [ 'title' => __( 'Bottom', 'plugin-name' ), 'icon' => 'fa fa-arrow-circle-down' ],
				],
				'default'     => 'center',
				'toggle'      => true,
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* ----------------------------------------------------
		 * VIDEO ACCORDION SETTINGS
		 * ----------------------------------------------------
		 * New settings similar to the Image Accordion but with additional video options.
		 */
		$this->start_controls_section(
			'section_video_settings',
			[
				'label'     => __( 'Video Accordion Settings', 'plugin-name' ),
				'condition' => [ 'accordion_style' => 'video' ],
			]
		);

		$this->add_control(
			'video_trigger',
			[
				'label'       => __( 'Trigger Type', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'on-click',
				'options'     => [
					'on-hover' => __( 'On Hover', 'plugin-name' ),
					'on-click' => __( 'On Click', 'plugin-name' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'video_direction',
			[
				'label'       => __( 'Direction', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'horizontal',
				'options'     => [
					'horizontal' => __( 'Horizontal', 'plugin-name' ),
					'vertical'   => __( 'Vertical', 'plugin-name' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'video_accordion_height',
			[
				'label'       => __( 'Height (px)', 'plugin-name' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '400',
				'description' => __( 'Container height in px', 'plugin-name' ),
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'video_horizontal_align',
			[
				'label'       => __( 'Horizontal Alignment', 'plugin-name' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'   => [ 'title' => __( 'Left', 'plugin-name' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => __( 'Center', 'plugin-name' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => __( 'Right', 'plugin-name' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'     => 'center',
				'toggle'      => true,
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'video_vertical_align',
			[
				'label'       => __( 'Vertical Alignment', 'plugin-name' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'top'    => [ 'title' => __( 'Top', 'plugin-name' ), 'icon' => 'fa fa-arrow-circle-up' ],
					'center' => [ 'title' => __( 'Center', 'plugin-name' ), 'icon' => 'eicon-text-align-center' ],
					'bottom' => [ 'title' => __( 'Bottom', 'plugin-name' ), 'icon' => 'fa fa-arrow-circle-down' ],
				],
				'default'     => 'center',
				'toggle'      => true,
				'render_type' => 'template',
			]
		);

		// Additional Video Options
		$this->add_control(
			'video_autoplay',
			[
				'label'        => __( 'Auto Play', 'plugin-name' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'plugin-name' ),
				'label_off'    => __( 'No', 'plugin-name' ),
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'video_player_controls',
			[
				'label'        => __( 'Player Controls', 'plugin-name' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'yes',
				'options'      => [
					'yes' => __( 'Show Player Control', 'plugin-name' ),
					'no'  => __( 'No Player Control', 'plugin-name' ),
				],
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'video_play_icon',
			[
				'label'       => __( 'Play Icon', 'plugin-name' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [ 'value' => 'fas fa-play', 'library' => 'fa-solid' ],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'video_start_time',
			[
				'label'       => __( 'Start Time (sec)', 'plugin-name' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => __( 'Set the start time for the video (in seconds)', 'plugin-name' ),
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'video_end_time',
			[
				'label'       => __( 'End Time (sec)', 'plugin-name' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => __( 'Set the end time for the video (in seconds)', 'plugin-name' ),
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* ----------------------------------------------------
		 * CREATIVE ACCORDION ITEMS (Repeater)
		 * ---------------------------------------------------- */
		$this->start_controls_section(
			'section_creative_content_items',
			[
				'label'     => __( 'Creative Accordion Items', 'plugin-name' ),
				'condition' => [ 'accordion_style' => 'creative' ],
			]
		);

		$creative_repeater = new Repeater();

		$creative_repeater->add_control(
			'active_by_default',
			[
				'label'       => __( 'Active as Default', 'plugin-name' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
				'render_type' => 'template',
			]
		);

		$creative_repeater->add_control(
			'enable_tab_icon',
			[
				'label'       => __( 'Enable Tab Icon', 'plugin-name' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
				'render_type' => 'template',
			]
		);

		$creative_repeater->add_control(
			'opened_tab_icon',
			[
				'label'       => __( 'Opened Tab Icon', 'plugin-name' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [ 'value' => 'fas fa-minus', 'library' => 'fa-solid' ],
				'condition'   => [ 'enable_tab_icon' => 'yes' ],
				'render_type' => 'template',
			]
		);

		$creative_repeater->add_control(
			'closed_tab_icon',
			[
				'label'       => __( 'Closed Tab Icon', 'plugin-name' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [ 'value' => 'fas fa-plus', 'library' => 'fa-solid' ],
				'condition'   => [ 'enable_tab_icon' => 'yes' ],
				'render_type' => 'template',
			]
		);

		$creative_repeater->add_control(
			'tab_title',
			[
				'label'       => __( 'Tab Title', 'plugin-name' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Accordion Tab Title', 'plugin-name' ),
				'label_block' => true,
				'render_type' => 'template',
			]
		);

		$creative_repeater->add_control(
			'content_type',
			[
				'label'       => __( 'Content Type', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'content',
				'options'     => [
					'content'        => __( 'Content', 'plugin-name' ),
					'saved_template' => __( 'Saved Template', 'plugin-name' ),
				],
				'render_type' => 'template',
			]
		);

		$creative_repeater->add_control(
			'saved_template_id',
			[
				'label'       => __( 'Choose Template', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT2,
				'default'     => '',
				'options'     => $this->get_elementor_templates(),
				'search'      => true,
				'description' => __( 'Select a saved template from your site.', 'plugin-name' ),
				'condition'   => [ 'content_type' => 'saved_template' ],
				'render_type' => 'template',
			]
		);

		$creative_repeater->add_control(
			'tab_content',
			[
				'label'       => __( 'Tab Content', 'plugin-name' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => __( 'Lorem ipsum dolor sit amet...', 'plugin-name' ),
				'condition'   => [ 'content_type' => 'content' ],
				'render_type' => 'template',
			]
		);

		$creative_repeater->add_control(
			'custom_id',
			[
				'label'       => __( 'Custom ID', 'plugin-name' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'description' => __( 'Use as anchor (e.g., #myTab)', 'plugin-name' ),
				'render_type' => 'template',
			]
		);

		$creative_repeater->add_control(
			'faq_schema_text',
			[
				'label'       => __( 'FAQ Schema Text', 'plugin-name' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'description' => __( 'Override content text for FAQ schema.', 'plugin-name' ),
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'creative_accordion_items',
			[
				'label'       => __( 'Accordion Items', 'plugin-name' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $creative_repeater->get_controls(),
				'title_field' => '{{{ tab_title }}}',
				'default'     => [
					[
						'tab_title'         => __( 'Accordion Tab Title 1', 'plugin-name' ),
						'active_by_default' => 'no',
					],
					[
						'tab_title'         => __( 'Accordion Tab Title 2', 'plugin-name' ),
						'active_by_default' => 'no',
					],
					[
						'tab_title'         => __( 'Accordion Tab Title 3', 'plugin-name' ),
						'active_by_default' => 'no',
					],
					[
						'tab_title'         => __( 'Accordion Tab Title 4', 'plugin-name' ),
						'active_by_default' => 'no',
					],
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* ----------------------------------------------------
		 * IMAGE ACCORDION ITEMS (Repeater)
		 * ---------------------------------------------------- */
		$this->start_controls_section(
			'section_image_content_items',
			[
				'label'     => __( 'Image Accordion Items', 'plugin-name' ),
				'condition' => [ 'accordion_style' => 'image' ],
			]
		);

		$image_repeater = new Repeater();

		$image_repeater->add_control(
			'active_by_default',
			[
				'label'       => __( 'Active as Default', 'plugin-name' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
				'render_type' => 'template',
			]
		);

		$image_repeater->add_control(
			'bg_image',
			[
				'label'       => __( 'Background Image', 'plugin-name' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => plugins_url( '../assets/images/GrowUp 2X Placeholder.png', __FILE__ )
				],
				'render_type' => 'template',
			]
		);

		$image_repeater->add_control(
			'image_title',
			[
				'label'       => __( 'Title', 'plugin-name' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Image Accordion Title', 'plugin-name' ),
				'label_block' => true,
				'render_type' => 'template',
			]
		);

		$image_repeater->add_control(
			'image_content',
			[
				'label'       => __( 'Content', 'plugin-name' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => __( 'Image Accordion Content Goes Here! Click edit button to change this text.', 'plugin-name' ),
				'render_type' => 'template',
			]
		);

		$image_repeater->add_control(
			'enable_title_link',
			[
				'label'       => __( 'Enable Title Link', 'plugin-name' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
				'render_type' => 'template',
			]
		);

		$image_repeater->add_control(
			'title_link',
			[
				'label'       => __( 'Title Link', 'plugin-name' ),
				'type'        => Controls_Manager::URL,
				'default'     => [ 'url' => '#' ],
				'condition'   => [ 'enable_title_link' => 'yes' ],
				'render_type' => 'template',
			]
		);

		$image_repeater->add_control(
			'enable_separator',
			[
				'label'       => __( 'Enable Separator', 'plugin-name' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
				'render_type' => 'template',
			]
		);

		$image_repeater->add_control(
			'enable_button',
			[
				'label'       => __( 'Enable Button', 'plugin-name' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
				'render_type' => 'template',
			]
		);

		$image_repeater->add_control(
			'button_text',
			[
				'label'       => __( 'Button Text', 'plugin-name' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Click Me', 'plugin-name' ),
				'condition'   => [ 'enable_button' => 'yes' ],
				'render_type' => 'template',
			]
		);

		$image_repeater->add_control(
			'button_link',
			[
				'label'       => __( 'Button Link', 'plugin-name' ),
				'type'        => Controls_Manager::URL,
				'default'     => [ 'url' => '#' ],
				'condition'   => [ 'enable_button' => 'yes' ],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'image_accordion_items',
			[
				'label'       => __( 'Accordion Items', 'plugin-name' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $image_repeater->get_controls(),
				'title_field' => '{{{ image_title }}}',
				'default'     => [
					[
						'image_title'       => __( 'Image Accordion #1', 'plugin-name' ),
						'active_by_default' => 'no',
					],
					[
						'image_title'       => __( 'Image Accordion #2', 'plugin-name' ),
						'active_by_default' => 'no',
					],
					[
						'image_title'       => __( 'Image Accordion #3', 'plugin-name' ),
						'active_by_default' => 'no',
					],
					[
						'image_title'       => __( 'Image Accordion #4', 'plugin-name' ),
						'active_by_default' => 'no',
					],
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* ----------------------------------------------------
		 * VIDEO ACCORDION ITEMS (Repeater)
		 * ----------------------------------------------------
		 * New repeater for Video Accordion Items.
		 */
		$this->start_controls_section(
			'section_video_content_items',
			[
				'label'     => __( 'Video Accordion Items', 'plugin-name' ),
				'condition' => [ 'accordion_style' => 'video' ],
			]
		);

		$video_repeater = new Repeater();

		$video_repeater->add_control(
			'active_by_default',
			[
				'label'       => __( 'Active as Default', 'plugin-name' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
				'render_type' => 'template',
			]
		);

		$video_repeater->add_control(
			'video_source',
			[
				'label'       => __( 'Video Source', 'plugin-name' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'youtube',
				'options'     => [
					'youtube'     => __( 'YouTube', 'plugin-name' ),
					'vimeo'       => __( 'Vimeo', 'plugin-name' ),
					'self_hosted' => __( 'Self Hosted', 'plugin-name' ),
				],
				'render_type' => 'template',
			]
		);

		$video_repeater->add_control(
			'video_url',
			[
				'label'       => __( 'Video URL', 'plugin-name' ),
				'type'        => Controls_Manager::URL,
				'default'     => [ 'url' => '' ],
				'render_type' => 'template',
			]
		);

		$video_repeater->add_control(
			'video_title',
			[
				'label'       => __( 'Title', 'plugin-name' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Video Accordion Title', 'plugin-name' ),
				'label_block' => true,
				'render_type' => 'template',
			]
		);

		$video_repeater->add_control(
			'video_content',
			[
				'label'       => __( 'Content', 'plugin-name' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => __( 'Video Accordion Content Goes Here!', 'plugin-name' ),
				'render_type' => 'template',
			]
		);

		$video_repeater->add_control(
			'custom_id',
			[
				'label'       => __( 'Custom ID', 'plugin-name' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'description' => __( 'Use as anchor (e.g., #myTab)', 'plugin-name' ),
				'render_type' => 'template',
			]
		);

		$video_repeater->add_control(
			'faq_schema_text',
			[
				'label'       => __( 'FAQ Schema Text', 'plugin-name' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'description' => __( 'Override content text for FAQ schema.', 'plugin-name' ),
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'video_accordion_items',
			[
				'label'       => __( 'Accordion Items', 'plugin-name' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $video_repeater->get_controls(),
				'title_field' => '{{{ video_title }}}',
				'default'     => [
					[
						'video_title'       => __( 'Video Accordion #1', 'plugin-name' ),
						'active_by_default' => 'no',
					],
					[
						'video_title'       => __( 'Video Accordion #2', 'plugin-name' ),
						'active_by_default' => 'no',
					],
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/**
		 * --------------------------------------------------------------------
		 * STYLE TAB: CREATIVE ACCORDION
		 * --------------------------------------------------------------------
		 */
		/* -- Creative Accordion: Heading Styling -- */
		$this->start_controls_section(
			'section_creative_heading_styling',
			[
				'label'     => __( 'Heading Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'creative' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'tab_heading_typography',
				'label'     => __( 'Title Typography', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .gm-accordion .gm-accordion-heading .gm-accordion-tab-title',
				'render_type' => 'template',
			]
		);
		$this->add_control(
			'heading_bg_color',
			[
				'label'     => __( 'Tab Background', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f7f7f7',
				'selectors' => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-heading' => 'background-color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_control(
			'heading_text_color',
			[
				'label'     => __( 'Title Text Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333',
				'selectors' => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-heading .gm-accordion-tab-title' => 'color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_control(
			'heading_hover_bg_color',
			[
				'label'     => __( 'Tab Hover Background', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4E0D77',
				'selectors' => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-heading:hover' => 'background-color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_control(
			'heading_hover_text_color',
			[
				'label'     => __( 'Title Text Hover Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#DDDDDD',
				'selectors' => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-heading:hover .gm-accordion-tab-title' => 'color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'heading_border',
				'label'     => __( 'Heading Border', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .gm-accordion .gm-accordion-heading',
				'render_type' => 'template',
			]
		);
		$this->add_control(
			'heading_border_radius',
			[
				'label'      => __( 'Heading Border Radius', 'plugin-name' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'size' => 0, 'unit' => 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 50 ],
					'%'  => [ 'min' => 0, 'max' => 50 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-heading' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_responsive_control(
			'heading_padding',
			[
				'label'      => __( 'Heading Padding', 'plugin-name' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [ 'top' => 10, 'right' => 15, 'bottom' => 10, 'left' => 15, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_responsive_control(
			'heading_margin',
			[
				'label'      => __( 'Heading Margin', 'plugin-name' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_control(
			'icon_gap',
			[
				'label'      => __( 'Icon Gap', 'plugin-name' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [ 'size' => 8, 'unit' => 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-icon.icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gm-accordion .gm-accordion-icon.icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
		$this->end_controls_section();

		/* -- Creative Accordion: Icon Styling (New) -- */
		$this->start_controls_section(
			'section_creative_icon_styling',
			[
				'label'     => __( 'Icon Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'creative' ],
			]
		);

		$this->add_control(
			'toggle_icon_size',
			[
				'label'      => __( 'Toggle Icon Size', 'plugin-name' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 16,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-icon.icon-right i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'render_type'=> 'template',
			]
		);

		$this->add_control(
			'toggle_icon_color',
			[
				'label'      => __( 'Toggle Icon Color', 'plugin-name' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '#000000',
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-icon.icon-right i' => 'color: {{VALUE}};',
				],
				'render_type'=> 'template',
			]
		);

		$this->add_control(
			'toggle_icon_hover_color',
			[
				'label'      => __( 'Toggle Icon Hover Color', 'plugin-name' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '#ff0000',
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-heading:hover .gm-accordion-icon.icon-right i' => 'color: {{VALUE}};',
				],
				'render_type'=> 'template',
			]
		);

		$this->add_control(
			'tab_icon_size',
			[
				'label'      => __( 'Tab Icon Size', 'plugin-name' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 16,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-icon.icon-left i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'render_type'=> 'template',
			]
		);

		$this->add_control(
			'tab_icon_color',
			[
				'label'      => __( 'Tab Icon Color', 'plugin-name' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '#000000',
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-icon.icon-left i' => 'color: {{VALUE}};',
				],
				'render_type'=> 'template',
			]
		);

		$this->add_control(
			'tab_icon_hover_color',
			[
				'label'      => __( 'Tab Icon Hover Color', 'plugin-name' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '#ff0000',
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-heading:hover .gm-accordion-icon.icon-left i' => 'color: {{VALUE}};',
				],
				'render_type'=> 'template',
			]
		);

		$this->end_controls_section();

		/* -- Creative Accordion: Content Styling -- */
		$this->start_controls_section(
			'section_creative_content_styling',
			[
				'label'     => __( 'Content Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'creative' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'content_typography',
				'label'     => __( 'Content Typography', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .gm-accordion .gm-accordion-content',
				'render_type' => 'template',
			]
		);
		$this->add_control(
			'content_bg_color',
			[
				'label'     => __( 'Content Background', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-content' => 'background-color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'content_border',
				'label'     => __( 'Content Border', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .gm-accordion .gm-accordion-content',
				'render_type' => 'template',
			]
		);
		$this->add_control(
			'content_border_radius',
			[
				'label'      => __( 'Content Border Radius', 'plugin-name' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'size' => 0, 'unit' => 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 50 ],
					'%'  => [ 'min' => 0, 'max' => 50 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-content' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Content Padding', 'plugin-name' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [ 'top' => 15, 'right' => 15, 'bottom' => 15, 'left' => 15, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_responsive_control(
			'content_margin',
			[
				'label'      => __( 'Content Margin', 'plugin-name' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion .gm-accordion-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
		$this->end_controls_section();

		/* -- Creative Accordion: Container Styling (Whole Accordion) -- */
		$this->start_controls_section(
			'section_creative_container_styling',
			[
				'label'     => __( 'Container Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'creative' ],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'accordion_border',
				'label'     => __( 'Accordion Border', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .gm-accordion',
				'render_type' => 'template',
			]
		);
		$this->add_responsive_control(
			'accordion_padding',
			[
				'label'      => __( 'Accordion Padding', 'plugin-name' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_responsive_control(
			'accordion_margin',
			[
				'label'      => __( 'Accordion Margin', 'plugin-name' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .gm-accordion' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'accordion_shadow',
				'label'     => __( 'Accordion Box Shadow', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .gm-accordion',
				'render_type' => 'template',
			]
		);
		$this->end_controls_section();

		/**
		 * --------------------------------------------------------------------
		 * IMAGE ACCORDION STYLING: Container, Thumbnail, Title, Content, Separator, Button
		 * --------------------------------------------------------------------
		 */
		/* -- Container -- */
		$this->start_controls_section(
			'section_image_styling_container',
			[
				'label'     => __( 'Container Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'image' ],
			]
		);

		$this->add_control(
			'eael_accordion_bg_color',
			[
				'label'     => __( 'Container Background', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion' => 'background-color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'eael_accordion_container_padding',
			[
				'label'     => __( 'Container Padding', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'eael_accordion_container_margin',
			[
				'label'     => __( 'Container Margin', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'eael_accordion_border',
				'label'     => __( 'Container Border', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .eael-img-accordion',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'eael_accordion_border_radius',
			[
				'label'     => __( 'Container Border Radius', 'plugin-name' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 'size' => 4 ],
				'range'     => [ 'px' => [ 'max' => 500 ] ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion' => 'border-radius: {{SIZE}}px;',
				],
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'eael_accordion_shadow',
				'selector'  => '{{WRAPPER}} .eael-img-accordion',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'img_accordion_item_gap',
			[
				'label'     => __( 'Image Gap', 'plugin-name' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 'size' => 0, 'unit' => 'px' ],
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* -- Thumbnail Styling -- */
		$this->start_controls_section(
			'section_image_styling_thumbnail',
			[
				'label'     => __( 'Thumbnail Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'image' ],
			]
		);

		$this->add_control(
			'eael_image_accordion_thumbnail_margin',
			[
				'label'     => __( 'Thumbnail Margin', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .eael-image-accordion-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
		$this->add_control(
			'eael_image_accordion_thumbnail_padding',
			[
				'label'     => __( 'Thumbnail Padding', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'default'   => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .eael-image-accordion-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* ----------------------------------------------------
		 * NEW: VIDEO STYLING
		 * ----------------------------------------------------
		 * New style section for Video Accordion (instead of Thumbnail Styling).
		 */
		$this->start_controls_section(
			'section_video_styling',
			[
				'label'     => __( 'Video Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'video' ],
			]
		);

		$this->add_responsive_control(
			'video_margin',
			[
				'label'     => __( 'Video Margin', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .eael-video-accordion' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'video_padding',
			[
				'label'     => __( 'Video Padding', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .eael-video-accordion' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'video_play_icon_size',
			[
				'label'      => __( 'Play Icon Size', 'plugin-name' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 100 ] ],
				'default'    => [ 'size' => 30, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .eael-video-accordion .video-play-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'render_type'=> 'template',
			]
		);

		$this->add_control(
			'video_play_icon_color',
			[
				'label'     => __( 'Play Icon Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .eael-video-accordion .video-play-icon' => 'color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'video_play_icon_hover_color',
			[
				'label'     => __( 'Play Icon Hover Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff0000',
				'selectors' => [
					'{{WRAPPER}} .eael-video-accordion .video-play-icon:hover' => 'color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* -- IMAGE OVERLAY & SHADOW STYLES (Unchanged) -- */
		$this->start_controls_section(
			'section_image_styling_overlay',
			[
				'label'     => __( 'Overlay & Shadow', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'image' ],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'img_accordion_item_shadow',
				'label'     => __( 'Image Box Shadow', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .eael-img-accordion .eael-image-accordion-item',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'overlay_bg_color',
			[
				'label'     => __( 'Overlay Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .eael-image-accordion-item .overlay' => 'background-color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'overlay_bg_color_hover',
			[
				'label'     => __( 'Hover Overlay Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.4)',
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .eael-image-accordion-item:hover .overlay' => 'background-color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* -- Title Styling -- */
		$this->start_controls_section(
			'section_image_styling_title',
			[
				'label'     => __( 'Title Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'image' ],
			]
		);

		$this->add_control(
			'eael_accordion_title_color',
			[
				'label'     => __( 'Title Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .overlay .img-accordion-title' => 'color: {{VALUE}} !important;',
				],
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'eael_accordion_title_typography',
				'label'     => __( 'Title Typography', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .eael-img-accordion .overlay .img-accordion-title',
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'ia_title_margin',
			[
				'label'     => __( 'Title Margin', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'default'   => [ 'top' => 0, 'right' => 0, 'bottom' => 10, 'left' => 0, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .overlay .img-accordion-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* -- Content Styling -- */
		$this->start_controls_section(
			'section_image_styling_content',
			[
				'label'     => __( 'Content Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'image' ],
			]
		);

		$this->add_control(
			'eael_accordion_content_color',
			[
				'label'     => __( 'Content Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .overlay p' => 'color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'eael_accordion_content_typography',
				'label'     => __( 'Content Typography', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .eael-img-accordion .overlay p',
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'ia_content_margin',
			[
				'label'     => __( 'Content Margin', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'default'   => [ 'top' => 0, 'right' => 0, 'bottom' => 10, 'left' => 0, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .overlay p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* -- Separator Styling -- */
		$this->start_controls_section(
			'section_image_styling_separator',
			[
				'label'     => __( 'Separator Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'image' ],
			]
		);

		$this->add_control(
			'img_accordion_separator_color',
			[
				'label'     => __( 'Separator Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-separator' => 'border-bottom-color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'img_accordion_separator_style',
			[
				'label'     => __( 'Separator Style', 'plugin-name' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => [
					'solid'  => __( 'Solid', 'plugin-name' ),
					'dashed' => __( 'Dashed', 'plugin-name' ),
					'dotted' => __( 'Dotted', 'plugin-name' ),
					'double' => __( 'Double', 'plugin-name' ),
				],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-separator' => 'border-bottom-style: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'img_accordion_separator_thickness',
			[
				'label'     => __( 'Separator Thickness', 'plugin-name' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 'size' => 1, 'unit' => 'px' ],
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-separator' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'img_accordion_separator_width',
			[
				'label'     => __( 'Separator Width', 'plugin-name' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 'size' => 50, 'unit' => '%' ],
				'range'     => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-separator' => 'width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'ia_separator_margin',
			[
				'label'     => __( 'Separator Margin', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'default'   => [ 'top' => 15, 'right' => 0, 'bottom' => 15, 'left' => 0, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/* -- Button Styling -- */
		$this->start_controls_section(
			'section_image_styling_button',
			[
				'label'     => __( 'Button Styling', 'plugin-name' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'accordion_style' => 'image' ],
			]
		);

		$this->add_control(
			'img_accordion_button_text_color',
			[
				'label'     => __( 'Button Text Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-button' => 'color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'img_accordion_button_bg_color',
			[
				'label'     => __( 'Button Background Color', 'plugin-name' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#605BE5',
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-button' => 'background-color: {{VALUE}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'img_accordion_button_typography',
				'label'     => __( 'Button Typography', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .eael-img-accordion .image-accordion-button',
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'img_accordion_button_border',
				'label'     => __( 'Button Border', 'plugin-name' ),
				'selector'  => '{{WRAPPER}} .eael-img-accordion .image-accordion-button',
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'img_accordion_button_border_radius',
			[
				'label'         => __( 'Button Border Radius', 'plugin-name' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'default'       => [
					'top'    => 4,
					'right'  => 4,
					'bottom' => 4,
					'left'   => 4,
					'unit'   => 'px',
				],
				'selectors'     => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type'   => 'template',
				'linked_options'=> true,
			]
		);

		$this->add_responsive_control(
			'img_accordion_button_padding',
			[
				'label'     => __( 'Button Padding', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units'=> [ 'px', 'em', '%' ],
				'default'   => [ 'top' => 8, 'right' => 16, 'bottom' => 8, 'left' => 16, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; text-align: center; display: inline-block; line-height: normal; text-decoration: none;',
				],
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'img_accordion_button_width',
			[
				'label'     => __( 'Button Width', 'plugin-name' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 'size' => '', 'unit' => 'px' ],
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 600 ] ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-button' => 'width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'ia_button_margin',
			[
				'label'     => __( 'Button Margin', 'plugin-name' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'default'   => [ 'top' => 10, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .eael-img-accordion .image-accordion-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; display:inline-block;',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * RENDER THE WIDGET
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( 'image' === $settings['accordion_style'] ) {
			$this->render_image_accordion( $settings );
		} elseif ( 'video' === $settings['accordion_style'] ) {
			$this->render_video_accordion( $settings );
		} else {
			$this->render_creative_accordion( $settings );
		}
	}

	/**
	 * CREATIVE ACCORDION RENDER
	 */
	protected function render_creative_accordion( $settings ) {
		if ( empty( $settings['creative_accordion_items'] ) ) {
			return;
		}
		$items = $settings['creative_accordion_items'];

		$trigger_type       = $settings['trigger_type'];
		$accordion_type     = $settings['accordion_type'];
		$enable_faq_schema  = $settings['enable_faq_schema'];
		$enable_toggle_icon = $settings['enable_toggle_icon'];
		$toggle_opened_icon = ! empty( $settings['toggle_opened_icon']['value'] ) ? $settings['toggle_opened_icon']['value'] : 'fas fa-minus';
		$toggle_closed_icon = ! empty( $settings['toggle_closed_icon']['value'] ) ? $settings['toggle_closed_icon']['value'] : 'fas fa-plus';
		$toggle_icon_pos    = ! empty( $settings['toggle_icon_position'] ) ? $settings['toggle_icon_position'] : 'right';

		$scroll_speed     = ( 'click' === $trigger_type && ! empty( $settings['scroll_speed']['size'] ) ) ? $settings['scroll_speed']['size'] : 300;
		$custom_id_offset = ( 'click' === $trigger_type && ! empty( $settings['custom_id_offset'] ) ) ? (int) $settings['custom_id_offset'] : 0;
		$scroll_on_click  = ( 'click' === $trigger_type && 'yes' === $settings['scroll_on_click'] ) ? 'yes' : 'no';

		$faq_schema_data  = [];
		$firstActiveFound = false;

		// Assign a unique container ID for creative accordion
		$accordion_id = 'gm-accordion-' . $this->get_id();

		echo '<style>
			.gm-accordion .gm-accordion-heading {
				display: flex;
				align-items: center;
				justify-content: space-between;
			}
			.gm-accordion .gm-accordion-tab-title {
				flex: 1;
			}
		</style>';

		echo '<div id="' . esc_attr( $accordion_id ) . '" class="gm-accordion"
		     data-trigger-type="' . esc_attr( $trigger_type ) . '"
		     data-accordion-type="' . esc_attr( $accordion_type ) . '"
		     data-scroll-speed="' . esc_attr( $scroll_speed ) . '"
		     data-scroll-on-click="' . esc_attr( $scroll_on_click ) . '"
		     data-scroll-offset="' . esc_attr( $custom_id_offset ) . '"
		     data-toggle-opened-icon="' . esc_attr( $toggle_opened_icon ) . '"
		     data-toggle-closed-icon="' . esc_attr( $toggle_closed_icon ) . '"
		     data-toggle-icon-position="' . esc_attr( $toggle_icon_pos ) . '">';

		foreach ( $items as $item ) {
			$active = false;
			if ( 'accordion' === $accordion_type ) {
				if ( ! $firstActiveFound && 'yes' === $item['active_by_default'] ) {
					$active           = true;
					$firstActiveFound = true;
				}
			} else {
				if ( 'yes' === $item['active_by_default'] ) {
					$active = true;
				}
			}

			$custom_id   = ! empty( $item['custom_id'] ) ? $item['custom_id'] : '';
			$use_tab_icon = ( 'yes' === $item['enable_tab_icon'] );
			$opened_tab_icon_val = $use_tab_icon && ! empty( $item['opened_tab_icon']['value'] ) ? $item['opened_tab_icon']['value'] : 'fas fa-minus';
			$closed_tab_icon_val = $use_tab_icon && ! empty( $item['closed_tab_icon']['value'] ) ? $item['closed_tab_icon']['value'] : 'fas fa-plus';

			$content_html = '';
			if ( 'saved_template' === $item['content_type'] && ! empty( $item['saved_template_id'] ) ) {
				$content_html = Plugin::$instance->frontend->get_builder_content_for_display( $item['saved_template_id'] );
				if ( empty( $content_html ) ) {
					$content_html = '<p>' . sprintf( __( 'Template ID %s not found or empty.', 'plugin-name' ), esc_html( $item['saved_template_id'] ) ) . '</p>';
				}
			} else {
				$content_html = $item['tab_content'];
			}

			$faq_answer = ! empty( $item['faq_schema_text'] ) ? $item['faq_schema_text'] : wp_strip_all_tags( $content_html );
			if ( 'yes' === $enable_faq_schema ) {
				$faq_schema_data[] = [
					'@type'          => 'Question',
					'name'           => strip_tags( $item['tab_title'] ),
					'acceptedAnswer' => [
						'@type' => 'Answer',
						'text'  => $faq_answer,
					],
				];
			}

			$heading_class = 'gm-accordion-heading' . ( $active ? ' active' : '' );

			echo '<div class="gm-acc-item" ' . ( $custom_id ? 'id="' . esc_attr( $custom_id ) . '"' : '' ) . '>';

			if ( 'right' === $toggle_icon_pos ) {
				echo '<div class="' . esc_attr( $heading_class ) . '"
					data-tab-opened-icon="' . esc_attr( $opened_tab_icon_val ) . '"
					data-tab-closed-icon="' . esc_attr( $closed_tab_icon_val ) . '">
					<span class="gm-accordion-icon icon-left">';
					if ( $use_tab_icon ) {
						$left_icon_class = $active ? $opened_tab_icon_val : $closed_tab_icon_val;
						echo '<i class="' . esc_attr( $left_icon_class ) . '"></i>';
					}
					echo '</span>
					<' . $settings['title_tag'] . ' class="gm-accordion-tab-title">' . esc_html( $item['tab_title'] ) . '</' . $settings['title_tag'] . '>
					<span class="gm-accordion-icon icon-right">';
						if ( 'yes' === $enable_toggle_icon ) {
							$right_icon_class = $active ? $toggle_opened_icon : $toggle_closed_icon;
							echo '<i class="' . esc_attr( $right_icon_class ) . '"></i>';
						}
					echo '</span>
				</div>';
			} else {
				echo '<div class="' . esc_attr( $heading_class ) . '"
					data-tab-opened-icon="' . esc_attr( $opened_tab_icon_val ) . '"
					data-tab-closed-icon="' . esc_attr( $closed_tab_icon_val ) . '">
					<span class="gm-accordion-icon icon-left">';
					if ( 'yes' === $enable_toggle_icon ) {
						$left_icon_class = $active ? $toggle_opened_icon : $toggle_closed_icon;
						echo '<i class="' . esc_attr( $left_icon_class ) . '"></i>';
					}
					echo '</span>
					<' . $settings['title_tag'] . ' class="gm-accordion-tab-title">' . esc_html( $item['tab_title'] ) . '</' . $settings['title_tag'] . '>
					<span class="gm-accordion-icon icon-right">';
						if ( $use_tab_icon ) {
							$right_icon_class = $active ? $opened_tab_icon_val : $closed_tab_icon_val;
							echo '<i class="' . esc_attr( $right_icon_class ) . '"></i>';
						}
					echo '</span>
				</div>';
			}

			$display_style = $active ? 'block' : 'none';
			echo '<div class="gm-accordion-content" style="display: ' . $display_style . ';">';
				echo do_shortcode( $content_html );
			echo '</div>';

			echo '</div>';
		}

		echo '</div>';

		if ( 'yes' === $enable_faq_schema && ! empty( $faq_schema_data ) ) {
			$schema = [
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $faq_schema_data,
			];
			echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
		}
		?>
		<script>
		(function($){
			var $root = $('#<?php echo esc_js($accordion_id); ?>');
			var triggerType = $root.data('trigger-type');
			var accordionType = $root.data('accordion-type');
			var scrollSpeed = parseInt($root.data('scroll-speed') || 300, 10);
			var scrollOnClick = $root.data('scroll-on-click');
			var scrollOffset = parseInt($root.data('scroll-offset') || 0, 10);
			var globalOpenedIcon = $root.data('toggle-opened-icon') || 'fas fa-minus';
			var globalClosedIcon = $root.data('toggle-closed-icon') || 'fas fa-plus';
			var togglePos = $root.data('toggle-icon-position') || 'right';

			function updateIcons($heading, isActive) {
				if (togglePos === 'right') {
					var perTabIcon = $heading.data('tab-opened-icon') || 'fas fa-minus';
					var perTabClosed = $heading.data('tab-closed-icon') || 'fas fa-plus';
					if (isActive) {
						$heading.find('.gm-accordion-icon.icon-left i').attr('class', perTabIcon);
						$heading.closest('.gm-acc-item').find('.gm-accordion-icon.icon-right i').attr('class', globalOpenedIcon);
					} else {
						$heading.find('.gm-accordion-icon.icon-left i').attr('class', perTabClosed);
						$heading.closest('.gm-acc-item').find('.gm-accordion-icon.icon-right i').attr('class', globalClosedIcon);
					}
				} else {
					var perTabIcon = $heading.data('tab-opened-icon') || 'fas fa-minus';
					var perTabClosed = $heading.data('tab-closed-icon') || 'fas fa-plus';
					if (isActive) {
						$heading.find('.gm-accordion-icon.icon-left i').attr('class', globalOpenedIcon);
						$heading.closest('.gm-acc-item').find('.gm-accordion-icon.icon-right i').attr('class', perTabIcon);
					} else {
						$heading.find('.gm-accordion-icon.icon-left i').attr('class', globalClosedIcon);
						$heading.closest('.gm-acc-item').find('.gm-accordion-icon.icon-right i').attr('class', perTabClosed);
					}
				}
			}

			if (triggerType === 'hover') {
				$root.find('.gm-accordion-heading').hover(
					function(){
						var $heading = $(this);
						if (!$heading.hasClass('active')) {
							if (accordionType === 'accordion') {
								$root.find('.gm-accordion-heading.active').each(function(){
									$(this).removeClass('active');
									$(this).next('.gm-accordion-content').slideUp(scrollSpeed);
									updateIcons($(this), false);
								});
							}
							$heading.addClass('active');
							$heading.next('.gm-accordion-content').slideDown(scrollSpeed);
							updateIcons($heading, true);
						}
					},
					function(){
						var $heading = $(this);
						if (accordionType === 'toggle') {
							$heading.removeClass('active');
							$heading.next('.gm-accordion-content').slideUp(scrollSpeed);
							updateIcons($heading, false);
						}
					}
				);
			} else {
				$root.find('.gm-accordion-heading').off('click').on('click', function(){
					var $heading = $(this);
					var $content = $heading.next('.gm-accordion-content');
					var isActive = $heading.hasClass('active');

					if (accordionType === 'accordion') {
						$root.find('.gm-accordion-heading.active').not($heading).each(function(){
							$(this).removeClass('active');
							$(this).next('.gm-accordion-content').slideUp(scrollSpeed);
							updateIcons($(this), false);
						});
						if (isActive) {
							$heading.removeClass('active');
							$content.slideUp(scrollSpeed);
							updateIcons($heading, false);
						} else {
							$heading.addClass('active');
							$content.slideDown(scrollSpeed);
							updateIcons($heading, true);
						}
					} else {
						if (isActive) {
							$heading.removeClass('active');
							$content.slideUp(scrollSpeed);
							updateIcons($heading, false);
						} else {
							$heading.addClass('active');
							$content.slideDown(scrollSpeed);
							updateIcons($heading, true);
						}
					}

					if (scrollOnClick === 'yes') {
						$('html, body').animate({
							scrollTop: $heading.offset().top - scrollOffset
						}, scrollSpeed);
					}
				});
			}
		})(jQuery);
		</script>
		<?php
	}

	/**
	 * IMAGE ACCORDION RENDER
	 */
	protected function render_image_accordion( $settings ) {
		if ( empty( $settings['image_accordion_items'] ) ) {
			return;
		}
		$items         = $settings['image_accordion_items'];
		$img_trigger   = $settings['img_trigger'];
		$img_direction = $settings['img_direction'];
		$img_height    = ! empty( $settings['img_accordion_height'] ) ? $settings['img_accordion_height'] : '400';
		$h_align       = ! empty( $settings['img_horizontal_align'] ) ? $settings['img_horizontal_align'] : 'center';
		$v_align       = ! empty( $settings['img_vertical_align'] ) ? $settings['img_vertical_align'] : 'center';

		$justify = ( 'left' === $h_align ) ? 'flex-start' : ( ( 'right' === $h_align ) ? 'flex-end' : 'center' );
		$align   = ( 'top' === $v_align ) ? 'flex-start' : ( ( 'bottom' === $v_align ) ? 'flex-end' : 'center' );
		$overlay_inline_style = "display: flex; justify-content: {$justify}; align-items: {$align}; text-align: {$h_align};";

		$hr_style = '';
		if ( 'left' === $h_align ) {
			$hr_style .= 'margin-left: 0; margin-right: auto;';
		} elseif ( 'right' === $h_align ) {
			$hr_style .= 'margin-left: auto; margin-right: 0;';
		} else {
			$hr_style .= 'margin-left: auto; margin-right: auto;';
		}

		if ( 'top' === $v_align ) {
			$hr_style .= ' margin-top: 0;';
		} elseif ( 'bottom' === $v_align ) {
			$hr_style .= ' margin-bottom: 0;';
		} else {
			$hr_style .= ' margin-top: auto; margin-bottom: auto;';
		}

		$dir_class    = ( 'vertical' === $img_direction ) ? 'eael-img-accordion-vertical' : 'eael-img-accordion-horizontal';
		$container_id = 'eael-img-accordion-' . $this->get_id();

		echo '<div id="'.esc_attr($container_id).'" class="eael-img-accordion '.$dir_class.'" data-img-trigger="'.esc_attr($img_trigger).'" style="height:'.esc_attr($img_height).'px;">';

		$firstActiveFound = false;

		foreach ( $items as $item ) {
			$active = ( ! $firstActiveFound && 'yes' === $item['active_by_default'] ) ? true : false;
			if ( $active ) {
				$firstActiveFound = true;
			}

			$image_url = ! empty( $item['bg_image']['url'] ) ? $item['bg_image']['url'] : \Elementor\Utils::get_placeholder_image_src();

			$inline_style = 'background-image: url(' . esc_url($image_url) . ');';
			if ( $active ) {
				$inline_style .= ' flex:3 1 0%;';
			}

			$title_link_start = '';
			$title_link_end   = '';
			if ( isset( $item['enable_title_link'] ) && 'yes' === $item['enable_title_link'] && ! empty( $item['title_link']['url'] ) ) {
				$target = ! empty( $item['title_link']['is_external'] ) ? '_blank' : '_self';
				$title_link_start = '<a href="'.esc_url($item['title_link']['url']).'" target="'.esc_attr($target).'">';
				$title_link_end   = '</a>';
			}

			echo '<div class="eael-image-accordion-item" style="'.esc_attr($inline_style).'">';
				echo '<div class="overlay" style="'.esc_attr($overlay_inline_style).'">';
					$overlay_inner_class = 'overlay-inner';
					if ( $active ) {
						$overlay_inner_class .= ' overlay-inner-show';
					}
					echo '<div class="'.esc_attr($overlay_inner_class).'">';
						echo $title_link_start;
						printf( '<h3 class="img-accordion-title">%s</h3>', esc_html( $item['image_title'] ) );
						echo $title_link_end;
						echo '<p>' . wp_kses_post( $item['image_content'] ) . '</p>';
						if ( isset( $item['enable_separator'] ) && 'yes' === $item['enable_separator'] ) {
							echo '<hr class="image-accordion-separator" style="'.esc_attr($hr_style).'" />';
						}
						if ( isset( $item['enable_button'] ) && 'yes' === $item['enable_button'] && ! empty( $item['button_text'] ) ) {
							$btn_link   = '#';
							$btn_target = '_self';
							if ( ! empty( $item['button_link']['url'] ) ) {
								$btn_link   = esc_url( $item['button_link']['url'] );
								$btn_target = ! empty( $item['button_link']['is_external'] ) ? '_blank' : '_self';
							}
							echo '<div class="image-accordion-button-wrap" style="margin-top:10px;">';
								echo '<a href="'.$btn_link.'" target="'.esc_attr($btn_target).'" class="image-accordion-button" style="display:inline-block; text-align:center; line-height:normal; text-decoration:none;">'.esc_html( $item['button_text'] ).'</a>';
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}

		echo '</div>';
		?>
		<style>
			#<?php echo esc_attr($container_id); ?> {
				display: flex;
				overflow: hidden;
			}
			#<?php echo esc_attr($container_id); ?>.eael-img-accordion-horizontal {
				flex-direction: row;
			}
			#<?php echo esc_attr($container_id); ?>.eael-img-accordion-vertical {
				flex-direction: column;
			}
			#<?php echo esc_attr($container_id); ?> .eael-image-accordion-item {
				flex: 1 1 0%;
				background-size: cover;
				background-position: center;
				position: relative;
				transition: all .3s ease-in-out;
				overflow: hidden;
			}
			#<?php echo esc_attr($container_id); ?> .overlay {
				width: 100%;
				height: 100%;
				position: relative;
			}
			#<?php echo esc_attr($container_id); ?> .overlay-inner {
				opacity: 0;
				visibility: hidden;
				transform: translateY(20px);
				transition: all .3s;
			}
			#<?php echo esc_attr($container_id); ?> .overlay-inner-show {
				opacity: 1 !important;
				visibility: visible !important;
				transform: translateY(0) !important;
			}
			#<?php echo esc_attr($container_id); ?> .image-accordion-separator {
				background-color: transparent;
			}
		</style>
		<script>
		(function($){
			var $container = $('#<?php echo esc_js($container_id); ?>');
			var triggerType = $container.data('img-trigger');

			if(triggerType === 'on-hover'){
				$container.find('.eael-image-accordion-item').hover(
					function(){
						$(this).css('flex','3 1 0%').find('.overlay-inner').addClass('overlay-inner-show');
					},
					function(){
						$(this).css('flex','1 1 0%').find('.overlay-inner').removeClass('overlay-inner-show');
					}
				);
			} else {
				$container.find('.eael-image-accordion-item').on('click', function(){
					var $item = $(this);
					$container.find('.eael-image-accordion-item').not($item)
						.css('flex','1 1 0%')
						.find('.overlay-inner')
						.removeClass('overlay-inner-show');
					if( $item.find('.overlay-inner').hasClass('overlay-inner-show') ){
						$item.css('flex','1 1 0%').find('.overlay-inner').removeClass('overlay-inner-show');
					} else {
						$item.css('flex','3 1 0%').find('.overlay-inner').addClass('overlay-inner-show');
					}
				});
			}
		})(jQuery);
		</script>
		<?php
	}

	/**
	 * VIDEO ACCORDION RENDER
	 */
	protected function render_video_accordion( $settings ) {
		if ( empty( $settings['video_accordion_items'] ) ) {
			return;
		}
		$items = $settings['video_accordion_items'];
		$video_trigger    = $settings['video_trigger'];
		$video_direction  = $settings['video_direction'];
		$video_height     = ! empty( $settings['video_accordion_height'] ) ? $settings['video_accordion_height'] : '400';
		$h_align          = ! empty( $settings['video_horizontal_align'] ) ? $settings['video_horizontal_align'] : 'center';
		$v_align          = ! empty( $settings['video_vertical_align'] ) ? $settings['video_vertical_align'] : 'center';

		$justify = ( 'left' === $h_align ) ? 'flex-start' : ( ( 'right' === $h_align ) ? 'flex-end' : 'center' );
		$align   = ( 'top' === $v_align ) ? 'flex-start' : ( ( 'bottom' === $v_align ) ? 'flex-end' : 'center' );
		$overlay_inline_style = "display: flex; justify-content: {$justify}; align-items: {$align}; text-align: {$h_align};";

		$dir_class    = ( 'vertical' === $video_direction ) ? 'eael-video-accordion-vertical' : 'eael-video-accordion-horizontal';
		$container_id = 'eael-video-accordion-' . $this->get_id();

		echo '<div id="'.esc_attr($container_id).'" class="eael-video-accordion '.$dir_class.'" data-video-trigger="'.esc_attr($video_trigger).'" style="height:'.esc_attr($video_height).'px;">';

		$firstActiveFound = false;
		foreach ( $items as $item ) {
			$active = ( ! $firstActiveFound && 'yes' === $item['active_by_default'] ) ? true : false;
			if ( $active ) {
				$firstActiveFound = true;
			}

			$custom_id = ! empty( $item['custom_id'] ) ? $item['custom_id'] : '';

			// Prepare the video embed code based on the selected source.
			$video_embed = '';
			$video_source = $item['video_source'];
			$video_url    = ! empty( $item['video_url']['url'] ) ? $item['video_url']['url'] : '';

			if ( 'youtube' === $video_source && $video_url ) {
				if ( strpos( $video_url, 'watch?v=' ) !== false ) {
					$embed_url = str_replace( 'watch?v=', 'embed/', $video_url );
				} else {
					$embed_url = $video_url;
				}
				$video_embed = '<iframe src="' . esc_url( $embed_url ) . '" frameborder="0" allowfullscreen style="width:100%; height:100%;"></iframe>';
			} elseif ( 'vimeo' === $video_source && $video_url ) {
				$embed_url = preg_replace( '/vimeo\.com\/(\d+)/', 'player.vimeo.com/video/$1', $video_url );
				$video_embed = '<iframe src="' . esc_url( $embed_url ) . '" frameborder="0" allowfullscreen style="width:100%; height:100%;"></iframe>';
			} elseif ( 'self_hosted' === $video_source && $video_url ) {
				$autoplay = ('yes' === $settings['video_autoplay']) ? 'autoplay' : '';
				$controls = ('yes' === $settings['video_player_controls']) ? 'controls' : '';
				$video_embed = '<video ' . $autoplay . ' ' . $controls . ' style="width:100%; height:100%;" poster=""><source src="' . esc_url( $video_url ) . '" type="video/mp4">Your browser does not support the video tag.</video>';
			}

			$start_time = ! empty( $settings['video_start_time'] ) ? $settings['video_start_time'] : '';
			$end_time   = ! empty( $settings['video_end_time'] ) ? $settings['video_end_time'] : '';

			echo '<div class="eael-video-accordion-item" ' . ( $custom_id ? 'id="' . esc_attr( $custom_id ) . '"' : '' ) . ' style="position: relative; overflow: hidden;">';

				// Overlay with Play Icon (visible when inactive)
				echo '<div class="video-overlay" style="display: ' . ( $active ? 'none' : 'flex' ) . '; position: absolute; top:0; left:0; width:100%; height:100%; '.$overlay_inline_style.'">';
					echo '<i class="video-play-icon ' . esc_attr( $settings['video_play_icon']['value'] ) . '"></i>';
				echo '</div>';

				// Video Content
				echo '<div class="video-content" style="display: ' . ( $active ? 'block' : 'none' ) . '; width:100%; height:100%;">';
					echo $video_embed;
				echo '</div>';

			echo '</div>';
		}

		echo '</div>';
		?>
		<style>
			#<?php echo esc_attr($container_id); ?> {
				display: flex;
				overflow: hidden;
			}
			#<?php echo esc_attr($container_id); ?>.eael-video-accordion-horizontal {
				flex-direction: row;
			}
			#<?php echo esc_attr($container_id); ?>.eael-video-accordion-vertical {
				flex-direction: column;
			}
			#<?php echo esc_attr($container_id); ?> .eael-video-accordion-item {
				flex: 1 1 0%;
				position: relative;
				transition: all .3s ease-in-out;
			}
			#<?php echo esc_attr($container_id); ?> .video-overlay {
				background: rgba(0,0,0,0.4);
			}
			#<?php echo esc_attr($container_id); ?> .video-play-icon {
				font-size: <?php echo ! empty( $settings['video_play_icon_size']['size'] ) ? esc_attr( $settings['video_play_icon_size']['size'] ) . esc_attr( $settings['video_play_icon_size']['unit'] ) : '30px'; ?>;
				color: <?php echo ! empty( $settings['video_play_icon_color'] ) ? esc_attr( $settings['video_play_icon_color'] ) : '#fff'; ?>;
			}
			#<?php echo esc_attr($container_id); ?> .eael-video-accordion-item.active {
				flex: 3 1 0%;
			}
		</style>
		<script>
		(function($){
			var $container = $('#<?php echo esc_js($container_id); ?>');
			var triggerType = $container.data('video-trigger');

			$container.find('.eael-video-accordion-item').on(triggerType === 'on-hover' ? 'mouseenter' : 'click', function(){
				var $item = $(this);
				$container.find('.eael-video-accordion-item').not($item)
					.css('flex','1 1 0%')
					.removeClass('active')
					.find('.video-content').hide()
					.end()
					.find('.video-overlay').show();
				$item.css('flex','3 1 0%').addClass('active');
				$item.find('.video-overlay').hide();
				$item.find('.video-content').show();
			});
		})(jQuery);
		</script>
		<?php
	}
}




