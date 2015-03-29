<?php
namespace Incraigulous\ContentfulSDK\PayloadBuilders;

interface PayloadBuilderInterface {
    /**
     * return the payload builder array part.
     * @return mixed
     */
    function make();

    /**
     * Return the key,
     * @return mixed
     */
    function getKey();

}