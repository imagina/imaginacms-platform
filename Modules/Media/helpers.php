<?php

if (!function_exists('mediaMimesAvailableRule')) {
  
  function mediaMimesAvailableRule()
  {
    return 'mimes:' . join(',', json_decode(setting('media::allowedImageTypes', null, config("asgard.media.config.allowedImageTypes"))))
      . "," . join(',', json_decode(setting('media::allowedFileTypes', null, config("asgard.media.config.allowedFileTypes"))))
      . "," . join(',', json_decode(setting('media::allowedVideoTypes', null, config("asgard.media.config.allowedVideoTypes"))))
      . "," . join(',', json_decode(setting('media::allowedAudioTypes', null, config("asgard.media.config.allowedAudioTypes"))));
  
  }
}
if (!function_exists('mediaExtensionsAvailable')) {
  
  function mediaExtensionsAvailable()
  {
    return  array_merge(json_decode(setting('media::allowedImageTypes', null, config("asgard.media.config.allowedImageTypes"))),
  json_decode(setting('media::allowedFileTypes', null, config("asgard.media.config.allowedFileTypes"))),
  json_decode(setting('media::allowedVideoTypes', null, config("asgard.media.config.allowedVideoTypes"))),
  json_decode(setting('media::allowedAudioTypes', null, config("asgard.media.config.allowedAudioTypes")))
  );
  
  }
}
if (!function_exists('mediaPrivatePath')) {
  
  function mediaPrivatePath($file)
  {
    $path = "";
    $argv = explode("/", $file->path->getRelativeUrl());
    $fileName = end($argv);
    foreach ($argv as $key => $str) if($key == 0) $path .= "$str"; elseif($str != $fileName) $path .= "/$str";
    $path .= "/".$file->filename;
  
    return $path;
  }
}
