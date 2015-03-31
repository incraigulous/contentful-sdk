<?php
namespace Incraigulous\ContentfulSDK\PayloadBuilders;

class AssetField implements PayloadBuilderInterface {
    protected $name;
    protected $content;
    protected $language;
    protected $languages;

    function __construct($name, $content = null, $language = null)
    {
        $this->name = $name;
        $this->content = $content;
        if (!$language && defined('CONTENTFUL_DEFAULT_LANGUAGE')) {
            $this->language = CONTENTFUL_DEFAULT_LANGUAGE;
        } else {
            $this->language = 'en-US';
        }

        $this->parseContent($content);
    }

    /**
     * Add a language to the field.
     * @param $languageKey
     * @param $content
     * @return $this
     */
    function addLanguage($languageKey, $content) {
        //If the langage exists and it's an array, add to it instead of replacing it.
        if (is_array($this->getLanguage($languageKey))) {
            $this->languages[$languageKey][] = $content[0];
            return;
        }
        $this->languages[$languageKey] = $content;
        return $this;
    }

    protected function getLanguage($languageKey) {
        return (!empty($this->languages[$languageKey])) ? $this->languages[$languageKey] : null;
    }

    /**
     * Parse loaded content. Tests to see if it's a link or if languages are provided and handle appropriately.
     * @param $content
     */
    protected function parseContent($content) {
        if (!$content) {
            return;
        }
        if (is_string($content)) {
            $this->addLanguage($this->language, $content);
            return;
        }
        foreach($content as $key => $data) {
            if (!empty($data[0]['sys']['linkType'])) {
                foreach($data as $link) {
                    $this->addLink($link['id'], $link['linkType'], $key);
                }
            } else {
                if (is_numeric($key)) {
                    $this->addLanguage($this->language, [$data]);
                } else {
                    $this->addLanguage($key, $data);
                }
            }
        }
    }
    /**
     * Return the payload builder array part. If links are provided, return them instead of languages.
     * @return array
     */
    function make()
    {
        return $this->languages;
    }

    /**
     * Return the key.
     * @return mixed
     */
    function getKey() {
        return $this->name;
    }
}