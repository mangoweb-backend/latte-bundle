<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge\FilterProvider;

use Mangoweb\LatteBundle\Filter\IFilterProvider;
use Symfony\Contracts\Translation\TranslatorInterface;


class TranslateFilters implements IFilterProvider
{
	/** @var null|TranslatorInterface */
	private $translator;


	public function __construct(?TranslatorInterface $translator = null)
	{
		$this->translator = $translator;
	}


	public function getFilters(): array
	{
		return [
			'translate' => [$this, 'translate'],
		];
	}


	/** @param mixed[] $arguments */
	public function translate(string $message, array $arguments = [], ?string $domain = null, ?string $locale = null): string
	{
		if (null === $this->translator) {
			return strtr($message, $arguments);
		}

		return $this->translator->trans($message, $arguments, $domain, $locale);
	}
}
