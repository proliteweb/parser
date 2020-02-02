<?php

	namespace App\Components\Parser;


	use App\Helpers\Arr;

	class Extractor
	{
		private $html;

		public function __construct(string $html = '')
		{
			$this->setHtml($html);
		}

		public function setHtml(string $html): self
		{
			$this->html = $html;
			return $this;
		}

		public function extractImages(): array
		{
			return $this->extractByTagName('img');
		}

		public function extractByTagName(string $tag)
		{
			libxml_use_internal_errors(true);
			$dom = new \DOMDocument();
			$dom->loadHTML('<?xml encoding="utf-8" ?>' . $this->html);
			$tags = [];
			foreach ($dom->getElementsByTagName($tag) as $item) {
				$tags[] = $dom->saveHTML($item);
			}
			return $tags;
		}

		public function extractAttributesFromTags(array $htmlTags, $attributes): array
		{
			$attributes = implode('|', (array)$attributes);
			$values = [];
			//todo remake to DOMDocument::getAttribute
			foreach ($htmlTags as $img_tag) {
				preg_match_all('/(' . $attributes . ')=("[^"]*")/i', $img_tag, $values[ $img_tag ]);
			}
			$callback = function (array $imgArr) {
				array_shift($imgArr);
				$newArr = [];
				foreach ($imgArr[0] as $index => $attr) {
					$newArr[ $attr ] = trim($imgArr[1][ $index ], '"');
				}
				return $newArr;
			};
			return array_map($callback, $values);
		}

		public function extractAttributeFromTags(array $htmlTags, string $attribute)
		{
			$attributesArr = $this->extractAttributesFromTags($htmlTags, $attribute);
			$callback = function (array $item) use ($attribute) {
				return Arr::get($item, $attribute, '');
			};
			return array_map($callback, $attributesArr);

		}

	}