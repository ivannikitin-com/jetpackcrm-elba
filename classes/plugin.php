<?php 
/**
 * Основной класс плагина
 * Реализован как Singleton, чтобы получать доступ к нему из любого места
 * 
 * @package           jetpackcrm-elba
 * @author            Иван Никитин
 * @copyright         2022 IvanNikitin.com
 * @license           GPL-3.0-or-later
 */
namespace JCRM_ELBA;

class Plugin {
    /**
     * Экземпляр класса
     */
     protected static $_instance;
 
    /**
     * Возвращает экземпляр класса
     */
    public static function get_instance() {
       if (self::$_instance === null) {
          self::$_instance = new self;  
       }
 
       return self::$_instance;
    }


    /**
     * Интерфейс плагина
     * @var UI
     */
    private $ui;

   /**
    * Конструктор класса
    */
    private function __construct() {
        // Интерфейс плагина
        // $this->ui = new UI();

        // Регистрируем расширение
        add_filter( 'jpcrm_register_free_extensions', array( $this, 'register_extension' ) );

        // Корректирует URL элементов расширения
        add_filter( 'plugins_url', array( $this, 'plugins_url' ), 10, 3 );

        // Остальная работа по регистрации расширения
        add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
    }

    /**
     * Метод регистрирует расширение
     * @param mixed $exts   Массив расширений
     */
    public function register_extension( $exts ) {
    	$exts['elba'] = array(
            'name'       => __( 'Контур.Эльба', JCRM_ELBA ),
            'i'          => 'elba-logo.png',
            'short_desc' => __( ' Интеграция Jetpack CRM с Контур.Эльба (загрузка счетов Эльбы)', JCRM_ELBA ),
        );
        return $exts;
    }

    /**
     * Метод корректирует URL объектов плагина из папки Jetpack CRM на свою папку
     * @param string $url       URL
     * @param string $path      Path
     * @param string $plugin    Plugin
     */
    public function plugins_url( $url, $path, $plugin ) {
        if ( ZBS_ROOTFILE == $plugin ) {
            if ( 'i/elba-logo.png' == $path ) $url = JCRM_ELBA_URL . 'assets/' . $path;
        }
        return $url;
    }

    /**
     * Метод корректирует URL объектов плагина из папки Jetpack CRM на свою папку
     */
    public function plugins_loaded() {
        global $zeroBSCRM_extensionsCompleteList;
        $zeroBSCRM_extensionsCompleteList['elba'] = array(
            'fallbackname' => __( 'Контур.Эльба', JCRM_ELBA ),
            'imgstr'       => '<i class="fa fa-keyboard-o" aria-hidden="true"></i>',
            'desc'         => __( ' Интеграция Jetpack CRM с Контур.Эльба (загрузка счетов Эльбы)', JCRM_ELBA ),
            'colour'       => 'rgb(126, 88, 232)',
            'shortname'    => __( 'Контур.Эльба', JCRM_ELBA ), // used where long name won't fit
        );


        global $jpcrm_core_extension_setting_map;
        $jpcrm_core_extension_setting_map['elba'] = 'feat_elba';

    } 
    
}