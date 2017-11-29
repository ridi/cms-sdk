.PHONY: all install cms-up cms-down

all: install

install:
	composer install
	composer create-project ridibooks/cms-bootstrap:dev-package ./cms-bootstrap

cms-up:
	make -C cms-bootstrap cms-up

cms-down:
	make -C cms-bootstrap cms-down
