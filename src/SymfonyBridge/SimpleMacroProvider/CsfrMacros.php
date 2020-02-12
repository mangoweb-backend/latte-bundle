<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge\SimpleMacroProvider;

use Mangoweb\LatteBundle\Macro\ISimpleMacroProvider;
use Mangoweb\LatteBundle\Macro\SimpleMacro;
use Mangoweb\LatteBundle\SymfonyBridge\SymfonyProvider;


final class CsfrMacros implements ISimpleMacroProvider
{
	public function getSimpleMacros(): array
	{
		return [
			new SimpleMacro(
				'csrfToken',
				'echo %escape(' . SymfonyProvider::PREFIX . '->getCsfr()->getCsrfToken(%node.word));'
			),
		];
	}
}
