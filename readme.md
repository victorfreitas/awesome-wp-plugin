# Awesome

Awesome is a WordPress plugin designed to track and report emails sent by WordPress. It logs both successful and failed email attempts and displays this information on a dedicated admin page within the WordPress dashboard.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Development](#development)
  - [Running tests via Docker](#running-tests-via-docker)
  - [Folder Structure](#folder-structure)
  - [Scripts](#scripts)
  - [Key Files](#key-files)
- [Dependencies](#dependencies)
- [Testing](#testing)
  - [Observations](#observations)
- [License](#license)
- [Initial folders and files structure](#folders-and-files)

## Features

- Tracks and logs emails sent by WordPress.
- Records both successful and failed email attempts.
- Displays email logs in a dedicated admin page.
- Supports PHP 8.3 and WordPress 6.7.2.
- Utilizes Clean Architecture principles.

## Requirements

- PHP 8.3 or higher
- Composer 2.8 or higher
- WordPress 6.7.2 or higher
- MySQL 8.0 or higher

## Installation

1. Clone the repository:

   ```sh
   git clone https://github.com/victorfreitas/awesome-wp-plugin.git awesome # keep the plugin name "awesome"
   ```

2. Navigate to the plugin directory:

   ```sh
   cd awesome
   ```

3. Plugin dependencies:

   ```sh
   # Create the wp-config.php file.
   cp wordpress/wp-config-sample.php wordpress/wp-config.php

   # Create the domain (wp.dev) certificates for the development mode using https and custom domain.
   mkcert \
   -cert-file ./wordpress/nginx/certs/wp.dev.pem \
   -key-file ./wordpress/nginx/certs/wp.dev-key.pem \
   wp.dev "*.wp.dev" \
   localhost 127.0.0.1 ::1
   
   # Add the host for the custom domain.
   sudo vim /etc/hosts # Add this entry: 127.0.0.1 wp.dev

   # Install composer dependencies.
   composer install

   # Install npm dependencies.
   npm install
   ```

4. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

Once activated, the plugin will automatically start logging emails sent by WordPress. You can view the logs by navigating to the "Awesome" page in the WordPress admin dashboard.

## Development

### Running tests via Docker

```sh
docker compose -f compose.test.yaml up --exit-code-from test
docker compose -f compose.test.yaml down
```

### Scripts

- `composer format`: Formats the codebase.
- `composer lint`: Lints the codebase.
- `composer test`: Runs the test suite.
- `composer test:watch`: Runs the test suite with watch mode.
- `composer make-pot`: Generate the translation pot file.

### Key Files

- `composer.json`: Composer configuration.
- `package.json`: NPM configuration.
- `awesome.php`: Main plugin file.
- `uninstall.php`: This file is responsible for deleting data stored through the plugin.
- `config/queries.php`: Database table creation queries.
- `src/Application/Controllers/PluginActivator.php`: Handles plugin activation and deactivation.
- `src/Application/Controllers/Email.php`: Handles email success and failure hooks.

## Dependencies

This project relies on the following dependencies:

- **PHP** (>=8.3): The main programming language used for the plugin.
- **psr/log** (^3.0): A common interface for logging libraries.
- **monolog/monolog** (^3.7): A comprehensive logging library for PHP.
- **psr/container** (^2.0): A common interface for dependency injection containers.

## Testing

This project uses PHPUnit for unit and integration tests. You can run the test suite using the following command:

```sh
composer test

# or with watch mode

composer test:watch
```

- ### Observations

  - The tests using coverage are stored in the `.phpunit/coverage` directory.
    - The coverage requires the [`xdebug`](https://xdebug.org/docs/install) extension to be installed.

## Standards

This project follows the following PSRs:

- **PSR-1**
- **PSR-2**
- **PSR-3**
- **PSR-4**
- **PSR-11**
- **PSR-12**

### The installed code standards are:

- **PEAR**
- **PSR-1**
- **PSR-2**
- **PSR-12**
- **Squiz**
- **Zend**

## License

This plugin is licensed under the GPL-3.0-or-later license. See the [LICENSE](https://www.gnu.org/licenses/gpl-3.0.txt) file for more information.

## Folders and Files:

- Initial plugin folders and files structure

```sh
.
├── config
│   ├── controllers.php
│   ├── facades.php
│   └── queries.php
├── includes
│   └── functions.php
├── languages
│   └── i18n
│       └── awesome.pot
├── requirements
│   └── php-version-notice.php
├── resources
│   ├── css
│   │   └── admin.css
│   └── js
│       └── admin.js
├── src
│   ├── Application
│   │   ├── Abstracts
│   │   │   └── Controller.php
│   │   ├── Controllers
│   │   │   ├── Email.php
│   │   │   └── PluginActivator.php
│   │   ├── Hooks
│   │   │   ├── Action.php
│   │   │   └── Filter.php
│   │   ├── App.php
│   │   ├── Config.php
│   │   └── Kernel.php
│   ├── Domain
│   │   ├── Constants
│   │   │   └── Version.php
│   │   ├── Enums
│   │   │   └── Event.php
│   │   └── Interfaces
│   │       ├── ActionInterface.php
│   │       ├── AppInterface.php
│   │       ├── BootableInterface.php
│   │       ├── ConfigInterface.php
│   │       ├── ContainerExceptionInterface.php
│   │       ├── ContainerInterface.php
│   │       ├── ContainerNotFoundExceptionInterface.php
│   │       ├── ControllerInterface.php
│   │       ├── DatabaseManagerInterface.php
│   │       ├── FilterInterface.php
│   │       ├── HookAttributeInterface.php
│   │       ├── HookInterface.php
│   │       ├── HookRegistrarInterface.php
│   │       ├── InvalidArgumentExceptionInterface.php
│   │       ├── LinkInterface.php
│   │       ├── LoggerInterface.php
│   │       ├── MapInterface.php
│   │       ├── MenuPageInterface.php
│   │       ├── NoticeInterface.php
│   │       ├── OptionInterface.php
│   │       ├── PageInterface.php
│   │       ├── RequireFileInterface.php
│   │       ├── RunnerInterface.php
│   │       ├── SystemInterface.php
│   │       └── ViewInterface.php
│   ├── Infrastructure
│   │   ├── Abstracts
│   │   │   ├── EventAttribute.php
│   │   │   └── HookAttribute.php
│   │   ├── Attributes
│   │   │   ├── Action.php
│   │   │   ├── Filter.php
│   │   │   └── On.php
│   │   ├── Exceptions
│   │   │   ├── ContainerException.php
│   │   │   ├── ContainerNotFoundException.php
│   │   │   └── InvalidArgumentException.php
│   │   ├── Facades
│   │   │   ├── Action.php
│   │   │   ├── App.php
│   │   │   ├── Config.php
│   │   │   ├── Container.php
│   │   │   ├── DatabaseManager.php
│   │   │   ├── Dependency.php
│   │   │   ├── Facade.php
│   │   │   ├── Filter.php
│   │   │   ├── HookRegistrar.php
│   │   │   ├── Option.php
│   │   │   ├── Plugin.php
│   │   │   ├── RequireFile.php
│   │   │   └── System.php
│   │   ├── Loggers
│   │   │   ├── Level.php
│   │   │   ├── Logger.php
│   │   │   └── NullLogger.php
│   │   ├── Repositories
│   │   │   └── DatabaseManager.php
│   │   ├── Services
│   │   │   └── Option.php
│   │   ├── Supports
│   │   │   └── HookRegistrar.php
│   │   └── Utils
│   │       ├── Map.php
│   │       ├── RequireFile.php
│   │       └── System.php
│   ├── Models
│   └── Presentation
│       ├── Abstracts
│       │   └── Notice.php
│       ├── Controllers
│       │   ├── Admin.php
│       │   └── Page.php
│       ├── Dto
│       │   ├── GenericNotice.php
│       │   ├── Link.php
│       │   ├── MenuPage.php
│       │   └── Page.php
│       ├── Utils
│       │   ├── Dependency.php
│       │   └── Plugin.php
│       └── Views
│           ├── Link.php
│           ├── Notice.php
│           └── Page.php
├── tests
│   ├── e2e
│   │   └── PluginLoadTest.php
│   ├── shared
│   │   ├── AbstractDatabaseTestCase.php
│   │   ├── AbstractTestCase.php
│   │   ├── GenericEnum.php
│   │   ├── Util.php
│   │   ├── WpdbInterface.php
│   │   ├── constants.php
│   │   └── wp-functions-polyfill.php
│   └── unit
│       ├── Application
│       │   ├── Controllers
│       │   │   ├── EmailTest.php
│       │   │   └── PluginActivatorTest.php
│       │   ├── Hooks
│       │   │   ├── ActionTest.php
│       │   │   └── FilterTest.php
│       │   ├── AppTest.php
│       │   ├── ConfigTest.php
│       │   └── KernelTest.php
│       ├── Includes
│       │   └── FunctionsTest.php
│       ├── Infrastructure
│       │   ├── Abstracts
│       │   │   └── EventAttributeTest.php
│       │   ├── Repositories
│       │   │   └── DatabaseManagerTest.php
│       │   └── Utils
│       │       └── SystemTest.php
│       ├── AbstractUnitTestCase.php
│       └── bootstrap.php
├── wordpress
│   ├── nginx
│   │   ├── certs
│   │   ├── Dockerfile
│   │   └── default.conf
│   ├── cli.sh
│   ├── compose.yaml
│   └── wp-config.php
├── Dockerfile.test
├── Makefile
├── awesome.php
├── compose.test.yaml
├── composer.json
├── composer.lock
├── package-lock.json
├── package.json
├── phpcs.xml.dist
├── phpunit-watcher.yml.dist
├── phpunit.xml.dist
├── readme.md
└── uninstall.php
```
