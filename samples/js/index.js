'use strict';

require('babel-polyfill')
const express = require('express')
const session = require('express-session');
const couchbaseStore = require('connect-couchbase')(session);
const { CmsClient, UserMenu } = require('../../lib/js/dist');

const cmsRpcUrl = 'http://localhost:8000';
const client = new CmsClient(cmsRpcUrl);
const userMenu = new UserMenu();

const isDev = true; // process.env.NODE_ENV || 'dev'
const userId = 'admin';

async function readUserMenus(userId) {
    return userMenu.readUserMenus(client, userId, isDev)
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

const app = express();
  
app.use(session({
    // use the default PHP session cookie name
    name: 'PHPSESSID',
    secret: 'example',
    store: new couchbaseStore({
        bucket: "session",
    }),
}));

app.use(authorizer);

app.get('/', function (req, res) {
    // show menu items allowed for the user.
    res.json(req.session.userMenu.menus);
});

app.get('/login', function (req, res) {
    console.log('Login');
    readUserMenus(userId)
        .then(function(data) {
            // save user menu info in session.
            req.session.userMenu = data;
            res.redirect('/');
    });
});

// this route path is listed in the user menu list.
app.get('/super/logs', function (req, res) {
    res.send('Restricted page');
});

app.listen(8080, function () {
    console.log('Example app listening on port 8080!')
});
