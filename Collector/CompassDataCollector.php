<?php
/**
 * User: matteo
 * Date: 11/12/12
 * Time: 12.49
 * 
 * Just for fun...
 */

namespace Cypress\CompassElephantBundle\Collector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Cypress\CompassElephantBundle\Listener\CypressCompassRequestListener;

/**
 * data collector for compass
 */
class CompassDataCollector extends DataCollector
{
    private $requestListener;

    /**
     * constructor
     *
     * @param \Cypress\CompassElephantBundle\Listener\CypressCompassRequestListener $requestListener request listener
     */
    public function __construct(CypressCompassRequestListener $requestListener)
    {
        $this->requestListener = $requestListener;
    }

    /**
     * Collects data for the given Request and Response.
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An Exception instance
     *
     * @api
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'messages' => $this->requestListener->getMessages()
        );
    }

    /**
     * @param string $message error message
     */
    public function addMessage($message)
    {
        $this->data = array(
            'message' => $message
        );
    }


    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     *
     * @api
     */
    public function getName()
    {
        return 'cypress_compass_elephant';
    }
}
