<?php

namespace Dyd\Config;


/**
 * Class for ...
 *
 * @author: jens
 * @since: 11/5/12
 */
class IniLoader implements \Symfony\Component\Config\Loader\LoaderInterface
{

    /**
     * @param FileLocatorInterface $locator
     */
    public function __construct(FileLocatorInterface $locator)
    {
        parent::__construct($locator);
    }

    /**
     * Loads a resource.
     *
     * @param mixed  $resource The resource
     * @param string $type     The resource type
     */
    public function load($resource, $type = null)
    {
        // TODO: Implement load() method.
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return Boolean true if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'ini' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }


}
