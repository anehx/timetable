# timetable

A php app for teachers and students to see their timetable online

# Installation

First of all, install composer and run `composer install`. After this you need to run `vendor/bin/phpdoc.php` to
generate the API Documentation.

## Vagrant

Just install vagrant and vagrant-hostsupdater-plugin and run `vagrant up`

## XAMPP

Copy the `app/config/development.ini` to `app/config/config.ini` and edit the values according to your XAMPP config.

# Initial data

If you want some initial data to test or something, you can insert `app/sql/initial.sql` into your database and run
`app/bin/generateLessons.php` to randomly generate some lessons into your application.