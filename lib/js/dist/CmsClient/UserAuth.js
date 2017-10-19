'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var readAuthorizedMenus = function () {
    var _ref = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(client, userID, isDev) {
        var menus, ajaxMenus, ownMenuIds, ownMenus, topMenuFlags, i;
        return regeneratorRuntime.wrap(function _callee$(_context) {
            while (1) {
                switch (_context.prev = _context.next) {
                    case 0:
                        _context.next = 2;
                        return client.adminMenu.getMenuList();

                    case 2:
                        menus = _context.sent;
                        _context.next = 5;
                        return client.adminMenu.getAllMenuAjax();

                    case 5:
                        ajaxMenus = _context.sent;
                        ownMenuIds = void 0;

                        if (!isDev) {
                            _context.next = 11;
                            break;
                        }

                        // Get all menus.
                        ownMenuIds = menus.map(function (m) {
                            return m.id;
                        });
                        _context.next = 14;
                        break;

                    case 11:
                        _context.next = 13;
                        return client.adminMenu.getAllMenuIds(userID);

                    case 13:
                        ownMenuIds = _context.sent;

                    case 14:

                        // Filter own menus
                        ownMenus = menus.filter(function (menu) {
                            var url = trimUrlFragments(menu.menu_url);
                            if (menu.menu_deep === 0 && url.length === 0) {
                                return true;
                            } else if (ownMenuIds.includes(menu.id)) {
                                return true;
                            }
                            return false;
                        });

                        // Fill additional attributes

                        ownMenus.forEach(function (menu) {
                            // Get ajaxs
                            menu.ajax_array = findAjaxMenusForMenu(menu.id, ajaxMenus);

                            // Get auths(hashes)
                            var url = trimUrlFragments(menu.menu_url);
                            var menusWithSameUrl = ownMenus.filter(function (m) {
                                return trimUrlFragments(m.menu_url) === url;
                            });
                            var auths = menusWithSameUrl.map(function (m) {
                                return getAuthFromUrl(m.menu_url);
                            }).filter(function (auth) {
                                return auth;
                            });
                            menu.auth = [].concat(_toConsumableArray(new Set(auths))); // Uniquify
                        });

                        // Hide empty top menu
                        topMenuFlags = ownMenus.map(function (menu) {
                            return menu.menu_deep === 0 && trimUrlFragments(menu.menu_url).length === 0 ? true : false;
                        });

                        topMenuFlags.push(1); // For tail check
                        for (i = 0; i < topMenuFlags.length; ++i) {
                            if (topMenuFlags[i] && topMenuFlags[i + 1]) {
                                ownMenus[i].is_show = false;
                            }
                        }

                        return _context.abrupt('return', ownMenus);

                    case 20:
                    case 'end':
                        return _context.stop();
                }
            }
        }, _callee, this);
    }));

    return function readAuthorizedMenus(_x, _x2, _x3) {
        return _ref.apply(this, arguments);
    };
}();

var fetchUserTags = function () {
    var _ref2 = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee2(client, userId) {
        return regeneratorRuntime.wrap(function _callee2$(_context2) {
            while (1) {
                switch (_context2.prev = _context2.next) {
                    case 0:
                        _context2.next = 2;
                        return client.adminTag.getAdminUserTag(userId);

                    case 2:
                        return _context2.abrupt('return', _context2.sent);

                    case 3:
                    case 'end':
                        return _context2.stop();
                }
            }
        }, _callee2, this);
    }));

    return function fetchUserTags(_x4, _x5) {
        return _ref2.apply(this, arguments);
    };
}();

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

function _asyncToGenerator(fn) { return function () { var gen = fn.apply(this, arguments); return new Promise(function (resolve, reject) { function step(key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { return Promise.resolve(value).then(function (value) { step("next", value); }, function (err) { step("throw", err); }); } } return step("next"); }); }; }

function filterMenusInUse(menus) {
    return menus.filter(function (menu) {
        return menu.is_use && menu.is_show;
    });
}

function trimUrlFragments(url) {
    return url.replace(/#.*/, '');
}

function findAjaxMenusForMenu(menuId, allAjaxMenus) {
    var ajaxList = [];
    //해당 menu 내의 ajax 리스트가 있는지 확인한다.
    allAjaxMenus.forEach(function (ajaxMenu) {
        if (ajaxMenu.menu_id === menuId) {
            ajaxMenu.ajax_auth = getAuthFromUrl(ajaxMenu.ajax_url);
            ajaxList.push(ajaxMenu);
        }
    });
    return ajaxList;
}

// url에 #태그 확인하여 권한을 반환한다.
function getAuthFromUrl(menuUrl) {
    return menuUrl.split('#')[1];
}

exports.default = function () {
    var _ref3 = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee3(client, userId, isDev) {
        var auths, tags, menus;
        return regeneratorRuntime.wrap(function _callee3$(_context3) {
            while (1) {
                switch (_context3.prev = _context3.next) {
                    case 0:
                        _context3.next = 2;
                        return readAuthorizedMenus(client, userId, isDev);

                    case 2:
                        auths = _context3.sent;
                        _context3.next = 5;
                        return fetchUserTags(client, userId);

                    case 5:
                        tags = _context3.sent;
                        menus = filterMenusInUse(auths);
                        return _context3.abrupt('return', {
                            adminAuth: auths,
                            adminMenu: menus,
                            adminTag: tags
                        });

                    case 8:
                    case 'end':
                        return _context3.stop();
                }
            }
        }, _callee3, this);
    }));

    return function (_x6, _x7, _x8) {
        return _ref3.apply(this, arguments);
    };
}();