.PHONY: clean all

all: thrift

thrift:
	thrift -r --gen php:server,psr4 AdminMenu.thrift
	thrift -r --gen php:server,psr4 AdminTag.thrift
	thrift -r --gen php:server,psr4 AdminUser.thrift
	cp -r gen-php/Ridibooks/Cms/Thrift/* ../thrift/
	rm -rf gen-php

doc:
	mkdir -p docs
	thrift -r --gen html:standalone -out docs AdminMenu.thrift
	thrift -r --gen html:standalone -out docs AdminTag.thrift
	thrift -r --gen html:standalone -out docs AdminUser.thrift

clean:
	rm -rf gen-* dist-* docs
