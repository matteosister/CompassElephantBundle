<?php
/**
 * User: matteo
 * Date: 27/01/12
 * Time: 16.16
 *
 * Just for fun...
 */

namespace Cypress\CompassElephantBundle\Collection;

use CompassElephant\CompassProject,
    CompassElephant\CommandCaller,
    CompassElephant\CompassBinary,
    CompassElephant\StalenessChecker\FinderStalenessChecker,
    CompassElephant\StalenessChecker\NativeStalenessChecker;

class CompassProjectCollection implements \ArrayAccess, \Iterator, \Countable
{
    private $compassProjects;
    private $binary;
    private $position;

    /**
     * class constructor
     *
     * @param \CompassElephant\CompassBinary $binary   a CompassBinary instance
     * @param                                $projects an array of projects configuration
     */
    public function __construct(CompassBinary $binary, $projects)
    {
        $this->binary = $binary;
        $this->position = 0;
        foreach ($projects as $name => $data) {
            $stalenessChecker = null;
            if ($data['staleness_checker'] == 'finder') {
                $stalenessChecker = new FinderStalenessChecker($data['path'], $data['config_file']);
            } else if ($data['staleness_checker'] == 'native') {
                $stalenessChecker = new NativeStalenessChecker(new CommandCaller($data['path'], $this->binary));
            } else {
                throw new \InvalidArgumentException('staleness_checker parameter should be "native" or "finder"');
            }
            $this->compassProjects[] = new CompassProject(
                $data['path'],
                $name,
                $this->binary,
                $stalenessChecker,
                $data['config_file'],
                $data['auto_init']
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->compassProjects[$this->position];
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->compassProjects[$this->position]);
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $offset An offset to check for.
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->compassProjects[$offset]);
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $offset The offset to retrieve.
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return isset($this->compassProjects[$offset]) ? $this->compassProjects[$offset] : null;
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value The value to set.
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->compassProjects[] = $value;
        } else {
            $this->compassProjects[$offset] = $value;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $offset The offset to unset.
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->compassProjects[$offset]);
    }

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function count()
    {
        return count($this->compassProjects);
    }


}
