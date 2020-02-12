<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge;

class SymfonyProvider
{
	public const PREFIX = '$this->global->_symfony';

	/** @var SymfonyProvider\HttpKernelRuntimeProvider */
	private $httpKernel;

	/** @var SymfonyProvider\HttpFoundationProvider */
	private $httpFoundation;

	/** @var SymfonyProvider\CsfrProvider */
	private $csfr;

	/** @var SymfonyProvider\LogoutProvider */
	private $logout;


	public function __construct(
		SymfonyProvider\HttpKernelRuntimeProvider $httpKernel,
		SymfonyProvider\HttpFoundationProvider $httpFoundation,
		SymfonyProvider\CsfrProvider $csfr,
		SymfonyProvider\LogoutProvider $logout
	) {
		$this->httpKernel = $httpKernel;
		$this->httpFoundation = $httpFoundation;
		$this->csfr = $csfr;
		$this->logout = $logout;
	}


	public function getHttpKernelRuntime(): SymfonyProvider\HttpKernelRuntimeProvider
	{
		return $this->httpKernel;
	}


	public function getHttpFoundation(): SymfonyProvider\HttpFoundationProvider
	{
		return $this->httpFoundation;
	}


	public function getCsfr(): SymfonyProvider\CsfrProvider
	{
		return $this->csfr;
	}


	public function getLogout(): SymfonyProvider\LogoutProvider
	{
		return $this->logout;
	}
}
