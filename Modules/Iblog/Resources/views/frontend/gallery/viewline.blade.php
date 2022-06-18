
<x-media::gallery :mediaFiles="$post->mediaFiles()" :responsive="[300 => ['items' =>  1],700 => ['items' =>  2], 1024 => ['items' => 3]]" />