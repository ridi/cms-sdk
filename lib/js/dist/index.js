"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
Object.defineProperty(exports, "CmsSdk", {
  enumerable: true,
  get: function () {
    return _CmsSdk.default;
  }
});
exports.TokenCookieName = void 0;

var _CmsSdk = _interopRequireDefault(require("./CmsSdk"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

const TokenCookieName = 'CF_Authorization';
exports.TokenCookieName = TokenCookieName;