<?php

namespace HarmsTyler\ContrastRatioCalculator;

/**
 * Class WCAGContrastRating
 */
class WCAGContrastRating
{
    const FAIL = 'fail';
    const AA_LARGE = 'aa-large';
    const AA = 'aa';
    const AAA = 'aaa';

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
            self::FAIL => [
                'range' => [0, 3]
            ],
            self::AA_LARGE => [
                'range' => [3, 4.5]
            ],
            self::AA => [
                'range' => [4.5, 7]
            ],
            self::AAA => [
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
