<?php

/**
 * BreadcrumbNavigation config file
 *
 * Maintained by Marijn Kampf (Nickname: marijnkampf) <marijn at exadium dot com>
 * http://www.exadium.com/tools/silverstripe/modules/breadcrumb-navigation/
 *
 * Sponsored by Exadium Web Development
 */

	Object::add_extension('SiteTree', 'BreadcrumbNavigation');

/**
	Set the following options in mysite/_config.php.

	BreadcrumbNavigation::$includeHome = false;			// Include homepage in breadcrumbs.
	BreadcrumbNavigation::$includeSelf = true;			// Include the current page in breadcrumbs. See README.md for option to link / not link.
	BreadcrumbNavigation::$maxDepth = 10;						// Maximum depth to traverse
	BreadcrumbNavigation::$stopAtPageType = false;	// ClassName of a page to stop the upwards traversal.
	BreadcrumbNavigation::$showHidden = false;			// Include pages marked with the attribute ShowInMenus = 0.
	BreadcrumbNavigation::$homeURLSegment = 'home'; // URL Segment to use for homepage.
**/