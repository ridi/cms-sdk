.PHONY: all server client thrift

all: server client thrift

server:
	make -C server

client:
	composer update --no-dev --optimize-autoloader

thrift:
	make -C src/thrift-src

