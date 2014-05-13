<?php
/**
 * DMC User Profiles
 *
 * Extends WordPress user profiles and displays as a profile box.
 *
 * @package   DMC_User_Profiles
 * @author    David McDonald <info@davidmcdonald.org>
 * @license   GPL-2.0+
 * @link      https://github.com/davemac/dmc-user-profiles
 * @copyright 2014 David McDonald
 *
 * @wordpress-plugin
 * Plugin Name:       DMC User Profiles
 * Plugin URI:        https://github.com/davemac/dmc-user-profiles
 * Description:       Extends WordPress user profiles and displays as a profile box.
 * Version:           0.0.8
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

if( ! class_exists('Acf') )
{
    define( 'ACF_LITE' , true );
    include_once( plugin_dir_path( __FILE__ ) . 'includes/advanced-custom-fields/acf.php');
}

if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_dmc-user-profiles',
        'title' => 'DMC User Profiles',
        'fields' => array (
            array (
                'key' => 'field_535de8b0f82b7',
                'label' => 'Hide User Profile?',
                'name' => 'dmc_hide_user_profile',
                'type' => 'true_false',
                'instructions' => 'Check this box to hide the user profile box for this user.',
                'message' => 'Hide the User Profile for this user',
                'default_value' => 0,
            ),
            array (
                'key' => 'field_53717ba38da0f',
                'label' => 'Custom User Image',
                'name' => 'dmc_custom_user_image',
                'type' => 'image',
                'instructions' => 'By default, if the user has a Gravatar profile, their Gravatar image will be shown in their user profile. You can override this by uploading a custom user image here.',
                'save_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'ef_user',
                    'operator' => '==',
                    'value' => 'all',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ));
}

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

    $output = '';
    $author_id = get_the_author_meta( 'ID' );
    $author_url = get_the_author_meta( 'user_url' );
    $author_name = get_the_author();

    if( !get_field('dmc_hide_user_profile', 'user_' . $author_id) ) { 
        the_field('dmc_hide_user_profile', 'user_' . $author_id);
    
        // if( !is_singular( 'post' ))
        //     return $content;
        
        // Author bio box
        $output = '<div class="author-bio highlight">';
        $output .= '<div class="the-author-info">';
        
        if( get_field('dmc_custom_user_image', 'user_' . $author_id ) ) : 
                        
           $output .= '<a href="' . get_author_posts_url( $author_id ) . '"><img src="' . get_field('dmc_custom_user_image', 'user_' . $author_id ) . '" alt="' . $author_name . '" title="' . $author_name . '" width="90" class="alignright" /></a>';
        else : 
            $avatar = get_avatar( $author_id, '90' );
            $output .= '<div class="author-avatar">' . $avatar . "</div>";
       endif; 
     
        if( $twitter = get_the_author_meta( 'twitter' )) {
            $output .= '<a href="http://twitter.com/' . $twitter . '" class="right"><span class="icon-twitter small"></span></a>';
        } 
        if ( $linkedin = get_the_author_meta( 'linkedin' )) {
            $output .= '<a href="' . $linkedin . '" class="right"><span class="icon-linkedin small"></span></a>';
        }
        if( $author_url ) {
            $output .= '<h3><a href="' . $author_url . '">' . $author_name . '</a></h3>';
        } else {
            $output .= '<h3>' . $author_name . '</h3>';
        }
        
        $output .= '<p>' . get_the_author_meta( 'description' ) . '</p>';
        $output .= '<div class="post-meta">';
        if ( $phone = get_the_author_meta( 'phone' )) {
            $output .= '<span>Phone: ' . $phone .'</span> &nbsp;';
        }
        if ( $mobile = get_the_author_meta( 'mobile' )) {
            $output .= '<span> Mobile: ' . $mobile .'</span>';
        }
        if( $author_url ) {
             $output .= '<span class="right"><a href="' . $author_url . '">' . $author_name .'s website</a></span>';
        }
        $output .= '<span class="right"><a href="' . get_author_posts_url( $author_id ) . '">More articles by ' . get_the_author() . '</a></span>';

        $output .= '</div>';

        $output .= '</div>';
        $output .= '</div>';
    
        return $output;
    }
 }

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
