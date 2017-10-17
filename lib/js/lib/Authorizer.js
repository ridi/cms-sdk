

function isValidLogin() {
    return false;
}

function isValidUser() {

}

export default function (rpcUrl) {
    const client = new Client(rpcUrl);

    return function (req, res, next) {
        if (req.path === '/login') {
            next();
            return;
        }

        if (!isValidLogin() || !isValidUser()) {
            res.redirect(`/login?return_url=${req.path}`);
            return;
        }

        if (!hasUrlAuth()) {
            res.status().send();
        }

        next();
    }
}