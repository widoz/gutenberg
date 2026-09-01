/**
 * The block is dynamic. The saved markup holds the inner blocks only, and
 * render.php adds the wrapper and the responsive CSS.
 */

import { InnerBlocks } from '@wordpress/block-editor';

export default function Save() {
	return <InnerBlocks.Content />;
}
