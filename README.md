# Breadcrumb Navigation SilverStripe 3.0

## Maintainers

 * Marijn Kampf (Nickname: marijnkampf)
  <marijn at exadium dot com>
   
   http://www.exadium.com/tools/silverstripe/modules/breadcrumb-navigation/
   
   Sponsored by Exadium Web Development
   
## Introduction

Self contained Breadcrum Navigation module, allowing you to control breadcrumbs using templates, rather than from code.

## Requirements

 * SilverStripe Trunk SilverStripe 3.0
 
For SS 2.4 version see https://github.com/marijnkampf/Silverstripe-Module-BreadcrumbNavigation/tree/2.4 

## Install and setup

 * BreadcrumbNavigation should be in your sites root folder.
 * Set options in your mysite/_config.php
			BreadcrumbNavigation::$includeHome = false;
			BreadcrumbNavigation::$includeSelf = true;
			BreadcrumbNavigation::$maxDepth = 20;
			BreadcrumbNavigation::$stopAtPageType = false;
			BreadcrumbNavigation::$showHidden = false;
			BreadcrumbNavigation::$homeURLSegment = 'home';
 
 * In your template include either:
    <% include BreadcrumbNavigationTemplate %>
   or
    <% include BreadcrumbNavigationTemplateAllLinked %>
    
## Advanced use
If you would like to add additional items to the Breadcrumb trail (e.g. for URL parameter actions) you can use AddBreadcrumbAfter($object) and AddBreadcrumbBefore($object) functions. 
You only need to define the attributes you use in your templates. These are Link and MenuTitle for the supplied templates. 
Define isSelf if you are not linking the current page.

	$do = new DataObject();
	$do->Link = $this->Link() . "show";
	$do->MenuTitle = "Menu title";
	$do->isSelf = true;
	$this->AddBreadcrumbAfter($do);

