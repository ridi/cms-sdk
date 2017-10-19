'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

exports.default = function (sessionHandler) {
    return function (req, res, next) {
        if (req.path === '/login') {
            next();
            return;
        }

        if (!isValidLogin() || !isValidUser()) {
            res.redirect('/login?return_url=' + req.path);
            return;
        }

        if (!hasUrlAuth(sessionHandler)) {
            res.status().send();
        }

        next();
    };
};

function isValidLogin() {
    return false;
}

function isValidUser() {}

function hasUrlAuth(session) {
    return session.get('session_user_auth') && session.get('session_user_menu');
}