class CmsSession {
  constructor(sessionId, sdk) {
    this.sessionId = sessionId;
    this.sdk = sdk;
  }

  load() {
    return new Promise((resolve, reject) => {
      this.sdk.sessionStore.readCmsSession(this.sessionId).then((res) => {
        this.session = res;
        resolve(res);
      }).catch(err => reject(err));
    });
  }

  isLogin() {
    return new Promise((resolve, reject) => {
      if (this.session == null || this.session.session_admin_id == null) {
        resolve(false);
        return;
      }

      this.sdk.getUserService().getUser(this.session.session_admin_id).then((user) => {
        if (user && user.is_use) {
          resolve(true);
        } else {
          resolve(false);
        }
      }).catch(err => reject(err));
    });
  }

  getLoginId() {
    if (this.session) {
      return this.session.session_admin_id;
    }
    return null;
  }

  getUserMenus() {
    return this.sdk.getAuthService().getAdminMenuAsync(this.getLoginId());
  }

  authorizeUrl(method, checkUrl) {
    return this.sdk.getAuthService().hasHashAuthAsync(null, checkUrl, this.getLoginId());
  }
}

export default CmsSession;
