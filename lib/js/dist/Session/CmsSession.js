'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _CmsSessionStore = require('./CmsSessionStore');

var _CmsSessionStore2 = _interopRequireDefault(_CmsSessionStore);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var CmsSession = function () {
  function CmsSession(sessionId, sdk) {
    _classCallCheck(this, CmsSession);

    this.sessionId = sessionId;
    this.sessionStore = sdk.sessionStore;
  }

  _createClass(CmsSession, [{
    key: 'read',
    value: function read() {
      var _this = this;

      return new Promise(function (resolve, reject) {
        _this.sessionStore.read(_this.sessionId).then(function (res) {
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
      return this.session && this.session.session_admin_id;
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
  }]);

  return CmsSession;
}();

exports.default = CmsSession;