<?php
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Entities\Place;

//OBTENER LUGARES
if (!function_exists('get_places')) {

  function get_places($options=array())
  {
    $default_options = array(

      'categories' => null,
      'users' => null, //usuario o usuarios que desea llamar
      'include' => array(),//id de place a para incluir en una consulta
      'exclude' => array(),// place, categorias o usuarios, que desee excluir de una consulta metodo de llmado tour=>'', places=>'' , users=>''
      'exclude_tours' => null,// categoria o categorias que desee Excluir
      'exclude_users' => null, //usuario o usuarios que desea Excluir
      'take' => 5, //Numero de places a obtener,
      'skip' => 0, //Omitir Cuantos place a llamar
      'order' => 'desc',//orden de llamado
      'status' => Status::ACTIVE
    );

    $options = array_merge($default_options, $options);

    $places = Place::query();

    $places = Place::with(['user','category']);

    if (!empty($options['id'])) {
      $places->where('id', $options['id']);
    }

    if (!empty($options['categories'])) {
      $places->whereHas('categories', function ($query) use ($options) {
        $query->whereIn('category_id', $options['categories']);
      });
    }
    if (!empty($options['tags'])) {
      $places->whereHas('tags', function ($query) use ($options) {
        $query->whereIn('tag_id', $options['tags']);
      });
    }
    if (!empty($options['users'])) {
      $places->whereHas('user', function ($query) use ($options) {
        $query->whereIn('user_id', $options['users']);
      });
    }
      if (!empty($options['validated'])&&$options['validated']) {
          $places->where('validated', true);
      }
    if (!empty($options['include'])) {
      $places->whereIn('id', $options['include']);
    }
    if (!empty($options['exclude'])) {
      $places->whereNotIn('id', $options['exclude']);
    }
    if (isset($options['exclude_tours'])) {
      $places->whereHas('tours', function ($query) use ($options) {
        $query->whereNotIn('tour_id', $options['exclude_tours']);
      });
    }
    if (isset($options['exclude_users'])) {
      $places->whereHas('user', function ($query) use ($options) {
        $query->whereNotIn('user_id', $options['exclude_users']);
      });
    }

    $places->whereStatus($options['status'])
      ->skip($options['skip'])
      ->take($options['take']);

    /*if(!empty($options['business_status_order'])) {
        $places->orderBy('business_status', $options['business_status_order']);
    } else {
        $places->orderBy('business_status', 'ASC');
    }*/

    if($options['order']=='RAND') {
      $places->inRandomOrder();
    } else {
      $places->orderBy('order', $options['order']);
    }
    return $places->get();
  }
}

if(!function_exists('format_date')){

  function format_date($date,$format){

    date_default_timezone_set('America/Bogota');
    setlocale(LC_TIME, "es_CO.UTF-8");
    //echo strftime($format,strtotime($date));
  }

}

if (!function_exists('placegallery')){

  function placegallery($id){
    $images = Storage::disk('publicmedia')->files('assets/iplaces/place/gallery/' . $id);
    return $images;
  }
}


if (!function_exists('get_Iplaces_categories')) {

  function get_Iplaces_categories($options = array())
  {
    $default_options = array(
      'include' => array(),//id de Categorias  para incluir en una consulta, se envia como arreglo ['include'=>[1,2,3]]
      'exclude' => array(),//id de categorias  que desee excluir de una consulta metodo de llmado category=>'[1,2]'
      'parent' => [0], //id de categorias  padre que desee mostrar en una consulta metodo de llmado category=>'[1,2]'
      'take' => 5, //Numero de posts a obtener,
      'skip' => 0, //Omitir Cuantos post a llamar
      'order' => 'desc',//orden de llamado
    );

    $options = array_merge($default_options, $options);

    $categories = Category::query();
    if (!empty($options['include'])) {
      $categories->whereIn('id', $options['include']);
    }
    if (!empty($options['exclude'])) {
      $categories->whereNotIn('id', $options['exclude']);
    }
    if (!empty($options['parent'])) {
      $categories->whereIn('parent_id', $options['parent']);
    }
    $categories->skip($options['skip'])
      ->take($options['take'])
      ->orderBy('created_at', $options['order']);

    return $categories->get();


  }
}