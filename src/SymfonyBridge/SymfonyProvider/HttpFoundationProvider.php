<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge\SymfonyProvider;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RequestContext;


/**
 * Functions copied from \Symfony\Bridge\Twig\Extension\HttpFoundationExtension.
 */
class HttpFoundationProvider
{
	/** @var RequestStack */
	private $requestStack;

	/** @var RequestContext|null */
	private $requestContext;


	public function __construct(RequestStack $requestStack, ?RequestContext $requestContext = null)
	{
		$this->requestStack = $requestStack;
		$this->requestContext = $requestContext;
	}


	public function generateAbsoluteUrl(string $path): string
	{
		if (false !== strpos($path, '://') || 0 === strpos($path, '//')) {
			return $path;
		}

		if (!$request = $this->requestStack->getMasterRequest()) {
			if (null !== $this->requestContext && '' !== $host = $this->requestContext->getHost()) {
				$scheme = $this->requestContext->getScheme();
				$port = '';

				if ('http' === $scheme && 80 !== $this->requestContext->getHttpPort()) {
					$port = ':' . $this->requestContext->getHttpPort();
				} elseif ('https' === $scheme && 443 !== $this->requestContext->getHttpsPort()) {
					$port = ':' . $this->requestContext->getHttpsPort();
				}

				if ('#' === $path[0]) {
					$queryString = $this->requestContext->getQueryString();
					$path = $this->requestContext->getPathInfo() . ($queryString ? '?' . $queryString : '') . $path;
				} elseif ('?' === $path[0]) {
					$path = $this->requestContext->getPathInfo() . $path;
				}

				if ('/' !== $path[0]) {
					$path = rtrim($this->requestContext->getBaseUrl(), '/') . '/' . $path;
				}

				return $scheme . '://' . $host . $port . $path;
			}

			return $path;
		}

		if ('#' === $path[0]) {
			$path = $request->getRequestUri() . $path;
		} elseif ('?' === $path[0]) {
			$path = $request->getPathInfo() . $path;
		}

		if (!$path || '/' !== $path[0]) {
			$prefix = $request->getPathInfo();
			$last = \strlen($prefix) - 1;
			if ($last !== $pos = strrpos($prefix, '/')) {
				$prefix = substr($prefix, 0, $pos ?: 0) . '/';
			}

			return $request->getUriForPath($prefix . $path);
		}

		return $request->getSchemeAndHttpHost() . $path;
	}


	public function generateRelativePath(string $path): string
	{
		if (false !== strpos($path, '://') || 0 === strpos($path, '//')) {
			return $path;
		}

		if (!$request = $this->requestStack->getMasterRequest()) {
			return $path;
		}

		return $request->getRelativeUriForPath($path);
	}
}
