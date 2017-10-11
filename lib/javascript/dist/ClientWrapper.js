'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _thrift = require('thrift');

var _thrift2 = _interopRequireDefault(_thrift);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var ClientWrapper = function () {
  function ClientWrapper(serviceName, service, connection) {
    var _this = this;

    _classCallCheck(this, ClientWrapper);

    var multiplexer = new _thrift2.default.Multiplexer();
    this.client = multiplexer.createClient(serviceName, service, connection);

    var serviceMethods = Object.getOwnPropertyNames(Object.getPrototypeOf(this.client)).filter(function (property) {
      return property.indexOf('seqid') === -1 && property.indexOf('send_') === -1 && property.indexOf('recv_') === -1;
    });

    serviceMethods.forEach(function (method) {
      ClientWrapper.prototype[method + 'Async'] = function () {
        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
          args[_key] = arguments[_key];
        }

        return _this.asyncClientCall.apply(_this, [method].concat(args));
      };
      ClientWrapper.prototype[method] = function () {
        for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
          args[_key2] = arguments[_key2];
        }

        return _this.syncClientCall.apply(_this, [method].concat(args));
      };
    });
  }

  _createClass(ClientWrapper, [{
    key: 'asyncClientCall',
    value: async function asyncClientCall(methodName) {
      var _this2 = this;

      for (var _len3 = arguments.length, args = Array(_len3 > 1 ? _len3 - 1 : 0), _key3 = 1; _key3 < _len3; _key3++) {
        args[_key3 - 1] = arguments[_key3];
      }

      return new Promise(function (resolve, reject) {
        var _client;

        (_client = _this2.client)[methodName].apply(_client, args.concat([function (err, response) {
          if (err) {
            reject(err);
            return;
          }

          resolve(response);
        }]));
      });
    }
  }, {
    key: 'syncClientCall',
    value: function syncClientCall(methodName) {
      var _client2;

      for (var _len4 = arguments.length, args = Array(_len4 > 1 ? _len4 - 1 : 0), _key4 = 1; _key4 < _len4; _key4++) {
        args[_key4 - 1] = arguments[_key4];
      }

      return (_client2 = this.client)[methodName].apply(_client2, args);
    }
  }]);

  return ClientWrapper;
}();

exports.default = ClientWrapper;