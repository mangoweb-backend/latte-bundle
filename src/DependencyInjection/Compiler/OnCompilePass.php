<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\DependencyInjection\Compiler;

use Latte\IMacro;
use Mangoweb\LatteBundle\LatteEngineFactory;
use Mangoweb\LatteBundle\Macro\SimpleMacro;
use Mangoweb\LatteBundle\Macro\ISimpleMacroProvider;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\TypedReference;


final class OnCompilePass implements CompilerPassInterface
{
	public const TAG_MACRO = 'latte.advanced_macro';
	public const TAG_MACRO__NAME = 'macro_name';

	public const TAG_MACRO_SIMPLE = 'latte.simple_macro';
	public const TAG_MACRO_SIMPLE_PROVIDER = 'latte.simple_macro_provider';


	/**
	 * @param ContainerBuilder $containerBuilder
	 */
	public function process(ContainerBuilder $containerBuilder): void
	{
		if (!$containerBuilder->has(LatteEngineFactory::class)) {
			return;
		}

		$definition = $containerBuilder->findDefinition(LatteEngineFactory::class);

		$this->addSimpleMacros($containerBuilder, $definition);
		$this->addSimpleMacroProviders($containerBuilder, $definition);
		$this->addMacros($containerBuilder, $definition);
	}


	private function addMacros(ContainerBuilder $containerBuilder, Definition $definition): void
	{
		$simpleMacroServices = $containerBuilder->findTaggedServiceIds(self::TAG_MACRO, true);

		foreach ($simpleMacroServices as $id => $tags) {
			foreach ($tags as $attributes) {
				if (empty($attributes[self::TAG_MACRO__NAME])) {
					throw new \Symfony\Component\Config\Definition\Exception\Exception(
						'Latte: Macro has to have name (add ' . self::TAG_MACRO__NAME . "), service ${id}, tag " . self::TAG_MACRO
					);
				}

				$className = $containerBuilder->getDefinition($id)->getClass();
				\assert(
					$className && is_subclass_of($className, IMacro::class),
					'Latte: Macro service has to implement ' . IMacro::class . ", service ${id}"
				);

				$definition->addMethodCall(
					'addAdvancedMacro',
					[$attributes[self::TAG_MACRO__NAME], new TypedReference($id, IMacro::class)]
				);
			}
		}
	}


	private function addSimpleMacros(ContainerBuilder $containerBuilder, Definition $definition): void
	{
		$simpleMacroServices = $containerBuilder->findTaggedServiceIds(self::TAG_MACRO_SIMPLE, true);

		foreach ($simpleMacroServices as $id => $tags) {
			$className = $containerBuilder->getDefinition($id)->getClass();

			\assert(
				$className && is_subclass_of($className, SimpleMacro::class),
				'Latte: Simple macro service has to implement ' . SimpleMacro::class . ", service ${id}"
			);

			$definition->addMethodCall(
				'addSimpleMacro',
				[new TypedReference($id, SimpleMacro::class)]
			);
		}
	}


	private function addSimpleMacroProviders(ContainerBuilder $containerBuilder, Definition $definition): void
	{
		$simpleMacroProvidersServices = $containerBuilder->findTaggedServiceIds(self::TAG_MACRO_SIMPLE_PROVIDER, true);

		foreach ($simpleMacroProvidersServices as $id => $tags) {
			$className = $containerBuilder->getDefinition($id)->getClass();

			\assert(
				$className && is_subclass_of($className, ISimpleMacroProvider::class),
				'Latte: Macro provider service has to implement ' . ISimpleMacroProvider::class . ", service ${id}"
			);

			$definition->addMethodCall(
				'addSimpleMacroProvider',
				[new TypedReference($id, ISimpleMacroProvider::class)]
			);
		}
	}
}
