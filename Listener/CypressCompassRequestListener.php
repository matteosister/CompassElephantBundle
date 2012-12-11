<?php
/**
 * User: matteo
 * Date: 27/01/12
 * Time: 13.48
 *
 * Just for fun...
 */

namespace Cypress\CompassElephantBundle\Listener;

use Cypress\CompassElephantBundle\Collection\CompassProjectCollection;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use CompassElephant\Exception\CompassException;
use Cypress\CompassElephantBundle\Collector\CompassDataCollector;

/**
 * listener for kernel event to compile compass
 */
class CypressCompassRequestListener
{
    /**
     * @var \Cypress\CompassElephantBundle\Collection\CompassProjectCollection
     */
    private $projectCollection;

    /**
     * @var array
     */
    private $messages;

    /**
     * class constructor
     *
     * @param \Cypress\CompassElephantBundle\Collection\CompassProjectCollection $projectCollection project collection
     */
    public function __construct(CompassProjectCollection $projectCollection)
    {
        $this->projectCollection = $projectCollection;
        $this->messages = array();
    }

    /**
     * update compass projects
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $getResponseEvent
     */
    public function updateCompass(GetResponseEvent $getResponseEvent)
    {
        if (HttpKernelInterface::MASTER_REQUEST !==  $getResponseEvent->getRequestType()) {
            return;
        }
        foreach ($this->projectCollection as $project) {
            if (!$project->isClean() || 1 == 1) {
                try {
                    $project->compile();
                } catch (CompassException $e) {
                    $this->messages[] = $e->getMessage();
                }
            }
        }
    }

    /**
     * Messages getter
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
