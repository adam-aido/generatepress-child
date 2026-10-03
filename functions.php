<?php
/**
 * GeneratePress Child Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package generatepress-child
 */

/**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'webartisan_parent_theme_enqueue_styles' );
function webartisan_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'generatepress-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'generatepress-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'generatepress-style' ]
	);
}

/**
 * Custom logo link on login page (login.php)
 */
add_filter( 'login_headerurl', 'webartisan_loginlogo_url' );
function webartisan_loginlogo_url($url)
{
  return home_url();
}


/**
 * Configure WordPress to use SMTP for sending emails
 */
add_action( 'phpmailer_init', 'webartisan_mailer' );
function webartisan_mailer( $phpmailer ) {
    if ( ! defined( 'SMTP_HOST' ) || empty( SMTP_HOST ) ) {
        return;
    }

    $phpmailer->isSMTP();
    $phpmailer->Host       = SMTP_HOST;
    $phpmailer->Port       = defined( 'SMTP_PORT' ) ? SMTP_PORT : 587;
    $phpmailer->SMTPSecure = defined( 'SMTP_SECURE' ) ? SMTP_SECURE : 'tls';

    if ( defined( 'SMTP_AUTH' ) && SMTP_AUTH ) {
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = defined( 'SMTP_USER' ) ? SMTP_USER : '';
        $phpmailer->Password = defined( 'SMTP_PASS' ) ? SMTP_PASS : '';
    }

    if ( defined( 'SMTP_REPLYTO' ) && SMTP_REPLYTO ) {
        $phpmailer->addReplyTo(
            SMTP_REPLYTO,
            defined( 'SMTP_REPLYTO_NAME' ) ? SMTP_REPLYTO_NAME : ''
        );
    }
}

/**
 * Set the From email address
 */
add_filter( 'wp_mail_from', 'webartisan_mail_from' );
function webartisan_mail_from( $from ) {
    if ( defined( 'SMTP_FROM' ) && SMTP_FROM ) {
        return SMTP_FROM;
    }
    return $from;
}

/**
 * Set the From name
 */
add_filter( 'wp_mail_from_name', 'webartisan_mail_from_name' );
function webartisan_mail_from_name( $name ) {
    if ( defined( 'SMTP_NAME' ) && SMTP_NAME ) {
        return SMTP_NAME;
    }
    return $name;
}


/**
 * Set GeneratePress to use latin-ext subset for Google Fonts
 */
add_filter( 'generate_fonts_subset', 'webartisan_set_latin_ext_fonts_subset' );
function webartisan_set_latin_ext_fonts_subset()
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


