<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle;

use Mangoweb\LatteBundle\DependencyInjection\Compiler\LatteEnginePass;
use Mangoweb\LatteBundle\DependencyInjection\Compiler\OnCompilePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class LatteBundle extends Bundle
{
	public function build(ContainerBuilder $containerBuilder): void
	{
		parent::build($containerBuilder);

		$containerBuilder->addCompilerPass(new LatteEnginePass());
		$containerBuilder->addCompilerPass(new OnCompilePass());
	}
}
