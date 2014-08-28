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


use eZ\Publish\API\Repository\Values\ValueObject;

abstract class AbstractMeasurer implements MeasurerInterface {

    /**
     * Make measurements for each ValueObject given.
     * Return a Result object.
     *
     * @param ValueObject[] $valueObjects
     *
     * @return Result
     */
    public function measureAll($valueObjects)
    {
        // init result
        $result = new Result();
        $result->setReference($this->getName());
        $result->setIterations(count($valueObjects));

        // init start values
        $min = 9999999999999999;
        $max = 0;
        $total = 0;

        // make test for each value object
        foreach($valueObjects as $valueObject) {
            $time = $this->measure($valueObject);

            $min = ($min < $time) ? $min : $time;
            $max = ($max > $time) ? $max : $time;

            $total += $time;
        }

        // save results in object
        $result->setAvg($total / count($valueObjects));
        $result->setMin($min);
        $result->setMax($max);

        return $result;
    }
} 