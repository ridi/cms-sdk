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
    const menus = await this.userMenu.readUserMenus(this.cmsClient, userId);
    return new Promise((resolve, reject) => {
      this.userMenu.hasUrlAuth(menus, method, checkUrl).then(allowed => {
        resolve(allowed);
      }).catch(err => {
        reject(err);
      })
    });
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
