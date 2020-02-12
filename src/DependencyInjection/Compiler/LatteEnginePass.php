<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\DependencyInjection\Compiler;

use Mangoweb\LatteBundle\Filter\IFilterProvider;
use Mangoweb\LatteBundle\LatteEngineFactory;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;


final class LatteEnginePass implements CompilerPassInterface
{
	public const TAG_FILTER__NAME = 'filter_name';
	public const TAG_FILTER_PROVIDER = 'latte.filter_provider';

	public const TAG_PROVIDER = 'latte.provider';
	public const TAG_PROVIDER__NAME = 'provider_name';

	public const FILTER_PROVIDER_METHOD_SUFFIX = 'Filter';


	public function process(ContainerBuilder $containerBuilder): void
	{
		if (!$containerBuilder->has(LatteEngineFactory::class)) {
			return;
		}

		$definition = $containerBuilder->findDefinition(LatteEngineFactory::class);

		$this->addFilterProvider($containerBuilder, $definition);

		$this->addProviders($containerBuilder, $definition);
	}


	private function addFilterProvider(ContainerBuilder $containerBuilder, Definition $definition): void
	{
		$taggedServices = $containerBuilder->findTaggedServiceIds(self::TAG_FILTER_PROVIDER, true);

		foreach ($taggedServices as $id => $tags) {
			$class = $containerBuilder->getDefinition($id)->getClass();

			assert(
				$class !== null && is_subclass_of($class, IFilterProvider::class),
				'Latte: Services with tag ' . self::TAG_FILTER_PROVIDER . ' has to implement ' . IFilterProvider::class . "service ${id}"
			);

			$definition->addMethodCall('addFilterProvider', [new Reference($id)]);
		}
	}


	private function addProviders(ContainerBuilder $containerBuilder, Definition $definition): void
	{
		$taggedServices = $containerBuilder->findTaggedServiceIds(self::TAG_PROVIDER, true);
		foreach ($taggedServices as $id => $tags) {
			foreach ($tags as $attributes) {
				if (empty($attributes[self::TAG_PROVIDER__NAME])) {
					throw new \Symfony\Component\Config\Definition\Exception\Exception(
						'Latte: Provider has to have name (add ' . self::TAG_PROVIDER__NAME . "), service ${id}, tag " . self::TAG_PROVIDER
					);
				}

				$definition->addMethodCall(
					'addProvider',
					[(string) $attributes[self::TAG_PROVIDER__NAME], new Reference($id)]
				);
			}
		}
	}
}
