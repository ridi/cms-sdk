.PHONY: all thrift thrift-php thrift-js

all: thrift

thrift: thrift-php thrift-js

thrift-php:
	thrift -r --gen php:server,psr4 lib/thrift/AdminMenu.thrift
	thrift -r --gen php:server,psr4 lib/thrift/AdminTag.thrift
	thrift -r --gen php:server,psr4 lib/thrift/AdminUser.thrift
	cp -r gen-php/Ridibooks/Cms/Thrift/* lib/php/Thrift/
	rm -rf gen-php

thrift-js:
	thrift -r --gen js:node lib/thrift/AdminMenu.thrift
	thrift -r --gen js:node lib/thrift/AdminTag.thrift
	thrift -r --gen js:node lib/thrift/AdminUser.thrift
	cp -r gen-nodejs/* lib/js/lib/CmsClient/thrift/
	rm -rf gen-nodejs
