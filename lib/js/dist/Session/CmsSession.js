'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _Auth = require('../Auth');

var _Auth2 = _interopRequireDefault(_Auth);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var CmsSession = function () {
  function CmsSession(sessionId, sdk) {
    _classCallCheck(this, CmsSession);

    this.sessionId = sessionId;
    this.sdk = sdk;
    this.sessionStore = sdk.sessionStore;
  }

  _createClass(CmsSession, [{
    key: 'load',
    value: function load() {
      var _this = this;

      return new Promise(function (resolve, reject) {
        _this.sessionStore.readCmsSession(_this.sessionId).then(function (res) {
          _this.session = res;
          resolve(res);
        }).catch(function (err) {
          return reject(err);
        });
      });
    }
  }, {
    key: 'isLogin',
    value: function isLogin() {
      var _this2 = this;

      return new Promise(function (resolve, reject) {
        if (_this2.session == null || _this2.session.session_admin_id == null) {
          resolve(false);
          return;
        }

        _this2.sdk.getUserService().getUser(_this2.session.session_admin_id).then(function (user) {
          if (user && user.is_use) {
            resolve(true);
          } else {
            resolve(false);
          }
        }).catch(function (err) {
          return reject(err);
        });
      });
    }
  }, {
    key: 'getLoginId',
    value: function getLoginId() {
      if (this.session) {
        return this.session.session_admin_id;
      }
      return null;
    }
  }, {
    key: 'getUserMenus',
    value: function getUserMenus() {
      if (this.session) {
        return this.session.session_user_menu;
      }
      return null;
    }
  }, {
    key: 'getUserMenuAuths',
    value: function getUserMenuAuths() {
      if (this.session) {
        // Object to Array.
        var auths = Object.values(this.session.session_user_auth);
        auths.forEach(function (auth) {
          if (auth.ajax_array) {
            auth.ajax_array = Object.values(auth.ajax_array);
          }
          if (auth.auth) {
            auth.auth = Object.values(auth.auth);
          }
        });
        return auths;
      }
      return null;
    }
  }, {
    key: 'authorizeUrl',
    value: function authorizeUrl(method, checkUrl) {
      var auths = this.getUserMenuAuths();
      return new Promise(function (resolve, reject) {
        (0, _Auth2.default)(auths, method, checkUrl).then(function (allowed) {
          resolve(allowed);
        }).catch(function (err) {
          reject(err);
        });
      });
    }
  }]);

  return CmsSession;
}();

exports.default = CmsSession;