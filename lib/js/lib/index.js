import CmsClient from './CmsClient';
import CmsSession from './Session/CmsSession';
import CmsSessionStore from './Session/CmsSessionStore';
import UserMenu from './UserMenu';

const LoginEndpoint = '/login'
const CouchbaseBucketName = 'session';

class CmsSdk {
  constructor(options) {
    this.cmsClient = new CmsClient(options.cmsRpcUrl);
    this.userMenu = new UserMenu();
    this.sessionStore = new CmsSessionStore(options.couchbaseUri, CouchbaseBucketName);
  }

  getLoginPageUrl(return_url) {
    return `${LoginEndpoint}?return_url=` + encodeURIComponent(return_url);
  }

  async accessMenu(userId, method, checkUrl) {
    const authList = await this.userMenu.readUserMenus(this.cmsClient, userId);
    return new Promise((resolve, reject) => {
      this.userMenu.hasUrlAuth(authList, method, checkUrl).then(allowed => {
        resolve(allowed);
      }).catch(err => {
        reject(err);
      })
    });
  }

  getAdminMenu() {
    return this.cmsClient.adminMenu;
  }

  getAdminTag() {
    return this.cmsClient.adminTag;
  }

  getAdminUser() {
    return this.cmsClient.adminUser;
  }
}

export { CmsSdk, CmsSession };
