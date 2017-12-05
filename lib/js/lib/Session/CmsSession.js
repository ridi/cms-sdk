import authorize from '../authorize';

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
    if (this.session) {
      return this.session.session_user_menu;
    }
    return null;
  }

  getUserMenuAuths() {
    if (this.session) {
      // Object to Array.
      const menuAuths = Object.values(this.session.session_user_auth);
      menuAuths.map((menu) => {
        const ajax = menu.ajax_array ? Object.values(menu.ajax_array) : null;
        const auth = menu.auth ? Object.values(menu.auth) : null;
        return Object.assign(menu, { ajax_array: ajax, auth });
      });
      return menuAuths;
    }
    return null;
  }

  authorizeUrl(method, checkUrl) {
    const auths = this.getUserMenuAuths();
    return new Promise((resolve) => {
      resolve(authorize(auths, null, checkUrl));
    });
  }
}

export default CmsSession;
