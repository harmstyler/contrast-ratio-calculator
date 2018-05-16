# Contrast Ratio Calculator

Accessibility library that calculates contrast ratios of colors as well as
rates the contrast ratio against WCAG standards.

## Usage

```php
<?php

use Blend\ContrastRatioCalculator\Color;
use Blend\ContrastRatioCalculator\ContrastRatio;
use Blend\ContrastRatioCalculator\WCAGContrastRating;

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
