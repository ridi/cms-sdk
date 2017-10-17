import session from 'express-session';
import connectCouchbase from 'connect-couchbase';

export default function (option) {
    let store = null
    if (option.couchbaseConfig) {
        const CouchbaseStore = connectCouchbase(session);
        store = new CouchbaseStore(option.couchbaseConfig);
    }

    return session({
        store,
        secret: option.secret,
        cookie: { maxAge: option.maxAge }
    })
}