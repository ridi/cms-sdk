import unittest
from unittest.mock import MagicMock
from ridi.cms import cms_client
from ridi.cms.login_session import LoginSession
from ridi.cms.config import Config

class TestAdminAuth(unittest.TestCase):
    def setUp(self):
        self.config = Config()
        self.config.RPC_URL = 'http://localhost'
        self.admin_auth = cms_client.AdminAuth(self.config)
        assert self.admin_auth

    def testExistanceOfThriftMethods(self):
        self.assertTrue(hasattr(self.admin_auth, 'hasHashAuth'))
        self.assertTrue(hasattr(self.admin_auth, 'getCurrentHashArray'))
        self.assertTrue(hasattr(self.admin_auth, 'getAdminMenu'))

    def testGetLoginUrl(self):
        self.assertEqual(
            '/login?return_url=%2Ftest',
            self.admin_auth.getLoginUrl(return_url='/test')
        )
        self.assertEqual(
            '/login',
            self.admin_auth.getLoginUrl()
        )

    def testShouldRedirectForLogin(self):
        session = LoginSession(self.config, None)
        session.requestTokenIntrospect = MagicMock(return_value={'user_id': 'test'})

        self.assertFalse(
            self.admin_auth.shouldRedirectForLogin(session)
        )
        session.requestTokenIntrospect.assert_called_with()

    def testShouldRedirectForLoginWithErrorResponce(self):
        session = LoginSession(self.config, None)
        session.requestTokenIntrospect = MagicMock(return_value={'error': 'invalid token'})

        self.assertTrue(
            self.admin_auth.shouldRedirectForLogin(session)
        )
        session.requestTokenIntrospect.assert_called_with()

if __name__ == '__main__':
    unittest.main()
