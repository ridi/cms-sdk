"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = void 0;

var _thrift = _interopRequireDefault(require("thrift"));

var _url = _interopRequireDefault(require("url"));

var _AdminAuthService = _interopRequireDefault(require("./thrift/AdminAuthService"));

var _AdminMenuService = _interopRequireDefault(require("./thrift/AdminMenuService"));

var _AdminTagService = _interopRequireDefault(require("./thrift/AdminTagService"));

var _AdminUserService = _interopRequireDefault(require("./thrift/AdminUserService"));

var _ClientWrapper = _interopRequireDefault(require("./ClientWrapper"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

class CmsClient {
  constructor(endpoint, secret) {
    const multiplexer = new _thrift.default.Multiplexer();

    const urlObj = _url.default.parse(endpoint || 'http://localhost');

    const cfHeaders = secret ? {
      'CF-Access-Client-Id': secret.split(',')[0],
      'CF-Access-Client-Secret': secret.split(',')[1]
    } : null;

    const connection = _thrift.default.createHttpConnection(urlObj.hostname, urlObj.port, {
      path: urlObj.pathname,
      https: urlObj.protocol === 'https:',
      transport: _thrift.default.TBufferedTransport,
      protocol: _thrift.default.TJSONProtocol,
      headers: {
        Accept: 'application/x-thrift',
        'Content-Type': 'application/x-thrift',
        ...cfHeaders
      }
    });

    const authClient = multiplexer.createClient('AdminAuth', _AdminAuthService.default, connection);
    this.auth = new _ClientWrapper.default(authClient);
    const menuClient = multiplexer.createClient('AdminMenu', _AdminMenuService.default, connection);
    this.menu = new _ClientWrapper.default(menuClient);
    const tagClient = multiplexer.createClient('AdminTag', _AdminTagService.default, connection);
    this.tag = new _ClientWrapper.default(tagClient);
    const userClient = multiplexer.createClient('AdminUser', _AdminUserService.default, connection);
    this.user = new _ClientWrapper.default(userClient);
  }

}

var _default = CmsClient;
exports.default = _default;