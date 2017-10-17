import thrift from 'thrift';

class ClientWrapper {
  constructor(serviceName, service, connection) {
    const multiplexer = new thrift.Multiplexer();
    this.client = multiplexer.createClient(serviceName, service, connection);

    const serviceMethods = Object.getOwnPropertyNames(Object.getPrototypeOf(this.client))
      .filter(property =>
        property.indexOf('seqid') === -1
          && property.indexOf('send_') === -1
          && property.indexOf('recv_') === -1);

    serviceMethods.forEach((method) => {
      ClientWrapper.prototype[`${method}Async`] = (...args) => this.callAsync(method, ...args);
      ClientWrapper.prototype[method] = (...args) => this.callSync(method, ...args);
    });
  }

  async callAsync(methodName, ...args) {
    return new Promise((resolve, reject) => {
      this.client[methodName](...args, (err, response) => {
        if (err) {
          reject(err);
          return;
        }

        resolve(response);
      });
    });
  }

  callSync(methodName, ...args) {
    return this.client[methodName](...args);
  }
}

export default ClientWrapper;
