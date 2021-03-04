<?php
/*
Plugin Name: Posts To QR Code
Plugin URI: http://post-to-qrcode.com
Description: Show QR Code under the post
Version: 1.0.0
Author: Hasinur Rahman
Author URI:  http://hasinur.me
License: GPLv2 or later
Text Domain:  post-to-qrcode
*/

/**
 * POST_TO_QRCODE Class
 */
final class POST_TO_QRCODE {
    /**
     * Initialize
     */
    public function __construct() {
        $this->includes();

        $this->init_classes();

        add_filter( 'the_content', [ $this, 'show_qrcode' ] );

        add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );
    }

    /**
     * Includes all requied files
     *
     * @return void
     */
    public function includes() {
        require_once dirname( __FILE__ ) . '/vendor/autoload.php';
    }

    /**
     * Instantiate all classes
     *
     * @return void
     */
    public function init_classes() {
        new PQRC\Admin\Settings();
    }
    /**
     * Instantiate the class
     *
     * @return object
     */
    public static function instance() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new POST_TO_QRCODE();
        }

        return $instance;
    }

    /**
     * Load textdomain
     *
     * @return void
     */
    public function load_textdomain() {
        load_textdomain( 'post-to-qrcode', false, dirname( __FILE__ ) . '/laguages' );
    }

    /**
     * Show qrcode under the post
     *
     * @param string $content
     * 
     * @return string
     */
    public function show_qrcode( $content ) {
        $current_post_id   = get_the_ID();
        $post_title        = get_the_title( $current_post_id );
        $current_post_ink  = urlencode( get_permalink( $current_post_id ) );
        $current_post_type = get_post_type( $current_post_id );

        /**
         * Post Type Check
         */
        $excluded_post_types = apply_filters( 'pqrc_excluded_post_types', [] );

        if ( in_array( $current_post_type, $excluded_post_types ) ) {
            return $content;
        }

        /**
         * Dimension Hook
         */
        $width  = get_option('pqrc_width') ?: 180 ;
        $height = get_option('pqrc_height') ?: 180;

        $dimension = apply_filters( 'pqrc_qrcode_dimension', "{$width}x{$height}" );

        $image_src        = sprintf( 'https://api.qrserver.com/v1/create-qr-code/?size=%s&data=%s', $dimension, $current_post_ink );
        $content          .= sprintf( '<div class="qrcode"><img src="%s" alt="%s"></div>', $image_src, $post_title );

        return $content;
    }
}

POST_TO_QRCODE::instance();