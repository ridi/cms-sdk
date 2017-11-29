'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _MenuAuth = require('./MenuAuth');

var _MenuAuth2 = _interopRequireDefault(_MenuAuth);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var authorizeUrl = function authorizeUrl(userMenu, method, checkUrl) {
  return new Promise(function (resolve) {
    resolve((0, _MenuAuth2.default)(userMenu, method, checkUrl));
  });
};

exports.default = authorizeUrl;