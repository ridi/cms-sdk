"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = void 0;

class ClientWrapper {
  constructor(client) {
    const serviceMethods = Object.getOwnPropertyNames(Object.getPrototypeOf(client)).filter(property => property.indexOf('seqid') === -1 && property.indexOf('send_') === -1 && property.indexOf('recv_') === -1);
    serviceMethods.forEach(method => {
      ClientWrapper.prototype[`${method}Async`] = (...args) => this.callAsync(method, ...args);

      ClientWrapper.prototype[method] = (...args) => this.callSync(method, ...args);
    });
    this.client = client;
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

var _default = ClientWrapper;
exports.default = _default;