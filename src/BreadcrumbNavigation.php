<?php

/**
 * @package BreadcrumbNavigation SS 3.0
 */

class BreadcrumbNavigation extends DataExtension
{
    private $initialised = false;

    public static $includeHome = true;
    public static $includeSelf = true;
    public static $maxDepth = 20;
    public static $stopAtPageType = false;
    public static $showHidden = false;
    public static $homeURLSegment = 'home';

    public $hasHome = false;

    public $parentPages = null;
    protected $isSelf = false;

    /**
     * Initialises the BreadcrumbNavigation class. Only called when Breadcrumbs are actually used.
     *
     * @return ArrayList of parent pages
     */
    public function Pages()
    {
        if (!$this->initialised) {
            $this->parentPages = array();
            $page = $this->owner;
            $i = 0;
            while (
                $page
                && (!self::$maxDepth || sizeof($this->parentPages) < self::$maxDepth)
                && (!self::$stopAtPageType || $page->ClassName != self::$stopAtPageType)
            ) {
                if (self::$showHidden || $page->ShowInMenus || ($page->ID == $this->owner->ID)) {
                    if ($page->URLSegment == self::$homeURLSegment) {
                        $this->hasHome = true;
                    }
                    if ($page->ID == $this->owner->ID) {
                        $page->isSelf = true;
                    }

                    if ((!$page->isSelf) || ($page->isSelf) && (self::$includeSelf)) {
                        array_unshift($this->parentPages, $page);
                    }
                }
                $page = $page->Parent;
            }
            if ((!$this->hasHome) && (self::$includeHome)) {
                array_unshift($this->parentPages, DataObject::get_one('SiteTree', "`URLSegment` = '" . self::$homeURLSegment . "'"));
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
