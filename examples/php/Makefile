.PHONY: all install cms-up cms-down

all: install

install:
	composer install
	composer create-project ridibooks/cms-bootstrap:dev-package ./cms-bootstrap

cms-up:
	cd cms-bootstrap && make cms-up

cms-down:
	cd cms-bootstrap && make cms-down
