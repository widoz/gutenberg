#!/usr/bin/env bash
#
# Build the design system.
#
# It writes `design-system/scss/_tokens.scss` from the JSON token contract,
# then compiles the SCSS of the design system and of every block.
#
# It uses the Node and Sass binaries of the Gutenberg checkout. Pass `--watch`
# to keep Sass running. To watch the JSON contract as well, run `npm start`.

set -euo pipefail

theme_dir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
sass_bin="${theme_dir}/../../../node_modules/.bin/sass"

if [[ ! -x "${sass_bin}" ]]; then
	echo "Sass not found at ${sass_bin}. Run npm install in the Gutenberg root." >&2
	exit 1
fi

node "${theme_dir}/design-system/scripts/generate-tokens.mjs"

"${sass_bin}" \
	--no-source-map \
	--style=expanded \
	--load-path="${theme_dir}" \
	"$@" \
	"${theme_dir}/design-system/scss/utilities.scss:${theme_dir}/design-system/assets/utilities.css" \
	"${theme_dir}/blocks/notice/style.scss:${theme_dir}/blocks/notice/style.css"
