<?php

namespace HarmsTyler\ContrastRatioCalculator;

/**
 * Class Color
 * Set either a hex or an rgb color and the rest will be calculated.
 * @package Blend\ContrastRatioCalculator
 */
class Color
{
    /**
     * The hex version of the color code (e.g. #ffffff)
     *
     * @var string
     */
    private $hex;

    /**
     * @var float
     */
    private $luminance;

    /**
     * The rgb version of the color code (e.g. [255, 255, 255])
     *
     * @var array
     */
    private $rgb;

    /**
     * @return string
     */
    public function getHex(): string
    {
        return $this->hex;
    }

    /**
     * @param string $hex
     */
    public function setHex(string $hex)
    {
        $this->hex = $hex;
        $this->calculateRgb();
        $this->calculateLuminance();
    }

    /**
     * @return float
     */
    public function getLuminance(): float
    {
        if ($this->luminance) {
            return $this->luminance;
        } else {
            return $this->calculateLuminance();
        }
    }
    /**
     * Helper method for getting a new color
     *
     * @param string $hex
     * @return self
     */
    public static function fromHex(string $hex): self
    {
        $color = new self();
        $color->setHex($hex);

        return $color;
    }
    /**
     * Helper method for getting a new color
     *
     * @param array $rgb
     * @return self
     */
    public static function fromRgb(array $rgb): self
    {
        $color = new self();
        $color->setRgb($rgb);

        return $color;
    }

    /**
     * @return array
     */
    public function getRgb(): array
    {
        return $this->rgb;
    }

    /**
     * @param array $rgb
     */
    public function setRgb(array $rgb)
    {
        $this->rgb = $rgb;
        $this->calculateHex();
        $this->calculateLuminance();
    }

    /**
     * @return string
     */
    private function calculateHex(): string
    {
        $this->hex = sprintf("#%02x%02x%02x", $this->rgb[0], $this->rgb[1], $this->rgb[2]);

        return $this->hex;
    }

    /**
     * @return array
     */
    private function calculateRgb(): array
    {
        $hex = $this->hex;
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $this->rgb = [$r, $g, $b];

        return $this->rgb;
    }

    /**
     * @return array
     */
    private function calculateAdjustedRgb(): array
    {
        $hex = $this->hex;
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) === 3) {
            $hex .= $hex;
        }

        $hexValues = str_split($hex, 2);

        if (count($hexValues) !== 3) {
            throw new \Exception('Hex values should be 3 or 6 characters long');
        }

        $adjustedRgb = [];

        foreach ($hexValues as $value) {
            $adjustedRgb[] = $this->adjustValue($value);
        }

        return $adjustedRgb;
    }

    /**
     * Formula: http://springmeier.org/www/contrastcalculator/index.php
     *
     * @param string $val Hexadecimal value of colour component (00-FF)
     *
     * @return array
     */
    private function adjustValue(string $val): string
    {
        $val = hexdec($val)/255;
        if ($val <= 0.03928) {
            $val = $val / 12.92;
        } else {
            $val = pow((($val + 0.055) / 1.055), 2.4);
        }

        return $val;
    }

    /**
     * Formula: http://www.w3.org/TR/2008/REC-WCAG20-20081211/#relativeluminancedef
     * todo: use bcmath if available
     *
     * @return float
     */
    private function calculateLuminance()
    {
        $rgb = $this->calculateAdjustedRgb();

        $this->luminance = .2126 * $rgb[0] + .7152 * $rgb[1] + 0.0722 * $rgb[2];

        return $this->luminance;
    }
}
