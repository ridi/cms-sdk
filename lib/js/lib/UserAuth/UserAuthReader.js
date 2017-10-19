

async function readAuthorizedMenus(client, userID, isDev) {
    const menus = await client.adminMenu.getMenuList();
    const ajaxMenus = await client.adminMenu.getAllMenuAjax();

    let ownMenuIds;
    if (isDev) {
        // Get all menus.
        ownMenuIds = menus.map(m => m.id); 
    } else {
        // Get menus only for the user.
        ownMenuIds = await client.adminMenu.getAllMenuIds(userID);
    }

    // Filter own menus
    let ownMenus = menus.filter(menu => {
        const url = trimUrlFragments(menu.menu_url);
        if (menu.menu_deep === 0 && url.length === 0) {
            return true;
        } else if (ownMenuIds.includes(menu.id)) {
            return true;
        }
        return false;
    });

    // Fill additional attributes
    ownMenus.forEach(menu => {
        // Get ajaxs
        menu.ajax_array = findAjaxMenusForMenu(menu.id, ajaxMenus);

        // Get auths(hashes)
        const url = trimUrlFragments(menu.menu_url);
        const menusWithSameUrl = ownMenus.filter(m => {
            return trimUrlFragments(m.menu_url) === url;
        });
        const auths = menusWithSameUrl
            .map(m => getAuthFromUrl(m.menu_url))
            .filter(auth => auth);
        menu.auth = [...new Set(auths)] // Uniquify
    });

    // Hide empty top menu
    let topMenuFlags = ownMenus.map(menu => {
        return (menu.menu_deep === 0 && trimUrlFragments(menu.menu_url).length === 0) ? true : false;
    });
    topMenuFlags.push(1); // For tail check
    for (let i = 0; i < topMenuFlags.length; ++i) {
        if (topMenuFlags[i] && topMenuFlags[i + 1]) {
            ownMenus[i].is_show = false;
        }
    }

    return ownMenus;
}

function filterMenusInUse(menus) {
    return menus.filter(menu => menu.is_use && menu.is_show);
}

async function fetchUserTags(client, userId) {
    return await client.adminTag.getAdminUserTag(userId);
}

function trimUrlFragments(url) {
    return url.replace(/#.*/, '');
}

function findAjaxMenusForMenu(menuId, allAjaxMenus) {
    let ajaxList = [];
    //해당 menu 내의 ajax 리스트가 있는지 확인한다.
    allAjaxMenus.forEach(function(ajaxMenu) {
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

export default async function (client, userId, isDev) {
    const auths = await readAuthorizedMenus(client, userId, isDev);
    const tags = await fetchUserTags(client, userId)
    const menus = filterMenusInUse(auths);
    return {
        menuAuths: auths, // menus with auth
        menus, // menus without auth
        tags,
    }; 
}

