# Breadcrumb Navigation SilverStripe 4.0
[![Build Status](https://travis-ci.org/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation.svg?branch=upgradess4)](https://travis-ci.org/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation/badges/quality-score.png?b=upgradess4)](https://scrutinizer-ci.com/g/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation/?branch=upgradess4)
[![Build Status](https://scrutinizer-ci.com/g/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation/badges/build.png?b=upgradess4)](https://scrutinizer-ci.com/g/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation/build-status/upgradess4)
[![CircleCI](https://circleci.com/gh/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation.svg?style=svg)](https://circleci.com/gh/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)

[![codecov.io](https://codecov.io/github/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation/coverage.svg?branch=upgradess4)](https://codecov.io/github/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation?branch=upgradess4)


[![Latest Stable Version](https://poser.pugx.org/exadium/breadcrumbnavigation/version)](https://packagist.org/packages/exadium/breadcrumbnavigation)
[![Latest Unstable Version](https://poser.pugx.org/exadium/breadcrumbnavigation/v/unstable)](//packagist.org/packages/exadium/breadcrumbnavigation)
[![Total Downloads](https://poser.pugx.org/exadium/breadcrumbnavigation/downloads)](https://packagist.org/packages/exadium/breadcrumbnavigation)
[![License](https://poser.pugx.org/exadium/breadcrumbnavigation/license)](https://packagist.org/packages/exadium/breadcrumbnavigation)
[![Monthly Downloads](https://poser.pugx.org/exadium/breadcrumbnavigation/d/monthly)](https://packagist.org/packages/exadium/breadcrumbnavigation)
[![Daily Downloads](https://poser.pugx.org/exadium/breadcrumbnavigation/d/daily)](https://packagist.org/packages/exadium/breadcrumbnavigation)
[![composer.lock](https://poser.pugx.org/exadium/breadcrumbnavigation/composerlock)](https://packagist.org/packages/exadium/breadcrumbnavigation)

[![GitHub Code Size](https://img.shields.io/github/languages/code-size/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)](https://github.com/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)
[![GitHub Repo Size](https://img.shields.io/github/repo-size/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)](https://github.com/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)
[![GitHub Last Commit](https://img.shields.io/github/last-commit/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)](https://github.com/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)
[![GitHub Activity](https://img.shields.io/github/commit-activity/m/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)](https://github.com/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)
[![GitHub Issues](https://img.shields.io/github/issues/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation)](https://github.com/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation/issues)

![codecov.io](https://codecov.io/github/gordonbanderson/Silverstripe-Module-BreadcrumbNavigation/branch.svg?branch=upgradess4)

## Maintainers

 * Marijn Kampf (Nickname: marijnkampf)
  <marijn at exadium dot com>

   http://www.exadium.com/tools/silverstripe/modules/breadcrumb-navigation/

   Sponsored by Exadium Web Development

## Introduction

Self contained Breadcrum Navigation module, allowing you to control breadcrumbs using templates, rather than from code.

## Requirements

 * SilverStripe Trunk SilverStripe 4.0
 
For SS 3 version see https://github.com/marijnkampf/Silverstripe-Module-BreadcrumbNavigation/tree/SS3

For SS 2.4 version see https://github.com/marijnkampf/Silverstripe-Module-BreadcrumbNavigation/tree/2.4

## Install and setup

 * BreadcrumbNavigation should be in your sites root folder.
 * Set options in your `mysite/_config/breadcrumbs.yml`

```yaml
---
Name: my-breadcrumbs-settings
After:
  - exadium-breadcrumbs-settings
---

#Override values here
Exadium\BreadcrumbNavigation\BreadcrumbNavigation:
  includeHome: false
  includeSelf: true
  maxDepth: 10
  stopAtPageType: false
  showHidden: false
  homeURLSegment: home

```

 * In your template include either:
    <% include BreadcrumbNavigationTemplate %>
   or
    <% include BreadcrumbNavigationTemplateAllLinked %>

## Advanced use
If you would like to add additional items to the Breadcrumb trail (e.g. for URL parameter actions) you can use AddBreadcrumbAfter($object) and AddBreadcrumbBefore($object) functions.
You only need to define the attributes you use in your templates. These are Link and MenuTitle for the supplied templates.
Define isSelf if you are not linking the current page.

```php
	$do = new DataObject();
	$do->Link = $this->Link() . "show";
	$do->MenuTitle = "Menu title";
	$do->isSelf = true;
	$this->AddBreadcrumbAfter($do);
```


