Problem 1 - This package requires php ~7.1 but your PHP version (7.0.22) does not satisfy that requirement. Problem 2 - The requested PHP extension ext-curl * is missing from your system. Install or enable PHP's curl extension. Problem 3 - The requested PHP extension ext-gd * is missing from your system. Install or enable PHP's gd extension. Problem 4 - The requested PHP extension ext-intl * is missing from your system. Install or enable PHP's intl extension. Problem 5 - The requested PHP extension ext-mbstring * is missing from your system. Install or enable PHP's mbstring extension. Problem 6 - The requested PHP extension ext-xml * is missing from your system. Install or enable PHP's xml extension. Problem 7 - The requested PHP extension ext-zip * is missing from your system. Install or enable PHP's zip extension. Problem 8 - Installation request for sonata-project/user-bundle 4.x-dev -> satisfiable by sonata-project/user-bundle[4.x-dev]. - sonata-project/user-bundle 4.x-dev requires php ^7.1 -> your PHP version (7.0.22) does not satisfy that requirement. Problem 9 - symfony/web-server-bundle v4.0.2 requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/web-server-bundle v4.0.1 requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/web-server-bundle v4.0.0-RC2 requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/web-server-bundle v4.0.0-RC1 requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/web-server-bundle v4.0.0-BETA4 requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/web-server-bundle v4.0.0-BETA3 requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/web-server-bundle v4.0.0-BETA2 requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/web-server-bundle v4.0.0-BETA1 requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/web-server-bundle v4.0.0 requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/web-server-bundle 4.1.x-dev requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/web-server-bundle 4.0.x-dev requires php ^7.1.3 -> your PHP version (7.0.22) does not satisfy that requirement. - symfony/symfony v4.0.2 requires ext-xml * -> the requested PHP extension xml is missing from your system. - symfony/symfony v4.0.1 requires ext-xml * -> the requested PHP extension xml is missing from your system. - symfony/symfony v4.0.0-RC2 requires ext-xml * -> the requested PHP extension xml is missing from your system. - symfony/symfony v4.0.0-RC1 requires ext-xml * -> the requested PHP extension xml is missing from your system. - symfony/symfony v4.0.0-BETA4 requires ext-xml * -> the requested PHP extension xml is missing from your system. - symfony/symfony v4.0.0-BETA3 requires ext-xml * -> the requested PHP extension xml is missing from your system. - symfony/symfony v4.0.0-BETA2 requires ext-xml * -> the requested PHP extension xml is missing from your system. - symfony/symfony v4.0.0-BETA1 requires ext-xml * -> the requested PHP extension xml is missing from your system. - symfony/symfony v4.0.0 requires ext-xml * -> the requested PHP extension xml is missing from your system. - symfony/symfony 4.1.x-dev requires ext-xml * -> the requested PHP extension xml is missing from your system. - symfony/symfony 4.0.x-dev requires ext-xml * -> the requested PHP extension xml is missing from your system. - Installation request for symfony/web-server-bundle ~4.0 -> satisfiable by symfony/symfony[4.0.x-dev, 4.1.x-dev, v4.0.0, v4.0.0-BETA1, v4.0.0-BETA2, v4.0.0-BETA3, v4.0.0-BETA4, v4.0.0-RC1, v4.0.0-RC2, v4.0.1, v4.0.2], symfony/web-server-bundle[4.0.x-dev, 4.1.x-dev, v4.0.0, v4.0.0-BETA1, v4.0.0-BETA2, v4.0.0-BETA3, v4.0.0-BETA4, v4.0.0-RC1, v4.0.0-RC2, v4.0.1, v4.0.2].

## Chamilo 2.x Installation

This installation guide is for development environments only.

### Install PHP, a web server and MySQL/MariaDB

To run Chamilo, you will need at least a web server (we recommend Apache2 for commodity reasons), 
a database server (we recommend MariaDB but will explain MySQL for commodity reasons) and a PHP interpreter (and a series of libraries for it). If you are working on a Debian-based system (Debian, Ubuntu, Mint, etc), just
type
```
sudo apt-get install libapache2-mod-php mysql-server php5-gd php5-intl php5-curl php5-json
```

### Install Git

The development version 2.x requires you to have Git installed. 
If you are working on a Debian-based system (Debian, Ubuntu, Mint, etc), just type
```
sudo apt-get install git
```

### Install Composer

To run the development version 2.x, you need Composer, a libraries dependency management system that will update all the 
libraries you need for Chamilo to the latest available version.

Make sure you have Composer installed. If you do, you should be able to launch "composer" on the command line and have the 
inline help of composer show a few subcommands. 
If you don't, please follow the installation guide at https://getcomposer.org/download/

### Download Chamilo from GitHub

Clone the repository

```
sudo mkdir chamilo2
sudo chown -R `whoami` chamilo2
git clone -b master --single-branch https://github.com/chamilo/chamilo-lms.git chamilo2
```

Checkout branch 2.x

```
cd chamilo2
git checkout --track origin/master
git config --global push.default current
```

### Create database

You should have a MariaDB/MySQL user and database created before hand.

### Update dependencies using Composer

From the Chamilo folder (in which you should be now if you followed the previous steps), launch:

```
composer update
```

Composer update will ask for the database credentials in order to create a configuration file in:

```
app/config/parameters.yml.dist
```

If you face issues related to missing CSS/JS files, you might need to ensure
that your web/assets folder is completely re-generated.
Use this set of commands to do that:
```
rm composer.lock
rm -rf vendor/
composer clear-cache
composer update
```
This will take several minutes in the best case scenario, but should definitely
generate the missing files.

### Change permissions

On a Debian-based system, launch:
```
sudo chown -R www-data:www-data app main/default_course_document/images main/lang  
```

### Start the installer

In your browser, load the "web/install.php" URL and follow the installation instructions.

