## Development Setup

### Requirements

* vagrant (https://www.vagrantup.com/)
* php
* composer (https://getcomposer.org/download/)
* npm (https://nodejs.org/en/)

### Install

* Install php dependencies `composer install`
* Create a environment config file `cp .env.example .env`
    * Adjust settings in the `.env` file, .e.g set database settings to
        * `DB_DATABASE=prepper`
        * `DB_USERNAME=homestead`
        * `DB_PASSWORD=secret`
        * You should also set `ADMIN_EMAIL`, `ADMIN_PASSWORD` and the mail settings
* Create a virtual machine
    * Create your virtual machine config `vendor/bin/homestead make`
    * Adjust settings in the newly created `Homestead.yaml` file
    * Create a new line in your `/etc/hosts` file
    * Depends on the `ip` and `sites:map` setting in your `Homestead.yaml` file, e.g. `192.168.10.10 prepper.test`
    * Start the virutal machine: `vagrant up`
    * Login with `vagrant ssh`
    * Go the source folder `cd code`
    * Create a new key to e.g. encrypt session data `php artisan key:generate`
    * Fill the database with test data `php artisan migrate:fresh`
* Install js and css dependencies `npm install` or `yarn install`
* Build the js and css files `npm dev` or `yarn dev`
    * To watch constantly for changes run `npm watch` or `yarn watch`
* Visit the website on `http://prepper.test` (depends on the actual setting in your `Homestead.yaml`)
