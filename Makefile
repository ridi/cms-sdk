.PHONY: all client thrift

all: client thrift

client:
	composer install --no-dev --optimize-autoloader

thrift:
	make -C src/thrift-src

