<?php

namespace HarmsTyler\ContrastRatioCalculator;


/**
 * Class ContrastRatio
 * @package Blend\ContrastRatioCalculator
 */
class ContrastRatio
{
    /**
     * @var float
     */
    private $ratio;
    /**
     * @var Color
     */
    private $primaryColor;
    /**
     * @var Color
     */
    private $secondaryColor;

    /**
     * ContrastRatio constructor.
     * @param Color $primaryColor
     * @param Color $secondaryColor
     */
    public function __construct(Color $primaryColor, Color $secondaryColor)
    {
        $this->primaryColor = $primaryColor;
        $this->secondaryColor = $secondaryColor;
        $this->ratio = $this->calculateContrastRatio();
    }

    /**
     * @return Color
     */
    public function getPrimaryColor(): Color
    {
        return $this->primaryColor;
    }

    /**
     * @return Color
     */
    public function getSecondaryColor(): Color
    {
        return $this->secondaryColor;
    }

    /**
     * @return float
     */
    public function getRatio(): float
    {
        return $this->ratio;
    }

    /**
     * Formula: http://www.w3.org/TR/2008/REC-WCAG20-20081211/#contrast-ratiodef
     *
     * @return float
     */
    public function calculateContrastRatio(): float
    {
        $l1 = $this->primaryColor->getLuminance();
        $l2 = $this->secondaryColor->getLuminance();
        $ratio = ($l1 + 0.05) / ($l2 + 0.05);

        if ($l2 > $l1) {
            $ratio = 1 / $ratio;
        }

        $ratio = round($ratio, 1);

        return $ratio;
    }
}
