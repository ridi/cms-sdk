import authorize from '../Auth';

class CmsSession {
  constructor(sessionId, sdk) {
    this.sessionId = sessionId;
    this.sdk = sdk;
    this.sessionStore = sdk.sessionStore;
  }

  load() {
    return new Promise((resolve, reject) => {
      this.sessionStore.readCmsSession(this.sessionId).then((res) => {
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
    if (this.session) {
      return this.session.session_user_menu;
    }
    return null;
  }

  getUserMenuAuths() {
    if (this.session) {
      // Object to Array.
      const auths = Object.values(this.session.session_user_auth);
      auths.forEach((auth) => {
        if (auth.ajax_array) {
          auth.ajax_array = Object.values(auth.ajax_array);
        }
        if (auth.auth) {
          auth.auth = Object.values(auth.auth);
        }
      });
      return auths;
    }
    return null;
  }

  authorizeUrl(method, checkUrl) {
    const auths = this.getUserMenuAuths();
    return new Promise((resolve, reject) => {
      authorize(auths, method, checkUrl).then((allowed) => {
        resolve(allowed);
      }).catch((err) => {
        reject(err);
      });
    });
  }
}

export default CmsSession;
