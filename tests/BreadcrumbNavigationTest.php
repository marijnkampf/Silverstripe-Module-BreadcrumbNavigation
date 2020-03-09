<?php

namespace Exadium\BreadcrumbNavigation\Tests;

use Exadium\BreadcrumbNavigation\BreadcrumbNavigation;
use \SilverStripe\Dev\SapphireTest;

class BreadcrumbNavigationTest extends SapphireTest
{
    protected static $fixture_file = 'tests/fixtures/pagetree.yml';

    public function setUp()
    {
        parent::setUp();
        $page = $this->objFromFixture('Page', 'thirdLevelPage');
        $page->resetBreadcrumbs();
    }

    public function test_top_level_pages()
    {
        $page = $this->objFromFixture('Page', 'topLevelPage');
        $pages = $page->Pages();

        // top level page plus home, aka site root
        $this->checkPages($pages, ['Home', 'Top Level']);

    }

    public function test_second_level_pages()
    {
        $page = $this->objFromFixture('Page', 'secondLevelPage');
        $pages = $page->Pages();
        $this->checkPages($pages, ['Home', 'Top Level', 'Second Level']);
    }

    public function test_third_level_pages()
    {
        $page = $this->objFromFixture('Page', 'thirdLevelPage');
        $pages = $page->Pages();
        $this->checkPages($pages, ['Home', 'Top Level', 'Second Level', 'Third Level']);

    }


    public function test_create_breadcrumbs()
    {
        $crumb = BreadcrumbNavigation::CreateBreadcrumb('Menu Title', '/link/menu-title', false);
        $this->assertEquals('Menu Title', $crumb->MenuTitle);
        $this->assertEquals('/link/menu-title', $crumb->Link);
        $this->assertFalse($crumb->isSelf);
    }

    public function test_add_breadcrumb_after()
    {
        $crumb = BreadcrumbNavigation::CreateBreadcrumb('New Title After', 'new-title-after', false);
        $page = $this->objFromFixture('Page', 'thirdLevelPage');
        $page->AddBreadcrumbAfter($crumb, false);
        $pages = $page->Pages();
        $this->checkPages($pages, ['Home', 'Top Level', 'Second Level', 'Third Level', 'New Title After']);
    }


    public function test_add_breadcrumb_before()
    {
        $crumb = BreadcrumbNavigation::CreateBreadcrumb('New Title Before', 'new-title-before', false);
        $page = $this->objFromFixture('Page', 'thirdLevelPage');
        $page->AddBreadcrumbBefore($crumb, false);
        $pages = $page->Pages();
        $this->checkPages($pages, ['New Title Before', 'Home', 'Top Level', 'Second Level', 'Third Level']);
    }


    private function checkPages($pages, $expected)
    {
        $this->assertEquals($expected,
            array_map(function($page) {
                // note that URLSegment cannot be used here as an extra breadcrumb field is not a page and thus not saved
                return $page->MenuTitle;
            }, $pages->toArray())
        );
    }
}
