<?php

/**
 * Copyright (c) 2016 Tobias Trozowski
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace TobiasTest\Expressive\Filter;

use Interop\Container\ContainerInterface;
use Zend\Filter\FilterPluginManager;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Tobias\Expressive\Filter\FilterManagerDelegatorFactory;

/**
 * Class FilterManagerDelegatorFactoryTest
 * @package TobiasTest\Expressive\Filter
 */
class FilterManagerDelegatorFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            [ContainerInterface::class, '__invoke'],
            [ServiceLocatorInterface::class, 'createDelegatorWithName'],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testInvoke($interface, $method)
    {
        $config = [
            'input_filters' => [],
        ];

        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $container */
        $container = $this->getMockBuilder($interface)->getMockForAbstractClass();
        $container->expects($this->once())->method('has')->with('config')->will($this->returnValue(true));
        $container->expects($this->once())->method('get')->with('config')->will($this->returnValue($config));

        $pluginManager = $this->getMockBuilder(FilterPluginManager::class)->disableOriginalConstructor()->getMock();
        if (method_exists(FilterPluginManager::class, 'configure')) {
            $pluginManager->expects($this->once())->method('configure')->with(
                [
                    'abstract_factories' => [],
                    'aliases'            => [],
                    'delegators'         => [],
                    'factories'          => [],
                    'initializers'       => [],
                    'invokables'         => [],
                    'lazy_services'      => [],
                    'services'           => [],
                    'shared'             => [],
                ]
            );
        }


        $callback = function () use ($pluginManager) {
            return $pluginManager;
        };

        $subject = new FilterManagerDelegatorFactory();
        $this->assertInstanceOf(DelegatorFactoryInterface::class, $subject);

        if ($container instanceof ServiceLocatorInterface) {
            $instance = $subject->$method($container, 'FilterManager', 'FilterManager', $callback);
        } else {
            $instance = $subject->$method($container, 'FilterManager', $callback);
        }

        $this->assertInstanceOf(FilterPluginManager::class, $instance);
    }
}
