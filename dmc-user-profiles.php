<?php
/**
 * DMC User Profiles
 *
 * Extends WordPress user profiles and displays as a profile box
 *
 * @package   DMC_User_Profiles
 * @author    David McDonald <info@davidmcdonald.org>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins
 * @copyright 2014 David McDonald
 *
 * @wordpress-plugin
 * Plugin Name:       DMC User Profiles
 * Plugin URI:        http://wordpress.org/plugins
 * Description:       Extends WordPress user profiles and displays as a profile box
 * Version:           0.0.2
 * Author:            David McDonald
 * Author URI:        http://www.dmcweb.com.au
 * Text Domain:       dmc-user-profiles
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/davemac/dmc-user-profiles
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-dmc-user-profiles.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'DMC_User_Profiles', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'DMC_User_Profiles', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'DMC_User_Profiles', 'get_instance' ) );

// Remove obsolete user fields and add new fields
function dmc_new_contactmethods( $contactmethods ) {

// Remove these
// unset($contactmethods['aim']);
// unset($contactmethods['yim']);
// unset($contactmethods['jabber']);
// unset($contactmethods['description']);

// Add Twitter & LinkedIn
$contactmethods['twitter'] = 'Twitter handle (no @)';
$contactmethods['linkedin'] = 'LinkedIn';
$contactmethods['phone'] = 'Phone';
$contactmethods['mobile'] = 'Mobile';

    return $contactmethods;
}
add_filter( 'user_contactmethods', 'dmc_new_contactmethods', 10, 1 );

//  Add bio box to posts
function dmc_user_profile_box() {
    
    // if( !is_singular( 'post' ))
    //     return $content;
    
    $id = get_the_author_meta( 'ID' );
    $output = '';
    if ( $id == 5 || $id== 7 ) {

        // Author bio box
        $output = '<div class="author-bio highlight">';
        $output .= '<div class="the-author-info">';
            $avatar = get_avatar( $id, '90' );
                $output .= '<div class="author-avatar">' . $avatar . "</div>";
         
            if( $twitter = get_the_author_meta( 'twitter' )) {
                $output .= '<a href="http://twitter.com/' . $twitter . '" class="right"><span class="icon-twitter small"></span></a>';
            } 
            if ( $linkedin = get_the_author_meta( 'linkedin' )) {
                $output .= '<a href="' . $linkedin . '" class="right"><span class="icon-linkedin small"></span></a>';
            }
            if( $url = get_the_author_meta( 'user_url' )) {
                $output .= '<h3><a href="' . $url . '">' . get_the_author() . '</a></h3>';
            } else {
                $output .= '<h3>' . get_the_author() . '</h3>';
            }
            
            $output .= '<p>' . get_the_author_meta( 'description' ) . '</p>';
            $output .= '<div class="post-meta">';
            if ( $phone = get_the_author_meta( 'phone' )) {
                $output .= '<span>Phone: ' . $phone .'</span> &nbsp;';
            }
            if ( $mobile = get_the_author_meta( 'mobile' )) {
                $output .= '<span> Mobile: ' . $mobile .'</span>';
            }
            $output .= '<span class="right"><a href="' . get_author_posts_url( $id ) . '">More articles by ' . get_the_author() . '</a></span>';
            $output .= '</div>';

        $output .= '</div>';
        $output .= '</div>';
     }
        return $output;
   
 }
 // add_filter( 'the_content', 'dmc_post_user_profile' );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-dmc-user-profiles-admin.php' );
	add_action( 'plugins_loaded', array( 'DMC_User_Profiles_Admin', 'get_instance' ) );

}
