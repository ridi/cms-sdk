import CmsClient from './CmsClient';
import { NoTokenException } from './CmsClient/thrift/Errors_types';
import CFJwtValidator from './CFJwtValidator';


const LoginEndpoint = '/login';

class CmsSdk {
  constructor(options) {
    this.options = options;
    this.client = new CmsClient(
      options.cmsRpcUrl,
      options.cmsRpcSecret,
    );
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
      throw new NoTokenException();
    }

    const validator = new CFJwtValidator();

    const keys = await validator.getPublicKeys(this.options.cfAccessDomain);
    const payload = validator.decodeJwt(token, keys);

    return payload.email.split('@')[0];
  }
}

export default CmsSdk;
