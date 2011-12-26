<?php
/*
 * This file is part of the AlphaLemonThemeEngineBundle and it is distributed
 * under the MIT License. To use this bundle you must leave
 * intact this copyright notice.
 *
 * (c) Since 2011 AlphaLemon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://alphalemon.com
 * 
 * @license    MIT License
 */

namespace ElFinderCore\Connector;

use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerInterface;

// elfinder configuration
error_reporting(0);

include_once dirname(__FILE__).'/../../../Resources/public/vendor/ElFinder/php/elFinderConnector.class.php';
include_once dirname(__FILE__).'/../../../Resources/public/vendor/ElFinder/php/elFinder.class.php';
include_once dirname(__FILE__).'/../../../Resources/public/vendor/ElFinder/php/elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).'/../../../Resources/public/vendor/ElFinder/php/elFinderVolumeLocalFileSystem.class.php';

/**
 * Instantiates the elFinder connector
 *
 * @author AlphaLemon
 */
abstract class AlphaLemonElFinderBaseConnector
{
    private $options = array();
    protected $container = array();

    /**
     * Configures the elFinder options
     */
    abstract protected function configure();

    /**
     * The constructor
     * 
     * @param ContainerInterface $container 
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $options = $this->configure();
        if(null === $options)
        {
            throw new InvalidConfigurationException(sprintf("The configure method cannot return a null value. Check the value returned by the configure method in the %className% object", \get_class($this)));
        }

        if(!is_array($options))
        {
            throw new InvalidConfigurationException(sprintf("The configure method must return an array. Check the value returned by the configure method in the %className% object", \get_class($this)));
        }
        $this->options = $this->configure();
    }

    /**
     * Starts the elFinder
     */
    public function connect()
    {   
        $connector = new \elFinderConnector(new \elFinder($this->options));
        $connector->run();
    }
}
