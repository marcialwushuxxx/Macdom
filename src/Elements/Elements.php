<?php

/**
 *
 * This file is part of the Macdom
 *
 * Copyright (c) 2015 Vladimír Macháček
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 *
 */

namespace Machy8\Macdom\Elements;

use Machy8\Macdom\Elements\ElementsSettings;

class Elements extends ElementsSettings
{

	public function isBoolean ($attribute)
	{
		$is = in_array($attribute, $this->booleanAttributes);

		return $is;
	}

	/**
	 * @param string $el
	 * @param string $method
	 * @return boolean
	 * @return array $settings
	 */
	public function findElement ($el, $method)
	{
		$exists = in_array($el, $this->elements);
		$return = FALSE;

		if ($exists === TRUE) {

			switch ($method) {
				case 'exists':
					$return = TRUE;
					break;
				case 'settings':
					$return = $this->getElementSettings($el);
					break;
			}
		}

		return $return;
	}

	/**
	 * @param string $el
	 * @return array
	 */
	private function getElementSettings ($el)
	{
		$qkAttributes = NULL;
		$paired = TRUE;
		$settings = $this->elementsSettings;

		if (isset($settings[$el])) {
			$s = $settings[$el];

			$paired = in_array('unpaired', $s) ? FALSE : TRUE;

			if (isset($s['qkAttributes'])) {
				if(count($s['qkAttributes']) >= 1)
				{
					$qkAttributes = $s['qkAttributes'];
				}
			}
		}

		return
		[
			'element' => $el,
			'paired' => $paired,
			'qkAttributes' => $qkAttributes
		];
	}

	/**
	 * @param array $elements
	 */
	public function addElements($elements)
	{
		if($elements !== NULL)
		{
			foreach($elements as $element => $settings)
			{
				$settingsExists = TRUE;

				if(is_integer($element))
				{
					$settingsExists = FALSE;
					$element = $settings;
				}

				if(!in_array($element, $this->elements))
				{
					$this->elements[] = $element;
				}

				if($settingsExists === TRUE)
				{
					if(!isset($this->elementsSettings[$element]))
					{
						$this->elementsSettings[] = $element;
					}
					if($settings !== NULL)
					{
						$this->elementsSettings[$element] = $settings;
					}
				}
			}
		}
	}

	/**
	 * @param array $attributes
	 */
	public function addBooleanAttributes ($attributes)
	{
		if($attributes !== NULL && gettype($attributes) === "array")
		{
			if(count($attributes) >= 1)
			{
				$merged = array_merge($this->booleanAttributes, $attributes);
				$this->booleanAttributes = $merged;
			}
		}
	}
}
