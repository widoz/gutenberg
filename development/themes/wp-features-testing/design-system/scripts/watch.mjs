#!/usr/bin/env node
/**
 * Watch the design system, in one action.
 *
 * It starts `build-styles.sh --watch`, which keeps Sass running, and it watches
 * `design-system/tokens/*.json`. When the token contract changes, it writes
 * `design-system/scss/_tokens.scss` again, and Sass compiles every stylesheet
 * that reads the contract.
 *
 * Usage:
 *
 *     npm start
 */

import { spawn, spawnSync } from 'node:child_process';
import { watch } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, join } from 'node:path';

const scriptDir = dirname( fileURLToPath( import.meta.url ) );
const themeDir = join( scriptDir, '..', '..' );
const tokensDir = join( scriptDir, '..', 'tokens' );
const generator = join( scriptDir, 'generate-tokens.mjs' );

/** Milliseconds to wait, so one save does not start two builds. */
const DEBOUNCE = 50;

/**
 * Write the SCSS token contract again.
 *
 * A failure does not stop the watch: the contract is often invalid halfway
 * through an edit, and the next save corrects it.
 */
function generateTokens() {
	const result = spawnSync( process.execPath, [ generator ], {
		stdio: 'inherit',
	} );

	if ( 0 !== result.status ) {
		process.stderr.write(
			'The token contract is invalid. The watch continues.\n'
		);
	}
}

generateTokens();

const sass = spawn( join( themeDir, 'build-styles.sh' ), [ '--watch' ], {
	cwd: themeDir,
	stdio: 'inherit',
} );

sass.on( 'exit', ( code ) => process.exit( code ?? 0 ) );

let timer = null;

const watcher = watch( tokensDir, ( event, file ) => {
	if ( ! file || ! file.endsWith( '.json' ) ) {
		return;
	}

	clearTimeout( timer );
	timer = setTimeout( generateTokens, DEBOUNCE );
} );

for ( const signal of [ 'SIGINT', 'SIGTERM' ] ) {
	process.on( signal, () => {
		watcher.close();
		sass.kill( signal );
	} );
}
