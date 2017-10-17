'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _thrift = require('thrift');

var _thrift2 = _interopRequireDefault(_thrift);

var _url = require('url');

var _url2 = _interopRequireDefault(_url);

var _AdminMenuService = require('./thrift/AdminMenuService');

var _AdminMenuService2 = _interopRequireDefault(_AdminMenuService);

var _AdminTagService = require('./thrift/AdminTagService');

var _AdminTagService2 = _interopRequireDefault(_AdminTagService);

var _AdminUserService = require('./thrift/AdminUserService');

var _AdminUserService2 = _interopRequireDefault(_AdminUserService);

var _ClientWrapper = require('./ClientWrapper');

var _ClientWrapper2 = _interopRequireDefault(_ClientWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var CmsClient = function CmsClient() {
  var endpoint = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'http://localhost';

  _classCallCheck(this, CmsClient);

  var urlObj = _url2.default.parse(endpoint);
  var connection = _thrift2.default.createHttpConnection(urlObj.hostname, urlObj.port, {
    path: urlObj.pathname,
    https: urlObj.protocol === 'https:',
    transport: _thrift2.default.TBufferedTransport,
    protocol: _thrift2.default.TJSONProtocol,
    headers: {
      Accept: 'application/x-thrift'
    }
  });

  this.adminMenu = new _ClientWrapper2.default('AdminMenu', _AdminMenuService2.default, connection);
  this.adminTag = new _ClientWrapper2.default('AdminTag', _AdminTagService2.default, connection);
  this.adminUser = new _ClientWrapper2.default('AdminUser', _AdminUserService2.default, connection);
};

exports.default = CmsClient;