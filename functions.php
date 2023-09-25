<?php
/**
 * GeneratePress Child Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package generatepress-child
 */

/*
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php') ) {
  // TODO: import file with WooCommerce specific snipets
}
*/

/**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'adamant_parent_theme_enqueue_styles' );
function adamant_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'generatepress-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'generatepress-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'generatepress-style' ]
	);
}


/**
 * Custom logo on login page (login.php) – uses a logo set in theme customizer
 */
add_action( 'login_enqueue_scripts', 'adamant_login_logo' );
function adamant_login_logo() { ?>
    <style type="text/css">
        body.login h1 a {
            background-image: url(<?php echo esc_url( wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) ); ?>);
        }
    </style>
<?php }


/**
 * Custom logo link on login page (login.php)
 */
add_filter( 'login_headerurl', 'adamant_loginlogo_url' );
function adamant_loginlogo_url($url)
{
  return home_url();
}


/**
 * Set PHP Mailer to use SMTP with credentials provided in wp-config.php
 */
add_action( 'phpmailer_init', 'adamant_mailer' );
function adamant_mailer( $phpmailer ) {
	if(defined('SMTP_HOST')) {
		$phpmailer->isSMTP();
		$phpmailer->Host = SMTP_HOST;
		$phpmailer->SMTPAuth = SMTP_AUTH;
		$phpmailer->Port = SMTP_PORT;
		$phpmailer->Username = SMTP_USER;
		$phpmailer->Password = SMTP_PASS;
		$phpmailer->SMTPSecure = SMTP_SECURE;
		$phpmailer->From = SMTP_FROM;
		$phpmailer->FromName = SMTP_NAME;
		$phpmailer->AddReplyTo( SMTP_REPLYTO, SMTP_REPLYTO_NAME );
	}
}

/**
 * Set GeneratePress to use latin-ext subset for Google Fonts
 */
add_filter( 'generate_fonts_subset', 'adamant_set_latin_ext_fonts_subset' );
function adamant_set_latin_ext_fonts_subset()
{
    return 'latin-ext';
}

/**
 * Script for activating GeneratePress Premium
 */
add_filter( 'pre_http_request', function( $pre, $args, $url ) {
    if ( 'https://generatepress.com' === $url || 'https://generatepress.com/' === $url ) {
        return wp_remote_post(
            'https://api.generatepress.com',
                array(
                    'timeout' => $args['timeout'],
                    'sslverify' => $args['sslverify'],
                    'body' => $args['body'],
                )
        );
    }

    return $pre;
}, 10, 3 );
