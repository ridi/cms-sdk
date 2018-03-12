'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _http = require('http');

var _http2 = _interopRequireDefault(_http);

var _https = require('https');

var _https2 = _interopRequireDefault(_https);

var _url = require('url');

var _url2 = _interopRequireDefault(_url);

var _buffer = require('buffer');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var LoginSession = function () {
  function LoginSession(sdk) {
    _classCallCheck(this, LoginSession);

    this.sdk = sdk;
  }

  _createClass(LoginSession, [{
    key: 'requestTokenIntrospect',
    value: function requestTokenIntrospect(cmsHost, token) {
      return new Promise(function (resolve, reject) {
        var cmsUrl = _url2.default.parse(cmsHost);
        var http_ = cmsUrl.protocol === 'https:' ? _https2.default : _http2.default;
        var param = 'token='.concat(token);
        var options = {
          host: cmsUrl.hostname,
          path: '/token-introspect',
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Content-Length': _buffer.Buffer.byteLength(param)
          }
        };

        var req = http_.request(options, function (res) {
          res.setEncoding('utf8');
          var chunks = [];
          res.on('data', function (chunk) {
            return chunks.push(chunk);
          });
          res.on('end', function () {
            var data = chunks.join('');
            try {
              resolve(JSON.parse(data));
            } catch (e) {
              reject(new Error('Faild token introspection'));
            }
          });
        });
        req.on('error', function (err) {
          console.log('Error, with: '.concat(err.message));
          reject(err);
        });
        req.write(param);
        req.end();
      });
    }
  }, {
    key: 'shouldRedirectForLogin',
    value: function shouldRedirectForLogin(token) {
      var _this = this;

      return new Promise(function (resolve, reject) {
        _this.requestTokenIntrospect(_this.sdk.options.cmsRpcUrl, token).then(function (data) {
          _this.loginId = data.user_id;
          resolve(data);
        }).catch(function (e) {
          return reject(e);
        });
      });
    }
  }, {
    key: 'getLoginId',
    value: function getLoginId() {
      return this.loginId;
    }
  }, {
    key: 'getUserMenus',
    value: function getUserMenus() {
      return this.sdk.getAuthService().getAdminMenuAsync(this.getLoginId());
    }
  }, {
    key: 'authorizeUrl',
    value: function authorizeUrl(checkUrl, userId) {
      return this.sdk.getAuthService().hasHashAuthAsync(null, checkUrl, userId || this.getLoginId());
    }
  }, {
    key: 'getCmsTokenCookieName',
    value: function getCmsTokenCookieName() {
      return 'cms-token';
    }
  }, {
    key: 'authorize',
    value: function authorize(token, checkUrl) {
      var _this2 = this;

      return new Promise(function (resolve, reject) {
        _this2.shouldRedirectForLogin(token).then(function (data) {
          return data.user_id;
        }).then(function (userId) {
          return _this2.authorizeUrl(checkUrl, userId);
        }).then(function (isAllowed) {
          if (isAllowed) resolve();else reject(new Error('path not allowed: ' + checkUrl));
        }).catch(function (e) {
          return reject(e);
        });
      });
    }
  }]);

  return LoginSession;
}();

exports.default = LoginSession;