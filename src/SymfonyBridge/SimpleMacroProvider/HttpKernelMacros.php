<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge\SimpleMacroProvider;

use Mangoweb\LatteBundle\Macro\ISimpleMacroProvider;
use Mangoweb\LatteBundle\Macro\SimpleMacro;
use Mangoweb\LatteBundle\SymfonyBridge\SymfonyProvider;


final class HttpKernelMacros implements ISimpleMacroProvider
{
	private const MACRO_PROVIDER_PREFIX = SymfonyProvider::PREFIX . '->getHttpKernelRuntime()';


	public function getSimpleMacros(): array
	{
		$simpleMacros = [];

		$simpleMacros[] = new SimpleMacro(
			'renderRoute',
			'echo %escape(' . self::MACRO_PROVIDER_PREFIX . '->renderRoute(%node.word, %node.array))'
		);

		$simpleMacros[] = new SimpleMacro(
			'routePath',
			'echo %escape(' . self::MACRO_PROVIDER_PREFIX . '->getRouteUrl(%node.word, %node.array))'
		);

		$simpleMacros[] = new SimpleMacro(
			'routeUrl',
			'echo %escape(' . self::MACRO_PROVIDER_PREFIX . '->getRouteUrl(
				%node.word, 
				%node.array, 
				Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
			))'
		);

		$simpleMacros[] = new SimpleMacro(
			'href',
			null,
			null,
			"
				echo ' href=\"'; 
				echo %escape(" . self::MACRO_PROVIDER_PREFIX . "->getRouteUrl(
					%node.word, 
					%node.array
				)); 
				echo '\"'
			"
		);

		return $simpleMacros;
	}
}
