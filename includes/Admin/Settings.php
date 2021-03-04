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
            [ $this, 'add_width' ],
            'general',
            'pqrc_section'  
        );

        add_settings_field(
            'pqrc_height',
            __( 'QR Code Height', 'post-to-qrcde' ),
            [ $this, 'add_heitght' ],
            'general',
            'pqrc_section'
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
     * Width field
     *
     * @return void
     */
    public function add_width() {
        $width = get_option('pqrc_width');
        printf( '<input type="text" name="pqrc_width" id="pqrc_width" class="regular-text" value="%s"/>', $width );
    }

    /**
     * Height field
     *
     * @return void
     */
    public function add_heitght() {
        $height = get_option('pqrc_height');
        printf( '<input type="text" name="pqrc_height" id="pqrc_height" class="regular-text" value="%s"/>', $height );
    }

}