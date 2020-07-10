# Ridibooks CMS SDK - javascript

## Install
```sh
npm install @ridi/cms-sdk
```

## Usage
```js
const { CmsSdk, TokenCookieName } = require('@ridi/cms-sdk')

const SDK = new CmsSdk({
  cmsRpcUrl: 'http://localhost',
  cmsRpcSecret: 'CMS_RPC_SECRET',
  cfAccessDomain: 'https://cms.ridi.io',
});

const token = req.cookies[TokenCookieName]

(async () => {
  try {
    const userId = await SDK.authenticate(token)
    console.log('userId:', userId)
    
    const menus = await SDK.getMenus(userId)
    console.log('menus:', menus)
      
    await SDK.authorizeAdminByUrl(userId)
  } catch (e) {
  
  }
})()
```

Check out our [sample project](https://github.com/ridi/cms-bootstrap-js) for more details.
