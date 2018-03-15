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
# In macOS, you can install easily with homebrew.
brew install thrift
```

To generate thrift code, please run:

``` sh
make thrift
```

### CMS-SDK Release steps

1. Create `release/{version}` branch.
1. Update `CHANGELOG.md`.
1. Update new SDK version in `package.json` & `lib/python/setup.py`.
1. Commit & push all the changes and make a pull request.
1. After PR, tag a new release in github. This will release a new version in Packagist.
1. `make -C lib/js release` will release js module.
1. `make -C lib/python release` will release python package.
