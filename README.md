# Modern WooCommerce Theme

A modern, responsive WordPress theme designed specifically for WooCommerce stores. This theme provides a clean, professional design with excellent user experience and full WooCommerce integration.

## Features

### 🎨 Design & Layout
- **Modern & Clean Design**: Professional appearance with clean typography
- **Fully Responsive**: Works perfectly on desktop, tablet, and mobile devices
- **Customizable Colors**: Easy color customization through WordPress Customizer
- **Google Fonts Integration**: Uses Inter font family for modern typography
- **CSS Grid Layout**: Modern layout system for better responsiveness

### 🛒 WooCommerce Integration
- **Full WooCommerce Support**: Complete integration with all WooCommerce features
- **Product Gallery**: Zoom, lightbox, and slider support
- **Shopping Cart**: Header cart with item count
- **Product Grid**: Responsive product grid with hover effects
- **Single Product Pages**: Optimized product detail pages
- **Checkout & Cart Pages**: Styled checkout and cart pages

### ⚙️ Customization Options
- **WordPress Customizer**: Extensive customization options
- **Color Schemes**: Primary and secondary color customization
- **Typography**: Font family selection for body and headings
- **Layout Options**: Show/hide various elements
- **WooCommerce Settings**: Products per page, related products toggle

### 📱 Mobile-First Design
- **Mobile Menu**: Hamburger menu for mobile devices
- **Touch-Friendly**: Optimized for touch interactions
- **Fast Loading**: Optimized for performance
- **Accessibility**: WCAG compliant design

## Installation

1. **Upload the Theme**:
   - Upload the theme folder to `/wp-content/themes/`
   - Or use WordPress admin: Appearance > Themes > Add New > Upload Theme

2. **Activate the Theme**:
   - Go to Appearance > Themes
   - Click "Activate" on the Modern WooCommerce Theme

3. **Install WooCommerce** (if not already installed):
   - Go to Plugins > Add New
   - Search for "WooCommerce"
   - Install and activate WooCommerce

4. **Customize Your Theme**:
   - Go to Appearance > Customize
   - Configure colors, typography, and layout options

## Customization

### WordPress Customizer Options

#### Theme Options
- **Primary Color**: Main brand color for links and buttons
- **Secondary Color**: Secondary brand color
- **Footer Text**: Custom footer text
- **Show/Hide Elements**: Toggle search and cart in header

#### Typography
- **Body Font Family**: Choose from Inter, Roboto, Open Sans, Lato, Poppins
- **Heading Font Family**: Font for headings

#### WooCommerce Settings
- **Products per Page**: Number of products to display
- **Show Related Products**: Toggle related products on single product pages

### Custom CSS

You can add custom CSS through the WordPress Customizer:
1. Go to Appearance > Customize
2. Click "Additional CSS"
3. Add your custom styles

### Child Theme

For customizations, it's recommended to create a child theme:

1. Create a new folder: `modern-woocommerce-theme-child`
2. Create `style.css` with:
```css
/*
Theme Name: Modern WooCommerce Theme Child
Template: modern-woocommerce-theme
*/
@import url("../modern-woocommerce-theme/style.css");
```
3. Create `functions.php` for custom functions

## File Structure

```
modern-woocommerce-theme/
├── style.css                 # Main stylesheet with theme header
├── index.php                 # Main template file
├── header.php                # Header template
├── footer.php                # Footer template
├── functions.php             # Theme functions
├── woocommerce.php           # WooCommerce template
├── single.php                # Single post template
├── page.php                  # Page template
├── archive.php               # Archive template
├── search.php                # Search results template
├── 404.php                   # 404 error template
├── comments.php              # Comments template
├── inc/
│   ├── template-tags.php     # Custom template tags
│   ├── template-functions.php # Template functions
│   ├── customizer.php        # Customizer options
│   └── woocommerce.php       # WooCommerce functions
├── js/
│   ├── navigation.js         # Mobile navigation
│   └── customizer.js         # Customizer preview
└── README.md                 # This file
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Internet Explorer 11+

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- WooCommerce 4.0 or higher (for e-commerce features)

## Support

For support and customization requests, please contact the theme developer.

## Changelog

### Version 1.0.0
- Initial release
- Full WooCommerce integration
- Responsive design
- WordPress Customizer support
- Mobile-friendly navigation

## License

This theme is licensed under the GPL v2 or later.

## Credits

- **Fonts**: Google Fonts (Inter)
- **Icons**: Feather Icons
- **Framework**: WordPress
- **E-commerce**: WooCommerce
