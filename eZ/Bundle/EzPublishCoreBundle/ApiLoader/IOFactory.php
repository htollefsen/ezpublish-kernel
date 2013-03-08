<?php
/**
 * File containing the IOServiceFactory class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace eZ\Bundle\EzPublishCoreBundle\ApiLoader;

use eZ\Publish\SPI\IO\Handler as IoHandlerInterface;
use eZ\Publish\Core\MVC\ConfigResolverInterface;

class IOFactory
{
    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    protected $configResolver;

    protected $IOServiceClass = 'eZ\\Publish\\Core\\IO\\IOService';

    /**
     * Constructs a new IOServiceFactory
     * @param ConfigResolverInterface $configResolver
     */
    public function __construct( ConfigResolverInterface $configResolver )
    {
        $this->configResolver = $configResolver;
    }

    /**
     * Returns a new IOService instance with the config string in $prefixSetting as a prefix
     *
     * @param IOHandlerInterface $IOHandler
     * @param string $prefixSetting
     *
     * @return \eZ\Publish\Core\IO\IOService
     */
    public function getService( IOHandlerInterface $IOHandler, $prefixSetting = false )
    {
        $settings = array();

        if ( $prefixSetting )
        {
            $settings['prefix'] = $this->configResolver->getParameter( $prefixSetting );
        }

        return new $this->IOServiceClass( $IOHandler, $settings );
    }

    /**
     * Returns an IOHandler instance
     *
     * @param $handlerClass The IOHandler class to instanciate
     * @param $legacyKernel
     * @param $varDirectorySetting Path to the "var" directory
     *
     * @return mixed
     */
    public function getHandler( $handlerClass, $legacyKernel, $varDirectorySetting )
    {
        return new $handlerClass(
            $legacyKernel,
            $this->configResolver->getParameter( $varDirectorySetting )
        );
    }
}
