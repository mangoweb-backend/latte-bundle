<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge\SymfonyProvider;

use Symfony\Component\Security\Http\Logout\LogoutUrlGenerator;


class LogoutProvider
{
	/** @var null|LogoutUrlGenerator */
	private $generator;


	public function __construct(?LogoutUrlGenerator $generator = null)
	{
		$this->generator = $generator;
	}


	public function getLogoutPath(?string $key = null): string
	{
		assert($this->generator !== null, 'Latte: You need to install Symfony/Security to use logout macro');
		return $this->generator->getLogoutPath($key);
	}


	public function getLogoutUrl(?string $key = null): string
	{
		assert($this->generator !== null, 'Latte: You need to install Symfony/Security to use logout macro');
		return $this->generator->getLogoutUrl($key);
	}
}
