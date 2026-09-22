<?php
/**
 * Title: Design system sink
 * Slug: wp-features-testing/design-system-sink
 * Categories: featured
 * Block Types: core/post-content
 * Post Types: page
 * Description: One page with every block that design-system/components styles.
 *
 * Media blocks carry example URLs. Replace them with attachments of the site.
 *
 * @package wp-features-testing
 */

?>
<!-- wp:group {"tagName":"main","layout":{"type":"constrained"}} -->
<main class="wp-block-group">

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Design system sink</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every block with a file in <code>design-system/components</code> appears once on this page. No block carries an inline style, so each block shows the component layer alone.</p>
<!-- /wp:paragraph -->

<!-- wp:wp-features-testing/notice {"title":"Read this first","content":"This page is a test surface. Replace the media URLs with attachments of the site."} /-->

<!-- wp:wp-features-testing/notice {"className":"is-style-destructive","title":"Destructive variation","content":"The same block with the destructive style variation."} /-->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Site identity and navigation</h2>
<!-- /wp:heading -->

<!-- wp:site-logo {"width":64} /-->

<!-- wp:site-title /-->

<!-- wp:site-tagline /-->

<!-- wp:navigation {"overlayMenu":"mobile"} -->
<!-- wp:page-list /-->
<!-- wp:navigation-submenu {"label":"More","url":"#","isTopLevelItem":true} -->
<!-- wp:navigation-link {"label":"WordPress","url":"https://wordpress.org/"} /-->
<!-- /wp:navigation-submenu -->
<!-- /wp:navigation -->

<!-- wp:breadcrumbs /-->

<!-- wp:search {"label":"Search","showLabel":true,"buttonText":"Search"} /-->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Text</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>An unordered list item.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>A second item, with a <a href="https://wordpress.org/">link</a>.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>A quote takes the surface and the border of the token contract.</p>
<!-- /wp:paragraph --><cite>A source</cite></blockquote>
<!-- /wp:quote -->

<!-- wp:pullquote -->
<figure class="wp-block-pullquote"><blockquote><p>A pullquote states one idea in the display size.</p><cite>A source</cite></blockquote></figure>
<!-- /wp:pullquote -->

<!-- wp:verse -->
<pre class="wp-block-verse">A verse keeps
	the line breaks
of the source.</pre>
<!-- /wp:verse -->

<!-- wp:preformatted -->
<pre class="wp-block-preformatted">Preformatted text keeps the spacing.</pre>
<!-- /wp:preformatted -->

<!-- wp:code -->
<pre class="wp-block-code"><code>function ds_token( string $name ): string {
	return sprintf( 'var(--wp--custom--ds--%s)', $name );
}</code></pre>
<!-- /wp:code -->

<!-- wp:math -->
<div class="wp-block-math"><math display="block"><semantics><mrow><mi>x</mi><mo>=</mo><mfrac><mrow><mo lspace="0em" rspace="0em">−</mo><mi>b</mi><mo>±</mo><msqrt><mrow><msup><mi>b</mi><mn>2</mn></msup><mo>−</mo><mn>4</mn><mi>a</mi><mi>c</mi></mrow></msqrt></mrow><mrow><mn>2</mn><mi>a</mi></mrow></mfrac></mrow><annotation encoding="application/x-tex">x = \frac{-b \pm \sqrt{b^2-4ac}}{2a}</annotation></semantics></math></div>
<!-- /wp:math -->

<!-- wp:table -->
<figure class="wp-block-table"><table class="has-fixed-layout"><thead><tr><th>Token</th><th>Layer</th><th>Default</th></tr></thead><tbody><tr><td>ds.color.surface</td><td>Contract</td><td>Neutral</td></tr><tr><td>ds.elevation.rest</td><td>Contract</td><td>Neutral</td></tr><tr><td>ds.font.size.body</td><td>Element</td><td>Neutral</td></tr></tbody><tfoot><tr><td>Three rows</td><td></td><td></td></tr></tfoot></table><figcaption class="wp-element-caption">The token contract, in short.</figcaption></figure>
<!-- /wp:table -->

<!-- wp:details {"summary":"A details block"} -->
<details class="wp-block-details"><summary>A details block</summary><!-- wp:paragraph -->
<p>The panel holds any block.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:footnotes /-->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Actions and interaction</h2>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">Primary action</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#">Secondary action</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:icon {"icon":"core/info"} /-->

<!-- wp:accordion -->
<div role="group" class="wp-block-accordion"><!-- wp:accordion-item -->
<div class="wp-block-accordion-item"><!-- wp:accordion-heading {"title":"First item"} -->
<h3 class="wp-block-accordion-heading has-icon has-icon-right"><button type="button" class="wp-block-accordion-heading__toggle"><span class="wp-block-accordion-heading__toggle-title">First item</span><span class="wp-block-accordion-heading__toggle-icon" aria-hidden="true">+</span></button></h3>
<!-- /wp:accordion-heading -->

<!-- wp:accordion-panel -->
<div role="region" class="wp-block-accordion-panel"><!-- wp:paragraph -->
<p>The panel of the first item.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:accordion-panel --></div>
<!-- /wp:accordion-item -->

<!-- wp:accordion-item -->
<div class="wp-block-accordion-item"><!-- wp:accordion-heading {"title":"Second item"} -->
<h3 class="wp-block-accordion-heading has-icon has-icon-right"><button type="button" class="wp-block-accordion-heading__toggle"><span class="wp-block-accordion-heading__toggle-title">Second item</span><span class="wp-block-accordion-heading__toggle-icon" aria-hidden="true">+</span></button></h3>
<!-- /wp:accordion-heading -->

<!-- wp:accordion-panel -->
<div role="region" class="wp-block-accordion-panel"><!-- wp:paragraph -->
<p>The panel of the second item.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:accordion-panel --></div>
<!-- /wp:accordion-item --></div>
<!-- /wp:accordion -->

<!-- wp:tabs -->
<div class="wp-block-tabs"><!-- wp:tab-list -->
<div role="tablist" class="wp-block-tab-list"><button type="button" role="tab">Tokens</button><button type="button" role="tab">Mixins</button></div>
<!-- /wp:tab-list -->

<!-- wp:tab-panels -->
<div class="wp-block-tab-panels"><!-- wp:tab-panel {"label":"Tokens"} -->
<section role="tabpanel" tabindex="0" class="wp-block-tab-panel"><!-- wp:paragraph -->
<p>The contract declares every token of the <code>ds</code> namespace.</p>
<!-- /wp:paragraph --></section>
<!-- /wp:tab-panel -->

<!-- wp:tab-panel {"label":"Mixins"} -->
<section role="tabpanel" tabindex="0" class="wp-block-tab-panel"><!-- wp:paragraph -->
<p>The SCSS layer holds the states, the transitions and the layout.</p>
<!-- /wp:paragraph --></section>
<!-- /wp:tab-panel --></div>
<!-- /wp:tab-panels --></div>
<!-- /wp:tabs -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Media</h2>
<!-- /wp:heading -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="https://s.w.org/style/images/about/WordPress-logotype-standard.png" alt="The WordPress logotype"/><figcaption class="wp-element-caption">A caption takes the caption element.</figcaption></figure>
<!-- /wp:image -->

<!-- wp:gallery {"linkTo":"none"} -->
<figure class="wp-block-gallery has-nested-images columns-default is-cropped"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png" alt="The WordPress mark"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="https://s.w.org/style/images/about/WordPress-logotype-alternative.png" alt="The alternative WordPress logotype"/></figure>
<!-- /wp:image --><figcaption class="blocks-gallery-caption wp-element-caption">A gallery of two images.</figcaption></figure>
<!-- /wp:gallery -->

<!-- wp:cover {"url":"https://s.w.org/style/images/about/WordPress-logotype-wmark.png","dimRatio":50,"layout":{"type":"constrained"}} -->
<div class="wp-block-cover"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">A cover with an overlay.</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->

<!-- wp:video -->
<figure class="wp-block-video"><video controls src="https://videos.files.wordpress.com/kUJmAcSf/video-1dd4e6d9dc_hd.mp4"></video><figcaption class="wp-element-caption">Replace the source with an attachment of the site.</figcaption></figure>
<!-- /wp:video -->

<!-- wp:playlist {"caption":"A playlist"} -->
<figure class="wp-block-playlist"><ol class="wp-block-playlist__tracklist wp-block-playlist__tracklist-show-numbers"><!-- wp:playlist-track {"src":"https://example.com/track-one.mp3","title":"First track","artist":"An artist","album":"An album","length":"3:21"} /-->

<!-- wp:playlist-track {"src":"https://example.com/track-two.mp3","title":"Second track","artist":"An artist","album":"An album","length":"4:05"} /--></ol><figcaption class="wp-element-caption">A playlist</figcaption></figure>
<!-- /wp:playlist -->

<!-- wp:file {"href":"https://example.com/design-system.pdf","displayPreview":false} -->
<div class="wp-block-file"><a href="https://example.com/design-system.pdf">The design system, as a PDF</a><a href="https://example.com/design-system.pdf" class="wp-block-file__button wp-element-button" download>Download</a></div>
<!-- /wp:file -->

<!-- wp:embed {"url":"https://wordpress.tv/2023/11/16/state-of-the-word-2023/","type":"video","providerNameSlug":"videopress","responsive":true} -->
<figure class="wp-block-embed is-type-video is-provider-videopress wp-block-embed-videopress wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
https://wordpress.tv/2023/11/16/state-of-the-word-2023/
</div><figcaption class="wp-element-caption">An embed keeps its aspect ratio.</figcaption></figure>
<!-- /wp:embed -->

<!-- wp:avatar {"size":64,"isLink":false} /-->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Layout</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p>The first column. The columns block carries the gap of the token contract.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p>The second column.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:social-links -->
<ul class="wp-block-social-links"><!-- wp:social-link {"url":"https://wordpress.org/","service":"wordpress"} /-->

<!-- wp:social-link {"url":"https://github.com/WordPress/gutenberg","service":"github"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The post, in a query loop</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":1,"query":{"perPage":2,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false},"layout":{"type":"default"}} -->
<div class="wp-block-query"><!-- wp:query-title {"type":"archive"} /-->

<!-- wp:query-total /-->

<!-- wp:post-template -->
<!-- wp:post-featured-image /-->

<!-- wp:post-title {"isLink":true} /-->

<!-- wp:post-date /-->

<!-- wp:post-author {"showAvatar":true,"showBio":false} /-->

<!-- wp:post-author-name {"isLink":true} /-->

<!-- wp:post-author-biography /-->

<!-- wp:post-terms {"term":"category"} /-->

<!-- wp:post-terms {"term":"post_tag"} /-->

<!-- wp:post-excerpt {"excerptLength":30} /-->

<!-- wp:read-more {"content":"Read the post"} /-->

<!-- wp:post-comments-count /-->

<!-- wp:post-comments-link /-->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->
<!-- /wp:post-template -->

<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query -->

<!-- wp:post-navigation-link {"type":"previous"} /-->

<!-- wp:post-navigation-link {"type":"next"} /-->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Terms and site data</h2>
<!-- /wp:heading -->

<!-- wp:terms-query {"termQuery":{"perPage":4,"taxonomy":"category","order":"asc","orderBy":"name","include":[],"hideEmpty":true,"showNested":false,"inherit":false}} -->
<div class="wp-block-terms-query"><!-- wp:term-template -->
<!-- wp:term-name {"level":3,"isLink":true} /-->

<!-- wp:term-count /-->

<!-- wp:term-description /-->
<!-- /wp:term-template --></div>
<!-- /wp:terms-query -->

<!-- wp:categories /-->

<!-- wp:tag-cloud /-->

<!-- wp:archives /-->

<!-- wp:calendar /-->

<!-- wp:latest-posts {"displayPostDate":true,"displayPostContent":true,"excerptLength":20,"displayFeaturedImage":true} /-->

<!-- wp:latest-comments {"displayAvatar":true,"displayDate":true,"displayExcerpt":true} /-->

<!-- wp:rss {"feedURL":"https://wordpress.org/news/feed/","itemsToShow":3,"displayExcerpt":true,"displayDate":true} /-->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Comments</h2>
<!-- /wp:heading -->

<!-- wp:comments -->
<div class="wp-block-comments"><!-- wp:comments-title /-->

<!-- wp:comment-template -->
<!-- wp:comment-author-avatar /-->

<!-- wp:comment-author-name /-->

<!-- wp:comment-date /-->

<!-- wp:comment-content /-->

<!-- wp:comment-reply-link /-->

<!-- wp:comment-edit-link /-->
<!-- /wp:comment-template -->

<!-- wp:comments-pagination -->
<!-- wp:comments-pagination-previous /-->

<!-- wp:comments-pagination-numbers /-->

<!-- wp:comments-pagination-next /-->
<!-- /wp:comments-pagination -->

<!-- wp:post-comments-form /--></div>
<!-- /wp:comments -->

</main>
<!-- /wp:group -->
