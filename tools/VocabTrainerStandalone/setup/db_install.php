<?php
/* 
 * @author rellek
 */

$dbInfo = parse_ini_file('config.ini');

$con = mysqli_connect(
        $dbInfo['dbHost'], $dbInfo['dbUser'], $dbInfo['dbPass']
);

mysqli_query($con, 'CREATE DATABASE IF NOT EXISTS ' . $dbInfo['dbName'] .
        ' CHARACTER SET utf8 COLLATE utf8_unicode_ci;');

mysqli_select_db($con, $dbInfo['dbName']);

// init vocab table
mysqli_query($con, 'CREATE TABLE IF NOT EXISTS vocab (
        vid INT NOT NULL AUTO_INCREMENT,
        word VARCHAR(128) NOT NULL,
        vtype ENUM("noun", "verb", "adjective") NOT NULL,
        translations MEDIUMTEXT NOT NULL, 
        PRIMARY KEY (vid)
        );');

mysqli_close($con);