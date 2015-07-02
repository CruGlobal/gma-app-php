# gma-app-php
Global Measurements Application PHP Wrapper

## Installation on localhost
Clone the repo and submodule
```bash
git clone -b develop --recursive https://github.com/GlobalTechnology/gma-app-php.git gma-app-php
cd gma-app-php
```
Install Composer and Download Dependencies
```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```
Copy provided config.php to the config directory
```bash
cp config.php config/
```

Install bower, bower components and npm packages
```bash
cd app
git checkout develop
npm install -g bower
npm install
bower install
```

Point your server at the gma-app-php directory as the document root and serve index.php as the entry point to the application.
The php wrapper loads the app through an iframe from the app folder specified in the config.
