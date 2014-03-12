<?php
defined('ABSPATH') or die();
/*
Plugin Name: VA CodeEditor for ACF
Description: CodeMirror and Emmet to textarea filled for Advanced Custom Fields.
Version: 1.0.0
Plugin URI: http://visualive.jp/wordpress/plugins/va_codemirroe_cssmode_for_acf/
Author: KUCKLU
Author URI: http://visualive.jp/
License: GPLv2
Text Domain: vaceacf
Domain Path: /languages
*/
$vaceacf_data = get_file_data( __FILE__, array('ver' => 'Version', 'langs' => 'Domain Path') );
define('VACEACF_URL',  plugins_url('', __FILE__));
define('VACEACF_PATH', dirname(__FILE__));
define('VACEACF_VARSION', $vaceacf_data['ver']);
define('VACEACF_LANGS', $vaceacf_data['langs']);
define('VACEACF_THEME', 'visualive');

if ( class_exists( 'acf_field' ) AND ! class_exists( 'va_codeeditor_for_acf' ) ) :
class va_codeeditor_for_acf {
	private $version = '';
	private $langs   = '';

	function __construct() {
		// set data
		$this->version = VACEACF_VARSION;
		$this->langs   = VACEACF_LANGS;
		// set text domain
		load_textdomain('vaceacf', $this->langs . '/vaceacf-' . get_locale() . '.mo');
		// includes
		$this->include_before_theme();
		add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );
	}

	function include_before_theme() {
		// admin only includes
		if( is_admin() ) {
			include_once( VACEACF_PATH . '/include/editor-mixedmode.php' );
			include_once( VACEACF_PATH . '/include/editor-htmlmode.php' );
			include_once( VACEACF_PATH . '/include/editor-cssmode.php' );
			include_once( VACEACF_PATH . '/include/editor-jsmode.php' );
		}
	}

	function admin_enqueue_scripts() {
		wp_enqueue_style('source-code-pro', '//fonts.googleapis.com/css?family=Source+Code+Pro:200,300,400,500,600,700,900', array(), $this->version, 'all' );
	}
}
new va_codeeditor_for_acf();
endif;
