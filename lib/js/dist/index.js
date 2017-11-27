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

var _UserMenu = require('./UserMenu');

var _UserMenu2 = _interopRequireDefault(_UserMenu);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _asyncToGenerator(fn) { return function () { var gen = fn.apply(this, arguments); return new Promise(function (resolve, reject) { function step(key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { return Promise.resolve(value).then(function (value) { step("next", value); }, function (err) { step("throw", err); }); } } return step("next"); }); }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var LoginEndpoint = '/login';
var CouchbaseBucketName = 'session';

var CmsSdk = function () {
  function CmsSdk(options) {
    _classCallCheck(this, CmsSdk);

    this.cmsClient = new _CmsClient2.default(options.cmsRpcUrl);
    this.userMenu = new _UserMenu2.default();
    this.sessionStore = new _CmsSessionStore2.default(options.couchbaseUri, CouchbaseBucketName);
  }

  _createClass(CmsSdk, [{
    key: 'getLoginPageUrl',
    value: function getLoginPageUrl(return_url) {
      return LoginEndpoint + '?return_url=' + encodeURIComponent(return_url);
    }
  }, {
    key: 'accessMenu',
    value: function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(userId, method, checkUrl) {
        var _this = this;

        var menus;
        return regeneratorRuntime.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return this.userMenu.readUserMenus(this.cmsClient, userId);

              case 2:
                menus = _context.sent;
                return _context.abrupt('return', new Promise(function (resolve, reject) {
                  _this.userMenu.hasUrlAuth(menus, method, checkUrl).then(function (allowed) {
                    resolve(allowed);
                  }).catch(function (err) {
                    reject(err);
                  });
                }));

              case 4:
              case 'end':
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function accessMenu(_x, _x2, _x3) {
        return _ref.apply(this, arguments);
      }

      return accessMenu;
    }()
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