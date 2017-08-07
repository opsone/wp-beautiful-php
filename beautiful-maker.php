<?php

if ( ! defined( 'WP_CLI' ) ) return;

class WP_Beautiful_Command extends WP_CLI_Command {

    private static $_php_fixer_bin;

    private static $_config;

    private static $_php_fixer_options;

    public function __construct() {
        if (file_exists(__DIR__ . '/../../autoload.php')) {
            self::$_php_fixer_bin = dirname(__FILE__) . "/../../bin/php-cs-fixer";
        } else {
            self::$_php_fixer_bin = dirname(__FILE__) . "/vendor/bin/php-cs-fixer";
        }

        self::$_config            = new StdClass();
        self::$_php_fixer_options = array(
            '--verbose',
            '--show-progress=estimating',
            '--config=' . dirname(__FILE__) . '/config.php'
        );
    }

    public function php( $args, $assoc_args ) {
        $args = self::sanitize_args( __FUNCTION__, $args, $assoc_args );

        if(!empty(self::$_config->what)) {
            call_user_func( __CLASS__ . "::php_" . self::$_config->what );
        }
    }

    private static function php_core() {
        $path_to_fix = ABSPATH;
        shell_exec(self::$_php_fixer_bin . " fix " . $path_to_fix . ' ' . implode(' ', self::$_php_fixer_options));
    }

    private static function php_themes() {
        $path_to_fix = ABSPATH . "/wp-content/themes/";

        if( empty(self::$_config->themename)) {
            shell_exec(self::$_php_fixer_bin . " fix " . $path_to_fix . ' ' . implode(' ', self::$_php_fixer_options));
        } else {
            shell_exec(self::$_php_fixer_bin . " fix " . $path_to_fix . '/' . self::$_config->themename . ' ' . implode(' ', self::$_php_fixer_options));
        }
    }

    private static function sanitize_args( $command, $args, $assoc_args = null ) {
        $what_param      = "what";
        $themename_param = "themename";

        $what = '';
        if ( isset( $assoc_args[$what_param] ) ) {
            $what = $assoc_args[$what_param];
            $themename = $assoc_args[$themename_param];

            if ( method_exists( __CLASS__, "{$command}_{$what}" ) ) {
                self::$_config->what = $what;
            } else {
                WP_Cli::error( "Using unknown '$what' parameter for --what argument." );
            }

            if( is_dir(ABSPATH . "/wp-content/themes/" . $themename) ) {
                self::$_config->themename = $themename;
            } else {
                WP_Cli::error( "Theme '$themename' was not found in your Wordpress install." );
            }
        }
    }
}

WP_CLI::add_command( 'beautiful', 'WP_Beautiful_Command' );
