import requests
from cmssdk.Config import Config

COOKIE_CMS_TOKEN = 'cms-token'
COOKIE_ADMIN_ID = 'admin-id'

class LoginSession:
    def __init__(self, config: Config, token: str, admin_id: str = None):
        self.token = token
        self.admin_id = admin_id
        self.rpc_url = config.RPC_URL

    def requestTokenIntrospect(self):
        res = requests.post(self.rpc_url + '/token-introspect', data={'token': self.token})
        self.admin_id = res['user_id'] if 'user_id' in res else ''

    def getAdminId(self):
        return self.admin_id
