<?php

namespace PassThisTest\Utility;

class Sanitize
{
    public static function textarea( $input )
    {
        global $allowedposttags;
        $output = wp_kses( $input, $allowedposttags );
        return $output;
    }

    public static function raw( $input )
    {
        return $input;
    }

    public static function attribute( $input )
    {
        return esc_attr($input);
    }

    public static function url( $input )
    {
        return esc_url($input);
    }

    public static function sql( $input )
    {
        return esc_sql($input);
    }

    public static function plaintext( $input )
    {
        $output = wp_kses( $input, array() );
        return $output;
    }

    public static function editor( $input )
    {
        if (current_user_can( 'unfiltered_html' )) {
            $output = $input;
        } else {
            global $allowedtags;
            $output = wpautop( wp_kses( $input, $allowedtags ) );
        }
        return $output;
    }

    public static function hex( $hex, $default = '#000000' )
    {
        if ( preg_match("/^\#?([a-f0-9]{3}){1,2}$/", $hex ) ) {
            return $hex;
        }
        return $default;
    }

    public static function underscore( $name )
    {
        if (is_string( $name )) {
            $name = preg_replace( '/[\.]+/', '_', $name );
            $name = preg_replace("/[^A-Za-z0-9\\s\\-\\_?]/",'', strtolower(trim($name)) );
            $name = preg_replace( '/[-\\s]+/', '_', $name );
            $name = preg_replace( '/_+/', '_', $name );
        }
        return $name;
    }

    public static function dash( $name )
    {
        if (is_string( $name )) {
            $name = preg_replace( '/[\.]+/', '_', $name );
            $name = preg_replace("/[^A-Za-z0-9\\s\\-\\_?]/",'', strtolower(trim($name)) );
            $name = preg_replace( '/[_\\s]+/', '-', $name );
            $name = preg_replace( '/-+/', '-', $name );
        }
        return $name;
    }
}