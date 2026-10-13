#!/usr/bin/env sh
# Package the theme for Appearance → Themes → Upload.
set -e
cd "$(dirname "$0")"
mkdir -p dist
rm -f dist/developernasim.zip
zip -rq dist/developernasim.zip developernasim -x '*.DS_Store'
echo "Built dist/developernasim.zip"
