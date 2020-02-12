<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\SymfonyBridge;

use Nette\Utils\FileSystem;
use Nette\Utils\Strings;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Extractor\AbstractFileExtractor;
use Symfony\Component\Translation\Extractor\ExtractorInterface;
use Symfony\Component\Translation\MessageCatalogue;


class LatteExtractor extends AbstractFileExtractor implements ExtractorInterface
{
	/** @var string */
	private $prefix = '';


	/** @param string|iterable $resource */
	public function extract($resource, MessageCatalogue $catalogue): void
	{
		$pattern = '#(?|
			  \\{ _ \' ([\w.]++) \' \\}
			| \\(   \' ([\w.]++) \' \\|translate\\)
		)#x';

		foreach ($this->extractFiles($resource) as $file) {
			$content = FileSystem::read((string) $file);

			foreach (Strings::matchAll($content, $pattern) as $match) {
				$message = $match[1];
				$catalogue->set($message, $this->prefix . $message);
			}
		}
	}


	public function setPrefix($prefix): void
	{
		$this->prefix = $prefix;
	}


	protected function canBeExtracted($file): bool
	{
		return $this->isFile($file) && pathinfo($file, PATHINFO_EXTENSION) === 'latte';
	}


	/**
	 * @param string|string[] $directory
	 * @return iterable
	 */
	protected function extractFromDirectory($directory): iterable
	{
		return (new Finder())
			->files()
			->name('*.latte')
			->in($directory);
	}
}
