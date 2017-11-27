import CmsSessionStore from './CmsSessionStore';

class CmsSession {
  constructor(sessionId, sdk) {
    this.sessionId = sessionId;
    this.sdk = sdk;
    this.sessionStore = sdk.sessionStore;
  }

  load() {
    return new Promise((resolve, reject) => {
      this.sessionStore.read(this.sessionId).then(res => {
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

      this.sdk.getUserService().getUser(this.session.session_admin_id).then(user => {
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
    if (this.session) {
      return this.session.session_user_menu;
    }
    return null;
  }
}

export default CmsSession;