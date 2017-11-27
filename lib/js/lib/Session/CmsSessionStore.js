import cb from 'couchbase';
import phpUnserialize from 'php-unserialize';

class CmsSessionStore {
  constructor(couchbaseUri, bucketName) {
    this.cluster = new cb.Cluster(couchbaseUri);
    this.bucket = this.cluster.openBucket(bucketName);
  }

  read(key) {
    return new Promise((resolve, reject) => {
      this.bucket.get(key, (err, res) => {
        if (err == null && res) {
          resolve(res.value);
          return;
        }
        reject();
      });
    });
  }

  write(key, value, callback) {
    return new Promise((resolve, reject) => {
      this.bucket.upsert(key, value, (err, res) => {
        if (err == null) {
          resolve();
          return;
        }
        reject();
      });
    });
  }

  readCmsSession(key) {
    return new Promise((resolve, reject) => {
      this.bucket.get(key, (err, res) => {
        if (err == null && res) {
          resolve((this.decodePhpSession(res.value)));
          return;
        }
        reject();
      });
    });
  }

  decodePhpSession(data) {
    return phpUnserialize.unserializeSession(data);
  }
}

export default CmsSessionStore;
