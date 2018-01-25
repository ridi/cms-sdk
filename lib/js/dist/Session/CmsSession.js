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

var CmsSession = function () {
  function CmsSession(sdk) {
    _classCallCheck(this, CmsSession);

    this.sdk = sdk;
  }

  _createClass(CmsSession, [{
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
            resolve(JSON.parse(data));
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
        }).catch(function (err) {
          return reject(err);
        });
      });
    }
  }, {
    key: 'parseTokenResource',
    value: function parseTokenResource(data) {
      if (data && data.user_id) {
        this.loginId = data.user_id;
      }
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
    value: function authorizeUrl(method, checkUrl) {
      return this.sdk.getAuthService().hasHashAuthAsync(null, checkUrl, this.getLoginId());
    }
  }]);

  return CmsSession;
}();

exports.default = CmsSession;