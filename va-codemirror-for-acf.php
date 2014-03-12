<?php
defined('ABSPATH') or die();
/*
Plugin Name: VA CodeMirror for ACF
Description: CodeMirror to textarea filled for Advanced Custom Fields.
Version: 1.0.0
Plugin URI: http://visualive.jp/wordpress/plugins/va_codemirroe_cssmode_for_acf/
Author: KUCKLU
Author URI: http://visualive.jp/
License: GPLv2
Text Domain: vashacf
Domain Path: /languages
*/
$vacmcaf_data = get_file_data( __FILE__, array('ver' => 'Version', 'langs' => 'Domain Path') );
define('VACMACF_URL',  plugins_url('', __FILE__));
define('VACMACF_PATH', dirname(__FILE__));
define('VACMACF_VARSION', $vacmcaf_data['ver']);
define('VACMACF_LANGS', $vacmcaf_data['langs']);
define('VACMACF_THEME', 'visualive');

if ( class_exists( 'acf_field' ) AND ! class_exists( 'VA_CodeMirror_For_ACF' ) ) :
class VA_CodeMirror_For_ACF {
	private $version = '';
	private $langs   = '';

	function __construct() {
		// set data
		$this->version = VACMACF_VARSION;
		$this->langs   = VACMACF_LANGS;
		// set text domain
		load_textdomain('vashacf', $this->langs . '/vashacf-' . get_locale() . '.mo');
		// includes
		$this->include_before_theme();
		add_action( 'admin_enqueue_scripts', array($this, 'vacmacf_scripts') );
	}

	function include_before_theme() {
		// admin only includes
		if( is_admin() ) {
			include_once( VACMACF_PATH . '/include/va-codemirror-mixedmode-for-acf.php' );
			include_once( VACMACF_PATH . '/include/va-codemirror-htmlmode-for-acf.php' );
			include_once( VACMACF_PATH . '/include/va-codemirror-cssmode-for-acf.php' );
			include_once( VACMACF_PATH . '/include/va-codemirror-jsmode-for-acf.php' );
		}
	}

	function vacmacf_scripts() {
		wp_enqueue_style('source-code-pro', '//fonts.googleapis.com/css?family=Source+Code+Pro:200,300,400,500,600,700,900', array(), $this->version, 'all' );
	}
}
new VA_CodeMirror_For_ACF();
endif;
