<?php
/*
 * This file is part of the <PROJECT> package.
 *
 * (c) Kuborgh GmbH
 *
 * For the full copyright and license information, please view the LICENSE-IMPRESS
 * file that was distributed with this source code.
 */

namespace Kuborgh\Bundle\MeasureBundle\Services\LoadContentType;

/**
 * Measurement result object.
 * Simple container for measurements results
 *
 * @package Kuborgh\Bundle\MeasureBundle\Services\LoadContentType
 */
class Result {

    /**
     * Minimum load time
     *
     * @var float
     */
    private $min;

    /**
     * Maximum load time
     *
     * @var float
     */
    private $max;

    /**
     * Average load time
     *
     * @var float
     */
    private $avg;

    /**
     * Iterations performed
     *
     * @var int
     */
    private $iterations;

    /**
     * Human readable reference to measurer
     *
     * @var string
     */
    private $reference;

    /**
     * @param float $avg
     */
    public function setAvg($avg)
    {
        $this->avg = $avg;
    }

    /**
     * @return float
     */
    public function getAvg()
    {
        return $this->avg;
    }

    /**
     * @param int $iterations
     */
    public function setIterations($iterations)
    {
        $this->iterations = $iterations;
    }

    /**
     * @return int
     */
    public function getIterations()
    {
        return $this->iterations;
    }

    /**
     * @param float $max
     */
    public function setMax($max)
    {
        $this->max = $max;
    }

    /**
     * @return float
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param float $min
     */
    public function setMin($min)
    {
        $this->min = $min;
    }

    /**
     * @return float
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
} 