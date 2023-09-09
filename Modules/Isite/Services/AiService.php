<?php

namespace Modules\Isite\Services;

class AiService
{
  public $logTitle;
  public $n8nBaseUrl;
  public $translatablePrompt;

  private $fileService;

  public function __construct()
  {
    $this->logTitle = "[IA]::Service";
    $this->n8nBaseUrl = setting("isite::n8nBaseUrl");
    $this->translatablePrompt = "Generar para español e ingles poniendo los valores así {en, es}";

    $this->fileService = app("Modules\Media\Services\FileService");
  }

  /**
   * Return content about a promt
   *
   * @param $prompt
   * @param $quantity
   * @return array|void
   */
  public function getContent($prompt, $quantity = 1)
  {
    try {
      //Instance the full prompt
      $prompt = "Crea un JSON array de objects valido. con " .
        "$quantity elementos diferentes siguiendo estás instrucciones $prompt ";
      //Validate site description to do it
      $siteDescription = setting("core::site-description");
      \Log::info($this->logTitle."|getContent|Setting CoreSiteDescription: ".$siteDescription);

      if ($siteDescription) $prompt .= "el contenido debe de estar basado en esta descripción: $siteDescription";
      //Request
      $client = new \GuzzleHttp\Client();
      $request = $client->request('GET',
        "{$this->n8nBaseUrl}/ia/content",
        ['body' => json_encode(["prompt" => $prompt]), 'headers' => ['Content-Type' => 'application/json']]
      );
      $requestResponse = json_decode($request->getBody()->getContents());
      //Map the data
      $response = [];
      foreach ($requestResponse->data as $item) {
        foreach ($item as $key => $value) {
          if (isset($value->en)) $tmpItem["en"][$key] = $value->en;
          if (isset($value->es)) $tmpItem["es"][$key] = $value->es;
          if (isset($value->es) || isset($value->en)) continue;//Break
          $tmpItem[$key] = $value;
          
          if($key==="tags"){
            $itemImage = $this->getImage($value);
            $tmpItem['image'] = $itemImage;
          }

        }
        $response[] = $tmpItem;
      }


      //Get response
      return $response;
    } catch (\Exception $e) {
      \Log::error("$this->logTitle -> getContent | Error: " . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine());
    }
  }

  /**
   * Return standar fields to request content as string to concat in promt
   *
   * @return string[]
   */
  public function getStandardPrompts($fields = [], $params = [])
  {
    $response = "";
    //Instance default prompt fields
    $fieldsData = [
      'title' => "title: Que sea descriptivo, llamativo de entre 8 a 12 palabras, menos de 60 caracteres, $this->translatablePrompt",
      'shortTitle' => "shortTitle: Que sea descriptivo, llamativo de entre 1 a 2 palabras, $this->translatablePrompt",
      'name' => "name: Que sea descriptivo, llamativo de entre 8 a 12 palabras, menos de 60 caracteres, $this->translatablePrompt",
      'description' => "description: Que contenga entre 1200 y 1600 palabras con contenio que genere al menos 7 minutos " .
        "de lectura. El texto sea en formato HTML puede usar listas, títulos llamativos, $this->translatablePrompt",
      'body' => "body: Que contenga entre 2000 y 2500 palabras con contenido que genere al menos 7 minutos " .
        "de lectura. El texto sea en formato HTML puede usar listas, títulos llamativos y los titulos deben estar en la etiqueta html h2, $this->translatablePrompt",
      'summary' => "summary: Que contenga entre 50 y 80 palabras, que pueda atrapar e impulse a leer el post completo, $this->translatablePrompt",
      'slug' => "slug: Debe de estar apegado al titulo, solo mantener caracteres alfanuméricos y las palabras " .
        " separadas por guiones, $this->translatablePrompt",
      'shortSlug' => "shortSlug: Debe de estar apegado al shortTitle, solo mantener caracteres alfanuméricos y las palabras " .
        " separadas por guiones, $this->translatablePrompt",
      'category_id' => "category_id: Categoriza el elemento según su contenido en una de las siguientes categorías " .
        "seleccionando solo el ID: ",
      'price' => "price: Un valor Integer referente a valor de moneda colombiana",
      'tags' => "tags: crear tags separadados por coma"
    ];
    //Include the required fields
    foreach ($fields as $fieldName) {
      //Concat the field to response
      if (isset($fieldsData[$fieldName])) $response .= $fieldsData[$fieldName] . ", ";
      //If is category include the map categories
      if ($fieldName == "category_id" && isset($params["categories"])) {
        $response .= json_encode($params["categories"]->map(function ($item, $key) {
          return ["id" => $item->id, "title" => $item->title, "description" => $item->description,];
        })->toArray());
      }
    }
    //Response
    return $response;
  }

  /**
   * Save image from AI
   */
  public function getImage($tags)
  {
    
    \Log::info($this->logTitle."-> getImage |");

    if(is_array($tags))
      $tags = implode(",",$tags);
    

    $params = [
      'query' => [
         'prompt' => '"'.$tags.'"',
         'take' => 1
      ]
   ];

    $client = new \GuzzleHttp\Client();
    $request = $client->request('GET',"{$this->n8nBaseUrl}/ia/image",$params);
    $requestResponse = json_decode($request->getBody()->getContents());

    return $requestResponse;

  }

  /**
   * Save image in entity from AI
   */
  public function saveImage($image)
  {

    \Log::info($this->logTitle."|saveImage|entity");
   
    $path = $image->url;
    $provider = $image->provider;

    $fileCreated = $this->fileService->storeHotLinked($path,$provider);

    return $fileCreated;

  }

}
