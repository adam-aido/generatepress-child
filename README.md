# GeneratePress Child

This is a simple scaffold of GeneratePress child theme containing most common snippets and corrections.

## Installation

Go to your themes folder

```bash
$ cd wp-content/themes
```

Clone this repo with following command:

```bash
$ git clone https://github.com/adam-aido/generatepress-child.git
```

And activate it with wp-cli:

```bash
$ wp theme activate generatepress-child
```

### SMTP Configuration

There is a method forcing PHP Mailer to use SMTP in `functions.php`. I use this method to increase email notifications deliverability and avoid installing third party SMTP plugins. To make it work add custom constants to your `wp-config.php` file in your WordPress root folder:

```php
define( 'SMTP_USER', 'user@example.com' );
define( 'SMTP_PASS', 'a-password' );
define( 'SMTP_HOST', 'smtp.example.com' );
define( 'SMTP_FROM', 'user@example.com' );
define( 'SMTP_NAME', 'A user' );
define( 'SMTP_PORT', '587' );
define( 'SMTP_SECURE', 'tls' );
define( 'SMTP_AUTH', true );
```
