import requests
from cmssdk.Config import Config

class LoginSession:
    def __init__(self, config: Config, admin_id: str = None):
        self.admin_id = admin_id
        self.rpc_url = config.RPC_URL

    def requestTokenIntrospect(self):
        res = requests.post(self.rpc_url + '/token-introspect')
        self.admin_id = res['user_id'] if 'user_id' in res else ''

    def getAdminId():
        return self.admin_id
