function trimUrlFragments(url) {
  return url.replace(/#.*/, '');
}

// url에 #태그 확인하여 권한을 반환한다.
function getAuthFromUrl(menuUrl) {
  const auth = menuUrl.split('#')[1];
  return auth || null;
}

async function readAuthorizedMenus(client, userID) {
  const menus = await client.adminMenu.getMenuList();
  const ajaxMenus = await client.adminMenu.getAllMenuAjax();

  // Get menus for the user.
  const ownMenuIds = await client.adminMenu.getAllMenuIds(userID);

  // Filter own menus
  const ownMenus = menus.filter((menu) => {
    const url = trimUrlFragments(menu.menu_url);
    if (menu.menu_deep === 0 && url.length === 0) {
      return true;
    } else if (ownMenuIds.includes(menu.id)) {
      return true;
    }
    return false;
  });

  // Fill additional attributes
  ownMenus.forEach((menu) => {
    // Get ajaxs
    menu.ajax_array = findAjaxMenusForMenu(menu.id, ajaxMenus);

    // Get auths(hashes)
    const url = trimUrlFragments(menu.menu_url);
    const menusWithSameUrl = ownMenus.filter(m => trimUrlFragments(m.menu_url) === url);
    const auths = menusWithSameUrl
      .map(m => getAuthFromUrl(m.menu_url))
      .filter(auth => auth);
    menu.auth = [...new Set(auths)]; // Uniquify
  });

  // Hide empty top menu
  const topMenuFlags = ownMenus.map(menu => (!!((menu.menu_deep === 0 && trimUrlFragments(menu.menu_url).length === 0))));
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
  return client.adminTag.getAdminUserTag(userId);
}

function findAjaxMenusForMenu(menuId, allAjaxMenus) {
  const ajaxList = [];
  // 해당 menu 내의 ajax 리스트가 있는지 확인한다.
  allAjaxMenus.forEach((ajaxMenu) => {
    if (ajaxMenu.menu_id === menuId) {
      ajaxMenu.ajax_auth = getAuthFromUrl(ajaxMenu.ajax_url);
      ajaxList.push(ajaxMenu);
    }
  });
  return ajaxList;
}

export default async function (client, userId) {
  const auths = await readAuthorizedMenus(client, userId);
  const tags = await fetchUserTags(client, userId);
  const menus = filterMenusInUse(auths);
  return {
    auths, // menus with auth
    menus, // menus without auth
    tags,
  };
}

