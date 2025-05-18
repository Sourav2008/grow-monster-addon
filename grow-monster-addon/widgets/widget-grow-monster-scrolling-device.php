<?php
namespace GrowMonsterAddon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit;

class Grow_Monster_Scrolling_Device extends Widget_Base {

    public function get_name() {
        return 'grow_monster_scrolling_device';
    }
    
    public function get_title() {
        return __( 'Grow Monster Scrolling Device', 'grow-monster-addon' );
    }
    
    public function get_icon() {
        return 'eicon-device-mobile';
    }
    
    public function get_categories() {
        return [ 'general' ];
    }

    private function get_device_frames() {
        return [
            '' => __( 'Select a Device...', 'grow-monster-addon' ),
            'samsung_s20' => __( 'Samsung Galaxy S20', 'grow-monster-addon' ),
            'ipad_mini' => __( 'iPad Mini', 'grow-monster-addon' ),
            'iphone_14_pro' => __( 'iPhone 14 Pro', 'grow-monster-addon' ),
            'macbook_air' => __( 'MacBook Air', 'grow-monster-addon' ),
        ];
    }

    private function get_device_frames_map() {
        // Update with your actual image URLs
        return [
            'samsung_s20'  => GMA_PLUGIN_URL . 'assets/images/devices/samsung_s20.png',
            'ipad_mini'    => GMA_PLUGIN_URL . 'assets/images/devices/ipad_mini.webp',
            'iphone_14_pro'=> GMA_PLUGIN_URL . 'assets/images/devices/iphone_14_pro.webp',
            'macbook_air'  => GMA_PLUGIN_URL . 'assets/images/devices/macbook_air.webp',
        ];
    }

    protected function _register_controls() {
        /**
         * CONTENT TAB
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'grow-monster-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Select the device
        $this->add_control(
            'selected_device',
            [
                'label'   => __( 'Select Device', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->get_device_frames(),
                'default' => '',
            ]
        );

        // Content Type
        $this->add_control(
            'content_type',
            [
                'label'   => __( 'Inner Content Type', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'image'     => __( 'Image', 'grow-monster-addon' ),
                    'slideshow' => __( 'Slides (Swiper)', 'grow-monster-addon' ),
                    'video'     => __( 'Video', 'grow-monster-addon' ),
                    'website'   => __( 'Website (Iframe)', 'grow-monster-addon' ),
                ],
                'default' => 'image',
            ]
        );

        // IMAGE
        $this->add_control(
            'scrolling_image',
            [
                'label'     => __( 'Scrolling Image', 'grow-monster-addon' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [ 'url' => Utils::get_placeholder_image_src() ],
                'condition' => [
                    'content_type' => 'image',
                ],
            ]
        );

        // SLIDESHOW
        $repeater = new Repeater();
        $repeater->add_control(
            'slide_image',
            [
                'label'   => __( 'Slide Image', 'grow-monster-addon' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );
        $this->add_control(
            'slides',
            [
                'label'     => __( 'Slides', 'grow-monster-addon' ),
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   => [],
                'condition' => [
                    'content_type' => 'slideshow',
                ],
            ]
        );

        $this->add_control(
            'slider_direction',
            [
                'label'     => __( 'Slider Direction', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'horizontal' => __( 'Horizontal', 'grow-monster-addon' ),
                    'vertical'   => __( 'Vertical', 'grow-monster-addon' ),
                ],
                'default'   => 'horizontal',
                'condition' => [
                    'content_type' => 'slideshow',
                ],
            ]
        );

        $this->add_control(
            'slider_autoplay',
            [
                'label'     => __( 'Autoplay Slides?', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Yes', 'grow-monster-addon' ),
                'label_off' => __( 'No', 'grow-monster-addon' ),
                'default'   => '',
                'condition' => [
                    'content_type' => 'slideshow',
                ],
            ]
        );

        $this->add_control(
            'slider_autoplay_speed',
            [
                'label'     => __( 'Autoplay Speed (ms)', 'grow-monster-addon' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3000,
                'condition' => [
                    'content_type' => 'slideshow',
                    'slider_autoplay' => 'yes',
                ],
            ]
        );

        // Show/hide pagination
        $this->add_control(
            'slider_show_pagination',
            [
                'label'     => __( 'Show Pagination', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Yes', 'grow-monster-addon' ),
                'label_off' => __( 'No', 'grow-monster-addon' ),
                'default'   => 'yes',
                'condition' => [
                    'content_type' => 'slideshow',
                ],
            ]
        );

        // Show/hide navigation arrows
        $this->add_control(
            'slider_show_arrows',
            [
                'label'     => __( 'Show Navigation Arrows', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Yes', 'grow-monster-addon' ),
                'label_off' => __( 'No', 'grow-monster-addon' ),
                'default'   => 'yes',
                'condition' => [
                    'content_type' => 'slideshow',
                ],
            ]
        );

        // VIDEO
        $this->add_control(
            'video_source',
            [
                'label'     => __( 'Video Source', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'youtube'     => __( 'YouTube', 'grow-monster-addon' ),
                    'vimeo'       => __( 'Vimeo', 'grow-monster-addon' ),
                    'self_hosted' => __( 'Self-Hosted', 'grow-monster-addon' ),
                ],
                'default'   => 'youtube',
                'condition' => [
                    'content_type' => 'video',
                ],
            ]
        );

        $this->add_control(
            'video_url',
            [
                'label'       => __( 'Video URL', 'grow-monster-addon' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __( 'https://www.youtube.com/watch?v=...', 'grow-monster-addon' ),
                'condition'   => [
                    'content_type' => 'video',
                    'video_source!' => 'self_hosted',
                ],
            ]
        );

        $this->add_control(
            'self_hosted_video',
            [
                'label'     => __( 'Self-Hosted Video File', 'grow-monster-addon' ),
                'type'      => Controls_Manager::MEDIA,
                'media_types' => [ 'video' ],
                'condition' => [
                    'content_type' => 'video',
                    'video_source' => 'self_hosted',
                ],
            ]
        );

        $this->add_control(
            'video_autoplay',
            [
                'label'     => __( 'Autoplay Video?', 'grow-monster-addon' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Yes', 'grow-monster-addon' ),
                'label_off' => __( 'No', 'grow-monster-addon' ),
                'default'   => '',
                'condition' => [
                    'content_type' => 'video',
                ],
            ]
        );

        $this->add_control(
            'video_start_time',
            [
                'label'       => __( 'Start Time (seconds)', 'grow-monster-addon' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 0,
                'description' => __( 'Start playback from this time in seconds.', 'grow-monster-addon' ),
                'condition'   => [
                    'content_type' => 'video',
                ],
            ]
        );

        $this->add_control(
            'video_end_time',
            [
                'label'       => __( 'End Time (seconds)', 'grow-monster-addon' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 0,
                'description' => __( 'Stop playback at this time in seconds (0 means ignore).', 'grow-monster-addon' ),
                'condition'   => [
                    'content_type' => 'video',
                ],
            ]
        );

        // WEBSITE
        $this->add_control(
            'website_url',
            [
                'label'       => __( 'Website URL', 'grow-monster-addon' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __( 'https://example.com', 'grow-monster-addon' ),
                'condition'   => [
                    'content_type' => 'website',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE TAB
         */
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'grow-monster-addon' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Device Frame Width
        $this->add_control(
            'device_frame_width',
            [
                'label'   => __( 'Device Frame Width (px)', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SLIDER,
                'range'   => [
                    'px' => [
                        'min' => 300,
                        'max' => 1200,
                    ],
                ],
                'default' => [
                    'size' => 900,
                ],
            ]
        );

        // Device Frame Height
        $this->add_control(
            'device_frame_height',
            [
                'label'   => __( 'Device Frame Height (px)', 'grow-monster-addon' ),
                'type'    => Controls_Manager::SLIDER,
                'range'   => [
                    'px' => [
                        'min' => 300,
                        'max' => 1200,
                    ],
                ],
                'default' => [
                    'size' => 600,
                ],
            ]
        );

        // Device Frame Alignment
        $this->add_control(
            'device_frame_alignment',
            [
                'label'   => __( 'Alignment', 'grow-monster-addon' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => __( 'Left', 'grow-monster-addon' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'grow-monster-addon' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'grow-monster-addon' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .gma-scrolling-device-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Box Shadow
        $this->add_control(
            'box_shadow',
            [
                'label' => __( 'Box Shadow', 'grow-monster-addon' ),
                'type'  => Controls_Manager::BOX_SHADOW,
                'selectors' => [
                    '{{WRAPPER}} .gma-device-frame' => 'box-shadow: {{HORIZONTAL}} {{VERTICAL}} {{BLUR}} {{SPREAD}} {{COLOR}};',
                ],
            ]
        );

        // Scrolling Area Dimensions
        $this->add_control(
            'scrolling_area_heading',
            [
                'label'     => __( 'Scrolling Area Dimensions', 'grow-monster-addon' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Scrolling Area Width
        $this->add_control(
            'scroll_area_width',
            [
                'label' => __( 'Scrolling Area Width (px)', 'grow-monster-addon' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1200,
                    ],
                ],
                'default' => [
                    'size' => 900,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gma-scrolling-content' => 'width: {{SIZE}}px;',
                ],
            ]
        );

        // Scrolling Area Height
        $this->add_control(
            'scroll_area_height',
            [
                'label' => __( 'Scrolling Area Height (px)', 'grow-monster-addon' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1200,
                    ],
                ],
                'default' => [
                    'size' => 450,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gma-scrolling-content' => 'height: {{SIZE}}px;',
                ],
            ]
        );

        // Inner Content Padding
        $this->add_control(
            'content_padding',
            [
                'label'      => __( 'Content Padding', 'grow-monster-addon' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .gma-scrolling-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Inner Content Margin
        $this->add_control(
            'content_margin',
            [
                'label'      => __( 'Content Margin', 'grow-monster-addon' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .gma-scrolling-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Inner Content Border Radius
        $this->add_control(
            'content_border_radius',
            [
                'label'      => __( 'Content Border Radius', 'grow-monster-addon' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .gma-scrolling-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Inner Content Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'content_border',
                'selector' => '{{WRAPPER}} .gma-scrolling-content',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render the slideshow using Swiper
     */
    private function render_slideshow( $settings ) {
        $slides = $settings['slides'];
        if ( empty( $slides ) ) {
            return '<p>No slides found.</p>';
        }

        $direction        = ! empty( $settings['slider_direction'] ) ? $settings['slider_direction'] : 'horizontal';
        $autoplay_enabled = ( isset( $settings['slider_autoplay'] ) && 'yes' === $settings['slider_autoplay'] );
        $autoplay_speed   = ! empty( $settings['slider_autoplay_speed'] ) ? $settings['slider_autoplay_speed'] : 3000;

        $show_pagination  = ( isset( $settings['slider_show_pagination'] ) && 'yes' === $settings['slider_show_pagination'] );
        $show_arrows      = ( isset( $settings['slider_show_arrows'] ) && 'yes' === $settings['slider_show_arrows'] );

        // Unique ID for this slider
        $unique_id = 'gma-swiper-' . $this->get_id();

        ob_start();
        ?>
        <div id="<?php echo esc_attr( $unique_id ); ?>" class="gma-swiper-container swiper-container"
             data-direction="<?php echo esc_attr( $direction ); ?>"
             data-autoplay="<?php echo $autoplay_enabled ? 'yes' : 'no'; ?>"
             data-speed="<?php echo esc_attr( $autoplay_speed ); ?>"
             data-pagination="<?php echo $show_pagination ? 'yes' : 'no'; ?>"
             data-arrows="<?php echo $show_arrows ? 'yes' : 'no'; ?>"
        >
            <div class="swiper-wrapper">
                <?php foreach ( $slides as $slide ) :
                    $slide_url = isset( $slide['slide_image']['url'] ) ? $slide['slide_image']['url'] : '';
                    ?>
                    <div class="swiper-slide">
                        <?php if ( $slide_url ) : ?>
                            <img src="<?php echo esc_url( $slide_url ); ?>" alt="Slide" style="width: 100%; display:block;" />
                        <?php else : ?>
                            <div style="padding: 20px; background: #ccc; text-align:center;">
                                <?php esc_html_e( 'No image found.', 'grow-monster-addon' ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ( $show_pagination ) : ?>
                <div class="swiper-pagination"></div>
            <?php endif; ?>

            <?php if ( $show_arrows ) : ?>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            <?php endif; ?>
        </div>

        <!-- Inline script to init Swiper -->
        <script>
        document.addEventListener('DOMContentLoaded', function(){
            var container = document.getElementById('<?php echo esc_js( $unique_id ); ?>');
            if(!container) return;

            var direction = container.getAttribute('data-direction') || 'horizontal';
            var autoplay = container.getAttribute('data-autoplay') === 'yes';
            var speed = parseInt(container.getAttribute('data-speed'), 10) || 3000;
            var showPagination = container.getAttribute('data-pagination') === 'yes';
            var showArrows = container.getAttribute('data-arrows') === 'yes';

            new Swiper(container, {
                direction: direction,
                loop: true,
                pagination: showPagination ? {
                    el: container.querySelector('.swiper-pagination'),
                    clickable: true,
                } : false,
                navigation: showArrows ? {
                    nextEl: container.querySelector('.swiper-button-next'),
                    prevEl: container.querySelector('.swiper-button-prev'),
                } : false,
                autoplay: autoplay ? {
                    delay: speed,
                    disableOnInteraction: false,
                } : false,
                // For vertical slides, you might want autoHeight or fixed height
                autoHeight: (direction === 'vertical') ? true : false,
            });
        });
        </script>
        <?php
        return ob_get_clean();
    }

    /**
     * Render video (YouTube, Vimeo, Self-Hosted)
     */
    private function render_video( $settings ) {
        $video_source   = $settings['video_source'];
        $start_time     = ! empty( $settings['video_start_time'] ) ? intval( $settings['video_start_time'] ) : 0;
        $end_time       = ! empty( $settings['video_end_time'] ) ? intval( $settings['video_end_time'] ) : 0;
        $autoplay       = ( isset( $settings['video_autoplay'] ) && 'yes' === $settings['video_autoplay'] );

        ob_start();

        if ( 'self_hosted' === $video_source ) {
            // Self-Hosted
            $file = isset( $settings['self_hosted_video']['url'] ) ? $settings['self_hosted_video']['url'] : '';
            if ( ! $file ) {
                echo '<p>'.esc_html__( 'No self-hosted video file selected.', 'grow-monster-addon' ).'</p>';
            } else {
                $video_id = 'gma-selfhosted-video-' . $this->get_id();
                ?>
                <video 
                    id="<?php echo esc_attr( $video_id ); ?>"
                    width="100%" 
                    height="100%"
                    <?php echo $autoplay ? 'autoplay muted' : ''; ?>
                    controls
                >
                    <source src="<?php echo esc_url( $file ); ?>" type="video/mp4" />
                </video>

                <script>
                (function(){
                    var vid = document.getElementById('<?php echo esc_js( $video_id ); ?>');
                    if(!vid) return;

                    // Start time
                    vid.addEventListener('loadedmetadata', function(){
                        vid.currentTime = <?php echo $start_time; ?>;
                    });

                    // End time
                    <?php if ( $end_time > 0 ) : ?>
                    vid.addEventListener('timeupdate', function(){
                        if(vid.currentTime >= <?php echo $end_time; ?>){
                            vid.pause();
                        }
                    });
                    <?php endif; ?>
                })();
                </script>
                <?php
            }
        }
        else {
            // YouTube or Vimeo
            $video_url = ! empty( $settings['video_url'] ) ? $settings['video_url'] : '';
            if ( ! $video_url ) {
                echo '<p>'.esc_html__( 'No video URL provided.', 'grow-monster-addon' ).'</p>';
            } else {
                $autoplay_param = $autoplay ? '1' : '0';
                
                if ( 'youtube' === $video_source ) {
                    // Transform watch?v=VIDEO_ID -> embed/VIDEO_ID
                    $embed_url = preg_replace('/watch\?v=/', 'embed/', $video_url);
                    // Add start/end
                    $embed_url .= (strpos($embed_url, '?') !== false) ? '&' : '?';
                    $embed_url .= "start={$start_time}";
                    if ( $end_time > 0 ) {
                        $embed_url .= "&end={$end_time}";
                    }
                    // Autoplay & mute
                    $embed_url .= "&autoplay={$autoplay_param}&mute=1";
                }
                else {
                    // Vimeo
                    // https://player.vimeo.com/video/VIDEO_ID
                    $embed_url = str_replace('vimeo.com/', 'player.vimeo.com/video/', $video_url);
                    $embed_url .= (strpos($embed_url, '?') !== false) ? '&' : '?';
                    $embed_url .= "autoplay={$autoplay_param}&muted=1";
                    // Start time as #t=XXs
                    if ( $start_time > 0 ) {
                        $embed_url .= "#t={$start_time}s";
                    }
                }

                $iframe_id = 'gma-video-' . $this->get_id();
                ?>
                <iframe 
                    id="<?php echo esc_attr( $iframe_id ); ?>"
                    src="<?php echo esc_url( $embed_url ); ?>"
                    width="100%"
                    height="100%"
                    frameborder="0"
                    allow="autoplay; fullscreen"
                    allowfullscreen
                ></iframe>

                <?php if ( 'vimeo' === $video_source && $end_time > 0 ) : ?>
                <!-- For Vimeo, handle end time with API -->
                <script src="https://player.vimeo.com/api/player.js"></script>
                <script>
                (function(){
                    var iframe = document.getElementById('<?php echo esc_js( $iframe_id ); ?>');
                    if(!iframe) return;
                    var player = new Vimeo.Player(iframe);
                    
                    player.setCurrentTime(<?php echo $start_time; ?>);
                    player.on('timeupdate', function(data){
                        if(data.seconds >= <?php echo $end_time; ?>){
                            player.pause();
                        }
                    });
                })();
                </script>
                <?php endif; ?>
                <?php
            }
        }

        return ob_get_clean();
    }

    protected function render() {
        $settings         = $this->get_settings_for_display();
        $selected_device  = $settings['selected_device'];
        $content_type     = $settings['content_type'];

        // Device Frame Dimensions
        $frame_width  = ! empty( $settings['device_frame_width']['size'] ) ? intval( $settings['device_frame_width']['size'] ) : 900;
        $frame_height = ! empty( $settings['device_frame_height']['size'] ) ? intval( $settings['device_frame_height']['size'] ) : 600;

        // Device Frame URL
        $device_map = $this->get_device_frames_map();
        $frame_url  = '';
        if ( ! empty( $selected_device ) && isset( $device_map[ $selected_device ] ) ) {
            $frame_url = $device_map[ $selected_device ];
        }

        // Build inner content
        $inner_content_html = '';
        if ( 'image' === $content_type ) {
            $image_url = isset( $settings['scrolling_image']['url'] ) ? $settings['scrolling_image']['url'] : '';
            if ( $image_url ) {
                $inner_content_html = "<img src='{$image_url}' alt='Scrolling Content' style='width: 100%; display:block;' />";
            }
        }
        elseif ( 'slideshow' === $content_type ) {
            // Render Swiper slider
            $inner_content_html = $this->render_slideshow( $settings );
        }
        elseif ( 'video' === $content_type ) {
            $inner_content_html = $this->render_video( $settings );
        }
        elseif ( 'website' === $content_type ) {
            $site_url = ! empty( $settings['website_url'] ) ? $settings['website_url'] : '';
            if ( $site_url ) {
                $inner_content_html = "<iframe src='{$site_url}' width='100%' height='100%' frameborder='0' allowfullscreen></iframe>";
            }
        }

        // If it's a slideshow, remove the scroll bar so the slider can slide
        // Otherwise, keep the vertical scroll for image/video/website
        $overflow_style = ( 'slideshow' === $content_type ) ? 'overflow: hidden;' : 'overflow-y: auto;';

        ?>
        <div class="gma-scrolling-device-wrapper">
            <div class="gma-device-frame"
                style="
                    width: <?php echo esc_attr( $frame_width ); ?>px;
                    height: <?php echo esc_attr( $frame_height ); ?>px;
                    position: relative;
                    margin: 0 auto;
                    overflow: hidden;
                ">
                
                <!-- Device Frame -->
                <?php if ( $frame_url ) : ?>
                    <img src="<?php echo esc_url( $frame_url ); ?>" alt="Device Frame"
                         class="gma-frame-img"
                         style="width:100%; display:block;" />
                <?php else : ?>
                    <div style="text-align:center; padding:20px; background:#eee;">
                        <?php esc_html_e( 'Please select a device.', 'grow-monster-addon' ); ?>
                    </div>
                <?php endif; ?>

                <!-- Scrolling Content Container -->
                <div class="gma-scrolling-content"
                     style="
                         position: absolute;
                         top: 50%;
                         left: 50%;
                         transform: translate(-50%, -50%);
                         <?php echo $overflow_style; ?>
                         display: block;
                     ">
                    <?php echo $inner_content_html; ?>
                </div>
            </div>
        </div>
        <?php
    }

    protected function _content_template() {}
}
