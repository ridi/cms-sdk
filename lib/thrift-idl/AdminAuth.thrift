include "Errors.thrift"

namespace php Ridibooks.Cms.Thrift.AdminAuth
namespace py ridi.cms.thrift.AdminAuth

/**
 * AdminMenu 엔티티
 */
struct AdminMenu {
    1: optional i32 id,
    2: optional string menu_title,
    3: optional string menu_url,
    4: optional i32 menu_deep,
    5: optional i32 menu_order,
    6: optional bool is_use,
    7: optional bool is_show,
    8: optional string reg_date,
    9: optional bool is_newtab,
}

typedef list<AdminMenu> AdminMenuCollection

/**
 * AdminAuth 서비스
 */
service AdminAuthService {
    bool hasHashAuth(
        1: string hash,
        2: string checkUrl,
        3: string adminId,
    ) throws (
        1: Errors.SystemException systemException,
        2: Errors.UnauthorizedException unauthorizedException,
    ),

    list<string> getCurrentHashArray(
        1: string checkUrl,
        2: string adminId,

    ) throws (
        1: Errors.SystemException systemException,
    ),

    AdminMenuCollection getAdminMenu(
        1: string adminId,
    ) throws (
        1: Errors.SystemException systemException,
    ),

    void authorize(
        1: string token,
        2: list<string> methods,
        3: string check_url,
    ) throws (
        1: Errors.SystemException systemException,
        2: Errors.NoTokenException noTokenException,
        3: Errors.MalformedTokenException malformedTokenException,
        4: Errors.ExpiredTokenException expiredTokenException,
        5: Errors.UnauthorizedException unauthorizedException,
    ),
}
