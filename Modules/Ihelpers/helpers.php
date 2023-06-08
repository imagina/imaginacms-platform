<?php
use Illuminate\Support\Str;

if(! function_exists('canonical_url')) {

    function canonical_url() {
   
      if(isset(tenant()->id)){
        return str_replace(URL::to(''),tenant()->url,URL::current());
      }
        return str_replace(URL::to(''),config('app.url'),URL::current());
    }

}

if(! function_exists('istr_slug')) {
    function istr_slug($title, $separator = '-', $language = 'en',$allowedchars=array())
    {
        $title = Str::ascii($title, $language);
        // Convert all dashes/underscores into separator
        $flip = $separator == '-' ? '_' : '-';
        $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);
        // Replace @ with the word 'at'
        $title = str_replace('@', $separator . 'at' . $separator, $title);
        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = preg_replace('![^' . preg_quote($separator) . '^' . preg_quote(".") . '\pL\pN\s]+!u', '', mb_strtolower($title));
        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);
        return trim($title, $separator);
    }
}

if(!function_exists('isubstr')) {
    /**
     * Truncates text.
     *
     * Cuts a string to the length of $length and replaces the last characters
     * with the ending if the text is longer than length.
     *
     * ### Options:
     *
     * - `ending` Will be used as Ending and appended to the trimmed string
     * - `exact` If false, $text will not be cut mid-word
     * - `html` If true, HTML tags would be handled correctly
     *
     * @param string $text String to truncate.
     * @param integer $length Length of returned string, including ellipsis.
     * @param array $options An array of html attributes and options.
     * @return string Trimmed string.
     * @access public
     * @link http://book.cakephp.org/view/1469/Text#truncate-1625
     */
    function isubstr($text, $length = 100, $options = array())
    {
        $default = array(
            'ending' => '...', 'exact' => true, 'html' => false
        );
        $options = array_merge($default, $options);
        extract($options);

        if ($html) {
            if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
            $totalLength = mb_strlen(strip_tags($ending));
            $openTags = array();
            $truncate = '';

            preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
            foreach ($tags as $tag) {
                if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                    if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                        array_unshift($openTags, $tag[2]);
                    } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                        $pos = array_search($closeTag[1], $openTags);
                        if ($pos !== false) {
                            array_splice($openTags, $pos, 1);
                        }
                    }
                }
                $truncate .= $tag[1];

                $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
                if ($contentLength + $totalLength > $length) {
                    $left = $length - $totalLength;
                    $entitiesLength = 0;
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                        foreach ($entities[0] as $entity) {
                            if ($entity[1] + 1 - $entitiesLength <= $left) {
                                $left--;
                                $entitiesLength += mb_strlen($entity[0]);
                            } else {
                                break;
                            }
                        }
                    }

                    $truncate .= mb_substr($tag[3], 0, $left + $entitiesLength);
                    break;
                } else {
                    $truncate .= $tag[3];
                    $totalLength += $contentLength;
                }
                if ($totalLength >= $length) {
                    break;
                }
            }
        } else {
            if (mb_strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
            }
        }
        if (!$exact) {
            $spacepos = mb_strrpos($truncate, ' ');
            if (isset($spacepos)) {
                if ($html) {
                    $bits = mb_substr($truncate, $spacepos);
                    preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                    if (!empty($droppedTags)) {
                        foreach ($droppedTags as $closingTag) {
                            if (!in_array($closingTag[1], $openTags)) {
                                array_unshift($openTags, $closingTag[1]);
                            }
                        }
                    }
                }
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }
        $truncate .= $ending;

        if ($html) {
            foreach ($openTags as $tag) {
                $truncate .= '</' . $tag . '>';
            }
        }

        return $truncate;
    }
}

if (!function_exists('saveImage')) {

  /**
   * @param $value
   * @param $destination_path
   * @param string $disk
   * @param array $size
   * @param array $watermark
   * @return destination_path
   */
  function saveImage($value, $destination_path, $disk='publicmedia', $size = array(), $watermark = array())
  {

    $default_size = [
      'imagesize' => [
        'width' => 1024,
        'height' => 768,
        'quality'=>80
      ],
      'mediumthumbsize' => [
        'width' => 400,
        'height' => 300,
        'quality'=>80
      ],
      'smallthumbsize' => [
        'width' => 100,
        'height' => 80,
        'quality'=>80
      ],
    ];
    $default_watermark=[
      'activated' => false,
      'url' => 'modules/ihelpers/img/watermark/watermark.png',
      'position' => 'top-left',
      'x' => 10,
      'y' => 10,
    ];
    $size = json_decode(json_encode(array_merge($default_size, $size)));
    $watermark = json_decode(json_encode(array_merge($default_watermark, $watermark)));

    //Defined return.
    if (is_string($value) && strpos($value, '.jpg')) {
      return $value;
    }

    // if a base64 was sent, store it in the db
    if (Str::startsWith($value, 'data:image')) {
      // 0. Make the image
      $image = \Image::make($value);
      // resize and prevent possible upsizing

      $image->resize($size->imagesize->width, $size->imagesize->height, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
      });
      if ($watermark->activated) {
        $image->insert($watermark->url, $watermark->position, $watermark->x, $watermark->y);
      }

      //setting end file (format)
      $endFile = 'jpg';
      if(Str::startsWith($value, 'data:image/png;'))
        $endFile = 'png';

      \Log::info([$endFile, $size->imagesize->quality]);
      // 2. Store the image on disk.
      \Storage::disk($disk)->put($destination_path, $image->stream($endFile, $size->imagesize->quality));


      // Save Thumbs
      \Storage::disk($disk)->put(
        str_replace('.'.$endFile, '_mediumThumb.'.$endFile, $destination_path),
        $image->fit($size->mediumthumbsize->width, $size->mediumthumbsize->height)->stream($endFile, $size->mediumthumbsize->quality)
      );

      \Storage::disk($disk)->put(
        str_replace('.'.$endFile, '_smallThumb.'.$endFile, $destination_path),
        $image->fit($size->smallthumbsize->width, $size->smallthumbsize->height)->stream($endFile, $size->smallthumbsize->quality)
      );

      // 3. Return the path
      return $destination_path;
    }

    // if the image was erased
    if ($value == null) {
      // delete the image from disk
      \Storage::disk($disk)->delete($destination_path);

      // set null in the database column
      return null;
    }


  }
}

if(! function_exists('youtubeID')) {
    function youtubeID($url)
    {
        if (strlen($url) > 11) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                return 'https://www.youtube.com/embed/'.$match[1];
            } else
                return false;
        }

        return $url;
    }
}

if(!function_exists('validateJson')){
    function validateJson($string,$return_data = false) {
        $data = json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;

    }
}
