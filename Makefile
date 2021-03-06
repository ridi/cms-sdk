.PHONY: all thrift thrift-php thrift-js thrift-python

all: thrift

thrift: clean thrift-php thrift-js thrift-python

clean:
	rm -rf lib/php/src/Thrift/*/
	rm -rf lib/js/lib/CmsClient/thrift
	rm -rf lib/python/ridi/cms/thrift

thrift-php:
	thrift -r --gen php:server,psr4 lib/thrift-idl/AdminMenu.thrift
	thrift -r --gen php:server,psr4 lib/thrift-idl/AdminTag.thrift
	thrift -r --gen php:server,psr4 lib/thrift-idl/AdminUser.thrift
	thrift -r --gen php:server,psr4 lib/thrift-idl/AdminAuth.thrift
	cp -a gen-php/Ridibooks/Cms/Thrift/ lib/php/src/Thrift/
	rm -rf gen-php

thrift-js:
	thrift -r --gen js:node lib/thrift-idl/AdminMenu.thrift
	thrift -r --gen js:node lib/thrift-idl/AdminTag.thrift
	thrift -r --gen js:node lib/thrift-idl/AdminUser.thrift
	thrift -r --gen js:node lib/thrift-idl/AdminAuth.thrift
	cp -a gen-nodejs/ lib/js/lib/CmsClient/thrift/
	rm -rf gen-nodejs

thrift-python:
	thrift -r --gen py:coding=utf-8 lib/thrift-idl/AdminAuth.thrift
	thrift -r --gen py:coding=utf-8 lib/thrift-idl/AdminMenu.thrift
	thrift -r --gen py:coding=utf-8 lib/thrift-idl/AdminTag.thrift
	thrift -r --gen py:coding=utf-8 lib/thrift-idl/AdminUser.thrift
	cp -a gen-py/ lib/python
	rm -rf gen-py
