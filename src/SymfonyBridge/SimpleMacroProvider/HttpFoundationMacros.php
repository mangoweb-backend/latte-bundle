<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge\SimpleMacroProvider;

use Mangoweb\LatteBundle\Macro\ISimpleMacroProvider;
use Mangoweb\LatteBundle\Macro\SimpleMacro;
use Mangoweb\LatteBundle\SymfonyBridge\SymfonyProvider;


final class HttpFoundationMacros implements ISimpleMacroProvider
{
	private const MACRO_PROVIDER_PREFIX = SymfonyProvider::PREFIX . '->getHttpFoundation()';


	public function getSimpleMacros(): array
	{
		$simpleMacros = [];

		$simpleMacros[] = new SimpleMacro(
			'relativePath',
			'echo %escape(' . self::MACRO_PROVIDER_PREFIX . '->generateRelativePath(%node.word))'
		);

		$simpleMacros[] = new SimpleMacro(
			'absoluteUrl',
			'echo %escape(' . self::MACRO_PROVIDER_PREFIX . '->generateAbsoluteUrl(%node.word))'
		);

		return $simpleMacros;
	}
}
