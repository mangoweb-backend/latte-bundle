<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\DependencyInjection;

use Mangoweb\LatteBundle\Filter\IFilterProvider;
use Mangoweb\LatteBundle\Macro\ISimpleMacroProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class LatteExtension extends Extension
{
	/** @param mixed[] $configs */
	public function load(array $configs, ContainerBuilder $containerBuilder): void
	{
		$loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.yaml');

		$containerBuilder->registerForAutoconfiguration(ISimpleMacroProvider::class)
			->addTag('latte.simple_macro_provider');

		$containerBuilder->registerForAutoconfiguration(IFilterProvider::class)
			->addTag('latte.filter_provider');
	}
}
