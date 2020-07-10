import jwt from 'jsonwebtoken';
import axios from 'axios';

import {
  ErrorCode,
  MalformedTokenException,
} from './CmsClient/thrift/Errors_types';


const PUBLIC_KEY_PATH = '/cdn-cgi/access/certs';

class CFJwtValidator {
  decodeJwt(token, keys) {
    let decoded = null;
    keys.some((key) => {
      try {
        decoded = jwt.verify(token, key, { algorithm: 'RS256' });
        return true;
      } catch (e) {
        return false;
      }
    });

    if (!decoded) {
      throw new MalformedTokenException({
        code: ErrorCode.BAD_REQUEST,
        message: 'Invalid Cloudflare JWT',
      });
    }

    return decoded;
  }

  getPublicKeys(baseUrl) {
    const url = baseUrl + PUBLIC_KEY_PATH;

    return new Promise((resolve) => {
      axios.get(url)
        .then((res) => {
          const { data } = res;

          let keys = [data.public_cert.cert];
          if (data.public_certs) {
            data.public_certs.forEach(({cert}) => {
              keys = [...keys, cert];
            });
          }

          resolve(keys);
        });
    });
  }
}

export default CFJwtValidator;
