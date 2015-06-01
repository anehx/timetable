#!/bin/bash

export DEBIAN_FRONTEND=noninteractive

# Load pre-defined settings, so debconf / apt-get won't ask any questions
debconf-set-selections < /vagrant/tools/vagrant/debconf-set-selections.txt

apt-get update
apt-get -q -y install lamp-server^ phpmyadmin php5-dev php5-xdebug

a2enmod rewrite
a2enmod ssl

# Add www-data to vagrant group
usermod -a -G vagrant www-data

cd /vagrant

echo "Setting up Apache config..."
rm /etc/apache2/sites-enabled/000-default.conf
ln -sf /vagrant/tools/vagrant/vhost.conf /etc/apache2/sites-enabled/default.conf
ln -sf /tmp /vagrant/tmp
service apache2 restart
ln -sf /vagrant/app/config/vagrant.ini /vagrant/app/config/config.ini
apt-get -q -y install php5-mysqlnd

echo "Preparing MySQL database..."
mysql -uroot -pvagrant < /vagrant/tools/vagrant/database.sql
mysql -uroot -pvagrant timetable < /vagrant/app/sql/timetable.sql
mysql -uroot -pvagrant timetable < /vagrant/app/sql/initial.sql
