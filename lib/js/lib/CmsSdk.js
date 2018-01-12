import CmsClient from './CmsClient';

const LoginEndpoint = '/login';

class CmsSdk {
  constructor(options) {
    this.cmsClient = new CmsClient(options.cmsRpcUrl);
    this.options = options;
  }

  getLoginPageUrl(returnUrl) {
    return `${LoginEndpoint}?return_url=${encodeURIComponent(returnUrl)}`;
  }

  getAuthService() {
    return this.cmsClient.adminAuth;
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
