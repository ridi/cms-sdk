import requests
from ridi.cms.config import Config

COOKIE_CMS_TOKEN = 'cms-token'
COOKIE_ADMIN_ID = 'admin-id'

class LoginSession:
    def __init__(self, config: Config, token: str, admin_id: str = None):
        self.token = token
        self.admin_id = admin_id
        self.rpc_url = config.RPC_URL

    def requestTokenIntrospect(self):
        res = requests.post(self.rpc_url + '/token-introspect', data={'token': self.token})
        if res.status_code != requests.codes.ok:
            return None
        login = res.json()
        self.admin_id = login['user_id'] if 'user_id' in login else ''
        return login

    def getAdminId(self):
        return self.admin_id
