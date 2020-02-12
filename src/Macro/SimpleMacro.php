<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\Macro;

class SimpleMacro
{
	/** @var string */
	private $name;

	/** @var null|string|callable(\Latte\MacroNode, \Latte\PhpWriter):(null|string) */
	private $begin;

	/** @var null|string|callable(\Latte\MacroNode, \Latte\PhpWriter):(null|string) */
	private $end;

	/** @var null|string|callable(\Latte\MacroNode, \Latte\PhpWriter):(null|string) */
	private $attr;

	/** @var int|null */
	private $flags;


	/**
	 * @param string                                                                 $name
	 * @param null|string|callable(\Latte\MacroNode, \Latte\PhpWriter):(null|string) $begin
	 * @param null|string|callable(\Latte\MacroNode, \Latte\PhpWriter):(null|string) $end
	 * @param null|string|callable(\Latte\MacroNode, \Latte\PhpWriter):(null|string) $attr
	 * @param int|null                                                               $flags
	 */
	public function __construct(string $name, $begin = null, $end = null, $attr = null, ?int $flags = null)
	{
		$this->name = $name;
		$this->begin = $begin;
		$this->end = $end;
		$this->attr = $attr;
		$this->flags = $flags;
	}


	public function getName(): string
	{
		return $this->name;
	}


	/**
	 * @return null|string|callable(\Latte\MacroNode, \Latte\PhpWriter):(null|string)
	 */
	public function getBegin()
	{
		return $this->begin;
	}


	/**
	 * @return null|string|callable(\Latte\MacroNode, \Latte\PhpWriter):(null|string)
	 */
	public function getEnd()
	{
		return $this->end;
	}


	/**
	 * @return null|string|callable(\Latte\MacroNode, \Latte\PhpWriter):(null|string)
	 */
	public function getAttr()
	{
		return $this->attr;
	}


	public function getFlags(): ?int
	{
		return $this->flags;
	}
}
