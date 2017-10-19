
const allowedUrls = [
    '/admin/book/pa',
    '/me', // 본인 정보 수정
    '/welcome',
    '/logout',
    '/',
];

function isAuthUrl(checkUrl, menuUrl) {
    if (checkUrl.indexOf('/comm/') >= 0) { // /comm/으로 시작하는 url은 권한을 타지 않는다.
        return true;
    }
    const authUrl = menuUrl.replace(/(\?|#).*/, '');
    if (authUrl != '' && checkUrl.indexOf(authUrl) === 0) { // 현재 url과 권한 url이 같은지 비교
        return true;
    }
    return false;
}

/**권한이 정확한지 확인
 * @param null hash
 * @param array auth
 * @return bool
 */
function isAuthCorrect(hash, auth) {
    if (!hash) { // hash가 없는 경우 (보기 권한)
        return true;
    } else if (Array.isArray(hash)) {
        if (hash.some(h => auth.includes(h))) {
            return true;
        }
    } else if (auth.includes(hash)) {
        return true;
    }
    return false;
}

/**해당 URL의 Hash 권한이 있는지 검사한다.<br/>
 * @return bool
 */
function hasHashAuth(userAuth, hash, checkUrl) {
    if (allowedUrls.includes(checkUrl)) {
        return true;
    }

    const hasUrl = userAuth.menuAuths.some(menuAuth => {
        return isAuthUrl(checkUrl, menuAuth.menu_url)
            && isAuthCorrect(hash, menuAuth.auth ? menuAuth.auth : []);
    });
    if (hasUrl) {
        return true;
    }
    return userAuth.menuAuths
        .filter(menuAuth => menuAuth.ajax_array)
        .some(menuAuth => {
            const hasAjax = menuAuth.ajax_array.some(ajax => { // ajax_array 내의 key(ajax_url, ajax_auth)
                return isAuthUrl(checkUrl, ajax.ajax_url)
                    && (isAuthCorrect(hash, menuAuth.auth) || isAuthCorrect(hash, ajax.ajax_auth));
            });
            if (hasAjax) {
                return true;
            }
    });
}

export default function(userAuth, method, checkUrl) {
    return hasHashAuth(userAuth, null, checkUrl);
}
