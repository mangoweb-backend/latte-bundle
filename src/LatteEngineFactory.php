<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle;

use Closure;
use Latte\Engine;
use Latte\IMacro;
use Latte\Macros\MacroSet;
use Nette\Bridges\FormsLatte\FormMacros;
use Mangoweb\LatteBundle\Filter\IFilterProvider;
use Mangoweb\LatteBundle\Macro\SimpleMacro;
use Mangoweb\LatteBundle\Macro\ISimpleMacroProvider;


class LatteEngineFactory
{
	/** @var SimpleMacro[] */
	protected $simpleMacros = [];

	/** @var IMacro[] */
	protected $advancedMacros = [];

	/** @var IFilterProvider[] */
	protected $filterProviders;

	/** @var object[] */
	private $providers;


	public function addSimpleMacro(SimpleMacro $simpleMacro): void
	{
		$this->simpleMacros[] = $simpleMacro;
	}


	public function addSimpleMacroProvider(ISimpleMacroProvider $simpleMacroProvider): void
	{
		foreach ($simpleMacroProvider->getSimpleMacros() as $simpleMacro) {
			$this->simpleMacros[] = $simpleMacro;
		}
	}


	public function addProvider(string $name, object $provider): void
	{
		$this->providers[$name] = $provider;
	}


	public function addAdvanceMacro(string $name, IMacro $advancedMacro): void
	{
		$this->advancedMacros[$name] = $advancedMacro;
	}


	public function addFilterProvider(IFilterProvider $filterProvider): void
	{
		$this->filterProviders[] = $filterProvider;
	}


	protected function onCompile(Engine $engine): void
	{
		$compiler = $engine->getCompiler();
		$macroSet = new MacroSet($compiler);

		foreach ($this->simpleMacros as $simpleMacro) {
			$macroSet->addMacro(
				$simpleMacro->getName(),
				$simpleMacro->getBegin(),
				$simpleMacro->getEnd(),
				$simpleMacro->getAttr(),
				$simpleMacro->getFlags()
			);
		}

		foreach ($this->advancedMacros as $macroName => $advancedMacro) {
			$compiler->addMacro($macroName, $advancedMacro);
		}

		FormMacros::install($compiler);
	}


	public function create(): Engine
	{
		$engine = new Engine();
		$engine->onCompile[] = Closure::fromCallable([$this, 'onCompile']);

		foreach ($this->filterProviders as $filterProvider) {
			foreach ($filterProvider->getFilters() as $filterName => $filterCallable) {
				$engine->addFilter($filterName, $filterCallable);
			}
		}

		foreach ($this->providers as $providerName => $provider) {
			$engine->addProvider($providerName, $provider);
		}

		return $engine;
	}
}
