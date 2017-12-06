.PHONY: all thrift thrift-php thrift-js

all: thrift

thrift: thrift-php thrift-js

thrift-php:
	thrift -r --gen php:server,psr4 lib/thrift-idl/AdminMenu.thrift
	thrift -r --gen php:server,psr4 lib/thrift-idl/AdminTag.thrift
	thrift -r --gen php:server,psr4 lib/thrift-idl/AdminUser.thrift
	cp -a gen-php/Ridibooks/Cms/Thrift/ lib/php/src/Thrift/
	rm -rf gen-php

thrift-js:
	thrift -r --gen js:node lib/thrift-idl/AdminMenu.thrift
	thrift -r --gen js:node lib/thrift-idl/AdminTag.thrift
	thrift -r --gen js:node lib/thrift-idl/AdminUser.thrift
	cp -a gen-nodejs/ lib/js/lib/CmsClient/thrift/
	rm -rf gen-nodejs
