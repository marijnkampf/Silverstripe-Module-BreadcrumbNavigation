<?php

/**
 * @package BreadcrumbNavigation SS 4.0
 */
namespace Exadium\BreadcrumbNavigation;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;

class BreadcrumbNavigation extends \SilverStripe\ORM\DataExtension
{
    private $initialised = false;

    private static $includeHome = true;
    private static $includeSelf = true;
    private static $maxDepth = 10;
    private static $stopAtPageType = false;
    private static $showHidden = false;
    private static $homeURLSegment = 'home';



    public $hasHome = false;

    public $parentPages = null;
    protected $isSelf = false;


    /**
     * Reset the breadcrumbs.  Used during testing
     * @todo Inject this method
     */
    public function resetBreadcrumbs()
    {
        $this->initialised = false;
    }

    /**
     * Initialises the BreadcrumbNavigation class. Only called when Breadcrumbs are actually used.
     *
     * @return ArrayList of parent pages
     */
    public function Pages()
    {
        if (!$this->initialised) {
            $this->parentPages = [];
            $page = $this->owner;
            $i = 0;
            while ($page
                && (!self::$maxDepth || count($this->parentPages) < self::$maxDepth)
                && (!self::$stopAtPageType || $page->ClassName != self::$stopAtPageType)
            ) {
                if (self::$showHidden || $page->ShowInMenus || ($page->ID == $this->owner->ID)) {
                    if ($page->URLSegment == self::$homeURLSegment) {
                        $this->hasHome = true;
                    }
                    if ($page->ID == $this->owner->ID) {
                        $page->isSelf = true;
                    }

                    if ((!$page->isSelf) || (($page->isSelf) && (self::$includeSelf))) {
                        array_unshift($this->parentPages, $page);
                    }
                }
                $page = $page->Parent;
            }
            if ((!$this->hasHome) && (self::$includeHome)) {
                array_unshift($this->parentPages,
                    SiteTree::get()->filter('URLSegment', self:: $homeURLSegment)->first());
            }

            $this->initialised = true;
        }
        return  new ArrayList($this->parentPages);
    }

    public static function CreateBreadcrumb($menuTitle, $link, $isSelf)
    {
        $do = new DataObject();
        $do->Link =  $link;
        $do->MenuTitle = $menuTitle;
        $do->isSelf = $isSelf;
        return $do;
    }

    /**
     * Adds one or more pages as child(ren) to end of parent pages.
     *
     * @param mixed $object array of or single object to add
     * @param bool $unique Removes duplicate values from breadcrumb trail
     */
    public function AddBreadcrumbAfter($object, $unique = false)
    {
        $this->Pages();
        foreach ($this->parentPages as $page) {
            $page->isSelf = false;
        }
        if (is_array($object)) {
            foreach ($object as $obj) {
                array_push($this->parentPages, $obj);
            }
        } else {
            array_push($this->parentPages, $object);
        }
        if ($unique) {
            $this->parentPages = array_unique($this->parentPages);
        }
    }

    /**
     * Adds one or more pages as parent(s) to beginning of parent pages.
     *
     * @param mixed $object array of or single object to add
     * @param bool $unique Removes duplicate values from breadcrumb trail
     */
    public function AddBreadcrumbBefore($object, $unique = false)
    {
        $this->Pages();
        foreach ($this->parentPages as $page) {
            $page->isSelf = false;
        }
        if (is_array($object)) {
            foreach ($object as $obj) {
                array_unshift($this->parentPages, $obj);
            }
        } else {
            array_unshift($this->parentPages, $object);
        }
        if ($unique) {
            $this->parentPages = array_unique($this->parentPages);
        }
    }
}
