'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

exports.default = function (rpcUrl) {
    var client = new Client(rpcUrl);

    return function (req, res, next) {
        if (req.path === '/login') {
            next();
            return;
        }

        if (!isValidLogin() || !isValidUser()) {
            res.redirect('/login?return_url=' + req.path);
            return;
        }

        if (!hasUrlAuth()) {
            res.status().send();
        }

        next();
    };
};

function isValidLogin() {
    return false;
}

function isValidUser() {}