#!/bin/sh
# exit when any command fails
set -e

WEBSITE=/path/to/website       # FIXME: update this path correctly.
ARCHIVE=/path/to/archive       # FIXME: update this path correctly.
WEBSERVER_ROOT=/path/to/public # FIXME: update this path correctly.

echo "====== Deploy Gatsby static website ======"
echo "  => Build new website"
cd $WEBSITE
yarn install
yarn build

echo "  => Archive old website"
mv $WEBSERVER_ROOT/ $ARCHIVE/$(date +%s)

echo "  => Deploy new website"
cp -r $WEBSITE/public $WEBSERVER_ROOT

echo "  => Successfully deployed new version"
echo "====== DONE ======"
exit 0
