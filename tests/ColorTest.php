<?php

use PHPUnit\Framework\TestCase;
use HarmsTyler\ContrastRatioCalculator\Color;

final class ColorTest extends TestCase
{
    public function testCanBeCreatedFromValidHex(): void
    {
        $this->assertInstanceOf(
            Color::class,
            Color::fromHex('#fff')
        );

        $this->assertInstanceOf(
            Color::class,
            Color::fromHex('#00264c')
        );
    }

    public function testCanBeCreatedFromValidRgb(): void
    {
        $this->assertInstanceOf(
            Color::class,
            Color::fromRgb([0,0,0])
        );
    }

    public function testHexGeneratesProperRgb(): void
    {
        $color = Color::fromHex('#fff');
        $this->assertEquals(
            [255,255,255],
            $color->getRgb()
        );

        $color = Color::fromHex('#00264c');
        $this->assertEquals(
            [0, 38, 76],
            $color->getRgb()
        );
    }

    public function testRgbGenratesProperHex(): void
    {
        $color = Color::fromRgb([1,2,3]);
        $this->assertEquals(
            '#010203',
            $color->getHex()
        );

        $color = Color::fromRgb([0, 38, 76]);
        $this->assertEquals(
            '#00264c',
            $color->getHex()
        );
    }

    public function testCalculatedLuminanceValue(): void
    {
        $color = Color::fromHex('#FFFF00');
        $this->assertEquals(
            0.9278,
            $color->getLuminance()
        );
    }
}
