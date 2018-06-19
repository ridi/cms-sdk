<?php

namespace Ridibooks\Cms\Thrift;

use Thrift\Protocol\TJSONProtocol;
use Thrift\Protocol\TMultiplexedProtocol;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TSocket;

class ThriftService
{
    const HTTP_TIMEOUT_SECS = 60;

    private static $host = 'localhost';
    private static $port = '80';
    private static $path = '/';
    private static $scheme = 'http';

    public static function setEndPoint($end_point)
    {
        $parsed = parse_url($end_point);
        $host = isset($parsed['host']) ? $parsed['host'] : 'localhost';
        $port = isset($parsed['port']) ? $parsed['port'] : null;
        $scheme = isset($parsed['scheme']) ? $parsed['scheme'] : 'http';
        $path = isset($parsed['path']) ? $parsed['path'] : '';
        if (!$port) {
            $port = ($scheme === 'https') ? 443 : 80;
        }

        self::$host = $host;
        self::$port = $port;
        self::$path = $path;
        self::$scheme = $scheme;
    }

    public static function getEndPoint()
    {
        return self::$scheme . '://' . self::$host . ':' . self::$port . self::$path;
    }

    public static function getHttpClient($thrift_name)
    {
        $transport = new THttpsClient(self::$host, self::$port, self::$path, self::$scheme);
        $transport->setTimeoutSecs(self::HTTP_TIMEOUT_SECS);
        if (!empty($_ENV['XDEBUG_ENABLE'])) {
            $transport->addHeaders(['Cookie' => 'XDEBUG_SESSION=1']);
        }

        $protocol = new TJSONProtocol($transport);
        $multiplexed_protocol = new TMultiplexedProtocol($protocol, $thrift_name);
        return self::getClient($thrift_name, $multiplexed_protocol);
    }

    public static function getSocketClient($thrift_name)
    {
        $socket = new TSocket(self::$host, self::$port);
        $transport = new TBufferedTransport($socket);
        $protocol = new TJSONProtocol($transport);
        $multiplexed_protocol = new TMultiplexedProtocol($protocol, $thrift_name);
        return self::getClient($thrift_name, $multiplexed_protocol);
    }

    private static function getClient($thrift_name, $protocol)
    {
        $clientClass = __NAMESPACE__ . '\\' . $thrift_name . '\\' . $thrift_name . 'ServiceClient';
        if (!class_exists($clientClass)) {
            throw new \InvalidArgumentException(sprintf('Thrift client "%s" not found', $clientClass));
        }
        return new $clientClass($protocol);
    }

    public static function convertUserToArray($user)
    {
        return [
            'id' => $user->id,
            'passwd' => $user->passwd,
            'name' => $user->name,
            'team' => $user->team,
            'is_use' => $user->is_use,
            'reg_date' => $user->reg_date,
        ];
    }

    public static function convertUserCollectionToArray($users)
    {
        $collection = [];
        foreach ($users as $user) {
            $collection[] = self::convertUserToArray($user);
        }

        return $collection;
    }

    public static function convertMenuToArray($menu)
    {
        return [
            'id' => $menu->id,
            'menu_title' => $menu->menu_title,
            'menu_url' => $menu->menu_url,
            'menu_deep' => $menu->menu_deep,
            'menu_order' => $menu->menu_order,
            'is_use' => $menu->is_use,
            'is_show' => $menu->is_show,
            'reg_date' => $menu->reg_date,
            'is_newtab' => $menu->is_newtab,
        ];
    }

    public static function convertMenuCollectionToArray($menus)
    {
        $collection = [];
        foreach ($menus as $menu) {
            $collection[] = self::convertMenuToArray($menu);
        }

        return $collection;
    }

    public static function convertMenuAjaxToArray($menu)
    {
        return [
            'id' => $menu->id,
            'menu_id' => $menu->menu_id,
            'ajax_url' => $menu->ajax_url,
        ];
    }

    public static function convertMenuAjaxCollectionToArray($menus)
    {
        $collection = [];
        foreach ($menus as $menu) {
            $collection[] = self::convertMenuAjaxToArray($menu);
        }

        return $collection;
    }

    public static function convertTagToArray($tag)
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name,
            'is_use' => $tag->is_use,
            'creator' => $tag->creator,
            'reg_date' => $tag->reg_date,
        ];
    }

    public static function convertTagCollectionToArray($tags)
    {
        $collection = [];
        foreach ($tags as $tag) {
            $collection[] = self::convertTagToArray($tag);
        }

        return $collection;
    }
}
