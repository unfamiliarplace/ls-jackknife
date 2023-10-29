<?php

/*
 * =====================================================================
 * Require all main module files
 * =====================================================================
 */

$module_dirs = [
    'one',
];

foreach($module_dirs as $mdir) {
    require_once sprintf('modules/%s/module.php', $mdir);
}

/** 
 * Use the Jackknife API to register our modules.
 */
final class SJK_SawczakJackknife {
    
    /*
     * Create and register the space, along with its modules and settings pages.
     */
    static function register_space() {
       
        /*
         * =====================================================================
         * Create the space and set its menu settings
         * =====================================================================
         */
        
        $space = JKNAPI::create_space('sjk', 'S Jackknife');
        $space->set_icon_url(sprintf('%s/assets/menu-icon.png', $space->url()));
        $space->set_menu_order(83);
        
        
        /*
         * =====================================================================
         * Create all the dependencies
         * =====================================================================
         */
        
        // Plugins
        
        $acf_pro_dep = new JKNPluginDependency([
            'id'        => 'acf_pro',
            'name'      => 'Advanced Custom Fields Pro',
            'url'       => 'https://www.advancedcustomfields.com',
            'file'      => 'advanced-custom-fields-pro/acf.php'
        ]);

        // Plugins checked to activate optional behaviour
        
        // Themes

        // Our own modules

        
        /*
         * =====================================================================
         * Create all the modules and their settings pages
         * =====================================================================
         */
        
        // Announcement
        $one = new SJKOne($space);
        $one
                ->add_plugin_dependency($acf_pro_dep);

        
        /*
         * =====================================================================
         * Add all the settings pages to the space along with their order
         * =====================================================================
         */

	    // Just going to use ACF options pages I think
    }
}

SJK_SawczakJackknife::register_space();
