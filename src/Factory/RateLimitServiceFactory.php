<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace Lhpalacio\Zf2RateLimit\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Cache\StorageFactory;
use Lhpalacio\Zf2RateLimit\Service\RateLimitService;
use Lhpalacio\Zf2RateLimit\Options\RateLimitOptions;
use RuntimeException;

/**
 * RateLimitServiceFactory
 *
 * @license MIT
 * @author Luiz Henrique Gomes Palácio <lhpalacio@outlook.com>
 */
class RateLimitServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return PluginManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var RateLimitOptions $rateLimitOptions */
        $rateLimitOptions = $container->get(RateLimitOptions::class);

        $storage = $rateLimitOptions->getStorage();

        if (!is_array($storage) || !$cache = StorageFactory::factory($storage)) {
            throw new RuntimeException('Unable to load storage.');
        }

        return new RateLimitService($cache, $rateLimitOptions);
    }

    /**
     * {@inheritDoc}
     * @return RateLimitService
     */
    public function createService(ServiceLocatorInterface $container, $name = null, $requestedName = null)
    {
        return $this($container, RateLimitService::class);

    }
}
