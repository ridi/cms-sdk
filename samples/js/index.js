'use strict';

require('babel-polyfill')
const express = require('express')
const session = require('express-session');
const couchbaseStore = require('connect-couchbase')(session);

const app = express()
const cbStore = new couchbaseStore({
    bucket: "session",
});

const { CmsClient, UserMenu } = require('../../lib/js/dist');

const cmsRpcUrl = 'http://localhost:8000';
const client = new CmsClient(cmsRpcUrl);
const userMenu = new UserMenu();

async function readAuth(userId, sessionId) {
    return await userMenu.readUserAuth(client, userId, true);
}

async function authorizer(req, res, next) {
    if (req.path === '/login') {
        next();
        return;
    }

    const userMenus = req.session.userMenu;
    if (!userMenus) {
        res.redirect(`/login`);
        return;
    }
    const hasAuth = await userMenu.hasUrlAuth(userMenus, req.method, req.url);
    console.log(`hasAuth: ${req.url}, ${hasAuth}`);
    if (!hasAuth) {
        res.sendStatus(403);
        return;
    }
    next();
}

app.use(session({
    // use the default PHP session cookie name
    name: 'PHPSESSID',
    secret: 'example',
    store: cbStore,
}));

app.use(authorizer);

app.get('/', function (req, res) {
    // send menu items for the user.
    res.json(req.session.userMenu.menus);
});

app.get('/login', function (req, res) {
    console.log('Login');
    readAuth('admin', req.session.id)
        .then(function(data) {
            req.session.userMenu = data;
            res.redirect('/');
    });
});

app.get('/super/logs', function (req, res) {
    res.send('Restricted page');
});

app.listen(8080, function () {
    console.log('Example app listening on port 8080!')
});
