<?php

/*
 * @author rellek
 */
print "...\n";
print "... Init Vocab Trainer app- and test-database:\n...\n";
$dbInfo = parse_ini_file('config.ini') or die("Cannot parse given *.ini\n");

$con = mysqli_connect(
        $dbInfo['dbHost'], $dbInfo['dbUser'], $dbInfo['dbPass']
        ) or
        die("Cannot connect to mysql server, check host, username and password!\n");

// init db + debug/test db (aka vocab table)
function initDb($con, $dbName) {
    mysqli_query($con, 'CREATE DATABASE IF NOT EXISTS ' . $dbName .
                    ' CHARACTER SET utf8 COLLATE utf8_unicode_ci;') or
            die("Cannot create database $$dbName  check db name specification!\n");

    mysqli_select_db($con, $dbName) or
            die("Cannot select database $dbName\n");

    mysqli_query($con, 'CREATE TABLE IF NOT EXISTS vocab (
        vid INT NOT NULL AUTO_INCREMENT,
        word VARCHAR(128) NOT NULL,
        vtype ENUM("noun", "verb", "adjective") NOT NULL,
        translations MEDIUMTEXT NOT NULL, 
        PRIMARY KEY (vid)
        );') or
            die("Cannot create vocab table in database $dbName,  check your"
                    . " query syntax.\n");
    print "... $dbName db - installed succesfully\n";
}

initDb($con, $dbInfo['dbName'] . "_app"); // app db
initDb($con, $dbInfo['dbName'] . "_dev"); // dev db

mysqli_close($con) or die("Cannot close connection to mysql db.\n");
print "...\n... Installation successfully completed\n";
