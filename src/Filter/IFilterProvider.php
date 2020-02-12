<?php declare(strict_types = 1);

namespace Mangoweb\LatteBundle\Filter;

interface IFilterProvider
{
	/**
	 * Return array of filters in form of 'filter_name' => 'callable'.
	 *
	 * @return callable[]
	 */
	public function getFilters(): array;
}
