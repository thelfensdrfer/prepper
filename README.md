## Development Setup

### Requirements

* docker (https://www.docker.com/)
* npm (https://nodejs.org/en/) or yarn (https://yarnpkg.com/)

### Install

* Copy the `.docker_env.example` to `.docker_env` and adjust the variables  
* Create a environment config file `cp .env.example .env`
    * Adjust settings in the `.env` file to match your `.docker_env` file
        * Set database settings (so they match your docker-compose.override.yaml)
        * You should also set `ADMIN_EMAIL`, `ADMIN_PASSWORD` and the mail settings
* Install js and css dependencies `npm install` or `yarn install`
* Build the js and css files `npm dev` or `yarn dev`
    * To watch constantly for changes run `npm watch` or `yarn watch`
* Visit the website on `http://prepper.localhost:8080` (depending on your hosts file entry)
