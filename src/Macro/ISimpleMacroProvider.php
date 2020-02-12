<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\Macro;

interface ISimpleMacroProvider
{
	/**
	 * @return SimpleMacro[]
	 */
	public function getSimpleMacros(): array;
}
