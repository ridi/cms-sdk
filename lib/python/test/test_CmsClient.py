import unittest
from cmssdk.CmsClient import CmsClient

client = CmsClient('http://localhost:8000')
user = client.adminUser.getUser('admin')
