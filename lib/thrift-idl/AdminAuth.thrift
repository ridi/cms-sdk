include "Errors.thrift"

namespace php Ridibooks.Cms.Thrift.AdminAuth

/**
 * AdminAuth 서비스
 */
service AdminAuthService {
    bool authorizeRequest(
        1: string userId,
        2: string requestUrl,
    ) throws (
        1: Errors.UserException userException,
        2: Errors.SystemException systemException
    ),
}