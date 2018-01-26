.PHONY: all build dist pypi-upload

all: build

build:
	pip install -r requirements.txt

dist:
	rm -rf ./dist
	python setup.py sdist

pypi-upload:
	twine upload dist/*
