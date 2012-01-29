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

class CypressCompassRequestListener
{
    private $projectCollection;

    public function __construct(CompassProjectCollection $projectCollection)
    {
        $this->projectCollection = $projectCollection;
    }

    public function updateCompass(GetResponseEvent $getResponseEvent)
    {
        foreach ($this->projectCollection as $project) {
            if (!$project->isClean()) {
                $project->compile();
            }
        }
    }
}
