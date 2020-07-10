"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = void 0;

var _jsonwebtoken = _interopRequireDefault(require("jsonwebtoken"));

var _axios = _interopRequireDefault(require("axios"));

var _Errors_types = require("./CmsClient/thrift/Errors_types");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

const PUBLIC_KEY_PATH = '/cdn-cgi/access/certs';

class CFJwtValidator {
  decodeJwt(token, keys) {
    let decoded = null;
    keys.some(key => {
      try {
        decoded = _jsonwebtoken.default.verify(token, key, {
          algorithm: 'RS256'
        });
        return true;
      } catch (e) {
        return false;
      }
    });

    if (!decoded) {
      throw new _Errors_types.MalformedTokenException({
        code: _Errors_types.ErrorCode.BAD_REQUEST,
        message: 'Invalid Cloudflare JWT'
      });
    }

    return decoded;
  }

  getPublicKeys(baseUrl) {
    const url = baseUrl + PUBLIC_KEY_PATH;
    return new Promise(resolve => {
      _axios.default.get(url).then(res => {
        const {
          data
        } = res;
        let keys = [data.public_cert.cert];

        if (data.public_certs) {
          data.public_certs.forEach(({
            cert
          }) => {
            keys = [...keys, cert];
          });
        }

        resolve(keys);
      });
    });
  }

}

var _default = CFJwtValidator;
exports.default = _default;