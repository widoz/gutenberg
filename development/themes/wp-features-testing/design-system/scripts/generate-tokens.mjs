#!/usr/bin/env node
/**
 * Generate the SCSS token contract from the JSON token contract.
 *
 * `design-system/tokens/00-tokens.json` is the single source of truth. This
 * script projects it into `design-system/scss/_tokens.scss`, so a token that
 * the contract adds, renames or removes reaches every mixin.
 *
 * Usage:
 *
 *     node design-system/scripts/generate-tokens.mjs           # write
 *     node design-system/scripts/generate-tokens.mjs --check   # verify
 *
 * `--check` writes nothing and exits 1 when the file is out of date. Use it in
 * CI and in a pre-commit hook.
 */

import { readFileSync, writeFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, join, relative } from 'node:path';

const scriptDir = dirname( fileURLToPath( import.meta.url ) );
const designSystemDir = join( scriptDir, '..' );
const sourceFile = join( designSystemDir, 'tokens', '00-tokens.json' );
const targetFile = join( designSystemDir, 'scss', '_tokens.scss' );

const NAMESPACE = 'ds';

/**
 * Convert one key to the kebab case that WordPress emits.
 *
 * It mirrors `_wp_to_kebab_case()`, so the custom property that this script
 * writes matches the one that global styles declare.
 *
 * @param {string} key A key of the contract.
 * @return {string} The kebab case form.
 */
function toKebabCase( key ) {
	return key
		.replace(
			/(?<=[a-z])(?=[A-Z])|(?<=[A-Za-z])(?=[0-9])|(?<=[0-9])(?=[A-Z])/g,
			'-'
		)
		.toLowerCase();
}

/**
 * Flatten the contract into one group per map of literal values.
 *
 * A group whose values are all objects is a parent, and the walk continues
 * into it. A group whose values are all strings is a leaf, and it becomes one
 * Sass map. A mixed group fails the build, because the projection is then
 * ambiguous.
 *
 * @param {Object}   node  The current node of the contract.
 * @param {string[]} path  The keys that lead to the node.
 * @param {Map}      into  The groups that the walk collected.
 * @return {Map} The groups, in the order of the contract.
 */
function collectGroups( node, path = [], into = new Map() ) {
	const values = Object.values( node );
	const isLeaf = values.every( ( value ) => typeof value === 'string' );
	const isParent = values.every(
		( value ) => null !== value && 'object' === typeof value
	);

	if ( isLeaf ) {
		into.set( path.map( toKebabCase ).join( '-' ), {
			path,
			names: Object.keys( node ),
		} );

		return into;
	}

	if ( ! isParent ) {
		throw new Error(
			`The contract group "${ path.join(
				'.'
			) }" mixes values and groups. Every key of a group must be a value, or every key must be a group.`
		);
	}

	for ( const [ key, child ] of Object.entries( node ) ) {
		collectGroups( child, [ ...path, key ], into );
	}

	return into;
}

/**
 * Build the custom property of one token.
 *
 * @param {string[]} path The group keys.
 * @param {string}   name The token name.
 * @return {string} The custom property, with the `--wp--custom--` prefix.
 */
function customProperty( path, name ) {
	return `--wp--custom--${ [ NAMESPACE, ...path, name ]
		.map( toKebabCase )
		.join( '--' ) }`;
}

/**
 * Render the SCSS file.
 *
 * @param {Map} groups The groups that `collectGroups()` returned.
 * @return {string} The contents of `_tokens.scss`.
 */
function render( groups ) {
	const header = [
		'// The token contract of the design system, for SCSS.',
		'//',
		'// GENERATED FILE. Do not edit it.',
		'//',
		`// Source: ${ relative( designSystemDir, sourceFile ) }`,
		'// Command: npm run tokens',
		'//',
		'// Each map names the tokens of one group, and points each name at the `ds`',
		'// custom property that the contract declares. The file holds no literal value',
		'// and no preset name, so a token changes in the contract JSON, and every mixin',
		'// follows at run time, with no rebuild.',
		'',
		"@use 'sass:map';",
	];

	const maps = [ ...groups ].map( ( [ variable, { path, names } ] ) => {
		const rows = names.map(
			( name ) =>
				`\t${ toKebabCase( name ) }: var(${ customProperty(
					path,
					name
				) }),`
		);

		return [ `$${ variable }: (`, ...rows, ');' ].join( '\n' );
	} );

	const reader = [
		'// Read one token. It fails the build when the name is not in the contract.',
		'@function get($group, $name) {',
		'\t@if not map.has-key($group, $name) {',
		"\t\t@error 'Unknown design system token: #{$name}.';",
		'\t}',
		'',
		'\t@return map.get($group, $name);',
		'}',
	].join( '\n' );

	return [ header.join( '\n' ), ...maps, reader ].join( '\n\n' ) + '\n';
}

const contract = JSON.parse( readFileSync( sourceFile, 'utf8' ) );
const tokens = contract?.settings?.custom?.[ NAMESPACE ];

if ( ! tokens ) {
	throw new Error(
		`${ sourceFile } declares no "settings.custom.${ NAMESPACE }" object.`
	);
}

const output = render( collectGroups( tokens ) );

if ( process.argv.includes( '--check' ) ) {
	let current = '';

	try {
		current = readFileSync( targetFile, 'utf8' );
	} catch {
		current = '';
	}

	if ( current !== output ) {
		process.stderr.write(
			`${ relative(
				designSystemDir,
				targetFile
			) } is out of date. Run npm run tokens.\n`
		);
		process.exit( 1 );
	}

	process.stdout.write( 'The SCSS token contract is up to date.\n' );
} else {
	writeFileSync( targetFile, output );
	process.stdout.write(
		`Wrote ${ relative( designSystemDir, targetFile ) }.\n`
	);
}
