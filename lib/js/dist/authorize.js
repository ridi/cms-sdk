'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
var allowedUrls = ['/admin/book/pa', '/me', // 본인 정보 수정
'/welcome', '/logout', '/'];

var isAuthUrl = function isAuthUrl(checkUrl, menuUrl) {
  if (checkUrl.indexOf('/comm/') >= 0) {
    // /comm/으로 시작하는 url은 권한을 타지 않는다.
    return true;
  }
  var authUrl = menuUrl.replace(/(\?|#).*/, '');
  if (authUrl !== '' && checkUrl.indexOf(authUrl) === 0) {
    // 현재 url과 권한 url이 같은지 비교
    return true;
  }
  return false;
};

// 권한이 정확한지 확인
var isAuthCorrect = function isAuthCorrect(hash, auth) {
  if (!hash) {
    // hash가 없는 경우 (보기 권한)
    return true;
  } else if (Array.isArray(hash)) {
    if (hash.some(function (h) {
      return auth.includes(h);
    })) {
      return true;
    }
  } else if (auth.includes(hash)) {
    return true;
  }
  return false;
};

// 해당 URL의 Hash 권한이 있는지 검사한다.
var authorize = function authorize(userMenuAuths, hash, checkUrl) {
  if (allowedUrls.includes(checkUrl)) {
    return true;
  }

  var hasUrl = userMenuAuths.some(function (menuAuth) {
    return isAuthUrl(checkUrl, menuAuth.menu_url) && isAuthCorrect(hash, menuAuth.auth ? menuAuth.auth : []);
  });
  if (hasUrl) {
    return true;
  }
  return userMenuAuths.filter(function (menuAuth) {
    return menuAuth.ajax_array;
  }).some(function (menuAuth) {
    var hasAjax = menuAuth.ajax_array.some(function (ajax) {
      return (// ajax_array 내의 key(ajax_url, ajax_auth)
        isAuthUrl(checkUrl, ajax.ajax_url) && (isAuthCorrect(hash, menuAuth.auth) || isAuthCorrect(hash, ajax.ajax_auth))
      );
    });
    return hasAjax;
  });
};

exports.default = authorize;