<?php
/**
 * Jetpack CRM Elba
 *
 * @package           jetpackcrm-elba
 * @author            Иван Никитин
 * @copyright         2022 IvanNikitin.com
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Jetpack CRM Elba
 * Plugin URI:        https://github.com/ivannikitin-com/jetpackcrm-elba
 * Description:       Интеграция Jetpack CRM с Эльба.Контур (загрузка счетов Эльбы)
 * Version:           1.0
 * Requires at least: 5.9
 * Requires PHP:      7.4
 * Author:            Иван Никитин
 * Author URI:        https://ivannikitin.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/ivannikitin-com/jetpackcrm-elba/releases
 * Text Domain:       jetpackcrm-elba
 * Domain Path:       /lang
 */

/* Напрямую не вызываем! */
defined( 'ABSPATH' ) or die( 'Bad Request' );

/* Глобальные константы плагина */
define( 'JCRM_ELBA', 'jetpackcrm_elba' );	      // Text Domain
define( 'JCRM_ELBA_DIR', dirname( __FILE__ ) );	  // Папка плагина
define( 'JCRM_ELBA_URL', plugin_dir_url( __FILE__ ) );	  // Папка плагина

// Регистрация расширения
add_filter( 'jpcrm_register_free_extensions', function( $exts ) {
    $exts[ JCRM_ELBA ] = array(
        'name'       => __( 'Контур.Эльба', JCRM_ELBA ),
        'i'          => 'elba-logo.png',
        'short_desc' => __( 'Интеграция Jetpack CRM с Контур.Эльба (загрузка счетов Эльбы)', JCRM_ELBA ),
    );
    return $exts;
} );

// Корректирует URL элементов расширения
add_filter( 'plugins_url', function( $url, $path, $plugin ) {
    if ( ZBS_ROOTFILE == $plugin ) {
        if ( 'i/elba-logo.png' == $path ) $url = JCRM_ELBA_URL . 'assets/' . $path;
    }
    return $url;
}, 10, 3 );

// Функции инсталляции/деинсталляции, чтобы расширение можно было включать и выключать
add_action( 'plugins_loaded', function() {
    global $zeroBSCRM_extensionsCompleteList;
    $zeroBSCRM_extensionsCompleteList[ JCRM_ELBA ] = array(
        'fallbackname' => __( 'Контур.Эльба', JCRM_ELBA ),
        'imgstr'       => '<i class="fa fa-keyboard-o" aria-hidden="true"></i>',
        'desc'         => __( 'Интеграция Jetpack CRM с Контур.Эльба (загрузка счетов Эльбы)', JCRM_ELBA ),
        // 'url' => 'https://jetpackcrm.com/feature/',
        'colour'       => 'rgb(126, 88, 232)',
        'helpurl'      => 'https://github.com/ivannikitin-com/jetpackcrm-elba',
        'shortname'    => __( 'Интеграция Jetpack CRM с Контур.Эльба', JCRM_ELBA ), // used where long name won't fit
    );

    global $jpcrm_core_extension_setting_map;
    $jpcrm_core_extension_setting_map[ JCRM_ELBA ] = JCRM_ELBA;
} );

// Функции инсталляции/деинсталляции
function zeroBSCRM_extension_install_jetpackcrm_elba() {
	return jpcrm_install_core_extension( JCRM_ELBA );
}

function zeroBSCRM_extension_uninstall_jetpackcrm_elba() {
	return jpcrm_uninstall_core_extension( JCRM_ELBA );
}

// Запуск расширения
add_action( 'jpcrm_load_modules', function() {
	global $zbs;
	if ( zeroBSCRM_isExtensionInstalled( JCRM_ELBA ) ) {
        /* Классы */
        //require_once( JCRM_ELBA_DIR . '/classes/plugin.php' );
        //require_once( JCRM_ELBA_DIR . '/classes/ui.php' );

        // Запуск
        //\JCRM_ELBA\Plugin::get_instance();
	}    
} );