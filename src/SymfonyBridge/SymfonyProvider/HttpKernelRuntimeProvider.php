<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge\SymfonyProvider;

use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class HttpKernelRuntimeProvider
{
	/** @var FragmentHandler */
	private $fragmentHandler;

	/** @var UrlGeneratorInterface */
	private $urlGenerator;


	public function __construct(
		FragmentHandler $fragmentHandler,
		UrlGeneratorInterface $urlGenerator
	) {
		$this->fragmentHandler = $fragmentHandler;
		$this->urlGenerator = $urlGenerator;
	}


	/** @param mixed[] $routeParams */
	public function getRouteUrl(
		string $routeName,
		array $routeParams,
		int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH
	): string {
		return $this->urlGenerator->generate($routeName, $routeParams, $referenceType);
	}


	/** @param mixed[] $args */
	public function renderRoute(string $routeName, array $args): \Latte\Runtime\Html
	{
		$routeParams = $args['routeParams'] ?? [];
		$renderOptions = $args['renderOptions'] ?? [];

		$url = $this->urlGenerator->generate($routeName, $routeParams);

		$strategy = $renderOptions['strategy'] ?? 'inline';
		unset($renderOptions['strategy']);

		return new \Latte\Runtime\Html($this->fragmentHandler->render($url, $strategy, $renderOptions) ?? '');
	}
}
