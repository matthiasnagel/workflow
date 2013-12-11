# Test Driven Design with Continuous Integration in Open Source Projects

System Engineering und Management (EDV-Nr: 38311) bei [Prof. Walter Kriha](http://kriha.de/).



#Abstract

neg:
- many projects are chaotic 
- working without conventions
- various configs
- no deployment
- no (real, proveable) tests
- worse code quality due to lack of architecture (quick & dirty, straight forward)

pos:
- planning phase
- principles of tdd + value of tdd
- Continous integration + value of ci
- know your tools
- aspect of intro time for improved workflow


## Motivation

The first step of professional software development is the version control of your software via a tool like subversion or git. But big projects need much more than just version control to work efficient and clean. To have an overview of neccessary tools and paradigms for professional software development, we'd like to analyze some open-source tools and services. Our focus will be on test-driven development (tdd) and the continuous integration process. With our insights, we'd like to develop an ideal workflow. Testing and Evaluation of this workflow will happen on the basis of a small vocabulary trainer software project.
```
Die Versionierung von Software über Subversion oder Git ist der erste Schritt einer professionellen Entwicklung. Große Softwareprojekte gehen jedoch weit über die Versionierung hinaus. Dazu möchten wir große Projekte im OpenSource Bereich untersuchen und bestimmen, welche Architektur, Tools und Services eingesetzt werden. Dabei legen wir den Fokus auf das Test Driven Development und dem Continuous Integration Prozess. Anhand der Ergebnisse wollen wir einen optimalen Workflow erarbeiten und anhand einer Eigenentwicklung testen und evaluieren.
```

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

### PHPUnit Options

In PHPUnit, there are different options for getting testing visible in the shell.

####1.) phpunit --debug

Displays debugging information (e.g. ExceptionStack for Exceptions or filepath + linenumber for failed tests) during test execution.

```
phpunit --debug
PHPUnit 3.7.28 by Sebastian Bergmann.

Configuration read from ..../workflow/www/phpunit.xml


Starting test 'VocabFileParserTest::testParseSingleFile'.
.
Starting test 'VocabFileParserTest::testParseMultiFiles'.
.
Starting test 'VocabProviderTest::testMakeVocab'.
.
Starting test 'VocabProviderTest::testInsertVocab'.
E
Starting test 'VocabTest::testDummy'.
.

Time: 216 ms, Memory: 9.00Mb

There was 1 error:

1) VocabProviderTest::testInsertVocab
PDOException: SQLSTATE[HY000] [2003] Can't connect to MySQL server on '127.0.0.1' (61)
```


####2.) phpunit --tap

Report test execution progress in TAP format.

```
phpunit --tap
TAP version 13
ok 1 - VocabFileParserTest::testParseSingleFile
ok 2 - VocabFileParserTest::testParseMultiFiles
ok 3 - VocabProviderTest::testMakeVocab
not ok 4 - Error: VocabProviderTest::testInsertVocab
ok 5 - VocabTest::testDummy
1..5
```


####3.) phpunit --testdox

Test execution progress gets reported in TestDox format to the shell.

```
phpunit --testdox
PHPUnit 3.7.28 by Sebastian Bergmann.

Configuration read from ..../workflow/www/phpunit.xml

VocabFileParser
 [x] Parse single file
 [x] Parse multi files

VocabProvider
 [x] Make vocab
 [ ] Insert vocab

Vocab
 [x] Dummy
```


## Nice Links
* [PHP Unit Manual (Official)](http://phpunit.de/manual/current/en/index.html)
* [Best PHP Unit Tutorial on the WWW](https://jtreminio.com/2013/03/unit-testing-tutorial-introduction-to-phpunit/), especially check [this](https://jtreminio.com/2013/03/unit-testing-tutorial-part-3-testing-protected-private-methods-coverage-reports-and-crap/) chapter!
* [Testing Private Methods with Mocks](http://stackoverflow.com/questions/5937845/phpunit-private-method-testing)


### The actual Vocab Trainer
**Note**: Entire process described in the [Wiki](https://github.com/csm-sem/workflow/wiki/Wiki:-The-Coding-Procedure-using-the-Laravel-Framework).


## App

### Architecture

![Vocab Architecture][logo]

[logo]: https://raw.github.com/csm-sem/workflow/master/res/Vocab.png "Vocab Architecture"

We use that basic architecture to wrap finally that logic in Laravel.

## Initial Tasks
### Configure your Laravel environment
* Make sure, you've gone through all the [steps](https://github.com/csm-sem/workflow/blob/master/PAPER.md#installation) concerning the framework installation.
* Now adapt your database config in `<project_path>/www/app/config/database.php` (the mysql connection array only), usually that's db-name, user and pw.
```
                 [...]
			'database'  => 'vocab_laravel', //mandatory for compatibility
			'username'  => '<usrname>',
			'password'  => '<paswrd>',
                 [....]
```
* Create the database `vocab_laravel` itself using the mysql shell, phpmyadmin or whatever.

### Set up (the) application table(s) and model(s)
* Run `php artisan migrate:make create_vocab_table` in `<project_path>/www/`.
This call generates a migration class "CreateVocabTable" with an easy to handle code-body. You find the migration in `<project_path>/www/app/database/migration/<date_of_creation>_create_vocab_table.php`

**Note**: This is a one-time procedure which won't be repeated after a common repository pull.

* Edit the migration. Initially, let's say
```
    public function up() {
        Schema::create('vocabs', function($table) {
            $table->increments('id');
            $table->string('word')->unique();
            $table->enum('type', array('noun', 'verb', 'adjective'));
            $table->text('translations');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('vocabs');
    }
```
* Now run `php artisan migrate` in the shell. This will actually create the table for the `vocab_laravel` db.

**Note**: If you get an error here, you've forgot something during the configuration of the Laravel environment.

**Note**: If you alter something in your migration methods, just run the command again. If you realize, you've done something stupid, just rollback to the previous migration state via `php artisan migrate:rollback`.

* To access this table, we need a related (model) class Vocab, which we create in `<project_path>/www/app/models` and which looks like this:
```
class Vocab extends Eloquent {
    protected $fillable = array('word', 'type', 'translations');
}
```

**Note**: The `$fillable` is not mandatory but that way we assure, that no other column is manipulated (for example, we don't want to insert an `'id'` manually).

* That's pretty much it - you can go ahead and create a view for this model following the [instructions](http://laravel.com/docs/quick).

## Get the ExampleTest running
* A simple `composer update` fixed the dependency problems for me.

**Note**: Just **do not** try to get the unit tests running within your IDE, Laravel unit tests are meant to be run in shell only.

## Writing first functionality and unit tests

### Vocab Provider
* What we wanna do is to insert and read vocab records from the db. This is easy using the eloquent ORM:
```
class VocabProvider extends BaseController {

    public function insertVocab(Vocab $vocab) {
        $vocab->save();
    }

    public function makeVocab(array $record) {
        $vocab = new Vocab;
        $vocab->word = $record['word'];
        $vocab->type = $record['type'];
        $vocab->translations = $record['translations'];
        return $vocab;
    }
}
```
This methods takes a record of a single vocab and inserts it in the vocab table.

* To test this method, we pretty much insert a record and look it up afterwards, if it's there, the test is successful:
```
class VocabProviderTest extends TestCase {

    protected $vocabProvider;
    protected $vocab;

    public function setUp() {
        parent::setUp();
        $this->vocabProvider = new VocabProvider;

        $record = array(
            'word' => "working",
            'type' => "noun",
            'translations' => "Arbeiten, Arbeit, Bearbeitung, Betrieb, Handhabung"
        );
        $this->vocab = $this->vocabProvider->makeVocab($record);
    }

    public function testMakeVocab() {
        $this->assertEquals("working", $this->vocab->word);
        $this->assertEquals("noun", $this->vocab->type);
        $this->assertStringEndsWith(", Handhabung", $this->vocab->translations);
    }

    public function testInsertVocab() {
        $this->vocab->save(); // this is to test
        $inDb = Vocab::where('word', '=', 'working')->get();
        // we expect 1 item -> 0th item in result.
        $vocab = $inDb[0];
        $this->assertEquals($this->vocab->type, $vocab->type);
        $this->assertEquals($this->vocab->translations, $vocab->translations);
        // if test was successful, just delete the entry
        $inDb[0]->delete();
    }
}
```

### Database Migration and Seeding

To create the databse schema just type the following command:
```
php artisan migrate
```

To seed the database with data just type the following command. It uses the parser internally.
```
php artisan db:seed
```


## Continuous Integration

### What is Continuous Integration

### Travis CI

#### About Travis CI

Travis CI is a hosted continuous intergration software with which you can trigger automated builds by every change in your repository on github (including master branch and others, or even pull requests). Travis CI supports private github repositories as well as public ones. It offers also a wide range of supported programming languages (e.g. PHP, Java, C, Ruby, etc. full list can be seen under [http://about.travis-ci.org/]). There's also the possibility to test your project against different environments, because Travis provides various options to set up your runtime, data storages, etc. (additional options given here [http://about.travis-ci.org/docs/user/build-configuration/]).



Travis CI Repository: [https://travis-ci.org/csm-sem/workflow](https://travis-ci.org/csm-sem/workflow)

Short description and instructions to configure Travic CI:
- [Welcome to Travis CI](http://about.travis-ci.org/)
- [Getting Started](http://about.travis-ci.org/docs/user/getting-started/)

Status: [![Build Status](https://travis-ci.org/csm-sem/workflow.png?branch=master)](https://travis-ci.org/csm-sem/workflow)

To automatically trigger our tests, we use following configuration:
(Mit der folgenden Konfiguration lassen wir die Tests automatisiert testen:)

```
language: php

php:
 - 5.5
 - 5.4

env:
 - LARAVEL_ENV=travis DB=mysql

before_script:
 - mysql -e 'create database vocab_laravel;'
 - cd www
 - composer self-update
 - composer install --dev
 - php artisan migrate --env=travis
 - php artisan db:seed --env=travis

after_script:
 - php artisan env
 - php artisan migrate:reset --env=travis
 - php artisan cache:clear

script: phpunit

notifications:
 email: false
```
For proper execution of the tests, you have to configure your environment in ``` .travis.yml```. This file should be found in the root directory of your repository. Under ```language``` you setup the required programming language(s).
Due to the fact that Laravel is a php framework and we're using phpunit for testing purposes, our programming language is php. Because Laravel requires php version >= 5.3.7, we've defined php version 5.4 and 5.5 as runtime for travis ci.
The Key Term ```env``` indicates further options for the environment. 
With ```LARAVEL_ENV=travis``` we're setting up a global server constant, which we can read in php. It is now possible, to load different envirenment settings for database(s) and application(s).
We're using a simple MySQL database, which we've declared via another constant ```DB=mysql```.

The part ```before_script``` contains commands, running sequentially before testing. The analogous part ```after_script``` contains commands, running after testing.

To indicate that we'd like to have our code tested with phpunit, we've set up the command ```script: phpunit```.
A further feature is the ```notifications```option, in which you could set up to be notified about your build. As we don't need any notifications, because our build is done within seconds and can be checked immediately after start via web gui, we haven't enabled this feature.

Before testing starts to run, a test environment is set up. Therefore we've declared under the ```before_script```part to create a database named ```vocab_laravel``` with the command ```mysql -e 'create database vocab_laravel;'```. The script afterwords changes to ```/www```, the main directory of the laravel project, and installs the required scripts via composer. The next step will be the creation of a scheme with migration data ```php artisan migrate --env=travis``` and the following seeding of the database with test data ```php artisan db:seed --env=travis```.

The pre-test section is done. The tests should now be ready to pass and return a test result. 

After the tests took place, the section ```after_script``` comes into play. There the scheme is dropped ```php artisan migrate:reset --env=travis``` and the whole framework cache gets cleared ```php artisan cache:clear```.


Damit Travis die Tests ausführen kann, müssen einige Einstellungen zur Entwicklungsumgebung in der ```.travis.yml``` Datei festlegt werden. Diese Datei befindet sich im Root des Repositories. Mit ```language``` werden die benötigten Programmiersprachen fesgelegtt. Da Laravel ein PHP Framework ist und zum Testen PHPUnit nutzt, setzten wir als Programmiersprache PHP ein. Laravel erfordert eine PHP Version größergleich 5.3.7. Bei Travis kann man multiple Versionen der angegebenen Sprache setzen, sodass wir PHP 5.4 und 5.5. definiert haben. Mit dem Schlüsselbegriff ```env``` werden weitere Einstellungen zur Entwicklungsumgebung angegeben. Wir setzten mit ```LARAVEL_ENV=travis``` eine globale Server-Konstante, die wir in PHP auslesen können. Dadurch ist es nun möglich, dass man diverse Umgebungseinstellungen zu Datenbanken und Applikation laden kann. Als Datenbank nutzen wir eine einfache MySQL Datenbank, die mit einer weiteren Konstanten ```DB=mysql``` festgelegt wird. ```before_script``` beinhaltet Befehle, die vor dem Testen sequentiell ausgeführt werden. ```after_script``` beinhaltet Befehle, die nach dem Testen ausgeführt werden. Mit dem Befehl ```script: phpunit``` wird das eigentliche Testen mit PHPUnit angestossen. Bevor die Tests durchlaufen werden, wird eine Testumgebung aufgebaut. Zu Begin wird mit dem Befehl ```mysql -e 'create database vocab_laravel;'``` eine Datenbank mit dem Namen ```vocab_laravel``` erzeugt. Anschließend wechselt das Script in das Hauptverzeichnis der Laravel Installation und installiert die benötigten Scripte. Daraufhin wird ein Schema über die Migrationsdateien aufgebaut ```php artisan migrate --env=travis``` und mit dem Seeder mit Test-Daten befüllt ```php artisan db:seed --env=travis```. Nach diesem Befehl werden die einzelnen Tests durchgeführt und ein Ergebnis ausgegeben. Nach den Tests wird das Schema aufgehoben und der gesamte Framework Cache geleert. Die ganzen Ergebnise werden in Echtzeit sequentiell auf Travis ausgegeben.
