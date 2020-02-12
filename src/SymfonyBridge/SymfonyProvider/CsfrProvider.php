<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge\SymfonyProvider;

use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


class CsfrProvider
{
	/** @var null|CsrfTokenManagerInterface */
	private $csrfTokenManager;


	public function __construct(?CsrfTokenManagerInterface $csrfTokenManager = null)
	{
		$this->csrfTokenManager = $csrfTokenManager;
	}


	public function getCsrfToken(string $tokenId): string
	{
		assert($this->csrfTokenManager !== null, 'Latte: You need to install Symfony/Security to use CSFR macro');
		return $this->csrfTokenManager->getToken($tokenId)->getValue();
	}
}
