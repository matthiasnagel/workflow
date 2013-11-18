# Continuous Integration in OpenSource Software Development

System Engineering und Management (EDV-Nr: 38311) von [Prof. Walter Kriha](http://kriha.de/).

## Motivation

Die Versionierung von Software über Subversion oder Git ist der erste Schritt einer professionellen Entwicklung. Große Softwareprojekte gehen jedoch weit über die Versionierung hinaus. Dazu möchten wir große Projekte im OpenSource Bereich untersuchen und bestimmen, welche Architektur, Tools und Services eingesetzt werden. Dabei legen wir den Fokus auf das Test Driven Development und dem Continuous Integration Prozess. Anhand der Ergebnisse wollen wir einen optimalen Workflow erarbeiten und anhand einer Eigenentwicklung testen und evaluieren.


## Planung

* Untersuchung von großen OpenSource Projekten anhand von [GitHub](http://github.com/) und [Travis-CI](https://travis-ci.org/).
* Welche Tools werden eingesetzt? Welche Services werden eingesetzt? Unterschiede? Performance? Vor- und Nachteile?
* Aufsetzen einer testgetriebenen Software (Website) auf GitHub und Travis-CI.

## Brainstorming

### App

Possible test driven developed (demo-)application could be a (simple) vocabulary trainer, which accesses a vocab database (prolly a single table), can parse *.csv files or other input formats, etc. This simple application would provide a perfect environment for getting started in test driven dev plus would be easy to be overviewed in the context of auto-deployment, integration testing, etc. 

### Tools

Package Manager und Dependency Management:

* [npm](http://nodejs.org/) (node.js)
* [Bundler](http://bundler.io/) ([bundler/bundler](https://github.com/bundler/bundler)) (ruby gem)
* [Composer](http://getcomposer.org/) ([composer/composer](https://github.com/composer/composer)) (php)
* …
* [Homebrew](http://brew.sh/) ([mxcl/homebrew](https://github.com/mxcl/homebrew)) (osx), [Apt](https://wiki.debian.org/Apt) (linux)

Automatisierung:

* ~~[Ant](http://ant.apache.org/)~~ (java)
* [Guard](http://guardgem.org/) ([guard/guard](https://github.com/guard/guard))
* [Grunt](http://gruntjs.com/) (npm)
* …
* Software Deployment (Frontend, Backend)

Test Driven Development:

* [PHPUnit](https://github.com/sebastianbergmann/phpunit/) (php)
* [Jasmine](http://pivotal.github.io/jasmine/) ([pivotal/jasmine](https://github.com/pivotal/jasmine)) (javascript)
* …


### Services

* [GitHub](http://github.com/)
* [BitBucket](https://bitbucket.org/)
* [Travis-CI](https://travis-ci.org/)
* …


## Installation

### System Requirements

* PHP 5.4.* (Laravel, Composer, Server Configuration) ```php -v```

### Composer

Description:

> Composer is a tool for dependency management in PHP. It allows you to declare the dependent libraries your project needs and it will install them in your project for you.

>  Composer requires PHP **5.3.2+** to run. A few sensitive php settings and compile flags are also required, but the installer will warn you about any incompatibilities.

> To install packages from sources instead of simple zip archives, you will need git, svn or hg depending on how the package is version-controlled.

> Composer is multi-platform and we strive to make it run equally well on Windows, Linux and OSX.

[Installation of composer](http://getcomposer.org/doc/00-intro.md#globally):

```
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
composer -V
```
We created a laravel project via composer:

```
composer create-project laravel/laravel www
cd www
```

Install the project dependencies from the [composer.lock](https://github.com/csm-sem/workflow/blob/master/www/.gitignore) file if present, or fall back on the [composer.json](https://github.com/csm-sem/workflow/blob/master/www/composer.json). If you checkout the repository, you just need to execute the following command (in <path>/www) to install the required dependencies:

```
composer install
```

### Laravel

With the following alias, you can use the short version of artisan:

```
alias art="php artisan"
```

Start server via artisan (http://localhost:8000) or create manually a vhost (etc/hosts, apache configuration):

```
cd www
art serve
// or
// php -S localhost:8000 -t public
```

**Note**: You need execute-permissions on the artisian php-file.

### The actual Vocab Trainer
**Note**: Entire process described in the [Wiki](https://github.com/csm-sem/workflow/wiki/Wiki:-The-Coding-Procedure-using-the-Laravel-Framework).


## App

### Architecture

![Vocab Architecture][logo]

[logo]: https://raw.github.com/csm-sem/workflow/master/res/Vocab.png "Vocab Architecture"

We use that basic architecture to wrap finally that logic in Laravel.


## Continuous Integration

Travis CI Repository: [https://travis-ci.org/csm-sem/workflow](https://travis-ci.org/csm-sem/workflow)

Short description and instructions to configure Travic CI:
- [Welcome to Travis CI](http://about.travis-ci.org/)
- [Getting Started](http://about.travis-ci.org/docs/user/getting-started/)
