<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge\SimpleMacroProvider;

use Mangoweb\LatteBundle\Macro\ISimpleMacroProvider;
use Mangoweb\LatteBundle\Macro\SimpleMacro;
use Mangoweb\LatteBundle\SymfonyBridge\SymfonyProvider;


final class LogoutMacros implements ISimpleMacroProvider
{
	private const MACRO_PROVIDER_PREFIX = SymfonyProvider::PREFIX . '->getLogout()';


	public function getSimpleMacros(): array
	{
		$simpleMacros = [];

		$simpleMacros[] = new SimpleMacro(
			'logoutUrl',
			'echo %escape(' . self::MACRO_PROVIDER_PREFIX . '->getLogoutUrl(%node.word))'
		);

		$simpleMacros[] = new SimpleMacro(
			'logoutPath',
			'echo %escape(' . self::MACRO_PROVIDER_PREFIX . '->getLogoutPath(%node.word))'
		);

		return $simpleMacros;
	}
}
