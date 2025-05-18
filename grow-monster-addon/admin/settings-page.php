<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Add a menu item in the WordPress dashboard.
function gma_add_admin_menu() {
    add_menu_page(
        __( 'Grow Monster Addon Settings', 'grow-monster-addon' ),
        __( 'Grow Monster Addon', 'grow-monster-addon' ),
        'manage_options',
        'gma-settings',
        'gma_render_settings_page',
        'dashicons-admin-generic'
    );
}
add_action( 'admin_menu', 'gma_add_admin_menu' );

function gma_render_settings_page() {
    // Save settings if form submitted.
    if ( isset( $_POST['gma_settings_nonce'] ) && wp_verify_nonce( $_POST['gma_settings_nonce'], 'gma_save_settings' ) ) {

        // Save the "Enable All" checkbox.
        $enable_all_widgets = isset( $_POST['gma_enable_all_widgets'] ) ? 1 : 0;
        update_option( 'gma_enable_all_widgets', $enable_all_widgets );

        // Only store individual widget selections if "Enable All" is not checked.
        $enabled_widgets = [];
        if ( ! $enable_all_widgets && isset( $_POST['enabled_widgets'] ) ) {
            foreach ( $_POST['enabled_widgets'] as $widget ) {
                $enabled_widgets[] = sanitize_text_field( $widget );
            }
        }
        update_option( 'gma_enabled_widgets', $enabled_widgets );

        echo '<div class="updated"><p>' . __( 'Settings saved.', 'grow-monster-addon' ) . '</p></div>';
    }

    // Retrieve saved settings.
    $enable_all_widgets = get_option( 'gma_enable_all_widgets', 0 );
    $enabled_widgets    = get_option( 'gma_enabled_widgets', [] );

    // Define available widgets including the new Creative Heading widget.
    $available_widgets = [
        'grow_monster_button'             => __( 'Grow Monster Button', 'grow-monster-addon' ),
        'grow_monster_scrolling_device'   => __( 'Grow Monster Scrolling Device', 'grow-monster-addon' ),
        'grow_monster_creative_heading'   => __( 'Grow Monster Creative Heading', 'grow-monster-addon' ),
        'grow_monster_creative_accordion' => __( 'Grow Monster Creative Accordion', 'grow-monster-addon'),
        // Add more widget keys => labels as needed.
    ];
    ?>
    <div class="wrap">
        <h1><?php _e( 'Grow Monster Addon Settings', 'grow-monster-addon' ); ?></h1>
        <form method="post" action="">
            <?php wp_nonce_field( 'gma_save_settings', 'gma_settings_nonce' ); ?>

            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e( 'Enable All Widgets', 'grow-monster-addon' ); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="gma_enable_all_widgets" value="1" <?php checked( $enable_all_widgets, 1 ); ?> />
                            <?php _e( 'Enable all widgets at once', 'grow-monster-addon' ); ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Enable Widgets Individually', 'grow-monster-addon' ); ?></th>
                    <td>
                        <p style="margin-bottom: 8px;">
                            <?php _e( 'Select the widgets you want to enable. This will be ignored if "Enable All" is checked.', 'grow-monster-addon' ); ?>
                        </p>
                        <?php foreach ( $available_widgets as $key => $label ) : ?>
                            <label style="display: block; margin-bottom: 6px;">
                                <input type="checkbox" name="enabled_widgets[]" value="<?php echo esc_attr( $key ); ?>"
                                    <?php checked( in_array( $key, $enabled_widgets ) ); ?>
                                    <?php disabled( $enable_all_widgets, 1 ); ?> />
                                <?php echo esc_html( $label ); ?>
                            </label>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
