<?php

/*
 * User Role Editor WordPress plugin
 * Prohibit/Allow view of posts of selected categories for selected role - at User Role Editor dialog
 * Author: Vladimir Garagulya
 * Author email: support@role-editor.com
 * Author URI: https://www.role-editor.com
 * License: GPL v2+ 
 */

class URE_Posts_View_Access {

    const view_posts_access_cap = 'ure_view_posts_access';
    
    // reference to the code library object
    private $lib = null;        
    private $objects = null;
    private $notice = '';

    public function __construct($lib) {
        
        $this->lib = $lib;
        $this->objects = new URE_Posts_View($this->lib);
        
        add_action('ure_role_edit_toolbar_service', array(&$this, 'add_toolbar_buttons'));
        add_action('ure_load_js', array(&$this, 'add_js'));
        add_action('ure_dialogs_html', array(&$this, 'dialog_html'));
        add_action('ure_process_user_request', array(&$this, 'update_access'));
        add_action('ure_process_user_request', array(&$this, 'update_access_notification'));        

    }
    // end of __construct()

    public function load_access_data_for_role($role_id) {
    
        $data = $this->objects->load_access_data_for_role($role_id);
        
        return $data;
    }
    // end of load_access_data_for_role()
    
    
    public function load_access_data_for_user($user) {
        
        $data = $this->objects->load_access_data_for_user($user);
        
        return $data;
        
    }
    // end of load_access_data_for_user()
    
    public function add_toolbar_buttons() {
        if (current_user_can(self::view_posts_access_cap)) {
?>                
            <button id="ure_posts_view_access_button" class="ure_toolbar_button" title="<?php esc_html__('Prohibit view posts for selected categories', 'user-role-editor'); ?>">Posts View</button>
<?php
        }
    }

    // end of add_toolbar_buttons()

    
    public function dialog_html() {
        
?>
        <div id="ure_posts_view_access_dialog" class="ure-modal-dialog">
            <div id="ure_posts_view_access_container">
            </div>    
        </div>
<?php        
        
    }
    // end of dialog_html()


    public function add_js() {
        wp_register_script( 'ure-posts-view-access', plugins_url( '/js/pro/ure-pro-posts-view-access.js', URE_PLUGIN_FULL_PATH ) );
        wp_enqueue_script ( 'ure-posts-view-access' );
        wp_localize_script( 'ure-posts-view-access', 'ure_data_posts_view_access',
                array(
                    'posts_view' => esc_html__('Posts View', 'user-role-editor'),
                    'dialog_title' => esc_html__('Posts View Access', 'user-role-editor'),
                    'update_button' => esc_html__('Update', 'user-role-editor')
                ));
    }
    // end of add_js()    
        
            
    public function update_access() {
    
        if (!isset($_POST['action']) || $_POST['action']!=='ure_update_posts_view_access') {
            return;
        }
        
        if (!current_user_can(self::view_posts_access_cap)) {
            $this->notice = esc_html__('URE: you have not enough permissions to use this add-on.', 'user-role-editor');
            return;
        }
        $ure_object_type = filter_input(INPUT_POST, 'ure_object_type', FILTER_SANITIZE_STRING);
        if ($ure_object_type!=='role' && $ure_object_type!=='user') {
            $this->notice = esc_html__('URE: posts view access: Wrong object type. Data was not updated.', 'user-role-editor');
            return;
        }
        $ure_object_name = filter_input(INPUT_POST, 'ure_object_name', FILTER_SANITIZE_STRING);
        if (empty($ure_object_name)) {
            $this->notice = esc_html__('URE: posts view access: Empty object name. Data was not updated', 'user-role-editor');
            return;
        }
                        
        if ($ure_object_type=='role') {
            $this->objects->save_access_data_for_role($ure_object_name);
        } else {
            $this->objects->save_access_data_for_user($ure_object_name);
        }
        
    }
    // end of update_menu()
    
    
    public function update_access_notification() {
        $this->lib->show_message($this->notice);
    }
    // end of update_menu_access_notification()
                                   
        
}
// end of URE_Posts_View_Access class
