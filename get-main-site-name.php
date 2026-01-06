<?php
/**
 * Plugin Name: Get Main Site Name
 * Plugin URI:  https://curtistinkers.com/
 * Description: Helper function to get the main site's name in a WordPress Multisite setup.
 * Version:     0.1.0
 * Author:      curtistinkers
 * Author URI:  https://curtistinkers.com/
 * Text Domain: get-main-site-name
 * 
 * @package GetMainSiteName
 * @author curtistinkers (https://curtistinkers.com)
 * @copyright 2023 curtistinkers
 * @license MIT
 * @since 1.0.0
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'get_main_site_name_helper' ) ) {
    /**
     * Get the main site's name (multisite-aware).
     *
     * - If not multisite, returns current site name.
     * - If multisite, attempts to get the network's primary site name.
     *
     * @return string
     */
    function get_main_site_name_helper() {
        if ( ! function_exists( 'get_bloginfo' ) ) {
            return '';
        }

        if ( ! is_multisite() ) {
            return get_bloginfo( 'name' );
        }

        $main_site_id = SITE_ID_CURRENT_SITE ?? 1;
        if ( function_exists( 'get_network' ) ) {
            $network = get_network();
            if ( $network && isset( $network->site_id ) ) {
                $main_site_id = (int) $network->site_id;
            }
        }

        if ( function_exists( 'get_blog_details' ) ) {
            $details = get_blog_details( $main_site_id );
            if ( $details && ! empty( $details->blogname ) ) {
                return $details->blogname;
            }
        }

        if ( function_exists( 'switch_to_blog' ) ) {
            switch_to_blog( $main_site_id );
            $name = get_bloginfo( 'name' );
            restore_current_blog();
            return $name;
        }

        return get_bloginfo( 'name' );
    }
}
