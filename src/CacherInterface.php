<?php

namespace Incraigulous\ContentfulSDK;


interface CacherInterface {
    function has($key);
    function put($key, $payload);
    function get($key);
    function flush();
}