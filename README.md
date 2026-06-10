# flex.ja.do Companion

Companion plugin for the **jado Flex Theme** designed to offload plugin territory functionality. This ensures that essential features remain available even if the theme is switched, following WordPress best practices.

## Features

- **Custom User Roles:** Sets up the `Admin Customer` role with specific capabilities (`manage_jado_options`, `edit_theme_options`) and ensures Administrators have the `manage_jado_options` capability.
- **Header Cleanup:** Removes unnecessary meta tags and links from the WordPress `<head>` (RSD, WLW Manifest, shortlinks, and WP generator version).
- **SVG Upload Support:** Safely enables SVG file uploads to the Media Library (controlled via theme settings).
- **Embeds Management:** Provides the option to disable WordPress embeds on the frontend for improved performance (controlled via theme settings).
- **Email Encryption Shortcode:** Registers an `[email]` shortcode to help protect email addresses from spam bots (controlled via theme settings).

## Requirements

- **WordPress:** 7.0 or higher.
- **Theme:** Designed specifically for the [jado Flex Theme](https://flex.ja.do/).

## Installation

1. Upload the `flex-jado-companion` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## License

This plugin is licensed under the GPL2. See the `LICENSE` file for details.

