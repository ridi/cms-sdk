namespace php Ridibooks.Cms.Thrift.Errors
namespace py ridi.cms.thrift.Errors

/**
 * 에러 코드
 */
enum ErrorCode {
    /** 일반적인 클라이언트 에러 */
    BAD_REQUEST = 400,

    /** 요청한 리소스가 서버에 없음 */
    NOT_FOUND = 404,

    /** 클라이언트가 제시한 파라미터 값/형식이 기대 요건을 충족하지 않음 */
    UNPROCESSIBLE_ENTITY = 422,

    /** General server error */
    INTERNAL_SERVER_ERROR = 500,
}

/**
 * 클라이언트의 의해 발생한 에러 (4XX)
 */
exception UserException {
    1: required ErrorCode code,
    2: optional string message
}

/**
 * 서버에 의해 발생한 에러 (5XX)
 */
exception SystemException {
    1: required ErrorCode code,
    2: optional string message
}

/**
 * 토큰을 찾을 수 없음
 */
exception NoTokenException {
    1: required ErrorCode code,
    2: optional string message
}

/**
 * 잘못된 토큰 데이터
 */
exception MalformedTokenException {
    1: required ErrorCode code,
    2: optional string message
}

/**
 * 토큰 만료 기간이 지남
 */
exception ExpiredTokenException {
    1: required ErrorCode code,
    2: optional string message
}

/**
 * 접근 권한이 없음
 */
exception UnauthorizedException {
    1: required ErrorCode code,
    2: optional string message
}
