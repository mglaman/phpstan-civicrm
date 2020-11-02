# phpstan-civicrm

Extension for [PHPStan](https://phpstan.org) to allow static analysis of CiviCRM.

## Sponsors

The PHPStan CiviCRM was created through a sponsorship by [Megaphone Technology Consulting](https://megaphonetech.com/) 🎉

## Configuration

To use the PHPStan CiviCRM extension, you must define the root location of CiviCRM.

```
parameters:
    civicrm:
        root: sites/all/modules/civicrm
```

The default value expects CiviCRM to live in the Composer vendor directory, like it does for Drupal 8.

```
%currentWorkingDirectory%/vendor/civicrm/civicrm-core
```

The `civicrm.root` parameter this is equal to `$civicrm_root` as defined in the CMS integration settings. Here are some examples assuming your CMS is installed at `/var/www/htdocs`.

* Drupal 7: `/var/www/htdocs/drupal/sites/all/modules/civicrm/`
* Drupal 8: `/vendor/civicrm/civicrm-core`
* Backdrop: `/var/www/htdocs/backdrop/modules/civicrm/`
* Joomla: `/var/www/htdocs/joomla/administrator/components/com_civicrm/civicrm/`
* WordPress: `/var/www/htdocs/wordpress/wp-content/plugins/civicrm/civicrm/`
