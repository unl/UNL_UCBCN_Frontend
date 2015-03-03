UNL Events
==================

This is the new branch for the manager rewrite of UNL Events. 
This branch will eventually contain the manager, frontend, and backend, all in one repo.

INSTALL
-------
1. run `git submodule init`
2. run `git submodule update`
3. run `cp config.sample.php config.inc.php`
4. run `cp www/sample.htaccess www/.htaccess`
5. run `php composer.php install`
5. Set up a database.  For now we are copying down the live data into a development database.
6. customize config.inc.php and www/.htaccess
