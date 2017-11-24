require('babel-polyfill')
const express = require('express')
const Cookies = require('cookies');
const { CmsSdk, CmsSession } = require('../../lib/js/dist');

const sdk = new CmsSdk({
  cmsRpcUrl: 'http://admin.dev.ridi.com',
  couchbaseUri: '127.0.0.1',
});

function authorizer(req, res, next) {
  console.log(req.url)
  // check login
  const loginId = req.session.getLoginId();
  if (loginId == null) {
    const loginUrl = sdk.getLoginPageUrl(req.url);
    res.redirect(req.baseUrl + loginUrl);
    return
  }
  sdk.accessMenu(loginI, req.method, req.url).then(allowed => {
    if (allowed) {
      console.log(`access allowed: ${req.url}`);
      next();
    } else {
      res.sendStatus(403);
    }
  });
}

function cmsSession(req, res, next) {
  const cookies = new Cookies(req, null);
  const sessionId = cookies.get('PHPSESSID');
  req.session = new CmsSession(sessionId, sdk);
  req.session.load().then(session => {
    next();
  });
}

const app = express();

app.use(cmsSession);

app.use(authorizer);

app.get('/example/home', function (req, res) {
  res.json(req.session.getUserMenus());
});

// forbiden
app.get('/example/', function (req, res) {
  res.send(req.session.getLoginId());
});

app.listen(8080, function () {
  console.log('Example app listening on port 8080!')
});
