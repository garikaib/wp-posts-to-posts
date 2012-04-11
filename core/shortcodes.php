<?php

class P2P_Shortcodes {

	static function init() {
		add_shortcode( 'p2p_connected', array( __CLASS__, 'connected' ) );
		add_shortcode( 'p2p_related', array( __CLASS__, 'related' ) );
	}

	static function connected( $attr ) {
		return self::get_list( $attr, 'get_connected' );
	}

	static function related( $attr ) {
		return self::get_list( $attr, 'get_related' );
	}

	private static function get_list( $attr, $method ) {
		global $post;

		$attr = shortcode_atts( array(
			'type' => ''
		), $attr );

		$ctype = p2p_type( $attr['type'] );
		if ( !$ctype ) {
			trigger_error( sprintf( "Unregistered connection type '%s'.", $attr['type'] ), E_USER_WARNING );
			return '';
		}

		$extra_qv = array( 'p2p:context' => 'shortcode' );

		$connected = $ctype->$method( $post, $extra_qv );

		return p2p_list_posts( $connected, array( 'echo' => false ) );
	}
}

