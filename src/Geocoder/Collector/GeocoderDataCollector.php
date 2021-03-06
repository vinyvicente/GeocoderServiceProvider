<?php

namespace Geocoder\Collector;

use Geocoder\Logger\GeocoderLogger;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Michal Dabrowski <dabrowski@brillante.pl>
 */
class GeocoderDataCollector extends DataCollector
{
    /**
     * @var GeocoderLogger
     */
    protected $logger;

    /**
     *
     * @param GeocoderLogger $logger
     */
    public function __construct(GeocoderLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'requests' => $this->logger->getRequests(),
        );
    }

    /**
     * Returns an array of collected requests.
     *
     * @return array
     */
    public function getRequests()
    {
        return $this->data['requests'];
    }

    /**
     * Returns the number of collected requests.
     *
     * @return integer
     */
    public function getRequestsCount()
    {
        return count($this->data['requests']);
    }

    /**
     * Returns the execution time of all collected requests in seconds.
     *
     * @return float
     */
    public function getTime()
    {
        $time = 0;
        foreach ($this->data['requests'] as $command) {
            $time += $command['duration'];
        }

        return $time;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'geocoder';
    }
}
