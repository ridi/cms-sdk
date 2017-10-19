'use strict';

require("babel-polyfill")

const { CmsClient, UserAuth } = require('@ridibooks/cms-sdk');
const cmsRpcUrl = 'http://localhost:8000';
const client = new CmsClient(cmsRpcUrl);
/*
client.adminUser.getUser('admin', (err, result) => {
    console.log('sync=', result);
});
*/

const userAuth = new UserAuth();

async function readAuth() {
    const auth = await userAuth.readUserAuth(client, 'admin', true);
    console.log(auth);
    const has = await userAuth.hasUrlAuth(auth, '', '/super/logs');
    console.log(has);
}

readAuth();