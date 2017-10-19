import ReadUserAuth from './UserAuthReader'
import MenuAuth from './MenuAuth'

class UserMenu {
    constructor() {}

    readUserAuth(cmsClient, userId, isDev) {
        return new Promise((resolve, reject) => {
            const res = ReadUserAuth(cmsClient, userId, isDev);
            resolve(res);
        });
    }

    hasUrlAuth(userMenu, method, checkUrl) {
        return new Promise((resolve, reject) => {
            const res = MenuAuth(userMenu, method, checkUrl);
            resolve(res);
        });
    }
}

export default UserMenu;