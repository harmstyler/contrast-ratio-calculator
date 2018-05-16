<?php

namespace HarmsTyler\ContrastRatioCalculator;


/**
 * Class WCAGContrastRating
 * @package Blend\ContrastRatioCalculator
 */
class WCAGContrastRating
{
    /**
     * @var array
     */
    private $ratings;

    /**
     * W3Rating constructor.
     */
    public function __construct()
    {
        $this->ratings = [
            'fail' => [
                'range' => [0, 3]
            ],
            'aa-large' => [
                'range' => [3, 4.5]
            ],
            'aa' => [
                'range' => [4.5, 7]
            ],
            'aaa' => [
                'range' => [7, 22]
            ]
        ];
    }

    /**
     * @return array
     */
    public function getRatings(): array
    {
        return $this->ratings;
    }

    /**
     * optionally provide an alternate set of ratings
     *
     * @param array $ratings
     */
    public function setRatings(array $ratings): void
    {
        $this->ratings = $ratings;
    }

    /**
     * return the contrast ratio rating ('fail', 'aa-large', 'aa', 'aaa')
     *
     * @param $primaryColor
     * @param $secondaryColor
     * @return string
     */
    public function rateColors(Color $primaryColor, Color $secondaryColor)
    {
        $contrastRatio = new ContrastRatio($primaryColor, $secondaryColor);

        return $this->rateContrastRatio($contrastRatio);
    }

    /**
     * @param ContrastRatio $contrastRatio
     * @return string
     */
    public function rateContrastRatio(ContrastRatio $contrastRatio): string
    {
        foreach ($this->ratings as $levelName => $ratingLevel) {
            if ($contrastRatio->getRatio() > $ratingLevel['range'][0] && $contrastRatio->getRatio() < $ratingLevel['range'][1]) {
                return $levelName;
            }
        }

        return 'error';
    }
}
