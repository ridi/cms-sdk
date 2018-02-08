import http from 'http';
import https from 'https';
import url from 'url';
import { Buffer } from 'buffer';

class LoginSession {
  constructor(sdk) {
    this.sdk = sdk;
  }

  requestTokenIntrospect(cmsHost, token) {
    return new Promise((resolve, reject) => {
      const cmsUrl = url.parse(cmsHost);
      const http_ = cmsUrl.protocol === 'https:' ? https : http;
      const param = 'token='.concat(token);
      const options = {
        host: cmsUrl.hostname,
        path: '/token-introspect',
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'Content-Length': Buffer.byteLength(param),
        },
      };

      const req = http_.request(options, (res) => {
        res.setEncoding('utf8');
        const chunks = [];
        res.on('data', chunk => chunks.push(chunk));
        res.on('end', () => {
          const data = chunks.join('');
          try {
            resolve(JSON.parse(data));
          } catch (e) {
            reject(new Error('Faild token introspection'));
          }
        });
      });
      req.on('error', (err) => {
        console.log('Error, with: '.concat(err.message));
        reject(err);
      });
      req.write(param);
      req.end();
    });
  }

  shouldRedirectForLogin(token) {
    return new Promise((resolve, reject) => {
      this.requestTokenIntrospect(this.sdk.options.cmsRpcUrl, token)
        .then((data) => {
          this.loginId = data.user_id;
          resolve(data);
        })
        .catch(e => reject(e));
    });
  }

  getLoginId() {
    return this.loginId;
  }

  getUserMenus() {
    return this.sdk.getAuthService().getAdminMenuAsync(this.getLoginId());
  }

  authorizeUrl(checkUrl, userId) {
    return this.sdk.getAuthService().hasHashAuthAsync(null, checkUrl, userId || this.getLoginId());
  }

  getCmsTokenCookieName() {
    return 'cms-token';
  }

  authorize(token, checkUrl) {
    return new Promise((resolve, reject) => {
      this.shouldRedirectForLogin(token)
        .then(data => data.user_id)
        .then(userId => this.authorizeUrl(checkUrl, userId))
        .then((isAllowed) => {
          if (isAllowed) resolve();
          else reject(new Error(`path not allowed: ${checkUrl}`));
        })
        .catch(e => reject(e));
    });
  }
}

export default LoginSession;
