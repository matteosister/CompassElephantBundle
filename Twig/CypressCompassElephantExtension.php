<?php
/**
 * User: matteo
 * Date: 11/12/12
 * Time: 16.31
 * 
 * Just for fun...
 */

namespace Cypress\CompassElephantBundle\Twig;

/**
 * twig extension
 */
use Symfony\Component\DependencyInjection\ContainerInterface;

class CypressCompassElephantExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'base64_encode' => new \Twig_Function_Method($this, 'base64Encode')
        );
    }

    /**
     * base64 encode
     *
     * @param string $filename file name
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function base64Encode($filename)
    {
        $filename = realpath($this->container->getParameter('kernel.root_dir').'/../web'.$filename);
        if (!is_file($filename)) {
            throw new \InvalidArgumentException(sprintf('The file %s do not exists', $filename));
        }

        return base64_encode(file_get_contents($filename));
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'cypress_compass_elephant';
    }
}
