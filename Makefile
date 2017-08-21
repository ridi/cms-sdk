.PHONY: all thrift

all: thrift

thrift:
	thrift -r --gen php:server,psr4 src/Thrift/AdminMenu.thrift
	thrift -r --gen php:server,psr4 src/Thrift/AdminTag.thrift
	thrift -r --gen php:server,psr4 src/Thrift/AdminUser.thrift
	cp -r gen-php/Ridibooks/Cms/Thrift/* src/Thrift/
	rm -rf gen-php
