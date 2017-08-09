<?php
namespace Ridibooks\Platform\Cms\Util;

class UrlHelper
{
    /**
     * @param string $url
     * @param string $msg
     * @return string
     */
    public static function printAlertRedirect($url, $msg)
    {
        $html = '<!doctype html><html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"></head><body><script>';
        if (!empty($msg)) {
            $html .= "alert(" . json_encode($msg) . ");";
        }
        $html .= "location.href=" . json_encode($url) . ";";
        $html .= "</script></body></html>\n";

        return $html;
    }

    /**
     * @param string $msg
     * @return string
     */
    public static function printAlertHistoryBack($msg)
    {
        $html = '<!doctype html><html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"></head><body><script>';
        if (!empty($msg)) {
            $html .= "alert(" . json_encode($msg) . ");";
        }
        $html .= "history.go(-1);";
        $html .= "</script></body></html>\n";

        return $html;
    }

    /**
     * @param array $query_map
     * @param array $replace
     * @return string
     */
    public static function buildQuery($query_map, $replace)
    {
        foreach ($replace as $k => $v) {
            $query_map[$k] = $v;
        }

        $query_string = http_build_query($query_map);
        if (!empty($query_string)) {
            $query_string = '?' . $query_string;
        }

        return $query_string;
    }
}
