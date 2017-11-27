import ReadUserAuth from './UserAuthReader';
import MenuAuth from './MenuAuth';

class Auth {
  authorizeUrl(userMenu, method, checkUrl) {
    return new Promise((resolve, reject) => {
      const res = MenuAuth(userMenu, method, checkUrl);
      resolve(res);
    });
  }

  readUserMenuAuths(cmsClient, userId, isDev) {
    return new Promise((resolve, reject) => {
      const res = ReadUserAuth(cmsClient, userId, isDev);
      resolve(res);
    });
  }
}

export default Auth;
