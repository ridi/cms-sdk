.PHONY: all install cms-up cms-down run

all: install run

install:
	npm install
	composer create-project ridibooks/cms-bootstrap:dev-package ./cms-bootstrap

cms-up:
	cd cms-bootstrap && make cms-up

cms-down:
	cd cms-bootstrap && make cms-down
