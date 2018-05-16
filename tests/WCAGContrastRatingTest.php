<?php

use PHPUnit\Framework\TestCase;
use HarmsTyler\ContrastRatioCalculator\Color;
use HarmsTyler\ContrastRatioCalculator\WCAGContrastRating;

final class WCAGContrastRatingTest extends TestCase
{
    public function testRatingColorsReturnsProperGrade(): void
    {
        // test black and white
        $color1 = Color::fromHex('#000');
        $color2 = Color::fromHex('#fff');
        $rater = new WCAGContrastRating();

        $this->assertEquals(
            'aaa',
            $rater->rateColors($color1, $color2)
        );

        // blue and white
        $color1 = Color::fromHex('#00264c');
        $color2 = Color::fromHex('#fff');
        $rater = new WCAGContrastRating();

        $this->assertEquals(
            'aaa',
            $rater->rateColors($color1, $color2)
        );
    }
}
