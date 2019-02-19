# Contrast Ratio Calculator

Accessibility library that calculates contrast ratios of colors as well as
rates the contrast ratio against WCAG standards.

## Getting started

1. PHP 7.1.x is required
1. Install the Contrast Ratio Calculator using Composer (recommended) or manually

### Composer Installation

1. [Get Composer](http://getcomposer.org/)
1. Install with `composer require harmstyler/contrast-ratio-calculator`
1. Add the following to your application's main PHP file: `require 'vendor/autoload.php'`;

## Usage

```php
<?php

use HarmsTyler\ContrastRatioCalculator\Color;
use HarmsTyler\ContrastRatioCalculator\ContrastRatio;
use HarmsTyler\ContrastRatioCalculator\WCAGContrastRating;

$primaryColor = new Color();
$primaryColor->setHex('#ffffff');
$secondaryColor = new Color();
$secondaryColor->setHex('#000000');

$contrastRatio = new ContrastRatio($primaryColor, $secondaryColor);

echo $contrastRatio->getRatio(); // floating decimal point of calculated ratio

$rating = new WCAGContrastRating();
echo $rating->rateContrastRatio($contrastRatio); // the WCAGContrast grade, either 'fail', 'aa-large', 'aa', or 'aaa'
```

## Run the tests
```
./vendor/bin/phpunit tests/
```
