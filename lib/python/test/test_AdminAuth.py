import unittest
from unittest.mock import MagicMock
from cmssdk import CmsClient
from cmssdk.LoginSession import LoginSession
from cmssdk.Config import Config

class TestAdminAuth(unittest.TestCase):
    def setUp(self):
        self.config = Config()
        self.config.RPC_URL = 'http://localhost'
        self.admin_auth = CmsClient.AdminAuth(self.config)
        assert self.admin_auth

    def testExistanceOfThriftMethods(self):
        self.assertTrue(hasattr(self.admin_auth, 'hasHashAuth'))
        self.assertTrue(hasattr(self.admin_auth, 'getCurrentHashArray'))
        self.assertTrue(hasattr(self.admin_auth, 'getAdminMenu'))

    def testGetLoginUrl(self):
        self.assertEqual(
            '/login?return_url=test',
            self.admin_auth.getLoginUrl(return_url='test')
        )
        self.assertEqual(
            '/login',
            self.admin_auth.getLoginUrl()
        )

    def testShouldRedirectForLogin(self):
        session = LoginSession(self.config)
        session.requestTokenIntrospect = MagicMock(return_value={'user_id': 'test'})

        self.assertTrue(
            self.admin_auth.shouldRedirectForLogin(session)
        )
        session.requestTokenIntrospect.assert_called_with()

    def testShouldRedirectForLoginWithErrorResponce(self):
        session = LoginSession(self.config)
        session.requestTokenIntrospect = MagicMock(return_value={'error': 'invalid token'})

        self.assertFalse(
            self.admin_auth.shouldRedirectForLogin(session)
        )
        session.requestTokenIntrospect.assert_called_with()

if __name__ == '__main__':
    unittest.main()
