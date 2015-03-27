<?php

namespace Incraigulous\Contentful;


interface CacherInterface {
    function has($key);
    function put($key, $payload);
    function get($key);
    function flush();
}