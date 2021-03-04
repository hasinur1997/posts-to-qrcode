<?php 
namespace PQRC\Admin;

/**
 * Class Settings
 */
class Settings {
    /**
     * Initialize
     */
    public function __construct() {
        add_action( 'admin_init', [ $this, 'add_settings'] );
    }

    /**
     * Add settings for the admin
     *
     * @return void
     */
    public function add_settings() {

        add_settings_section( 
            'pqrc_section',
            __( 'Posts to QR Code', 'post-to-qrcode' ), 
            [ $this, 'add_section' ],
            'general' 
        );

        add_settings_field( 
            'pqrc_width', 
            __( 'QR Code Width', 'post-to-qrcode' ), 
            [ $this, 'display_field' ],
            'general',
            'pqrc_section',
            ['pqrc_width']  
        );

        add_settings_field(
            'pqrc_height',
            __( 'QR Code Height', 'post-to-qrcde' ),
            [ $this, 'display_field' ],
            'general',
            'pqrc_section',
            ['pqrc_height']
        );

        register_setting( 'general', 'pqrc_width', [ 'sanitize_callback' => 'esc_attr' ] );
        register_setting( 'general', 'pqrc_height', [ 'sanitize_callback' => 'esc_attr' ] );
    }

    /**
     * Add settings section
     *
     * @return void
     */
    public function add_section() {
        printf( '<p>%s</p>', __('Settings for QR Code Plugin', 'post-to-qrcde') );
    }

    /**
     * Display field
     *
     * @return void
     */
    public function display_field( $args ) {
        $option = get_option( $args[0] );
        printf( '<input type="text" name="%s" id="%s" class="regular-text" value="%s"/>', $option, $option, $option );
    }
}