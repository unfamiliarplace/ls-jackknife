<?php
/**
 Plugin Name: Sawczak Jackknife
 Plugin URI: https://sawczak.com
 Description: Modules built on the Jackknife framework.
 Author: Luke Sawczak
 Version: 1.0
 Author URI: https://sawczak.com
 */

// This is the Jackknife hook. By using it we load only if JKN is active.
add_action('jkn_register', function(): void { require_once 'registry.php'; });
