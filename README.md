# WordPress Gatsby build script runner.

This is the scripts needed to trigger a manual build from WordPress instance to
rebuild a static website and serve it from the same machine.

## Prerequisites
- WordPress `^5.1.1.2`
- [WP Utility Script Runner](https://wordpress.org/plugins/wp-utility-script-runner/) Plugin installed.

## Install
- Copy the [Deploy Gatsby Website](./wordpress/wp-content/plugins/wp-utility-script-runner/utilities/deploy-website.php) in the
plugin utilities folder **or** in the active theme utilities folder (either option will work).
  + Plugin utilities folder: `wordpress/wp-content/plugins/wp-utility-script-runner/utilities`
  + Assuming `twentynineteen` active theme: `/wordpress/wp-content/themes/twentynineteen/utilities`

- Copy the [`publish_website.sh`] to the website source directory (ex: `/var/website/src`)
- Configure the [`$cmd` path](./wordpress/wp-content/plugins/wp-utility-script-runner/utilities/deploy-website.php#L72)
to point to the exact path of the `publish_website.sh` script (ex: `/var/website/src/publish_website.sh`)
- Configure the [variables in the deploy script](./website/publish_website.sh#L5-L7) to configure
  + `WEBSITE`: the directory holding the website source code to build (ex: `/var/website/src`)
  + `ARCHIVE`: the directory holding the old archived versions of the website (ex: `/var/website/archive`)
  + `WEBSERVER_RROT`: the serving directory of the website (ex: `/var/www/html`)

## LICENSE

The project is available as open source under the terms of the [MIT License](/LICENSE.md)
