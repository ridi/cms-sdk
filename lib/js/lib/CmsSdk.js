import CmsClient from './CmsClient';
import CmsSessionStore from './Session/CmsSessionStore';

const LoginEndpoint = '/login';
const CouchbaseBucketName = 'session';

class CmsSdk {
  constructor(options) {
    this.cmsClient = new CmsClient(options.cmsRpcUrl);
    this.sessionStore = new CmsSessionStore(options.couchbaseUri, CouchbaseBucketName);
  }

  getLoginPageUrl(returnUrl) {
    return `${LoginEndpoint}?return_url=${encodeURIComponent(returnUrl)}`;
  }

  getMenuService() {
    return this.cmsClient.adminMenu;
  }

  getTagService() {
    return this.cmsClient.adminTag;
  }

  getUserService() {
    return this.cmsClient.adminUser;
  }
}

export default CmsSdk;
