<?php
declare(strict_types=1);

namespace Ridibooks\Cms\Auth\Test;

use PHPUnit\Framework\TestCase;
use Ridibooks\Cms\PaginationHelper;
use Symfony\Component\HttpFoundation\Request;

class GroupServiceTest extends TestCase
{
    public function testPaginationHelper()
    {
        $request = Request::create('test.com/home');
        $args = PaginationHelper::getArgs($request, 20, 2, 5);

        $this->assertEquals(2, $args["cur_page"]);
        $this->assertEquals(20, $args["total_count"]);
        $this->assertEquals(10, $args["button_count"]);
        $this->assertEquals(4, $args["total_page"]);
        $this->assertEquals(1, $args["start_page"]);
        $this->assertEquals(4, $args["end_page"]);
        $this->assertEquals(1, $args["prev_page"]);
        $this->assertEquals(4, $args["next_page"]);
        $this->assertEquals('test.com/home?', $args["link"]);
    }

    public function testIfEmptyQueryValueFiltered()
    {
        // 0 value
        $request = Request::create('/?genre=general&is_open=0');
        $args = PaginationHelper::getArgs($request, 20, 2, 5);
        $this->assertEquals('/?genre=general&is_open=0&', $args["link"]);

        // None value
        $request = Request::create('/?genre=general&is_open=');
        $args = PaginationHelper::getArgs($request, 20, 2, 5);
        $this->assertEquals('/?genre=general&', $args["link"]);
    }
}
