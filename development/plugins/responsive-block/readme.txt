=== Responsive Block ===
Contributors:      gutenberg
Tested up to:      7.1
Stable tag:        1.0.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

An example block with a custom attribute that holds one value per viewport state.

== Description ==

WordPress generates responsive CSS for the `style` attribute only. This plugin
shows how to give the same behaviour to a custom block attribute. The `columns`
attribute stores one value per viewport state:

	{ "default": 3, "@tablet": 2, "@mobile": 1 }

The editor writes the value of the device that the View menu shows, so the
block adds no device control of its own. The frontend renders
one CSS rule per state, inside the media queries of the theme breakpoints.

The plugin uses public APIs only.
