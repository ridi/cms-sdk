# Ridibooks CMS SDK
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.3.6] - 2018-07-20
- [PHP, JS, Python] Add `email` field in AdminUser struct

## [2.3.5] - 2018-07-17
### Fixed
- [PHP] Fix non static method call exception at `authorize` and `authorizeByTag`

## [2.3.4] - 2018-07-12
### Added
- [PHP] Add AuthorizeByTag
- [Python] Add authorize endpoint
### Fixed
- [PHP] Fixed PaginationHelper not to filter 0 value of query string #54
### Changed
- [PHP] Use new authorize endpoint `/auth/oauth2/authorize`
- [PHP] Use XDEBUG_ENABLE instead DEBUG env for XDebug switch

## [2.3.3] - 2018-05-24
### Added
- [ALL] Add `introspectToken` API

## [2.3.2] - 2018-05-03
### Fixed
- [JS, Python] Fix invalid content type setting
- [PHP] Fix undefined method in `getMappedAdminMenuHashes`

## [2.3.1] - 2018-04-19
### Added
- [PHP, JS, Python] new `authorizeByTag` API

## [2.3.0] - 2018-04-10
### Added
- [PHP] Add new method `SetAdminID` with the purpose of test
### Deprecated
- [PHP] Remove token-introspect url endpoint (#46)
  - Removed method `hasUrlAuth` from AdminAuthService class.
  - Removed method `checkUserPassword`, `doLoginAction`, `doCmsLoginAction`, `requestTokenIntrospect`, `getTokenApiUrl` `getLoginPageUrl`, `isAuthRequired`, `validateLogin`, `createRedirectForLogin`, `setLoginContext` from LoginService class

## [2.2.6] - 2018-04-04
### Added
- [PHP, JS, Python] Add new tag APIs, `getAdminTag` and `getAdminTags`.

## [2.2.5] - 2018-04-03
### Changed
- [PHP] `/token-refresh` does not redirect to CMS-RPC-URL (#43)

## [2.2.4] - 2018-04-02
### Added
- [PHP] Add cookie header to Thrift request for debugger (#42)

## [2.2.3] - 2018-03-27
### Fixed
- [PHP] Fix token-refresh failure due to domain mismatch

## [2.2.2] - 2018-03-26
### Added
- [PHP] Redirect to /token-refresh on token expired
- [PHP] Handle 400 error on token introspect

## [2.2.1] - 2018-03-12
### Fixed
- [PHP] Fix `MiniRouter` compatiblitiy issue

## [2.2.0] - 2018-03-09
### Added
- [PHP] CmsApplication accepts config variables by the constructor
- [PHP] Add `setLoginContext()` for test
### Changed
- [PHP] Remove PHP warning if a cookie is not set

## [2.1.1] - 2018-02-14
### Fixed
- [PHP] Fix compatibility error with Config class

## [2.1] - 2018-02-13
### Added
- [Node.js] Support Node.js
- [Python] Support Python
### Changed
- Use token-based Login
- Remove session server dependency
### Deprecated
- [PHP] Removed method `AdminAuthService::getAdminTag`

## [2.0] - 2017-08-17
### BREAKING CHANGES
- [PHP] Namespace change not to include `\Platform`
