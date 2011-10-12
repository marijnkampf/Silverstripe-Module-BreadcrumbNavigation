<?php

/**
 * @package BreadcrumbNavigation
 */

class BreadcrumbNavigation extends DataObjectDecorator {
	private $initialised = false;

	static $includeHome = true;
	static $includeSelf = true;
	static $maxDepth = 20;
	static $stopAtPageType = false;
	static $showHidden = false;
	static $homeURLSegment = 'home';

	public $hasHome = false;

	public $parentPages = null;
	protected $isSelf = false;

	function __construct($record = null, $isSingleton = false) {
		parent::__construct($record, $isSingleton);
	}

	/**
	 * Initialises the BreadcrumbNavigation class. Only called when Breadcrumbs are actually used.
	 *
	 * @return the number of parent pages
	 */
	private function initialise() {
		if (!$this->initialised) {
			$this->parentPages = new DataObjectSet();
			$page = $this->owner;
			$i = 0;
			while(
				$page
				&& (!BreadcrumbNavigation::$maxDepth || sizeof($this->parentPages) < BreadcrumbNavigation::$maxDepth)
				&& (!BreadcrumbNavigation::$stopAtPageType || $page->ClassName != BreadcrumbNavigation::$stopAtPageType)
			) {
				if(BreadcrumbNavigation::$showHidden || $page->ShowInMenus || ($page->ID == $this->owner->ID)) {
					if($page->URLSegment == BreadcrumbNavigation::$homeURLSegment) $this->hasHome = true;
					if ($page->ID == $this->owner->ID) $page->isSelf = true;

					if ((!$page->isSelf) || ($page->isSelf) && (BreadcrumbNavigation::$includeSelf))
						$this->parentPages->unshift($page);
				}
				$page = $page->Parent;
			}
			if ((!$this->hasHome) && (BreadcrumbNavigation::$includeHome)) $this->parentPages->unshift(DataObject::get_one('SiteTree', "`URLSegment` = '" . BreadcrumbNavigation::$homeURLSegment . "'"));

			$this->initialised = true;
		}
		return count($this->parentPages);
	}


	/**
	 * Return parent pages for Breadcrumb Navigation.
	 *
	 * @return DataObjectSet of parent pages
	 */
	function BreadcrumbNavigation() {
		$this->initialise();
		return $this->parentPages;
	}

	/**
	 * Adds one or more pages as child(ren) to end of parent pages.
	 *
	 * @param mixed $object array of or single object to add
	 */
	function AddAfter($object) {
		$this->initialise();
		foreach($this->parentPages as $page) {
			$page->isSelf = false;
		}
		if (is_array($object)) foreach ($object as $obj) $this->parentPages->push($obj);
		else $this->parentPages->push($object);
	}

	/**
	 * Adds one or more pages as parent(s) to beginning of parent pages.
	 *
	 * @param mixed $object array of or single object to add
	 */
	function AddBefore($object) {
		$this->initialise();
		foreach($this->parentPages as $page) {
			$page->isSelf = false;
		}
		if (is_array($object)) foreach ($object as $obj) $this->parentPages->unshift($obj);
		else $this->parentPages->unshift($object);
	}
}