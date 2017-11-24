import CmsSessionStore from './CmsSessionStore';

class CmsSession {
  constructor(sessionId, sdk) {
    this.sessionId = sessionId;
    this.sessionStore = sdk.sessionStore;
  }

  read() {
    return new Promise((resolve, reject) => {
      this.sessionStore.read(this.sessionId).then(res => {
        this.session = res;
        resolve(res);
      }).catch(err => reject(err));
    });
  }

  isLogin() {
    return this.session && this.session.session_admin_id;
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