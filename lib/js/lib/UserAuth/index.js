import ReadUserAuth from './UserAuthReader'
import AuthCheck from './AuthCheck'

class UserAuth {
    constructor() {}

    readUserAuth(cmsClient, userId, isDev) {
        return new Promise((resolve, reject) => {
            const res = ReadUserAuth(cmsClient, userId, isDev);
            resolve(res);
        });
    }

    hasUrlAuth(userAuth, method, checkUrl) {
        return new Promise((resolve, reject) => {
            const res = AuthCheck(userAuth, method, checkUrl);
            resolve(res);
        });
    }
}

export default UserAuth;