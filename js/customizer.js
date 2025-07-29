/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

    // Site title and description.
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            $( '.site-title a' ).text( to );
        } );
    } );
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            $( '.site-description' ).text( to );
        } );
    } );

    // Header text color.
    wp.customize( 'header_textcolor', function( value ) {
        value.bind( function( to ) {
            if ( 'blank' === to ) {
                $( '.site-title, .site-description' ).css( {
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                } );
            } else {
                $( '.site-title, .site-description' ).css( {
                    'clip': 'auto',
                    'position': 'relative'
                } );
                $( '.site-title a, .site-description' ).css( {
                    'color': to
                } );
            }
        } );
    } );

    // Primary color
    wp.customize( 'primary_color', function( value ) {
        value.bind( function( to ) {
            // Update CSS custom property
            document.documentElement.style.setProperty( '--primary-color', to );
            
            // Update specific elements
            $( 'a' ).css( 'color', to );
            $( '.woocommerce ul.products li.product .button, .single-product .product .summary .single_add_to_cart_button' ).css( 'background', to );
            
            // Calculate darker shade for hover states
            const darkerShade = adjustBrightness( to, -20 );
            $( '.woocommerce ul.products li.product .button:hover, .single-product .product .summary .single_add_to_cart_button:hover' ).css( 'background', darkerShade );
        } );
    } );

    // Secondary color
    wp.customize( 'secondary_color', function( value ) {
        value.bind( function( to ) {
            // Update secondary color elements
            $( '.site-navigation a:hover::after' ).css( 'background', to );
        } );
    } );

    // Footer text
    wp.customize( 'footer_text', function( value ) {
        value.bind( function( to ) {
            $( '.footer-bottom p' ).html( to );
        } );
    } );

    // Show/hide search in header
    wp.customize( 'show_search_in_header', function( value ) {
        value.bind( function( to ) {
            if ( to ) {
                $( '.header-search' ).show();
            } else {
                $( '.header-search' ).hide();
            }
        } );
    } );

    // Show/hide cart in header
    wp.customize( 'show_cart_in_header', function( value ) {
        value.bind( function( to ) {
            if ( to ) {
                $( '.header-cart' ).show();
            } else {
                $( '.header-cart' ).hide();
            }
        } );
    } );

    // Body font family
    wp.customize( 'body_font_family', function( value ) {
        value.bind( function( to ) {
            $( 'body' ).css( 'font-family', to + ', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' );
        } );
    } );

    // Heading font family
    wp.customize( 'heading_font_family', function( value ) {
        value.bind( function( to ) {
            $( 'h1, h2, h3, h4, h5, h6' ).css( 'font-family', to + ', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' );
        } );
    } );

    // WooCommerce settings
    if ( typeof wp.customize( 'products_per_page' ) !== 'undefined' ) {
        wp.customize( 'products_per_page', function( value ) {
            value.bind( function( to ) {
                // This would typically require a page reload to take effect
                // but we can update the display if needed
                console.log( 'Products per page changed to: ' + to );
            } );
        } );
    }

    if ( typeof wp.customize( 'show_related_products' ) !== 'undefined' ) {
        wp.customize( 'show_related_products', function( value ) {
            value.bind( function( to ) {
                if ( to ) {
                    $( '.related.products' ).show();
                } else {
                    $( '.related.products' ).hide();
                }
            } );
        } );
    }

    /**
     * Helper function to adjust color brightness
     */
    function adjustBrightness( hex, steps ) {
        hex = hex.replace( '#', '' );
        
        const r = parseInt( hex.substr( 0, 2 ), 16 );
        const g = parseInt( hex.substr( 2, 2 ), 16 );
        const b = parseInt( hex.substr( 4, 2 ), 16 );
        
        const newR = Math.max( 0, Math.min( 255, r + steps ) );
        const newG = Math.max( 0, Math.min( 255, g + steps ) );
        const newB = Math.max( 0, Math.min( 255, b + steps ) );
        
        return '#' + newR.toString( 16 ).padStart( 2, '0' ) + 
               newG.toString( 16 ).padStart( 2, '0' ) + 
               newB.toString( 16 ).padStart( 2, '0' );
    }

} )( jQuery );