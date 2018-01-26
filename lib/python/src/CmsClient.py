# -*- coding: utf-8 -*-

from thrift import Thrift
from thrift.transport import THttpClient
from thrift.protocol import TMultiplexedProtocol
from thrift.protocol import TJSONProtocol
from AdminMenu import AdminMenuService
from AdminTag import AdminTagService
from AdminUser import AdminUserService

class CmsClient:
    def __init__(self, uriOrHost, port=None, path=None):
        self.uriOrHost = uriOrHost
        self.port = port
        self.path = path
        self.adminMenu = self.createClient('AdminMenu', AdminMenuService)
        self.adminTag = self.createClient('AdminTag', AdminTagService)
        self.adminUser = self.createClient('AdminUser', AdminUserService)

    def createClient(self, serviceName, service):
        client = THttpClient.THttpClient(self.uriOrHost, self.port, self.path)
        client.setCustomHeaders({'Accept' : 'application/x-thrift'})
        protocol = TJSONProtocol.TJSONProtocol(client)
        protocol = TMultiplexedProtocol.TMultiplexedProtocol(protocol, serviceName)
        return service.Client(protocol)
