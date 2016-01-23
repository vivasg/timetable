#!/usr/bin/env bash

mysql -udev -p1 --character-set-server=utf8 --collation-server=utf8_unicode_ci timetable < /vagrant/timetable.sql