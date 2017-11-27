import CmsClient from './CmsClient';
import CmsSession from './Session/CmsSession';
import CmsSessionStore from './Session/CmsSessionStore';
import Auth from './Auth';

const LoginEndpoint = '/login'
const CouchbaseBucketName = 'session';

class CmsSdk {
  constructor(options) {
    this.cmsClient = new CmsClient(options.cmsRpcUrl);
    this.auth = new Auth();
    this.sessionStore = new CmsSessionStore(options.couchbaseUri, CouchbaseBucketName);
  }

  getLoginPageUrl(return_url) {
    return `${LoginEndpoint}?return_url=` + encodeURIComponent(return_url);
  }

  getAuthService() {
    return this.auth;
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

export { CmsSdk, CmsSession };
