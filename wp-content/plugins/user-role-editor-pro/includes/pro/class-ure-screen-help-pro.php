<?php

/* 
 * User Role Editor On Screen Help class
 * 
 */

class URE_Screen_Help_Pro {

    public function __construct() {
        
        add_filter('ure_get_settings_general_tab_help', array($this, 'get_settings_general_tab'));
        add_filter('ure_get_settings_additional_modules_tab_help', array($this, 'get_settings_additional_modules_tab'));
        //add_filter('ure_get_settings_default_roles_tab_help', array($this, 'get_settings_default_roles_tab'));
        add_filter('ure_get_settings_multisite_tab_help', array($this, 'get_settings_multisite_tab'));
    }
    // end of __construct()
    
    
    public function get_settings_general_tab($text) {
    
        $text .= '
            <li><strong>'. esc_html__('Download jQuery UI CSS from jQuery CDN', 'user-role-editor'). '</strong> - '.
            esc_html__('Download jQuery UI CSS from jQuery CDN instead of local copy included into the User Role Editor Pro installation package', 'user-role-editor') .'</li>
            <li><strong>'. esc_html__('User Role Editor full access capability', 'user-role-editor'). '</strong> - '.
                esc_html__('if it is empty, then default rule is in action: user should have "administrator" role - '.
                           'for single site WordPress installation, "manage_network_users" capability or be the "super administrator" - for multisite one. '.
                           'Input here your own user capability to change this logic.','user-role-editor') . '</li>            
            <li><strong>' . esc_html__('License key', 'user-role-editor') .'</strong> - ' .
                   'Input here the license key taken from your role-editor.com member account. This will turn on automatic updates for the User Role Editor Pro. '.
                   'It will get information about available updates from role-editor.com directly and report about them the same way as any other plugin '.
                   'from the wordpress.org plugins repository does.</li>';
        
        return $text;
    }
    // end of get_settings_general_tab()
    
   
    public function get_settings_additional_modules_tab($text) {
        $text .= '<li><strong>' . esc_html__('Activate "Administrator Menu Access" module', 'user-role-editor'). '</strong> - ' .
                esc_html__('Adds "Admin Menu" button to the "User Role Editor" page. Turning on checkboxes near menu items in the opened dialog window you may '.
                'block admin menu items available for the selected role', 'user-role-editor') . 
                ' (<a href="https://www.role-editor.com/block-admin-menu-items">'. esc_html__('more info...', 'user-role-editor') .'</a>)</li>'.
                '<li><strong>' . esc_html__('Activate "Widgets Access" module', 'user-role-editor'). '</strong> - ' .
                esc_html__('Adds "Widgets" button to the "User Role Editor" page. Turning on checkboxes near widgets names in the opened dialog window you may '.
                'block widgets available for selected role under the "Appearance" menu', 'user-role-editor') . 
                ' (<a href="https://www.role-editor.com/block-selected-widgets-under-appearance-menu">'. esc_html__('more info...', 'user-role-editor') .'</a>)</li>'.
                '<li><strong>' . esc_html__('Activate "Other Roles Access" module', 'user-role-editor'). '</strong> - ' .
                esc_html__('Adds "Other Roles" button to the "User Role Editor" page. Turning on checkboxes near roles names in the opened dialog window you may '.
                'block that roles from selection in the WordPress drop-down lists (e.g "Role" at the user profile page) '.
                'by the user with current role. Users with blocked roles will not be available for view/edit at the “Users” page also.', 'user-role-editor') . 
                ' (<a href="https://www.role-editor.com/other-roles-access/">'. esc_html__('more info...', 'user-role-editor') .'</a>)</li>'.
                '<li><strong>' . esc_html__('Activate per plugin user access management for plugins activation', 'user-role-editor'). '</strong> - '.
                esc_html__('this feature is useful when you need to allow different users activate/deactivate different plugins. '.
                'When this option is turned on you may input, what plugins are available for the user with "activate_plugins" capability. ' .
                'Go to such user profile and select plugins you allow him to manage.', 'user-role-editor') . '</li>'.
                '<li><strong>' . esc_html__('Activate "Create Post/Page" capability', 'user-role-editor'). '</strong> - ' .
                esc_html__('Turning on this option you automatically add "create_posts" and "create_pages" '.
                'capabilities to the list of WordPress core user capabilities. After that user with "edit_posts" capability '.
                '(even administrator) will can not create new post or page until you apparently include this capability '. 
                'to his user role. "edit_posts" will permit just to edit posts. Go to "User Role Editor" and turn on "create_posts", "create_pages" capability" '.
                'for "Administrator" role and other roles of your choice after this option activation.', 'user-role-editor') . '</li>
                 <li><strong>' . esc_html__('Activate user access management to editing selected posts and pages', 'user-role-editor'). '</strong> - ' .
                esc_html__('This way you may have for example the user with limited "Editor" role, who may edit just 2-3 posts or pages, but has no access '.
                'to all the rest. After this option activation go to the user profile and input allowed posts/pages ID '.
                'to the correspondent text input field. That\'s it.', 'user-role-editor') . 
                ' (<a href="https://www.role-editor.com/allow-user-edit-selected-posts">'. esc_html__('more info...', 'user-role-editor') .'</a>)</li>'.
                '<li><strong>' . esc_html__('Force custom post types to use their own capabilities', 'user-role-editor'). '</strong> - ' .
                esc_html__('Some custom post types use WordPress built-in "posts" based capabilities set: "edit_posts", "delete_posts", etc. '.
                'Activating this option your force such custom post types to use their own capabilities set, based on custom post type name: '.
                'for "videos" custom post type it will be "edit_videos", "delete_videos", etc.', 'user-role-editor');
        if (class_exists('GFForms')) {
            $text .=         
                '<li><strong>' . esc_html__('Activate per form user access management for Gravity Forms', 'user-role-editor'). '</strong> - ' .
                esc_html__('after turning on this option you may see the new “Gravity Forms Restrictions” section at the user profile '.
                'with input field “Allow access to forms with ID (comma separated)”. This field will appear at profile '.
                'of those users only who have at least one capability from the “Gravity Forms” capabilities list, '.
                'e.g. “gravityforms_edit_forms”, “gravityforms_view_entries”, etc. Look ', 'user-role-editor') .
                '<a href="http://role-editor.com/restrict-users-access-gravity-forms/">'.
                esc_html__('support video', 'user-role-editor'). '</a> ' . 
                esc_html__('for your reference.', 'user-role-editor') . '</li>';
        }
        $text .= 
                '<li><strong>' . esc_html__('Activate [user_role_editor roles="role1, role2, ..."] shortcode:', 'user-role-editor') .'</strong> - '.
                esc_html__('Allows view the content enclosed inside [user_role_editor roles="role1, role2"] Some restricted content [/user-role-editor] '.
                'just to users who have one of roles listed in the "roles" attribute. "role1" or "role2" in this case. '. 
                'Other users (except administrator) will not see the "restricted content" at the post or page. '.
                'When this option is turned off, all restricted content input earlier, becomes available as usual content.', 'user-role-editor').'</li>'.
                 '<li><strong>' . esc_html__('Activate content view restrictions', 'user-role-editor') .'</strong> - '.
                esc_html__('Allows to set which roles may or prohibited view what post/page, custom post type', 'user-role-editor') .
                ' (<a href="https://www.role-editor.com/content-view-access-restriction-selected-roles/">'. esc_html__('more info...', 'user-role-editor') .'</a>)</li>';    
                                          
        return $text;
    }
    // end of get_settings_additional_modules_tab()
    
    
    public function get_settings_default_roles_tab($text) {
        
        return $text;
    }
    // end of get_settings_default_roles_tab()
    
    
    public function get_settings_multisite_tab($text) {
        
        $text .= '<li><strong>' . esc_html__('Allow single site administrator access to User Role Editor', 'user-role-editor') . '</strong> - '.
            esc_html__('Super administator only has access to the User Role Editor under multi-site WordPress installation by default.' .
            'Turn on this option if you wish to make User Role Editor available for subsite administrators .', 'user-role-editor') . '</li>
            <li><strong>' . esc_html__('Show help links for single site administrator', 'user-role-editor') .'</strong> - '.
            esc_html__('Turning off this checkbox you will hide question side icons to the right of '.
            'user capabilities at the User Role Editor.', 'user-role-editor') .'</li>
            <li><span style="color: red; font-weight: bold;">' . esc_html__('Enable "unfiltered_html" capability', 'user-role-editor') .'</span> - '.
            esc_html__('WordPress multisite blocks this capabilities by default for all users except superadmin. '.
            'Be careful and double think before enable it. This makes your site potentially vulnerable.', 'user-role-editor'). '
            <li><strong>' . esc_html__('Activate access management for themes', 'user-role-editor') .'</strong> - '.
            esc_html__('with this option active you may setup individual lists of themes available for activation '. 
            'to selected single sites administrators ', 'user-role-editor') .'</li>
            <li><strong>' . esc_html__('Activate access restrictions to User Role Editor for single site administrator', 'user-role-editor') .'</strong> - '.
            esc_html__('Restrict access of single sites administrators to the selected user capabilities and '. 
            'Add/Delete role operations inside User Role Editor','user-role-editor') .'</li>';            
                
        return $text;
    }
    // end of get_settings_multisite_tab()
    
}
// end of URE_Screen_Help_Pro
