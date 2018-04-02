# Ridibooks CMS SDK

## 2.2.4 (2018-04-02)

- [PHP] Add cookie header to Thrift request for debugger (#42)

## 2.2.3 (2018-03-27)

- [PHP] Fix token-refresh failure due to domain mismatch

## 2.2.2 (2018-03-26)

- [PHP] Redirect to /token-refresh on token expired
- [PHP] Handle 400 error on token introspect

## 2.2.1 (2018-03-12)

- [PHP] Fix `MiniRouter` compatiblitiy issue

## 2.2.0 (2018-03-09)

- [PHP] CmsApplication accepts config variables by the constructor
- [PHP] Remove PHP warning if a cookie is not set
- [PHP] Add `setLoginContext()` for test

## 2.1.1 (2018-02-14)

- [PHP] Fix compatibility error with Config class

## 2.1 (2018-02-13)

- [PHP] **Remove** deprecated method `AdminAuthService::getAdminTag`
- [Node.js] Support Node.js
- [Python] Support Python
- Use token-based Login
- Remove session server dependency

## 2.0 (2017-08-17)

### BREAKING CHANGES

- [PHP] Namespace change not to include `\Platform`
