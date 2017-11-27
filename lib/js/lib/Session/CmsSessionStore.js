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
          resolve((this.decodePhpSession(res.value)));
          return;
        }
        reject();
      });
    });
  }

  write(key, value, callback) {
    const data = encodePhpSession(value);
    return this.bucket.upsert(key, data, callback);
  }

  encodePhpSession(data) {
    return data;
  }

  decodePhpSession(data) {
    return phpUnserialize.unserializeSession(data);
  }
}

export default CmsSessionStore;
