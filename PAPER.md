# Test Driven Development with Continuous Integration in Open Source Projects

System Engineering und Management, [Prof. Walter Kriha](http://kriha.de/), WS 13-14, HdM Stuttgart

### About this document
The following has to be read as a working document, since we've added and updated its parts over time. It's not meant to be a scientific paper. We've just documented what we've done during the semester and how we've experienced a couple of things that we handled. Sources are direclty hyperlinked in the text.

### Contents
tbd

***

#Abstract

As software developers, we've all experienced it in many different ways: an unstructured and even chaotic project environment. Sadly, many development teams are working without clearly defined conventions, without having any sort of cleanly structured **workflow**. Just like everyone is doing their own style in their own setup and time is wasted to build bridges between these varying setups. Code isn't tested in any serious way, but the author's quick and dirty __works for me__ experience. Another sad but common example is the lack of time and thoughts spent on the modelling and architecture process. These are only a minimal number of the developer's daily life encountered problems.

The described naturally leads to serious problems at the latest, when you get to the point where sourcecode has to be merged or tested or somebody else has to use or further develop existing code. On top, these scenarios often tend to carry a lot of (social) conflict potential, which will eventually lead to the loss of an unnecessary amount of valuable time and last but not least they will drive the involved people crazy.

To avoid a big number of these problems, you should start your project with a solid planning phase. At that time, it's important to make some things clear: what versions of tools, what language, what IDE, what repository, what OS, etc. are you going to use. Make sure, that everybody in your team is willing to give a quality commitment concerning the work contributed - it has to be suiting the defined standards.

An actually important thing about software is, that you can provide a certain quality of code. You will have an easy time to prove this quality by covering your functional code by unit tests - guaranteed results for a certain input at runtime, that's something. We've experienced unit testing, especially test driven design as a very positive experience, that provides a direct return of investment, measurable in code quality. 

Another workflow enhancement is continuous integration - a runtime simulating environment which is shared by a developer team to see code in realistic action. After each and every commit - there will be no more trash code carried from revision to revision, but the possibility to directly work on fixing it.

In the following we give an introduction to these two improvement aspects in the context of our vocabulary trainer application.

***

# Kickoff

## Motivation

The first step of professional software development is the version control of your software with a repository management tool like subversion or git. But big projects need much more than just versioning control to work efficiently and cleanly. To have an overview of helpful tools and paradigms for professional software development, we'd like to analyze some open-source tools and services. Our focus will be on test-driven development (TDD) and the continuous integration (CI) process. With our insights, we'd like to develop an ideal workflow. Testing and Evaluation of this workflow will happen on the basis of the development of a small vocabulary trainer application.

## Brainstorming

### about the App

A possible test driven developed demo application could be a (simple) vocabulary trainer, which accesses a vocab database (a single table should do it), can parse *.csv files or other input formats, etc. This simple application would provide a perfect environment for getting started in TDD plus would be easy to be overviewed in the context of automated deployment, integration testing, and so on. 

### about possible Tools

Package and dependency management:

* [npm](http://nodejs.org/) (node.js)
* [Bundler](http://bundler.io/) ([bundler/bundler](https://github.com/bundler/bundler)) (ruby gem)
* [Composer](http://getcomposer.org/) ([composer/composer](https://github.com/composer/composer)) (php)
* [Homebrew](http://brew.sh/) ([mxcl/homebrew](https://github.com/mxcl/homebrew)) (osx), [Apt](https://wiki.debian.org/Apt) (linux)

Automation:

* ~~[Ant](http://ant.apache.org/)~~ (java)
* [Guard](http://guardgem.org/) ([guard/guard](https://github.com/guard/guard))
* [Grunt](http://gruntjs.com/) (npm)
* Software Deployment (Frontend, Backend)

Test Driven Development:

* [PHPUnit](https://github.com/sebastianbergmann/phpunit/) PHP Unit is **the established** framework for unit testing of php code. It provides functionality equivalent to JUnit plus another set of advanced features, such as object mocking.
* [Jasmine](http://pivotal.github.io/jasmine/) ([pivotal/jasmine](https://github.com/pivotal/jasmine))

Other services:

* [GitHub](http://github.com/)
* [BitBucket](https://bitbucket.org/)
* [Travis-CI](https://travis-ci.org/)
* …

***

### Decisions









# Setting up the environment

## Installations

### System requirements

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

### Laravel

We created a laravel project via composer:

```
composer create-project laravel/laravel www
cd www
```

Install the project dependencies from the [composer.lock](https://github.com/csm-sem/workflow/blob/master/www/.gitignore) file if present, or fall back on the [composer.json](https://github.com/csm-sem/workflow/blob/master/www/composer.json). If you checkout the repository, you just need to execute the following command (in <path>/www) to install the required dependencies:

```
composer install
```

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

And there you go, your initial laravel framework project is ready to be developed.

## Inits: The vocab trainer application

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

**Note**: If you get an error here, you've forgoten something during the configuration of the Laravel environment.

**Note**: If you alter something in your migration methods, just run the command again. If you realize, you've done something stupid, just rollback to the previous migration state via `php artisan migrate:rollback`.

* To access this table, we need a related (model) class Vocab, which we create in `<project_path>/www/app/models` and which looks like this:
```
class Vocab extends Eloquent {
    protected $fillable = array('word', 'type', 'translations');
}
```

**Note**: The `$fillable` is not mandatory but that way we assure, that no other column is manipulated (for example, we don't want to insert an `'id'` manually).

* That's pretty much it - you can go ahead and create a view for this model following the [instructions](http://laravel.com/docs/quick).



***

# TDD and PHP Unit

## Writing a first test and functionality:

### Vocab Provider
* What we wanna do is to insert and read vocabulary records from the db. This is easy using laravel's **eloquent object relation mapping**. Let's say what we want to have is a provider class which will be working as our db-interface (it will provide vocabs, which are queried from the database):

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

## Test Driven Development

It's okay to do it as above, if you have methods of about 5 lines of code with no side-effects possible. It's better practice though and will eventually become worth it, to first write the test and then write the method itself. This order is promoted by the paradigm of **test driven development (TTD)**. Also, that's pretty much what it is all about - first write a test, then write the method, for which you've written the test. Then, go on with the next method, and so on. During the development process we strictly did it in the TTD-order, which was a bit hard at first but we've directly felt the payoff: You think about what a method is supposed to do, then you write the test with a couple of assertions which are supposed to check the output to certain inputs. Finally, you write your method and run the test. It's a bit like you are forced into writing good code, since you will implement the exact thing you've thought about at first and which will be checked by the test.

## Nice Links concerning PHP Unit
The following links have served well as first references on the topic:

* [PHP Unit Manual (Official)](http://phpunit.de/manual/current/en/index.html)
* [Best PHP Unit Tutorial on the WWW](https://jtreminio.com/2013/03/unit-testing-tutorial-introduction-to-phpunit/), especially check [this](https://jtreminio.com/2013/03/unit-testing-tutorial-part-3-testing-protected-private-methods-coverage-reports-and-crap/) chapter!
* [Testing Private Methods with Mocks](http://stackoverflow.com/questions/5937845/phpunit-private-method-testing)





## Some advanced PHPUnit Options for command line usage

In PHPUnit, there are different options for getting testing visible in the shell.

###1.) phpunit --debug

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


###2.) phpunit --tap

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


###3.) phpunit --testdox

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


***
# CI and Travis

## Continuous Integration

### What is Continuous Integration?

Continuous Integration (CI) is a software development practice for testing the code base constantly and completely after new changes have been made. This process increases the quality of your software and reduces time needed for testing.
The Idea of CI is the quick integration of code changes, improvements and new features made by the developer. As soon as the developer has integrated his changes into the version control system, the software will be compiled completely new and totally covered with automatic unit tests.

The advantages of continuous integration:

* Integration problems will be detected constantly - not just one day before a release
* Developers can return quickly to an old code base without investing to much time in bug hunting
* All changes will be tested immediately

For further reading have a look at this [CI-article](http://martinfowler.com/articles/continuousIntegration.html) by Martin Fowler (we think it is probably the best out there).

## Travis CI

### About Travis CI

Travis CI is a hosted continuous intergration software with which you can trigger automated builds by every change in your repository on github (including master branch and others, or even pull requests). Travis CI supports private github repositories as well as public ones. As a developer you give Travis the rights to checkout the repository and to run the tests in the cloud after you push a commit to your GitHub repository. It is recommended to push small changes, so Travis can run all the tests in the background immediately. If a test fails, you can receive a notification mail via Travis.

### Different environments

Travis offers also a wide range of [supported programming languages](http://about.travis-ci.org/) (e.g. PHP, Java, C, Ruby, etc.). There's also the possibility to test your project against different environments, because Travis provides [various options](http://about.travis-ci.org/docs/user/build-configuration/) to set up your runtime, data storages, etc. It is recommended to apply the production environment, because it doeasn't make sense to run the tests against another environments.

### Application environment

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

## GitHub

We highly recommend to use [Git](http://git-scm.com/), the state of the art tool for version control. Withit you have access to the change history of your code. In the next lines we demonstrate the basic usage of that helpful tool. GitHub uses Git. We hope, that you are not suprised.

In the next lines we describe the basic commands to use that version control. First create a new directory ```mkdir myproject```, open it ```cd myproject``` and perform ```git init``` to create a new git repository. After that you can propose changes (add it to the index) using ```git add <filename>``` or ```git add *```. This is the first step in the basic git workflow. To actually commit these changes use ```git commit -m "Commit message"```. Now the file is committed to the local HEAD, but not in your remote repository yet. Your changes are now in the HEAD of your local working copy. To send those changes to your remote repository, execute ```git push origin master```. If you have not cloned an existing repository and want to connect your repository to a remote server, you need to add it with ```git remote add origin <server>```. Before that you have to create a [new repository](https://github.com/new) at Github. Now you are able to push your changes to the selected remote server. We used a [public GitHub repository](https://github.com/csm-sem/workflow) for version control and connected it with [Travis CI](https://travis-ci.org/csm-sem/workflow).

## Application

### Screenshots

Here you see several screenshots of the final vocab trainer:

![Screenshot 1](https://raw.github.com/csm-sem/workflow/master/res/screen_1.png)

---

![Screenshot 2](https://raw.github.com/csm-sem/workflow/master/res/screen_2.png)

---

![Screenshot 3](https://raw.github.com/csm-sem/workflow/master/res/screen_3.png)
