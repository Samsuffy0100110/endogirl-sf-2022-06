Bienvenue sur Endoloris

La maquette et la modélisation est disponible dans le lien ci-dessous :

https://www.figma.com/file/qV2Pq1mSGW3XToqOujqI52/Untitled?node-id=0%3A1

Le repo ici :

https://github.com/Samsuffy0100110/endoloris

## Qi Gong - Kit de démarrage - Symfony

## Presentation

Welcome to Qi Gong , this site is a vitrine fully administrable. It allows you to create contents and pages by its owner.

### Prerequisites

1. Check composer is installed
2. Check yarn & node are installed

### Install and Working

1. Clone this project
2. Run `bash script.sh` for windows or `sh script.sh` for mac
3. if you have some troubles, go to Install and Working section

### Install

1. Clone this project
2. Run `composer install`
3. Run `yarn install`
4. Run `yarn encore dev` to build assets

### Working

1. Run `symfony server:start` to launch your local php web server
2. Run `yarn run dev --watch` to launch your local server for assets (or `yarn dev-server` do the same with Hot Module Reload activated)

### Testing

1. Run `php ./vendor/bin/phpcs` to launch PHP code sniffer
2. Run `php ./vendor/bin/phpstan analyse src --level max` to launch PHPStan
3. Run `php ./vendor/bin/phpmd src text phpmd.xml` to launch PHP Mess Detector
4. Run `./node_modules/.bin/eslint assets/js` to launch ESLint JS linter

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command:

`git config --global core.autocrlf true`

The `.editorconfig` file in root directory do this for you. You probably need `EditorConfig` extension if your IDE is VSCode.

### Run locally with Docker

1. Fill DATABASE_URL variable in .env.local file with
`DATABASE_URL="mysql://root:password@database:3306/<choose_a_db_name>"`
2. Install Docker Desktop an run the command:
```bash
docker-compose up -d
```
3. Wait a moment and visit http://localhost:8000


## Deployment

Some files are used to manage automatic deployments (using tools as Caprover, Docker and Github Action). Please do not modify them.

* [captain-definition](/captain-definition) Caprover entry point
* [Dockerfile](/Dockerfile) Web app configuration for Docker container
* [docker-entry.sh](/docker-entry.sh) shell instruction to execute when docker image is built
* [nginx.conf](/ginx.conf) Nginx server configuration
* [php.ini](/php.ini) Php configuration


## Built With

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [PHPMD](http://phpmd.org)
* [ESLint](https://eslint.org/)
* [Sass-Lint](https://github.com/sasstools/sass-lint)



## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning



## How to use this project

1. Go to localhost:8000/
2. email : admin@admin.fr
3. password : admin
