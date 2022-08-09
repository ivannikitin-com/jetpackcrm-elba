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
     * Слаг страницы плагина
     */
    const SLUG = JCRM_ELBA;

   /**
    * Конструктор класса
    */
    private function __construct() {
        // Initialize Hooks
        add_filter( 'zbs-tools-menu', array( $this, 'add_tools_menu_sub_item_link' ) );
        add_filter( 'zbs_menu_wpmenu', array( $this, 'add_wp_pages' ), 10, 1 );
    } 
 
	/**
	 * Adds Tools menu sub item
	 */
	public function add_tools_menu_sub_item_link( $menu_items ) {
		global $zbs;
		$menu_items[] = '<a href="' . 
            zeroBSCRM_getAdminURL( self::SLUG ) . 
            '" class="item"><i class="cloud upload icon"></i>' . 
            __( 'Контур.Эльба', JCRM_ELBA ) .
            '</a>';
		return $menu_items;
	}

	/**
	 * Main page addition
	 */
	function add_wp_pages( $menu_array=array() ) {
		global $zbs;
		// Get the admin layout option 1 = Full, 2 = Slimline, 3 = CRM Only
		$menu_mode = zeroBSCRM_getSetting( 'menulayout' );

		// depending on layout option, we add sub items or main items:
		if ( $menu_mode === ZBS_MENU_SLIM ) {
			// add a sub toplevel item:
			$menu_array['zbs']['subitems'][JCRM_ELBA] = array(
				'title'      => __( 'Контур.Эльба', JCRM_ELBA ),
				'url'        => self::SLUG,
				'perms'      => 'admin_zerobs_manage_options',
				'order'      => 1,
				'wpposition' => 1,
				'callback'   => 'jpcrm_woosync_render_hub_page',
				'stylefuncs' => array( 'zeroBSCRM_global_admin_styles', 'jpcrm_woosync_hub_page_styles_scripts' ),
			);
		} 
        else {
        	// add a sub datatools item
			$menu_array['datatools']['subitems'][JCRM_ELBA] = array(
				'ico'        => 'dashicons-admin-users',
				'title'      => __( 'Контур.Эльба', JCRM_ELBA ),
				'url'        => self::SLUG,
				'perms'      => 'admin_zerobs_view_customers',
				'order'      => 10, 'wpposition' => 25,
				'subitems'   => array(),
				'callback'   => 'jpcrm_woosync_render_hub_page',
				'stylefuncs' => array( 'zeroBSCRM_global_admin_styles', 'jpcrm_woosync_hub_page_styles_scripts' ),
			);
		}
		return $menu_array;
	} 


}