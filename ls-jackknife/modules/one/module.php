<?php

final class SJKOne extends JKNModule {

	/*
	 * =========================================================================
	 * Module registration
	 * =========================================================================
	 */

	/**
	 * @return string
	 */
    function id(): string { return 'one'; }

	/**
	 * @return string
	 */
    function name(): string { return 'One'; }

	/**
	 * @return string
	 */
    function description(): string {
        return 'All the stuff.';
    }


	/*
	 * =========================================================================
	 * Tasks
	 * =========================================================================
	 */

	/**
	 * Autoload classes.
	 */
    function run_on_load(): void {
    	JKNClasses::autoload([
		    'SJKOne_Shortcodes'  => 'includes/shortcodes/shortcodes.php'
	    ]);
    }

	/**
	 * Add the ACF filters and the shortcode.
	 */
    function run_on_startup(): void {

        // Instantiate the shortcode
	    SJKOne_Shortcodes::add_shortcodes();
    }
}
