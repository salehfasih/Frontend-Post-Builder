=== Frontend Post Builder ===
Contributors: @msfclicky
Tags: frontend post, custom post type, post submission, user post, frontend editor
Requires at least: 5.0
Author URI: https://github.com/salehfasih/
Plugin URI: https://github.com/salehfasih/Frontend-Post-Builder
Tested up to:  6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create WordPress posts and custom post types directly from a frontend form. Ideal for user-generated content, guest posts, and custom workflows.

== Description ==

**Frontend Post Builder** allows site administrators or users to submit WordPress posts (or any custom post type) from the frontend of your website. This plugin is ideal for user-generated content, blogs accepting guest posts, job boards, or any website requiring frontend content submission.

**Features:**

- Frontend form for post creation.
- Supports all public post types.
- Includes status selection (draft, publish, pending, etc).
- Admin settings to choose post type and status.
- Simple and clean UI.
- Developer-friendly hooks and templates.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/frontend-post-builder` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to **Settings > Frontend Post Builder** to configure post type and status.
4. Use the shortcode `[frontend_post_form]` to display the post submission form on any page.

== Usage ==

1. Configure which post type should be allowed for frontend submission via plugin settings.
2. Add the `[frontend_post_form]` shortcode to any post or page.
3. Users can fill in the form to submit a post.
4. Posts are created with the selected post type and saved with the chosen status (publish, draft, etc.).

== Screenshots ==

1. Settings panel to select post type and default status.
2. Frontend submission form UI.
3. Submitted post visible in WordPress admin area.

== Frequently Asked Questions ==

= Can users submit custom post types? =
Yes, all public post types (like `job`, `event`, `portfolio`) are supported.

= Can I customize the form? =
Yes. The form template can be overridden via your theme or filters.

= Are there any shortcodes? =
Yes. Use `[frontend_post_builder]` on any page or post.

= Does it support custom fields? =
Basic version supports title and content. For ACF or custom fields, you can extend it via hooks.

== Changelog ==

= 1.0.0 =
* Initial release of Frontend Post Builder.
* Admin settings page for selecting post type and status.
* Frontend form for creating new posts.
* Supports WordPress post statuses (publish, draft, private, etc).

== Upgrade Notice ==

= 1.0.0 =
Initial release.

== License ==

This plugin is licensed under the GPL v2 or later.
