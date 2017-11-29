import MenuAuth from './MenuAuth';

const authorizeUrl = (userMenu, method, checkUrl) =>
  new Promise((resolve) => {
    resolve(MenuAuth(userMenu, method, checkUrl));
  });

export default authorizeUrl;
