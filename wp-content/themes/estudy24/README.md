# eStudy24 Study Atlas WordPress Theme

## Installation

1. In WordPress, open **Appearance → Themes → Add New → Upload Theme**.
2. Choose `estudy24-study-atlas-theme.zip`, click **Install Now**, then **Activate**.
3. Activation creates the original site pages, sets the homepage, creates the primary menu, and adds six starter courses.
4. Review **Settings → Permalinks** and click **Save Changes** once if course links return 404 on an existing installation.

## Dynamic areas

- Site title metadata, WordPress language attributes, body classes, feeds, and document title.
- Custom logo and logo width under **Appearance → Customize → Site Identity**.
- Primary navigation under **Appearance → Menus**.
- Telegram URL under **Appearance → Customize → eStudy24 Contact**.
- Courses are a custom post type with editable content, featured image, price, old price, lesson count, and level.
- Universities and instructors are course taxonomies.
- The course catalog is searchable, filterable, paginated, and populated from WordPress courses.
- Standard pages, posts, search results, course details, and the 404 page use WordPress templates.
- Seeded page bodies are editable with the block editor. The design-heavy homepage starts as imported HTML to retain visual parity.

## Static/theme-coded areas

- Header/footer layout, mobile dock, homepage layout, labels, cart count, and account/checkout demonstrations remain theme-coded.
- The original site is a front-end prototype; login, registration, student/teacher/admin dashboards, cart, and checkout retain their visual content but do not provide authentication, learning-management, or commerce workflows. Add suitable LMS/e-commerce plugins for those functions.
- Original CSS and image assets are preserved without a visual redesign.

## Notes

- Elementor is not required. Free Elementor cannot visually build theme headers, footers, or custom post templates; these remain coded for consistent styling.
- PHP 7.4+ and WordPress 6.2+ are supported.
