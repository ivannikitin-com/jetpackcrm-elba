<?php 
/**
 * Класс, реализующий пользовательский интерфейс плагина
 * 
 * @package           jetpackcrm-elba
 * @author            Иван Никитин
 * @copyright         2022 IvanNikitin.com
 * @license           GPL-3.0-or-later
 */
namespace JCRM_ELBA;

class UI {

    public function __construct(){
        // Хуки JCRM
        add_filter( 'zbs-invoices-menu', array( $this, 'add_invoices_menu' ) );
        // Хуки на админ-меню
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );        
    }
    /**
     * Добавляет пункт меню для счетов 
     */
    public function add_invoices_menu( $invoicesMenu ) {

        $invoicesMenu = '<a class="item" href="#"><i class="icon cloud upload"></i>' . __( 'Загрузка счетов из Эльбы', JCRM_ELBA ) . '</a>';
        return $invoicesMenu;
    }

    /**
     * Добавляет страницу в меню Wordpress
     */
    public function add_admin_menu() {
        global $zbs;
        //echo '!!!'. $zbs->slugs['home'];        
        add_submenu_page( $zbs->slugs['dash'], //$zbs->slugs['home'], 
            __( 'Загрузка счетов из Эльбы', JCRM_ELBA ), 
            __( 'Загрузка счетов из Эльбы', JCRM_ELBA ), 
            'admin_zerobs_customers', //import
            JCRM_ELBA,
            array( $this, 'show_admin_page' ));
    }  
    
    /**
     * Отрисовывает страницу в CRM
     */
    public function show_admin_page( ) {
        echo 'Hello!';
    }
}