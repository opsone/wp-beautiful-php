# WP Beautiful PHP
Fix your Wordpress PHP code with PHP CS Fixer bin (https://github.com/FriendsOfPHP/PHP-CS-Fixer).


## How to install

```
wp package install git@github.com:opsone/wp-beautiful-php.git
```

## Commands and examples
* __`wp beautiful php --what=core`__:
Fix all php files in the Wordpress Core. (exclude : wp-content/themes/)

* __`wp beautiful php --what=themes`__:
Fix all php files in wp-content/themes folder.

* __`wp beautiful php --what=themes --themename=mytheme`__:
Fix all php files in 'mytheme' theme folder.

## Options
You can create a wp-cli.yml file to add some options to commands. For example, you can exclude some files or folders.

```
php-fixer:
  excludes:
    files:
      - 'index.php'
      - ...
    folders:
      - 'wp-includes'
      - 'wp-admin'
      - ...
```

### Default options
Some Wordpress files and folders are excluded by default :

```
wp-content/plugins
wp-config.php
```

You can set some files or folders to exclude with the wp-cli.yml option file.


Some PHP CS Fixer options are set by default :

```
'single_quote'       => true
'trim_array_spaces'  => true
'no_useless_else'    => true
'elseif'             => true
'align_double_arrow' => true
'align_equals'       => true
```

Please refer to the PHP CS Fixer Github documentation to get more informations about that.


## Uninstall
```
wp package uninstall opsone/wp-beautiful-php
```
