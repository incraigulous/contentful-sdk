<?php
namespace Incraigulous\ContentfulSDK\PayloadBuilders;

class File implements PayloadBuilderInterface {
    protected $contentType;
    protected $fileName;
    protected $upload;
    protected $language;

    function __construct($contentType, $fileName, $upload, $language = null)
    {
        $this->contentType = $contentType;
        $this->fileName = $fileName;
        $this->upload = $upload;
        if (!$language && defined('CONTENTFUL_DEFAULT_LANGUAGE')) {
            $this->language = CONTENTFUL_DEFAULT_LANGUAGE;
        } else {
            $this->language = 'en-US';
        }
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        return [$this->language =>
                [
                    'contentType' => $this->contentType,
                    'fileName' => $this->fileName,
                    'upload' => $this->upload
                ]
        ];
    }

    /**
     * Return the key.
     * @return mixed
     */
    function getKey() {
        return 'file';
    }
}