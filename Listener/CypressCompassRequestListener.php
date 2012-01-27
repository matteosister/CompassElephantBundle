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
    public function onKernelRequest()
    {
    }

    public function updateCompass(CompassProjectCollection $projectCollection)
    {
        foreach ($projectCollection as $project) {
            $project->compile();
        }
    }
}
