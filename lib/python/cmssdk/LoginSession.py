COOKIE_CMS_TOKEN = 'cms-token'
COOKIE_ADMIN_ID = 'admin-id'

class LoginSession:
    def __init__(self, cms_token, admin_id):
        self.cms_token = cms_token
        self.admin_id = admin_id

    def requestTokenIntrospect(self):
        pass

    def getAdminId():
        return self.admin_id
