# Design system

This directory is the scaffolded copy of the design system. A CLI copied it here once. The project owns the copy from that moment, edits it in place, and never pulls from the original. `scaffold.json` records the source and the version that the copy came from, so a later diff is possible.

This directory holds everything: the token contract, the presets, the element and component defaults, the SCSS layer, and the PHP that joins all of it to WordPress. `theme.json` stays a thin manifest and declares the template lists only.

The contract is the single source of truth. It holds every literal value. Everything else names a token: the presets, the element defaults, the components, the SCSS mixins, and the plugins of the project.

Every plugin and library of the project depends on this copy, and reads the tokens as the `--wp--custom--ds--*` custom properties. Only the theme merges the copy into global styles, so the project has one set of values and one owner for them.

| Layer | Directory | Format | Reuse through |
| --- | --- | --- | --- |
| Integration | `load.php` | PHP | One call: `WordPress\DesignSystem\boot()`. |
| Token contract | `tokens/00-tokens.json` | theme.json fragment | The `ds` custom properties. |
| Presets | `tokens/10-presets.json` | theme.json fragment | The `--wp--preset--*` custom properties. |
| Element and component defaults | `tokens/20-elements.json`, `components/` | theme.json fragments | The same tokens. |
| States, transitions, layout, and the elements outside theme.json | `scss/`, built into `assets/` | SCSS | SCSS mixins and element selectors. |
| Scaffold record | `scaffold.json` | JSON | The source and version of this copy. |

The file name sets the merge order inside a directory. The number prefix makes that order explicit.

## Integration

`load.php` is the single entry point. It holds everything that joins the design system to WordPress, and it names no theme and no project value, so it moves with the directory. A theme or a plugin loads it with two lines:

```php
require_once __DIR__ . '/design-system/load.php';

WordPress\DesignSystem\boot();
```

`boot()` registers two hooks:

- `wp_theme_json_data_theme` merges the JSON layer into global styles.
- `enqueue_block_assets` loads `assets/element-defaults.css`, then `assets/utilities.css`, on the front end and in the editor.

`boot()` runs once. A second call returns without an effect, so several consumers of the same copy can call it. The stylesheet URL comes from the location of the file, so the directory works inside a theme, inside a parent theme, or inside a plugin.

Nothing else in the theme knows how the design system reaches WordPress. To move the design system to a plugin, move the directory and call `boot()` there.

## The contract

`tokens/00-tokens.json` declares every token of the `ds` namespace, such as `ds.color.surface` and `ds.elevation.rest`, and gives each one a literal value:

```jsonc
"color": { "surface": "#ffffff" },
"space": { "lg": "1.5rem" }
```

This file is the single source of truth. No other file in the theme holds a literal color, size, space, radius, shadow or duration. To rebrand the project, change this file and nothing else.

A token may name another token when one follows the other, such as the heading family, which follows the body family.

## The presets

`tokens/10-presets.json` declares what the author picks in the editor: the palette, the font families, the type scale, the spacing scale, the shadow ramp and the layout widths. Every preset names a token, and holds no literal:

```jsonc
{ "slug": "primary", "color": "var(--wp--custom--ds--color--accent)", "name": "Primary" }
```

The presets are therefore a projection of the contract into the editor interface. A preset still carries its own slug and name, because the slug reaches the saved markup as a class, such as `has-primary-color`, and the name reaches the picker.

The file switches off the default WordPress palette, gradients, font sizes and spacing sizes, so the editor offers this set alone.

A preset that holds `var()` instead of a literal has one cost: WordPress and the editor cannot read the value. Fluid typography cannot compute a `clamp()` from it, duotone cannot build a filter from it, and a colour swatch in the editor interface can render empty where the custom property is not defined. Fluid typography and duotone are off in this theme. Check the palette and the type scale in the editor after a change here.

## The merge

Every JSON file here is valid theme.json: it needs `version`, and it holds `settings`, `styles`, or both. `tokens/` merges first, then `components/`, and the file name sets the order inside a directory. Custom properties resolve at run time, so the contract and the presets can merge in either order.

## The element layer

`tokens/20-elements.json` sets the document defaults, the root spacing, and every element that theme.json supports: `heading`, `h1` to `h6`, `link`, `button`, `caption`, `cite`, `label`, `select`, and `textInput`.

An element style reaches every block that renders that element, so one rule covers a paragraph, a heading inside a query loop, and a link inside a comment. The element layer is therefore the cheapest place to state a default. A block file only overrides what the element layer cannot say.

The type scale maps to the heading levels: `h1` uses `ds.font.size.display`, `h2` uses `title`, `h3` uses `lead`, `h4` uses `body`, `h5` uses `body-sm`, and `h6` uses `caption` with wide tracking.

`button`, `link`, `caption`, `cite` and the heading elements accept a pseudo class, so the file states the hover and focus styles there: the link drops its underline on hover, and both the link and the button take a focus ring from `ds.color.ring`. `label`, `select` and `textInput` accept plain styles only.

## The component layer

`components/` holds one file per block. The name is `core-<slug>.json` for a core block, and the plain slug for a block of this theme, such as `notice.json`.

A file states only what the token contract has to say about that block. It never repeats a value that the root or the element layer already gives.

These blocks carry no file, on purpose:

- **Structural blocks** that render no surface of their own: `group`, `column`, `query`, `post-template`, `comment-template`, `term-template`, `terms-query`, `post-content`, `template-part`, `pattern`, `block`, `spacer`, `more`, `nextpage`, `html`, `shortcode`, `freeform`, `missing`.
- **Blocks that the element layer already covers**: `paragraph` and `heading` take the root and heading styles, `button` takes the `button` element, `loginout` and `home-link` take the `link` element.
- **Child blocks that the parent styles**: `list-item`, `social-link`, `navigation-link`, `page-list-item`, `playlist-track`, `tab-panels`, `accordion`, `tabs`, and the `query-pagination-*` and `comments-pagination-*` blocks.
- **Experimental blocks**: `table-of-contents`.

Add a file when one of these blocks needs a value of its own.

## Why the split

A property that the user must be able to override belongs in the JSON layer. The Styles panel then shows a control for it, and a theme style variation can replace it.

A rule that theme.json cannot express belongs in the SCSS layer: a hover state, a transition, a media query, a layout primitive. theme.json has no pseudo class for a block, and the block `css` key cannot hold an at-rule.

## The SCSS layer

The mixins read the `ds` custom properties that theme.json emits, through the `token()` function: `token(space, md)` returns `var(--wp--custom--ds--space--md)`. The SCSS holds no literal value, so a change in the contract JSON, or a theme style variation that changes a token, changes every mixin at run time, with no rebuild.

`scss/_mixins.scss` holds the mixins: `elevate`, `stack`, `split`, `icon-button`, `focus-ring`, `text`, `transition`, `reduced-motion`.

A block includes what it needs:

```scss
@use '../../design-system/scss/mixins' as ds;

.wp-block-wp-features-testing-notice {
	@include ds.split;
	@include ds.elevate;

	&__dismiss {
		@include ds.icon-button;
	}
}
```

## The element defaults in SCSS

The SCSS layer holds a default for every HTML element, in two groups:

- **The theme.json elements**: the root, `heading`, `h1` to `h6`, `link`, `button`, `caption`, `cite`, `label`, `select` and `textInput`. The rules repeat `tokens/20-elements.json`, with the selectors that WordPress uses for each element (`WP_Theme_JSON::ELEMENTS`). They are a fallback for a page that does not load global styles. A change to `tokens/20-elements.json` needs the same change in the mixin.
- **The elements outside theme.json**: the SCSS layer is their only source.

The files:

- `scss/_elements.scss` holds the mixins.
    - The document: `root-spacing`, `body`, `global-padding`, `flow`, `layout-gap`, `selection`.
    - The theme.json elements: `heading`, `heading-level`, `link`, `button`, `caption`, `cite`, `label`, `field`, `focus-outline`.
    - The elements outside theme.json: `code`, `kbd`, `pre`, `mark`, `strong`, `del`, `abbr`, `small`, `script`, `rule`, `blockquote`, `list`, `marker`, `description-list`, `table`, `media`, `fieldset`, `choice`, `gauge`, `summary`, `placeholder`.
- `scss/element-defaults.scss` applies each mixin to its selector, and builds `assets/element-defaults.css`.

Each mixin states the full set that theme.json states for an element: the colour, the border, the spacing and the typography. An element inside a heading therefore does not take the heading tracking or weight.

Every rule sits in the `ds-elements` cascade layer. CSS outside a layer wins over a layered rule, whatever the specificity. The global styles of WordPress, a block style, a component file and the Styles panel of the user therefore all win, also for a `:hover` or a `:focus` rule. The selectors skip the markup of a core block, such as `pre.wp-block-code` or `hr.wp-block-separator`, because the component layer already styles that block.

The `button` mixin also covers a `button` or a submit `input` without a class, and the file picker button, because the `button` element of theme.json does not reach them. A change that the user makes in the Styles panel does not reach these buttons.

The root padding goes on `.has-global-padding`, not on `body`, because the theme sets `useRootPaddingAwareAlignments`. The fallback does not add the negative margins of an `.alignfull` block.

`mark` uses the `ds.color.highlight` and `ds.color.on-highlight` tokens. It skips a `mark` that carries an inline style, because the editor highlight format sets its own colour.

A block that renders one of these elements inside its own markup includes the mixin:

```scss
@use 'design-system/scss/elements' as el;

.wp-block-wp-features-testing-shortcut__key {
	@include el.kbd;
}
```

## Utility classes

`scss/utilities.scss` exposes the same mixins as the classes `ds-elevate`, `ds-stack`, `ds-split` and `ds-icon-button`. Use one on a core block, through the Advanced panel. A custom block includes the mixin instead, and carries no utility class.

## Build

```bash
./build-styles.sh           # compile once
./build-styles.sh --watch   # compile on each change
```

The script uses the Sass binary of the Gutenberg checkout. It writes `design-system/assets/element-defaults.css`, `design-system/assets/utilities.css` and `blocks/notice/style.css`. Both are build output: change the `.scss` file, never the `.css` file.

## Override order

From low to high:

1. WordPress defaults.
2. `theme.json`: the manifest, which declares no style.
3. This directory: the token contract, the presets, the element defaults and the components.
4. The user layer: a theme style variation from `styles/`, and every change the user makes in the Styles panel.

A value that the JSON layer declares is therefore a default, never a lock. `styles/typography/editorial.json` is the test case: it changes tokens only, and the presets, the elements and the components all follow.

A block style variation does not belong here. It belongs in `styles/blocks/`, which WordPress reads on its own.
