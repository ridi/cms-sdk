.PHONY: all thrift thrift-php thrift-nodejs

all: thrift

thrift: thrift-php thrift-nodejs

thrift-php:
	thrift -r --gen php:server,psr4 src/thrift/AdminMenu.thrift
	thrift -r --gen php:server,psr4 src/thrift/AdminTag.thrift
	thrift -r --gen php:server,psr4 src/thrift/AdminUser.thrift
	cp -r gen-php/Ridibooks/Cms/Thrift/* src/php/Thrift/
	rm -rf gen-php

thrift-nodejs:
	thrift -r --gen js:node src/thrift/AdminMenu.thrift
	thrift -r --gen js:node src/thrift/AdminTag.thrift
	thrift -r --gen js:node src/thrift/AdminUser.thrift
	cp -r gen-nodejs/* src/nodejs/thrift/
	rm -rf gen-nodejs
