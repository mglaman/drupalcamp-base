# DrupalCamps project template [![Build Status](https://travis-ci.org/mglaman/drupalcamp-base.svg?branch=master)](https://travis-ci.org/mglaman/drupalcamp-base)

Use [Composer](https://getcomposer.org/) to a DrupalCamp project template.

Based on [drupal-composer/drupal-project](https://github.com/drupal-composer/drupal-project) and [drupalcommerce/project-base](https://github.com/drupalcommerce/project-base).

## Usage

First you need to [install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

> Note: The instructions below refer to the [global composer installation](https://getcomposer.org/doc/00-intro.md#globally).
> You might need to replace `composer` with `php composer.phar` (or similar)
> for your setup.

After that you can create the project:

```sh
composer create-project mglaman/drupalcamp-base some-dir --stability dev --no-interaction
```

Done! Use `composer require ...` to download additional modules and themes:

```sh
cd some-dir
composer require "drupal/devel:8.1.x-dev"
```

The `composer create-project` command passes ownership of all files to the
project that is created. You should create a new git repository, and commit
all files not excluded by the .gitignore file.

### Providing custom modules, themes, or a profile

Your custom modules, themes, and profiles can be added by modifying the
`repositories` portion of the `composer.json`. See the following examples

Local path

```json
{
    "type": "path",
    "url": "./tests/testing_camp"
}
```
Other repo, not on packagist or drupal.org:

```json
{
    "type": "vcs",
    "url": "https://github.com/drupalcommerce/commerce_base"
}

```

## What does the template do

A quick outline of features

* Drupal is installed in the `web` directory.
* Modules (packages of type `drupal-module`) are placed in `web/modules/contrib/`
* Theme (packages of type `drupal-theme`) are placed in `web/themes/contrib/`
* Profiles (packages of type `drupal-profile`) are placed in `web/profiles/contrib/`
* Creates default writable versions of `settings.php` and `services.yml`.
* Creates the `sites/default/files` directory.
* Latest version of DrupalConsole is installed locally for use at `vendor/bin/drupal`.
* Default `services.yml` and `settings.local.php` symlinked to `sites/default`.

## Updating Drupal Core

This project will attempt to keep all of your Drupal Core files up-to-date; the
project [drupal-composer/drupal-scaffold](https://github.com/drupal-composer/drupal-scaffold)
is used to ensure that your scaffold files are updated every time drupal/core is
updated. If you customize any of the "scaffolding" files (commonly .htaccess),
you may need to merge conflicts if any of your modified files are updated in a
new release of Drupal core.

Follow the steps below to update your core files.

1. Run `composer update drupal/core`.
1. Run `git diff` to determine if any of the scaffolding files have changed.
   Review the files for any changes and restore any customizations to
  `.htaccess` or `robots.txt`.
1. Commit everything all together in a single commit, so `web` will remain in
   sync with the `core` when checking out branches or running `git bisect`.
1. In the event that there are non-trivial conflicts in step 2, you may wish
   to perform these steps on a branch, and use `git merge` to combine the
   updated core files with your customized files. This facilitates the use
   of a [three-way merge tool such as kdiff3](http://www.gitshah.com/2010/12/how-to-setup-kdiff-as-diff-tool-for-git.html). This setup is not necessary if your changes are simple;
   keeping all of your modifications at the beginning or end of the file is a
   good strategy to keep merges easy.

## FAQ

### Should I commit the contrib modules I download

Composer recommends **no**. They provide [argumentation against but also
workrounds if a project decides to do it anyway](https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).

### How can I apply patches to downloaded modules

If you need to apply patches (depending on the project being modified, a pull
request is often a better solution), you can do so with the
[composer-patches](https://github.com/cweagans/composer-patches) plugin.

To add a patch to drupal module foobar insert the patches section in the extra
section of composer.json:

```json
"extra": {
    "patches": {
        "drupal/foobar": {
            "Patch description": "URL to patch"
        }
    }
}
```
