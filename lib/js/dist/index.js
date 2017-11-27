'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.CmsSession = exports.CmsSdk = undefined;

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _CmsClient = require('./CmsClient');

var _CmsClient2 = _interopRequireDefault(_CmsClient);

var _CmsSession = require('./Session/CmsSession');

var _CmsSession2 = _interopRequireDefault(_CmsSession);

var _CmsSessionStore = require('./Session/CmsSessionStore');

var _CmsSessionStore2 = _interopRequireDefault(_CmsSessionStore);

var _Auth = require('./Auth');

var _Auth2 = _interopRequireDefault(_Auth);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var LoginEndpoint = '/login';
var CouchbaseBucketName = 'session';

var CmsSdk = function () {
  function CmsSdk(options) {
    _classCallCheck(this, CmsSdk);

    this.cmsClient = new _CmsClient2.default(options.cmsRpcUrl);
    this.auth = new _Auth2.default();
    this.sessionStore = new _CmsSessionStore2.default(options.couchbaseUri, CouchbaseBucketName);
  }

  _createClass(CmsSdk, [{
    key: 'getLoginPageUrl',
    value: function getLoginPageUrl(return_url) {
      return LoginEndpoint + '?return_url=' + encodeURIComponent(return_url);
    }
  }, {
    key: 'getAuthService',
    value: function getAuthService() {
      return this.auth;
    }
  }, {
    key: 'getMenuService',
    value: function getMenuService() {
      return this.cmsClient.adminMenu;
    }
  }, {
    key: 'getTagService',
    value: function getTagService() {
      return this.cmsClient.adminTag;
    }
  }, {
    key: 'getUserService',
    value: function getUserService() {
      return this.cmsClient.adminUser;
    }
  }]);

  return CmsSdk;
}();

exports.CmsSdk = CmsSdk;
exports.CmsSession = _CmsSession2.default;