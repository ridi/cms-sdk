"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = void 0;

var _CmsClient = _interopRequireDefault(require("./CmsClient"));

var _Errors_types = require("./CmsClient/thrift/Errors_types");

var _CFJwtValidator = _interopRequireDefault(require("./CFJwtValidator"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

const LoginEndpoint = '/login';

class CmsSdk {
  constructor(options) {
    this.options = options;
    this.client = new _CmsClient.default(options.cmsRpcUrl, options.cmsRpcSecret);
  }

  getLoginPageUrl(returnUrl) {
    return `${LoginEndpoint}?return_url=${encodeURIComponent(returnUrl)}`;
  }

  getMenus(userId) {
    return this.client.auth.getAdminMenuAsync(userId);
  }

  authorizeAdminByUrl(userId, url) {
    return this.client.auth.authorizeAdminByUrlAsync(userId, url);
  }

  authorizeAdminByTag(userId, tags) {
    return this.client.auth.authorizeAdminByTagAsync(userId, tags);
  }

  async authenticate(token) {
    if (!token) {
      throw new _Errors_types.NoTokenException();
    }

    const validator = new _CFJwtValidator.default();
    const keys = await validator.getPublicKeys(this.options.cfAccessDomain);
    const payload = validator.decodeJwt(token, keys);
    return payload.email.split('@')[0];
  }

}

var _default = CmsSdk;
exports.default = _default;