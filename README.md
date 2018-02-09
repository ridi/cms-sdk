# Ridibooks CMS SDK

[![Packagist](https://img.shields.io/packagist/v/ridibooks/cms-sdk.svg)](https://packagist.org/packages/ridibooks/cms-sdk)

## Introduction

CMS SDK provides common resources used in RIDI CMS
This library uses [Apache Thrift](https://thrift.apache.org) for a RPC implementation.

## Supporting Languages

For more details, see below links.

- [PHP](./lib/php/README.md)
- [JS](./lib/js/README.md)
- [Python](./lib/python/README.md)

## For SDK developers

To build a RPC client, you should install Apache Thrift.

``` sh
# In OSX, you can install easily with homebrew.
brew install thrift
```

To generate thrift code, please run:

``` sh
make thrift
```
