<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Repositories\Metric;

use CachetHQ\Cachet\Models\Metric;
use CachetHQ\Cachet\Services\Dates\DateFactory;
use DateInterval;

/**
 * This is the metric repository class.
 *
 * @author James Brooks <james@alt-three.com>
 */
class MetricRepository
{
    /**
     * Metric repository.
     *
     * @var \CachetHQ\Cachet\Repositories\Metric\MetricInterface
     */
    protected $repository;

    /**
     * The date factory instance.
     *
     * @var \CachetHQ\Cachet\Services\Dates\DateFactory
     */
    protected $dates;

    /**
     * Create a new metric repository class.
     *
     * @param \CachetHQ\Cachet\Repositories\Metric\MetricInterface $repository
     * @param \CachetHQ\Cachet\Services\Dates\DateFactory          $dates
     *
     * @return void
     */
    public function __construct(MetricInterface $repository, DateFactory $dates)
    {
        $this->repository = $repository;
        $this->dates = $dates;
    }

    /**
     * Returns all points as an array, for the last hour.
     *
     * @param \CachetHQ\Cachet\Models\Metric $metric
     *
     * @return \Illuminate\Support\Collection
     */
    public function listPointsLastHour(Metric $metric)
    {
        $dateTime = $this->dates->make();
        $pointKey = $dateTime->format('Y-m-d H:i');
        $nrOfMinutes = 61;
        $points = $this->repository->getPointsSinceMinutes($metric, $nrOfMinutes + $metric->threshold)->pluck('value', 'key')->take(-$nrOfMinutes);

        $timeframe = $nrOfMinutes;

        //Settings counter for minutes without data
        $minutesWithNoData = 0;

        for ($i = 0; $i < $timeframe; $i++) {
            if (!$points->has($pointKey)) {
                if ($i >= $metric->threshold) {
                    $points->put($pointKey, $metric->default_value);
                    //We put default value as metric, so we can reset counter for minutes without data
                    $minutesWithNoData = 0;
                } else {
                    //We didn't find any data, but threshold is not meet yet so we just adding to counter
                    $minutesWithNoData++;
                }
            } else {
                //We found data within this threshold, zeroing counter
                $minutesWithNoData = 0;
            }

            $pointKey = $dateTime->sub(new DateInterval('PT1M'))->format('Y-m-d H:i');
        }

        return $points->sortBy(function ($point, $key) {
            return $key;
        });
    }

    /**
     * Returns all points as an array, by x hours.
     *
     * @param \CachetHQ\Cachet\Models\Metric $metric
     * @param int                            $hours
     *
     * @return array
     */
    public function listPointsToday(Metric $metric, $hours = 12)
    {
        $dateTime = $this->dates->make();
        $pointKey = $dateTime->format('Y-m-d H:00');
        $points = $this->repository->getPointsSinceHour($metric, $hours)->pluck('value', 'key');

        for ($i = 0; $i < $hours; $i++) {
            if (!$points->has($pointKey)) {
                $points->put($pointKey, $metric->default_value);
            }

            $pointKey = $dateTime->sub(new DateInterval('PT1H'))->format('Y-m-d H:00');
        }

        return $points->sortBy(function ($point, $key) {
            return $key;
        });
    }

    /**
     * Returns all points as an array, in the last week.
     *
     * @param \CachetHQ\Cachet\Models\Metric $metric
     *
     * @return array
     */
    public function listPointsForWeek(Metric $metric)
    {
        $dateTime = $this->dates->make();
        $pointKey = $dateTime->format('Y-m-d');
        // $points = $this->repository->getPointsSinceHour($metric, 168)->pluck('value', 'key');
        $points = $this->repository->getPointsSinceDay($metric, 7)->pluck('value', 'key');

        for ($i = 0; $i <= 7; $i++) {
            if (!$points->has($pointKey)) {
                $points->put($pointKey, $metric->default_value);
            }

            $pointKey = $dateTime->sub(new DateInterval('P1W'))->format('Y-m-d');
        }

        return $points->sortBy(function ($point, $key) {
            return $key;
        });
    }

    /**
     * Returns all points as an array, in the last month.
     *
     * @param \CachetHQ\Cachet\Models\Metric $metric
     *
     * @return array
     */
    public function listPointsForMonth(Metric $metric)
    {
        $dateTime = $this->dates->make();
        $pointKey = $dateTime->format('Y-m-d');
        $daysInMonth = $dateTime->format('t');
        $points = $this->repository->getPointsSinceDay($metric, $daysInMonth)->pluck('value', 'key');

        for ($i = 0; $i <= $daysInMonth; $i++) {
            if (!$points->has($pointKey)) {
                $points->put($pointKey, $metric->default_value);
            }

            $pointKey = $dateTime->sub(new DateInterval('P1M'))->format('Y-m-d');
        }

        return $points->sortBy(function ($point, $key) {
            return $key;
        });
    }
}
