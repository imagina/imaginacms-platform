<?php

$vAttributes = include(base_path() . '/Modules/Isite/Config/standardValuesForBlocksAttributes.php');

return [
  "item" => [
    "title" => "Elemento",
    "systemName" => "isite::item-list",
    "nameSpace" => "Modules\Isite\View\Components\ItemList",
    "content" => [
      [
        "label" => "Inherit Page",
        "value" => "Modules\Page\Entities\Page",
        "loadOptions" => [
          "apiRoute" => "apiRoutes.qpage.pages"
        ]
      ]
    ],
    "attributes" => [
      "general" => [
        "title" => "General",
        "fields" => [
          "layout" => [
            "name" => "layout",
            "value" => "item-list-layout-6",
            "type" => "select",
            'columns' => 'col-12',
            "props" => [
              "label" => "Layout",
              "options" => [
                ["label" => "Layout 6 (Contenido Individual Vertical)", "value" => "item-list-layout-6"],
                ["label" => "Layout 7 (Textos - Imagenes)", "value" => "item-list-layout-7"]
              ]
            ]
          ],
          "itemClasses" => [
            "name" => "itemClasses",
            "type" => "input",
            "value" => "",
            "columns" => "col-12",
            "props" => [
                "label" => "Clases item",
            ]
          ],
          "contentPaddingL" => [
            "name" => "contentPaddingL",
            "type" => "input",
            "props" => [
              "label" => "(Izq) Espacio Externo",
              "type" => "number"
            ]
          ],
          "contentPaddingR" => [
            "name" => "contentPaddingR",
            "type" => "input",
            "props" => [
              "label" => "(Der) Espacio Externo",
              "type" => "number"
            ]
          ],
          "contentPaddingT" => [
            "name" => "contentPaddingT",
            "type" => "input",
            "props" => [
              "label" => "(Arriba) Espacio Externo",
              "type" => "number"
            ]
          ],
          "contentPaddingB" => [
            "name" => "contentPaddingB",
            "type" => "input",
            "props" => [
              "label" => "(Abajo) Espacio Externo",
              "type" => "number"
            ]
          ],
          "itemMarginB" => [
            "name" => "itemMarginB",
            "value" => "",
            "type" => "select",
            "props" => [
              "label" => "Margen Inferior",
              "options" => $vAttributes["marginB"]
            ]
          ],
          "contentBorderRounded" => [
            "name" => "contentBorderRounded",
            "value" => "",
            "type" => "input",
            "props" => [
              "label" => "Borde Redondeado",
              "type" => "number"
            ]
          ],
          "contentBorderRoundedType" => [
            "name" => "contentBorderRoundedType",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Posición del Borde",
              "options" => $vAttributes["contentBorderRoundedType"]
            ]
          ],
          "contentBorder" => [
            "name" => "contentBorder",
            "value" => "0",
            "type" => "select",
            "props" => [
              "label" => "Grosor del Borde",
              "options" => [
                ["label" => "0", "value" => "0"],
                ["label" => "1px", "value" => "1"],
                ["label" => "2px", "value" => "2"],
                ["label" => "3px", "value" => "3"],
                ["label" => "4px", "value" => "4"],
                ["label" => "5px", "value" => "5"]
              ]
            ]
          ],
          "contentBorderColor" => [
            "name" => "contentBorderColor",
            "type" => "inputColor",
            "props" => [
              "label" => "Color Del Borde"
            ]
          ],
          "itemBackgroundColor" => [
            "name" => "itemBackgroundColor",
            "type" => "input",
            "props" => [
              "label" => "Color del Fondo"
            ]
          ],
          "itemBackgroundColorHover" => [
            "name" => "itemBackgroundColorHover",
            "type" => "input",
            "props" => [
              "label" => "Color del Fondo (Hover)"
            ]
          ],
          "contentBorderShadows" => [
            "name" => "contentBorderShadows",
            "value" => "none",
            "type" => "select",
            "props" => [
              "label" => "Tamaño de la Sombra",
              "options" => $vAttributes["contentBorderShadows"]
            ]
          ],
          "contentBorderShadowsHover" => [
            "name" => "contentBorderShadowsHover",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Sombra en hover mouse",
              "options" => $vAttributes["validation"]
            ]
          ],
          "orderClasses" => [
            "name" => "orderClasses",
            "value" => ["photo" => "order-0", "title" => "order-1", "date" => "order-2", "categoryTitle" => "order-3", "summary" => "order-4", "viewMoreButton" => "order-5"],
            "type" => "json",
            "columns" => "col-12",
            "props" => [
              "label" => "Orden de los elementos"
            ]
          ],
        ]
      ],
      "contenido6" => [
        "title" => "Contenido Layout 6",
        "fields" => [
          "contentMarginInsideX" => [
            "name" => "contentMarginInsideX",
            "type" => "select",
            "props" => [
              "label" => "Margen X de los textos",
              "options" => $vAttributes["marginX"]
            ]
          ],
        ],
      ],
      "contenido7" => [
        "title" => "Contenido Layout 7",
        "fields" => [
          "contentPositionVertical" => [
            "name" => "contentPositionVertical",
            "type" => "select",
            "props" => [
              "label" => "Alineación vertical",
              "options" => $vAttributes["positionVertical"]
            ]
          ],
          "contentPaddingLeft" => [
            "name" => "contentPaddingLeft",
            "type" => "input",
            "props" => [
              "label" => "Espaciado izquierdo",
            ]
          ],
          "contentPaddingRight" => [
            "name" => "contentPaddingRight",
            "type" => "input",
            "props" => [
              "label" => "Espaciado derecho",
            ]
          ],
          "containerActive" => [
            "name" => "containerActive",
            "value" => "0",
            "type" => "select",
            "props" => [
              "label" => "Activar Container",
              "options" => $vAttributes["validation"]
            ]
          ],
          "containerType" => [
            "name" => "containerType",
            "value" => "container",
            "type" => "select",
            "props" => [
              "label" => "Tipo de contenedor",
              "options" => $vAttributes["containers"]
            ]
          ],
          "containerJustify" => [
            "name" => "containerJustify",
            "value" => "justify-content-center",
            "type" => "input",
            "props" => [
              "label" => "Alinear Horizontal Fila",
            ]
          ],
          "containerAlign" => [
            "name" => "containerAlign",
            "value" => "align-items-center",
            "type" => "input",
            "props" => [
              "label" => "Alinear Vertical Fila",
            ]
          ],
          "containerColumn" => [
            "name" => "containerColumn",
            "value" => "col-lg-10",
            "type" => "input",
            "props" => [
              "label" => "Ancho de Columna",
            ]
          ],
          "contentBackground" => [
            "name" => "contentBackground",
            "columns" => "col-lg-12",
            "type" => "input",
            "props" => [
              "label" => "Color del contenedor",
            ]
          ]
        ],
      ],
      "title" => [
        "title" => "Titulo",
        "fields" => [
          "withTitle" => [
            "name" => "withTitle",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar",
              "options" => $vAttributes["validation"]
            ]
          ],
          "titleTextSize" => [
            "name" => "titleTextSize",
            "value" => "20",
            "type" => "input",
            "props" => [
              "label" => "Tamaño",
              "type" => "number"
            ]
          ],
          "titleTextSizeMobile" => [
            "name" => "titleTextSizeMobile",
            "value" => "20",
            "type" => "input",
            "props" => [
              "label" => "Tamaño Movil",
              "type" => "number"
            ]
          ],
          "titleTextTransform" => [
            "name" => "titleTextTransform",
            "type" => "select",
            "props" => [
              "label" => "Transformar",
              "options" => $vAttributes["textTransform"]
            ]
          ],
          "titleColor" => [
            "name" => "titleColor",
            "type" => "select",
            "props" => [
              "label" => "Color",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "titleAlign" => [
            "name" => "titleAlign",
            "type" => "select",
            "props" => [
              "label" => "Alineación Horizontal",
              "options" => [
                ["label" => "centrado", "value" => "justify-content-center text-center"],
                ["label" => "derecha", "value" => "justify-content-end text-right"],
                ["label" => "izquierda", "value" => ""],
              ]
            ]
          ],
          "titleAlignVertical" => [
            "name" => "titleAlignVertical",
            "type" => "select",
            "props" => [
              "label" => "Alineación Vertical",
              "options" => $vAttributes["alignItems"]
            ]
          ],
          "titleMarginT" => [
            "name" => "titleMarginT",
            "type" => "select",
            "props" => [
              "label" => "Margen superior",
              "options" => $vAttributes["marginT"]
            ]
          ],
          "titleMarginB" => [
            "name" => "titleMarginB",
            "type" => "select",
            "props" => [
              "label" => "Margen inferior",
              "options" => $vAttributes["marginB"]
            ]
          ],
          "titleLetterSpacing" => [
            "name" => "titleLetterSpacing",
            "type" => "input",
            "props" => [
                "label" => "Espacio entre letras",
                "type" => "number"
            ]
          ],
          "titleTextWeight" => [
            "name" => "titleTextWeight",
            "columns" => "col-12",
            "type" => "select",
            "props" => [
              "label" => "Negrita",
              "options" => $vAttributes["textWeight"]
            ]
          ],
          "titleHeight" => [
            "name" => "titleHeight",
            "type" => "input",
            "props" => [
              "label" => "Alto maximo",
              "type" => "number"
            ]
          ],
          "numberCharactersTitle" => [
            "name" => "numberCharactersTitle",
            "type" => "input",
            "props" => [
              "label" => "Número de caracteres permitidos",
              "type" => "number"
            ]
          ],
          "titleTextDecoration" => [
            "name" => "titleTextDecoration",
            "value" => "none",
            "type" => "select",
            "props" => [
              "label" => "Decoración",
              "options" => $vAttributes["textDecoration"]
            ]
          ],
          "titleVineta" => [
            "name" => "titleVineta",
            "type" => "input",
            "props" => [
              "label" => "Icon",
              "type" => "text"
            ]
          ],
          "titleVinetaColor" => [
            "name" => "titleVinetaColor",
            "type" => "select",
            "props" => [
              "label" => "Color Icon",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "titleShadow" => [
            "name" => "titleShadow",
            "type" => "input",
            "value" => "",
            "props" => [
                "label" => "Sombra de texto",
            ]
          ],
          "titleHead" => [
            "name" => "titleHead",
            "value" => "h3",
            "type" => "select",
            "props" => [
              "label" => "Tipo de Cabecera",
              "options" => $vAttributes["headHtml"]
            ]
          ],
          "titleClasses" => [
            "name" => "titleClasses",
            "type" => "input",
            "value" => "",
            "columns" => "col-12",
            "props" => [
                "label" => "Clases generales",
            ]
          ],
        ],
      ],
      "summary" => [
        "title" => "Resumen",
        "fields" => [
          "withSummary" => [
            "name" => "withSummary",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar",
              "options" => $vAttributes["validation"]
            ]
          ],
          "summaryTextSize" => [
            "name" => "summaryTextSize",
            "value" => "16",
            "type" => "input",
            "props" => [
              "label" => "Tamaño",
              "type" => "number"
            ]
          ],
          "summaryAlign" => [
            "name" => "summaryAlign",
            "value" => "text-left",
            "type" => "select",
            "props" => [
              "label" => "Alineación",
              "options" => $vAttributes["textAlign"]
            ]
          ],
          "summaryColor" => [
            "name" => "summaryColor",
            "type" => "select",
            "props" => [
              "label" => "Color",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "summaryMarginT" => [
            "name" => "summaryMarginT",
            "value" => "mt-0",
            "type" => "select",
            "props" => [
              "label" => "Margen superior",
              "options" => $vAttributes["marginT"]
            ]
          ],
          "summaryMarginB" => [
            "name" => "summaryMarginB",
            "value" => "mb-0",
            "type" => "select",
            "props" => [
              "label" => "Margen inferior",
              "options" => $vAttributes["marginB"]
            ]
          ],
          "summaryLetterSpacing" => [
            "name" => "summaryLetterSpacing",
            "type" => "input",
            "props" => [
              "label" => "Espacio entre letras",
              "type" => "number"
            ]
          ],
          "summaryTextDecoration" => [
            "name" => "summaryTextDecoration",
            "value" => "none",
            "type" => "select",
            "props" => [
              "label" => "Decoración",
              "options" => $vAttributes["textDecoration"]
            ]
          ],
          "summaryTextWeight" => [
            "name" => "summaryTextWeight",
            "columns" => "col-12",
            "type" => "select",
            "props" => [
              "label" => "Negrita",
              "options" => $vAttributes["textWeight"]
            ]
          ],
          "numberCharactersSummary" => [
            "name" => "numberCharactersSummary",
            "value" => "100",
            "type" => "input",
            "props" => [
              "label" => "Número de caracteres permitidos",
              "type" => "number"
            ]
          ],
          "summaryHeight" => [
            "name" => "summaryHeight",
            "value" => "",
            "type" => "input",
            "props" => [
              "label" => "Alto maximo",
              "type" => "number"
            ]
          ],
          "summaryLineHeight" => [
            "name" => "summaryLineHeight",
            "type" => "input",
            "props" => [
              "label" => "Alto de la línea",
              "type" => "number"
            ]
          ],
          "summaryShadow" => [
            "name" => "summaryShadow",
            "type" => "input",
            "value" => "",
            "props" => [
                "label" => "Sombra de texto",
            ]
          ],
          "summaryClasses" => [
            "name" => "summaryClasses",
            "type" => "input",
            "value" => "",
            "columns" => "col-12",
            "props" => [
                "label" => "Clases generales",
            ]
          ],
          "summaryField" => [
            "name" => "summaryField",
            "columns" => "col-12",
            "type" => "input",
            "props" => [
                "label" => "Campo Falso Extra",
            ],
            "help" => [
                "description" => "Ejemplo de opciones de campo falso 'options.secondaryDescription'",
            ],
          ],
        ],
      ],
      "category" => [
        "title" => "Categoría",
        "fields" => [
          "withCategory" => [
            "name" => "withCategory",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar",
              "options" => $vAttributes["validation"]
            ]
          ],
          "categoryTextSize" => [
            "name" => "categoryTextSize",
            "value" => "16",
            "type" => "input",
            "props" => [
              "label" => "Tamaño",
              "type" => "number"
            ]
          ],
          "categoryAlign" => [
            "name" => "categoryAlign",
            "type" => "select",
            "props" => [
              "label" => "Alineación",
              "options" => $vAttributes["align"]
            ]
          ],
          "categoryColor" => [
            "name" => "categoryColor",
            "type" => "select",
            "props" => [
              "label" => "Color",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "categoryMarginT" => [
            "name" => "categoryMarginT",
            "type" => "select",
            "props" => [
              "label" => "Margen superior",
              "options" => $vAttributes["marginT"]
            ]
          ],
          "categoryMarginB" => [
            "name" => "categoryMarginB",
            "type" => "select",
            "props" => [
              "label" => "Margen inferior",
              "options" => $vAttributes["marginB"]
            ]
          ],
          "categoryLetterSpacing" => [
            "name" => "categoryLetterSpacing",
            "type" => "input",
            "props" => [
              "label" => "Espacio entre letras",
              "type" => "number"
            ]
          ],
          "categoryTextDecoration" => [
            "name" => "categoryTextDecoration",
            "value" => "none",
            "type" => "select",
            "props" => [
              "label" => "Decoración",
              "options" => $vAttributes["textDecoration"]
            ]
          ],
          "categoryTextWeight" => [
            "name" => "categoryTextWeight",
            "type" => "select",
            "props" => [
              "label" => "Negrita",
              "options" => $vAttributes["textWeight"]
            ]
          ],
          "categoryShadow" => [
            "name" => "categoryShadow",
            "type" => "input",
            "value" => "",
            "props" => [
                "label" => "Sombra de texto",
            ]
          ],
          "categoryClasses" => [
            "name" => "categoryClasses",
            "type" => "input",
            "value" => "",
            "columns" => "col-12",
            "props" => [
                "label" => "Clases generales",
            ]
          ],
        ],
      ],
      "date" => [
        "title" => "Fecha",
        "fields" => [
          "withCreatedDate" => [
            "name" => "withCreatedDate",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar",
              "options" => $vAttributes["validation"]
            ]
          ],
          "createdDateTextSize" => [
            "name" => "createdDateTextSize",
            "value" => "14",
            "type" => "input",
            "props" => [
              "label" => "Tamaño",
              "type" => "number"
            ]
          ],
          "createdDateAlign" => [
            "name" => "createdDateAlign",
            "type" => "select",
            "props" => [
              "label" => "Alineación",
              "options" => $vAttributes["align"]
            ]
          ],
          "createdDateColor" => [
            "name" => "createdDateColor",
            "type" => "select",
            "props" => [
              "label" => "Color",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "createdDateMarginT" => [
            "name" => "createdDateMarginT",
            "type" => "select",
            "props" => [
              "label" => "Margen superior",
              "options" => $vAttributes["marginT"]
            ]
          ],
          "createdDateMarginB" => [
            "name" => "createdDateMarginB",
            "type" => "select",
            "props" => [
              "label" => "Margen inferior",
              "options" => $vAttributes["marginB"]
            ]
          ],
          "createdDateLetterSpacing" => [
            "name" => "createdDateLetterSpacing",
            "type" => "input",
            "props" => [
              "label" => "Espacio entre letras",
              "type" => "number"
            ]
          ],
          "formatCreatedDate" => [
            "name" => "formatCreatedDate",
            "type" => "select",
            "props" => [
              "label" => "Formato",
              "options" => $vAttributes["formatCreatedDate"]
            ]
          ],
          "createdDateTextWeight" => [
            "name" => "createdDateTextWeight",
            "type" => "select",
            "columns" => "col-12",
            "props" => [
              "label" => "Negrita",
              "options" => $vAttributes["textWeight"]
            ]
          ],
          "createdDateTextDecoration" => [
            "name" => "createdDateTextDecoration",
            "value" => "none",
            "type" => "select",
            "props" => [
              "label" => "Decoración",
              "options" => $vAttributes["textDecoration"]
            ]
          ],
          "createdDateShadow" => [
            "name" => "createdDateShadow",
            "type" => "input",
            "value" => "",
            "props" => [
                "label" => "Sombra de texto",
            ]
          ],
          "createdDateClasses" => [
            "name" => "createdDateClasses",
            "type" => "input",
            "value" => "",
            "columns" => "col-12",
            "props" => [
                "label" => "Clases generales",
            ]
          ],
        ],
      ],
      "boton" => [
        "title" => "Botón",
        "fields" => [
          "withViewMoreButton" => [
            "name" => "withViewMoreButton",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar",
              "options" => $vAttributes["validation"]
            ]
          ],
          "buttonLayout" => [
            "name" => "buttonLayout",
            "value" => "",
            "type" => "select",
            "props" => [
              "label" => "Estilo de Botones",
              "options" => $vAttributes["buttonStyle"]
            ]
          ],
          "buttonSize" => [
            "name" => "buttonSize",
            "value" => "button-normal",
            "type" => "select",
            "props" => [
              "label" => "Espaciado",
              "options" => $vAttributes["buttonType"]
            ]
          ],
          "buttonAlign" => [
            "name" => "buttonAlign",
            "value" => "text-center",
            "type" => "select",
            "props" => [
              "label" => "Alineación",
              "options" => $vAttributes["align"]
            ]
          ],
          "buttonColor" => [
            "name" => "buttonColor",
            "value" => "primary",
            "type" => "select",
            "props" => [
              "label" => "Color",
              "options" => $vAttributes["bgColor"]
            ]
          ],
          "buttonMarginT" => [
            "name" => "buttonMarginT",
            "value" => "mt-0",
            "type" => "select",
            "props" => [
              "label" => "Margen superior",
              "options" => $vAttributes["marginT"]
            ]
          ],
          "buttonMarginB" => [
            "name" => "buttonMarginB",
            "value" => "mb-3",
            "type" => "select",
            "props" => [
              "label" => "Margen Inferior",
              "options" => $vAttributes["marginB"]
            ]
          ],
          "buttonTextSize" => [
            "name" => "buttonTextSize",
            "type" => "input",
            "props" => [
              "label" => "Tamaño del texto",
              "type" => "number"
            ]
          ],
          "buttonIcon" => [
            "name" => "buttonIcon",
            "type" => "input",
            "props" => [
              "label" => "Tipo de Icono"
            ]
          ],
          "buttonIconLR" => [
            "name" => "buttonIconLR",
            "value" => "left",
            "type" => "select",
            "props" => [
              "label" => "Posición del icono",
              "options" => [
                ["label" => "Izquierda", "value" => "left"],
                ["label" => "Derecha", "value" => "right"]
              ]
            ]
          ],
          "viewMoreButtonLabel" => [
            "name" => "viewMoreButtonLabel",
            "type" => "input",
            "props" => [
              "label" => "Texto del botón",
            ]
          ],
          "buttonShadow" => [
            "name" => "buttonShadow",
            "type" => "input",
            "value" => "",
            "props" => [
                "label" => "Sombra de texto",
            ]
          ],
          "buttonItemClasses" => [
            "name" => "buttonItemClasses",
            "type" => "input",
            "value" => "",
            "columns" => "col-12",
            "props" => [
                "label" => "Clases generales",
            ]
          ],
          "buttonConfig" => [
            "name" => "buttonConfig",
            "value" => ['color' => 'var(--primary)',
                'background' => 'var(--white)',
                'border' => '0',
                'boxShadow' => 'none',
                'transition' => '.4s',
                'borderRadius' => '10px',
                'colorHover' => 'var(--dark)',
                'backgroundHover' => 'var(--secondary)',
                'borderHover' => '0',
                'boxShadowHover' => 'none'],
            "type" => "json",
            "columns" => "col-12",
            "props" => [
                "label" => "Configuración de Botón Custom",
            ]
          ],
        ]
      ],
      "imagen" => [
        "title" => "Imagen",
        "fields" => [
          "Imagen" => [
            "name" => "withImage",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar",
              "options" => $vAttributes["validation"]
            ]
          ],
          "mediaImage" => [
            "name" => "mediaImage",
            "type" => "input",
            "value" => "mainimage",
            "props" => [
              "label" => "Zona"
            ]
          ],
          "imagePosition" => [
            "name" => "imagePosition",
            "value" => "1",  
            "type" => "select",
            "props" => [
              "label" => "Posición",
              "options" => $vAttributes["imagePosition"]
            ]
          ],
          "imagePositionVertical" => [
            "name" => "imagePositionVertical",
            "type" => "select",
            "props" => [
              "label" => "Alineación Vertical",
              "options" => $vAttributes["positionVertical"]
            ]
          ],
          "columnLeft" => [
            "name" => "columnLeft",
            "type" => "input",
            "props" => [
              "label" => "Tamaño Columna Izquierda"
            ]
          ],
          "columnRight" => [
            "name" => "columnRight",
            "type" => "input",
            "props" => [
              "label" => "Tamaño Columna Derecha"
            ]
          ],
          "imageWidth" => [
            "name" => "imageWidth",
            "value" => "100",
            "type" => "input",
            "props" => [
              "label" => "Tamaño imagen (%)",
              "type" => "number",
              "min" => "0",
              "max" => "100",
            ]
          ],
          "imageHeight" => [
            "name" => "imageHeight",
            "value" => "auto",
            "type" => "input",
            "props" => [
                "label" => "Alto imagen (Formato Libre)",
            ]
          ],
          "imageAlign" => [
            "name" => "imageAlign",
            "type" => "select",
            "props" => [
              "label" => "Alineación horizontal",
              "options" => $vAttributes["imageAlign"]
            ]
          ],
          "imagePadding" => [
            "name" => "imagePadding",
            "type" => "input",
            "props" => [
              "label" => "Espaciado antes del borde",
              "type" => "number"
            ]
          ],
          "imagePicturePadding" => [
            "name" => "imagePicturePadding",
            "type" => "input",
            "props" => [
              "label" => "Espaciado luego del borde",
              "type" => "number"
            ]
          ],
          "imageAspect" => [
            "name" => "imageAspect",
            "value" => "1/1",
            "type" => "select",
            "props" => [
              "label" => "Aspect Ratio",
              "options" => $vAttributes["imageAspect"]
            ]
          ],
          "imageAspectMobile" => [
            "name" => "imageAspectMobile",
            "value" => "1/1",
            "type" => "select",
            "props" => [
              "label" => "Aspect Ratio Mobile",
              "options" => $vAttributes["imageAspect"]
            ]
          ],
          "imageObject" => [
            "name" => "imageObject",
            "value" => "cover",
            "type" => "select",
            "props" => [
              "label" => "Object fit",
              "options" => $vAttributes["imageObject"]
            ]
          ],
          "imageBorderRadio" => [
            "name" => "imageBorderRadio",
            "value" => "0",
            "type" => "input",
            "props" => [
              "label" => "Redondeado del borde",
              "type" => "number"
            ]
          ],
          "imageBorderRadioType" => [
            "name" => "imageBorderRadioType",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Posición del redondeado del borde",
              "options" => $vAttributes["contentBorderRoundedType"]
            ]
          ],
          "imageBorderWidth" => [
            "name" => "imageBorderWidth",
            "value" => "0",
            "type" => "select",
            "props" => [
              "label" => "Ancho del Borde",
              "options" => $vAttributes["optionOneToFive"]
            ]
          ],
          "imageBorderStyle" => [
            "name" => "imageBorderStyle",
            "value" => "solid",
            "type" => "select",
            "props" => [
              "label" => "Estilo del Borde",
              "options" => $vAttributes["imageBorderStyle"]
            ]
          ],
          "imageBorderColor" => [
            "name" => "imageBorderColor",
            "type" => "inputColor",
            "props" => [
              "label" => "Color del Borde"
            ]
          ],
          "withImageOpacity" => [
            "name" => "withImageOpacity",
            "value" => "0",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Opacidad",
              "options" => $vAttributes["validation"]
            ]
          ],
          "imageOpacityColor" => [
            "name" => "imageOpacityColor",
            "type" => "select",
            "props" => [
              "label" => "Color de Opacidad",
              "options" => $vAttributes["opacityColor"]
            ]
          ],
          "imageOpacityDirection" => [
            "name" => "imageOpacityDirection",
            "type" => "select",
            "props" => [
              "label" => "Dirección de Opacidad",
              "options" => $vAttributes["opacityDirection"]
            ]
          ],
          "imageOpacityCustom" => [
            "name" => "imageOpacityCustom",
            "type" => "input",
            "props" => [
              "label" => "Opacidad Custom"
            ]
          ],
          "imageOpacityHover" => [
            "name" => "imageOpacityHover",
            "value" => "0",
            "type" => "select",
            "props" => [
              "label" => "Opacidad en Hover",
              "options" => $vAttributes["validation"]
            ]
          ],
          "imageShadow" => [
            "name" => "imageShadow",
            "type" => "input",
            "value" => "",
            "props" => [
                "label" => "Sombra",
            ]
          ],
        ]
      ],
      "video" => [
        "title" => "Video",
        "fields" => [
            "videoLoop" => [
                "name" => "videoLoop",
                "value" => "0",
                "type" => "select",
                "props" => [
                    "label" => "Loop",
                    "options" => $vAttributes["validation"]
                ]
            ],
            "videoAutoplay" => [
                "name" => "videoAutoplay",
                "value" => "0",
                "type" => "select",
                "props" => [
                    "label" => "Autoplay",
                    "options" => $vAttributes["validation"]
                ]
            ],
            "videoMuted" => [
                "name" => "videoMuted",
                "value" => "0",
                "type" => "select",
                "props" => [
                    "label" => "Muted",
                    "options" => $vAttributes["validation"]
                ]
            ],
            "videoControls" => [
                "name" => "videoControls",
                "value" => "0",
                "type" => "select",
                "props" => [
                    "label" => "Controls",
                    "options" => $vAttributes["validation"]
                ]
            ],
        ]
      ],
    ]
  ],
  "carousel" => [
    "title" => "Carousel",
    "systemName" => "isite::carousel.owl-carousel",
    "nameSpace" => "Modules\Isite\View\Components\Carousel\OwlCarousel",
    "content" => [
      [
        "label" => "Iblog::Post",
        "value" => "Modules\Iblog\Repositories\PostRepository"
      ],
      [
        "label" => "Iblog::Category",
        "value" => "Modules\Iblog\Repositories\CategoryRepository"
      ],
      [
        "label" => "Icommerce::Category",
        "value" => "Modules\Icommerce\Repositories\CategoryRepository"
      ],
      [
        "label" => "Icommerce::Productos",
        "value" => "Modules\Icommerce\Repositories\ProductRepository"
      ],
      [
        "label" => "Slider::Slider",
        "value" => "Modules\Slider\Repositories\SlideRepository"
      ]
    ],
    "childBlocks" => [
      "itemComponentAttributes" => "isite::item-list",
      "productItemComponentAttributes" => "icommerce::components.product-list-item"
    ],
    "contentFields" => [
        "title" => [
            "name" => "title",
            "type" => "input",
            "columns" => "col-12",
            "isTranslatable" => true,
            "props" => [
                "label" => "Titulo",
            ]
        ],
        "subTitle" => [
            "name" => "subTitle",
            "type" => "html",
            "columns" => "col-12",
            "isTranslatable" => true,
            "props" => [
                "label" => "Subtitulo",
            ]
        ],
    ],
    "attributes" => [
      "general" => [
        "title" => "General",
        "fields" => [
          "loop" => [
            "name" => "loop",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Loop",
              "options" => $vAttributes["validation"]
            ]
          ],
          "autoplay" => [
            "name" => "autoplay",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Repetición automática",
              "options" => $vAttributes["validation"]
            ]
          ],
          "center" => [
            "name" => "center",
            "value" => "0",
            "type" => "select",
            "props" => [
              "label" => "Center",
              "options" => $vAttributes["validation"]
            ]
          ],
          "autoplayHoverPause" => [
            "name" => "autoplayHoverPause",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Pausa en repetición automática",
              "options" => $vAttributes["validation"]
            ]
          ],
          "containerFluid" => [
            "name" => "containerFluid",
            "value" => "0",
            "type" => "select",
            "props" => [
              "label" => "Container fluid",
              "options" => $vAttributes["validation"]
            ]
          ],
          "margin" => [
            "name" => "margin",
            "value" => "10",
            "type" => "input",
            "props" => [
              "label" => "Margen",
              "type" => "number"
            ]
          ],
          "stagePadding" => [
            "name" => "stagePadding",
            "value" => "0",
            "type" => "input",
            "props" => [
              "label" => "Espaciado",
              "type" => "number"
            ]
          ],
          "autoplayTimeout" => [
            "name" => "autoplayTimeout",
            "value" => "5000",
            "type" => "input",
            "props" => [
              "label" => "Tiempo de espera del intervalo",
              "type" => "number"
            ]
          ],
          "itemsBySlide" => [
            "name" => "itemsBySlide",
            "value" => "1",
            "type" => "input",
            "props" => [
              "label" => "Elemendo por transición",
              "type" => "number"
            ]
          ],
          "responsiveClass" => [
            "name" => "responsiveClass",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Clase responsive",
              "options" => $vAttributes["validation"]
            ]
          ],
          "responsive" => [
            "name" => "responsive",
            "value" => [0 => ["items" => 1], 640 => ["items" => 2], 992 => ["items" => 4]],
            "type" => "json",
            'columns' => 'col-12',
            "props" => [
              "label" => "Responsive"
            ]
          ],
          "mouseDrag" => [
            "name" => "mouseDrag",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Arrastre de ratón",
              "options" => $vAttributes["validation"]
            ]
          ],
          "touchDrag" => [
            "name" => "touchDrag",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Arrastre por toque",
              "options" => $vAttributes["validation"]
            ]
          ],
        ]
      ],
      "navydots" => [
        "title" => "Navegación (nav y dots)",
        "fields" => [
          "nav" => [
            "name" => "nav",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar (nav)",
              "options" => $vAttributes["validation"]
            ]
          ],
          "navPosition" => [
            "name" => "navPosition",
            "value" => "bottom",
            "type" => "select",
            "props" => [
              "label" => "Posición (nav)",
              "options" => $vAttributes["navPositionCarousel"]
            ]
          ],
          "navStyleButton" => [
            "name" => "navStyleButton",
            "type" => "select",
            "props" => [
              "label" => "Estilo de Borde (nav)",
              "options" => $vAttributes["buttonStyle"]
            ]
          ],
          "navSizeButton" => [
            "name" => "navSizeButton",
            "type" => "select",
            "props" => [
              "label" => "Espaciado (nav)",
              "options" => $vAttributes["buttonType"]
            ]
          ],
          "navColor" => [
            "name" => "navColor",
            "value" => "primary",
            "type" => "select",
            "props" => [
              "label" => "Color (nav)",
              "options" => $vAttributes["bgColor"]
            ]
          ],
          "navIcon" => [
            "name" => "navIcon",
            "value" => "arrow",
            "type" => "select",
            "props" => [
              "label" => "Icono de Flecha (nav)",
              "options" => $vAttributes["iconArrow"]
            ]
          ],
          "navSizeLabel" => [
            "name" => "navSizeLabel",
            "value" => "20",
            "type" => "input",
            "props" => [
              "label" => "Tamaño del texto (nav)",
              "type" => "number"
            ]
          ],
          "dots" => [
            "name" => "dots",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar (dots)",
              "options" => $vAttributes["validation"]
            ]
          ],
          "dotsStyle" => [
            "name" => "dotsStyle",
            "value" => "dots-linear",
            "type" => "select",
            "props" => [
              "label" => "Estilos (dots)",
              "options" => $vAttributes["dotStyle"]
            ]
          ]
        ]
      ],
      "texto" => [
        "title" => "Texto (Titulo y Subtitulo)",
        "fields" => [
          "owlTextPosition" => [
            "name" => "owlTextPosition",
            "value" => "2",
            "type" => "select",
            "columns" => "col-12",
            "props" => [
              "label" => "Posición",
              "options" => [
                ["label" => "Solo título", "value" => "1"],
                ["label" => "Título con descripción abajo", "value" => "2"],
                ["label" => "Título abajo con descripción arriba", "value" => "3"]
              ]
            ]
          ],
          "owlTextAlign" => [
            "name" => "owlTextAlign",
            "value" => "text-left",
            "type" => "select",
            "props" => [
                "label" => "Alineación",
                "options" => $vAttributes["align"]
            ]
          ],
          "owlTitleSize" => [
            "name" => "owlTitleSize",
            "type" => "input",
            "props" => [
              "label" => "Tamaño Fuente (Titulo)",
              "type" => "number"
            ]
          ],
          "owlTitleTransform" => [
            "name" => "owlTitleTransform",
            "type" => "select",
            "props" => [
              "label" => "Transformar (Titulo)",
              "options" => $vAttributes["textTransform"]
            ]
          ],
          "owlTitleColor" => [
            "name" => "owlTitleColor",
            "type" => "select",
            "props" => [
              "label" => "Color (Titulo)",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "owlTitleMarginT" => [
            "name" => "owlTitleMarginT",
            "value" => "mt-0",
            "type" => "select",
            "props" => [
              "label" => "Margen superior (Titulo)",
              "options" => $vAttributes["marginT"]
            ]
          ],
          "owlTitleMarginB" => [
            "name" => "owlTitleMarginB",
            "value" => "mb-0",
            "type" => "select",
            "props" => [
              "label" => "Margen inferior (Titulo)",
              "options" => $vAttributes["marginB"]
            ]
          ],
          "owlTitleWeight" => [
            "name" => "owlTitleWeight",
            "value" => "font-weight-normal",
            "type" => "select",
            "props" => [
              "label" => "Negrita (Titulo)",
              "options" => $vAttributes["textWeight"]
            ]
          ],
          "owlTitleLetterSpacing" => [
            "name" => "owlTitleLetterSpacing",
            "type" => "input",
            "props" => [
              "label" => "Espacio entre letras (Titulo)",
              "type" => "number"
            ]
          ],
          "owlTitleVineta" => [
            "name" => "owlTitleVineta",
            "type" => "input",
            "props" => [
              "label" => "Icon (Titulo)"
            ]
          ],
          "owlTitleUrl" => [
            "name" => "owlTitleUrl",
            "type" => "input",
            "props" => [
              "label" => "Url (Titulo)"
            ]
          ],
          "owlTitleTarget" => [
            "name" => "owlTitleTarget",
            "value" => "_self",
            "type" => "select",
            "props" => [
              "label" => "Target (Titulo)",
              "options" => $vAttributes["target"]
            ]
          ],
          "owlTitleVinetaColor" => [
            "name" => "owlTitleVinetaColor",
            "type" => "select",
            "props" => [
              "label" => "Color icon (Titulo)",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "owlTitleClasses" => [
            "name" => "owlTitleClasses",
            "value" => "",
            "type" => "input",
            "columns" => "col-12",
            "props" => [
                "label" => "Clases (Titulo)",
            ]
          ],
          "owlSubtitleSize" => [
            "name" => "owlSubtitleSize",
            "type" => "input",
            "props" => [
              "label" => "Tamaño Fuente (Subtitulo)",
              "type" => "number"
            ]
          ],
          "owlSubtitleColor" => [
            "name" => "owlSubtitleColor",
            "type" => "select",
            "props" => [
              "label" => "Color (Subtitulo)",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "owlSubtitleMarginT" => [
            "name" => "owlSubtitleMarginT",
            "value" => "mt-0",
            "type" => "select",
            "props" => [
              "label" => "Margen superior (Subtitulo)",
              "options" => $vAttributes["marginT"]
            ]
          ],
          "owlSubtitleMarginB" => [
            "name" => "owlSubtitleMarginB",
            "value" => "mb-0",
            "type" => "select",
            "props" => [
              "label" => "Margen inferior (Subtitulo)",
              "options" => $vAttributes["marginB"]
            ]
          ],
          "owlSubtitleTransform" => [
            "name" => "owlSubtitleTransform",
            "type" => "select",
            "props" => [
              "label" => "Transformar (Subtitulo)",
              "options" => $vAttributes["textTransform"]
            ]
          ],
          "owlSubtitleWeight" => [
            "name" => "owlSubtitleWeight",
            "type" => "select",
            "props" => [
              "label" => "Negrita (Subtitulo)",
              "options" => $vAttributes["textWeight"]
            ]
          ],
          "owlSubtitleLetterSpacing" => [
            "name" => "owlSubtitleLetterSpacing",
            "type" => "input",
            "props" => [
              "label" => "Espacio entre letras (Subtitulo)",
              "type" => "number"
            ]
          ],
          "owlSubtitleClasses" => [
            "name" => "owlSubtitleClasses",
            "value" => "",
            "type" => "input",
            "columns" => "col-12",
            "props" => [
                "label" => "Clases (Subtitulo)",
            ]
          ],
          "owlWithLineTitle" => [
            "name" => "owlWithLineTitle",
            "value" => "0",
            "type" => "select",
            "columns" => "col-12",
            "props" => [
                "label" => "Linea",
                "options" => $vAttributes["titleLine"]
            ]
          ],
          "owlLineTitleConfig" => [
            "name" => "owlLineTitleConfig",
            "value" => ['background' => 'var(--primary)','height' => '2px','width' => '10%','margin' => '0 auto'],
            "type" => "json",
            "columns" => "col-12",
            "props" => [
                "label" => "Configuración de Línea",
            ]
          ],
        ]
      ]
    ]
  ],
  "itemsList" => [
    "title" => "Lista de Elementos",
    "systemName" => "isite::items-list",
    "nameSpace" => "livewire",
    "content" => [
      [
        "label" => "Post",
        "value" => "Modules\Iblog\Entities\Post"
      ],
      [
        "label" => "Category",
        "value" => "Modules\Iblog\Entities\Category"
      ]
    ],
    "contentFields" => [
        "title" => [
            "name" => "title",
            "type" => "input",
            "columns" => "col-12",
            "isTranslatable" => true,
            "props" => [
                "label" => "titulo"
            ]
        ],
    ],
    "attributes" => [
      "general" => [
        "title" => "General",
        "fields" => [
          "itemListLayout" => [
            "name" => "itemListLayout",
            "type" => "input",
            "props" => [
              "label" => "layout del item list"
            ]
          ],
          "viewMoreButtonLabel" => [
            "name" => "viewMoreButtonLabel",
            "value" => "isite::common.menu.viewMore",
            "type" => "input",
            "props" => [
                "label" => "ver boton del label"
            ]
          ],
          "params" => [
            "name" => "params",
            "value" => [],
            "type" => "json",
            "props" => [
              "label" => "parametros del itemsList"
            ]
          ],
          "responsiveTopContent" => [
            "name" => "responsiveTopContent",
            "value" => ["mobile" => true, "desktop" => true, "order" => true],
            "type" => "json",
            "props" => [
              "label" => "contenido responsivo"
            ]
          ],
          "withUser" => [
            "name" => "withUser",
            "value" => false,
            "type" => "select",
            "props" => [
              "label" => "con usuario",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "showTitle" => [
            "name" => "showTitle",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "mostrar titulo",
                "options" => $vAttributes["validation"]
            ]
          ],
          "configOrderBy" => [
            "name" => "configOrderBy",
            "type" => "input",
            "props" => [
              "label" => "orden de configuración por"
            ]
          ],
          "configLayoutIndex" => [
            "name" => "configLayoutIndex",
            "type" => "input",
            "props" => [
              "label" => "configuración del layout"
            ]
          ],
          "pagination" => [
            "name" => "pagination",
            "value" => ["show" => true, "type" => "normal"],
            "type" => "json",
            "props" => [
                "label" => "paginación"
            ]
          ],
          "itemModal" => [
            "name" => "itemModal",
            "value" => ["mobile" => false, "desktop" => false, "idModal" => 'modal_1'],
            "type" => "json",
            "props" => [
              "label" => "item modal"
            ]
          ],
          "carouselAttributes" => [
            "name" => "carouselAttributes",
            "type" => "json",
            "props" => [
              "label" => "atributos del carrusel"
            ]
          ],
          "uniqueItemListRendered" => [
            "name" => "uniqueItemListRendered",
            "value" => false,
            "type" => "select",
            "props" => [
              "label" => "renderizar un unico item list",
              "options" => $vAttributes["booleanValidation"]
            ]
          ],
          "description" => [
            "name" => "description",
            "value" => null,
            "type" => "input",
            "props" => [
              "label" => "descripción"
            ]
          ],
          "disableFilters" => [
            "name" => "disableFilters",
            "value" => false,
            "type" => "select",
            "props" => [
              "label" => "desabilitar filtros",
              "options" => $vAttributes["booleanValidation"]
            ]
          ]
        ]
      ]
    ]
  ],
  "infoContact" => [
    "title" => "Información De Contacto",
    "systemName" => "isite::InfoContact",
    "nameSpace" => "Modules\Isite\View\Components\InfoContact",
    "contentFields" => [
      "title" => [
        "name" => "title",
        "type" => "input",
        "isTranslatable" => true,
        "props" => [
          "label" => "Titulo"
        ]
      ],
      "subtitle" => [
        "name" => "subtitle",
        "type" => "input",
        "isTranslatable" => true,
        "props" => [
          "label" => "Subtitle"
        ]
      ],
    ],
    "attributes" => [
      "general" => [
        "title" => "General",
        "fields" => [
          "layout" => [
            "name" => "layout",
            "value" => "info-contact-layout-1",
            "type" => "select",
            "props" => [
              "label" => "Plantilla Para Información De Contacto",
              "options" => [
                ["label" => "Información De Contacto Plantilla 1", "value" => "info-contact-layout-1"],
              ]
            ]
          ],
          "withTitle" => [
            "name" => "withTitle",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Titulo",
              "options" => $vAttributes["validation"]
            ]
          ],
          "alignTitle" => [
            "name" => "alignTitle",
            "value" => "text-left",
            "type" => "select",
            "props" => [
              "label" => "Alineación del titulo",
              "options" => [
                ["label" => "Alineación a la Izquierda", "value" => "text-left"],
                ["label" => "Alineación a la Derecha", "value" => "text-right"],
                ["label" => "Alineación Centrado", "value" => "text-center"],
              ]
            ]
          ],
          "withSubtitle" => [
            "name" => "withSubtitle",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Subtitulo",
              "options" => $vAttributes["validation"]
            ]
          ],
          "alignSubtitle" => [
            "name" => "alignSubtitle",
            "value" => "text-left",
            "type" => "select",
            "props" => [
              "label" => "Alineación del subtitulo",
              "options" => [
                ["label" => "Alineación a la Izquierda", "value" => "text-left"],
                ["label" => "Alineación a la Derecha", "value" => "text-right"],
                ["label" => "Alineación Centrado", "value" => "text-center"],
              ]
            ]
          ],
          "alignIcons" => [
            "name" => "alignIcons",
            "value" => "justify-content-left",
            "type" => "select",
            "props" => [
              "label" => "Alineación Iconos Personalizados",
              "options" => [
                ["label" => "Alineación a la Izquierda", "value" => "justify-content-left"],
                ["label" => "Alineación a la Derecha", "value" => "justify-content-right"],
                ["label" => "Alineación Centrado", "value" => "justify-content-center"],
              ]
            ]
          ],
          "alignInfoContact" => [
            "name" => "alignInfoContact",
            "value" => "justify-content-left",
            "type" => "select",
            "props" => [
              "label" => "Alineación Información",
              "options" => [
                ["label" => "Alineación a la Izquierda", "value" => "justify-content-left"],
                ["label" => "Alineación a la Derecha", "value" => "justify-content-right"],
                ["label" => "Alineación Centrado", "value" => "justify-content-center"],
              ]
            ]
          ],
          "alignTitleInfoContact" => [
            "name" => "alignTitleInfoContact",
            "value" => "justify-content-left",
            "type" => "select",
            "props" => [
              "label" => "Alineación Titulo Información",
              "options" => [
                ["label" => "Alineación a la Izquierda", "value" => "justify-content-left"],
                ["label" => "Alineación a la Derecha", "value" => "justify-content-right"],
                ["label" => "Alineación Centrado", "value" => "justify-content-center"],
              ]
            ]
          ],
          "orderInfo" => [
            "name" => "orderInfo",
            "value" => ["phone" => "order-0", "address" => "order-1", "email" => "order-2", "socialNetworks" => "order-3"],
            "type" => "json",
            "columns" => "col-12",
            "props" => [
              "label" => "Orden de los elementos"
            ]
          ],
          "container" => [
            "name" => "container",
            "value" => "container",
            "type" => "select",
            "props" => [
              "label" => "Tipo de contenedor",
              "options" => $vAttributes["containers"]
            ]
          ],
          "contentPaddingY" => [
            "name" => "contentPaddingY",
            "value" => "",
            "type" => "select",
            "props" => [
              "label" => "Padding en Eje Y Bloque Información",
              "options" => [
                ["label" => "Sin Padding", "value" => ""],
                ["label" => "Padding de 1 Pixel", "value" => "py-1"],
                ["label" => "Padding de 2 Pixel", "value" => "py-2"],
                ["label" => "Padding de 3 Pixel", "value" => "py-3"],
                ["label" => "Padding de 4 Pixel", "value" => "py-4"],
                ["label" => "Padding de 5 Pixel", "value" => "py-5"],
              ]
            ]
          ],
          "contentPaddingX" => [
            "name" => "contentPaddingX",
            "value" => "",
            "type" => "select",
            "props" => [
              "label" => "Padding en Eje X Bloque Información",
              "options" => [
                ["label" => "Sin Padding", "value" => ""],
                ["label" => "Padding de 1 Pixel", "value" => "px-1"],
                ["label" => "Padding de 2 Pixel", "value" => "px-2"],
                ["label" => "Padding de 3 Pixel", "value" => "px-3"],
                ["label" => "Padding de 4 Pixel", "value" => "px-4"],
                ["label" => "Padding de 5 Pixel", "value" => "px-5"],
              ]
            ]
          ],
          "contentMarginY" => [
            "name" => "contentMarginY",
            "value" => "",
            "type" => "select",
            "props" => [
              "label" => "Margin en Eje Y Bloque Información",
              "options" => [
                ["label" => "Sin Margin", "value" => ""],
                ["label" => "Margin de 1 Pixel", "value" => "my-1"],
                ["label" => "Margin de 2 Pixel", "value" => "my-2"],
                ["label" => "Margin de 3 Pixel", "value" => "my-3"],
                ["label" => "Margin de 4 Pixel", "value" => "my-4"],
                ["label" => "Margin de 5 Pixel", "value" => "my-5"],
              ]
            ]
          ],
          "contentMarginX" => [
            "name" => "contentMarginX",
            "value" => "",
            "type" => "select",
            "props" => [
              "label" => "Margin en Eje X Bloque Información",
              "options" => [
                ["label" => "Sin Margin", "value" => ""],
                ["label" => "Margin de 1 Pixel", "value" => "mx-1"],
                ["label" => "Margin de 2 Pixel", "value" => "mx-2"],
                ["label" => "Margin de 3 Pixel", "value" => "mx-3"],
                ["label" => "Margin de 4 Pixel", "value" => "mx-4"],
                ["label" => "Margin de 5 Pixel", "value" => "mx-5"],
              ]
            ]
          ],
          "contentBorderType" => [
            "name" => "contentBorderType",
            "value" => "",
            "type" => "select",
            "props" => [
              "label" => "Tipo de Borde Bloque Información",
              "options" => [
                ["label" => "Sin Borde", "value" => ""],
                ["label" => "Borde Completo", "value" => "border"],
                ["label" => "Borde Arriba", "value" => "border-top"],
                ["label" => "Borde Derecha", "value" => "border-right"],
                ["label" => "Borde Abajo", "value" => "border-bottom"],
                ["label" => "Borde Izquierda", "value" => "border-left"],
              ]
            ]
          ],
          "contentBorder" => [
            "name" => "contentBorder",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Grosor del Borde Bloque Información",
              "options" => [
                ["label" => "0", "value" => "0"],
                ["label" => "1px", "value" => "1"],
                ["label" => "2px", "value" => "2"],
                ["label" => "3px", "value" => "3"],
                ["label" => "4px", "value" => "4"],
                ["label" => "5px", "value" => "5"]
              ]
            ]
          ],
          "contentBorderColor" => [
            "name" => "contentBorderColor",
            "type" => "inputColor",
            "props" => [
              "label" => "Color Del Borde Bloque Información"
            ]
          ],
          "fontSizeTitleSection" => [
            "name" => "fontSizeTitleSection",
            "type" => "input",
            "props" => [
              "label" => "Tamaño de fuente Titulo Principal",
              "type" => "number"
            ]
          ],
          "colorTitleSection" => [
            "name" => "colorTitleSection",
            "type" => "inputColor",
            "props" => [
              "label" => "Color Titulo Principal"
            ]
          ],
          "fontSizeSubtitleSection" => [
            "name" => "fontSizeSubtitleSection",
            "type" => "input",
            "props" => [
              "label" => "Tamaño de fuente Subtitulo",
              "type" => "number"
            ]
          ],
          "colorSubtitleSection" => [
            "name" => "colorSubtitleSection",
            "type" => "inputColor",
            "props" => [
              "label" => "Color Subtitulo"
            ]
          ],
          "fontSizeTitleContact" => [
            "name" => "fontSizeTitleContact",
            "type" => "input",
            "props" => [
              "label" => "Tamaño de fuente Titulo Información",
              "type" => "number"
            ]
          ],
          "colorTitleContact" => [
            "name" => "colorTitleContact",
            "type" => "inputColor",
            "props" => [
              "label" => "Color Titulo Información"
            ]
          ],
          "fontSizeIcons" => [
            "name" => "fontSizeIcons",
            "type" => "input",
            "props" => [
              "label" => "Tamaño de fuente Iconos",
              "type" => "number"
            ]
          ],
          "colorIcons" => [
            "name" => "colorTitleContact",
            "type" => "inputColor",
            "props" => [
              "label" => "Color Iconos"
            ]
          ],
        ]
      ],
      "phone" => [
        "title" => "Sección Teléfono",
        "fields" => [
          "withPhone" => [
            "name" => "withPhone",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Teléfono",
              "options" => $vAttributes["validation"]
            ]
          ],
          "withTitlePhone" => [
            "name" => "withTitlePhone",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Titulo Teléfono",
              "options" => $vAttributes["validation"]
            ]
          ],
          "titlePhone" => [
            "name" => "titlePhone",
            "type" => "input",
            "props" => [
              "label" => "Titulo Teléfono"
            ]
          ],
          "withIconCustomPhone" => [
            "name" => "withIconCustomPhone",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Icono Personalizado",
              "options" => $vAttributes["validation"]
            ]
          ],
          "iconCustomPhone" => [
            "name" => "iconCustomPhone",
            "type" => "input",
            "props" => [
              "label" => "Icono Personalizado Teléfono"
            ]
          ],
          "withIconComponentPhone" => [
            "name" => "withIconComponentPhone",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Icono Componente",
              "options" => $vAttributes["validation"]
            ]
          ],
        ]
      ],
      "address" => [
        "title" => "Sección Dirección",
        "fields" => [
          "withAddress" => [
            "name" => "withAddress",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Dirección",
              "options" => $vAttributes["validation"]
            ]
          ],
          "withTitleAddress" => [
            "name" => "withTitleAddress",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Titulo Dirección",
              "options" => $vAttributes["validation"]
            ]
          ],
          "titleAddress" => [
            "name" => "titleAddress",
            "type" => "input",
            "props" => [
              "label" => "Titulo Dirección"
            ]
          ],
          "withIconCustomAddress" => [
            "name" => "withIconCustomAddress",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Icono Personalizado",
              "options" => $vAttributes["validation"]
            ]
          ],
          "iconCustomAddress" => [
            "name" => "iconCustomAddress",
            "type" => "input",
            "props" => [
              "label" => "Icono Personalizado Dirección"
            ]
          ],
          "withIconComponentAddress" => [
            "name" => "withIconComponentAddress",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Icono Componente",
              "options" => $vAttributes["validation"]
            ]
          ],
        ]
      ],
      "email" => [
        "title" => "Sección Correo Electrónico",
        "fields" => [
          "withEmail" => [
            "name" => "withEmail",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Correo Electrónico",
              "options" => $vAttributes["validation"]
            ]
          ],
          "withTitleEmail" => [
            "name" => "withTitleEmail",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Titulo Correo Electrónico",
              "options" => $vAttributes["validation"]
            ]
          ],
          "titleEmail" => [
            "name" => "titleEmail",
            "type" => "input",
            "props" => [
              "label" => "Titulo Correo Electrónico"
            ]
          ],
          "withIconCustomEmail" => [
            "name" => "withIconCustomEmail",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Icono Personalizado",
              "options" => $vAttributes["validation"]
            ]
          ],
          "iconCustomEmail" => [
            "name" => "iconCustomEmail",
            "type" => "input",
            "props" => [
              "label" => "Icono Personalizado Correo Electrónico"
            ]
          ],
          "withIconComponentEmail" => [
            "name" => "withIconComponentEmail",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Icono Componente",
              "options" => $vAttributes["validation"]
            ]
          ],
        ]
      ],
      "socialNetworks" => [
        "title" => "Sección Redes Sociales",
        "fields" => [
          "withSocialNetworks" => [
            "name" => "withSocialNetworks",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Redes Sociales",
              "options" => $vAttributes["validation"]
            ]
          ],
          "layoutSocialNetwork" => [
            "name" => "layoutSocialNetwork",
            "value" => "social-layout-1",
            "type" => "select",
            "props" => [
              "label" => "Plantilla Para Redes Sociales",
              "options" => [
                ["label" => "Redes Sociales Plantilla 1", "value" => "social-layout-1"],
              ]
            ]
          ],
          "alignSocialNetwork" => [
            "name" => "alignSocialNetwork",
            "value" => "justify-content-left",
            "type" => "select",
            "props" => [
              "label" => "Alineación Redes Sociales",
              "options" => [
                ["label" => "Alineación a la Izquierda", "value" => "justify-content-left"],
                ["label" => "Alineación a la Derecha", "value" => "justify-content-right"],
                ["label" => "Alineación Centrado", "value" => "justify-content-center"],
              ]
            ]
          ],
        ]
      ],
    ]
  ],
  "map" => [
    "title" => "Mapa",
    "systemName" => "isite::Maps",
    "nameSpace" => "Modules\Isite\View\Components\Maps",
    "contentFields" => [
      "title" => [
        "name" => "title",
        "type" => "input",
        "isTranslatable" => true,
        "props" => [
          "label" => "Titulo"
        ]
      ],
      "locationName" => [
        "name" => "locationName",
        "type" => "input",
        "isTranslatable" => true,
        "props" => [
          "label" => "Nombre De La Ubicación"
        ]
      ],
    ],
    "attributes" => [
      "general" => [
        "title" => "General",
        "fields" => [
          'inputLocation' => [
            'value' => null,
            'name' => 'inputLocation',
            'type' => 'positionMarkerMap',
            'colClass' => 'col-12',
            'props' => [
              'label' => 'Mapa',
            ]
          ],
          "mapStyle" => [
            "name" => "mapStyle",
            "value" => "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            "type" => "select",
            "props" => [
              "label" => "Estilo Para Mapa",
              "options" => [
                ["label" => "Mapa Estilo 1", "value" => "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"],
              ]
            ]
          ],
          "lat" => [
            'value' => '4.442452',
            "name" => "lat",
            "type" => "input",
            "props" => [
              "label" => "Latitud Ubicación (Opcional)",
            ]
          ],
          "lng" => [
            'value' => '-75.238074',
            "name" => "lng",
            "type" => "input",
            "props" => [
              "label" => "Longitud Ubicación (Opcional)",
            ]
          ],
          "classes" => [
            'value' => '',
            "name" => "classes",
            "type" => "input",
            "props" => [
              "label" => "Clases",
            ]
          ],
          "zoom" => [
            'value' => 16,
            "name" => "zoom",
            "type" => "input",
            "props" => [
              "label" => "Zoom",
              "type" => "number"
            ]
          ],
          "maxZoom" => [
            'value' => 20,
            "name" => "maxZoom",
            "type" => "input",
            "props" => [
              "label" => "Zoom Maximo Permitido En El Mapa",
              "type" => "number"
            ]
          ],
          "minZoom" => [
            'value' => 2,
            "name" => "minZoom",
            "type" => "input",
            "props" => [
              "label" => "Zoom Mínimo Permitido En El Mapa",
              "type" => "number"
            ]
          ],
          "id" => [
            'value' => 1,
            "name" => "id",
            "type" => "input",
            "props" => [
              "label" => "Identificador",
              "type" => "number"
            ]
          ],
          "inModal" => [
            "name" => "inModal",
            "value" => "0",
            "type" => "select",
            "props" => [
              "label" => "Mapa Para modal",
              "options" => $vAttributes["validation"]
            ]
          ],
          "mapWidth" => [
            'value' => '100%',
            "name" => "mapWidth",
            "type" => "input",
            "props" => [
              "label" => "Ancho Del Mapa",
            ]
          ],
          "mapHeight" => [
            'value' => '314px',
            "name" => "mapHeight",
            "type" => "input",
            "props" => [
              "label" => "Altura Del Mapa",
            ]
          ],
          "imageIcon" => [
            'value' => null,
            "name" => "imageIcon",
            "type" => "input",
            "props" => [
              "label" => "Url Imagen Icono Ubicación (Opcional)",
            ]
          ],
          "markerMapClasses" => [
            'value' => 'marker-map-class',
            "name" => "markerMapClasses",
            "type" => "input",
            "props" => [
              "label" => "Clases Para El Icono (Opcional)",
            ]
          ],
          "iconHeight" => [
            'value' => 42,
            "name" => "iconHeight",
            "type" => "input",
            "props" => [
              "label" => "Altura Icono",
              "type" => "number"
            ]
          ],
          "iconWidth" => [
            'value' => 28,
            "name" => "iconWidth",
            "type" => "input",
            "props" => [
              "label" => "Anchor Icono",
              "type" => "number"
            ]
          ],
          "withTitle" => [
            "name" => "withTitle",
            "value" => "1",
            "type" => "select",
            "props" => [
              "label" => "Mostrar Titulo",
              "options" => $vAttributes["validation"]
            ]
          ],
          "alignTitle" => [
            "name" => "alignTitle",
            "value" => "text-left",
            "type" => "select",
            "props" => [
              "label" => "Alineación del titulo",
              "options" => [
                ["label" => "Alineación a la Izquierda", "value" => "text-left"],
                ["label" => "Alineación a la Derecha", "value" => "text-right"],
                ["label" => "Alineación Centrado", "value" => "text-center"],
              ]
            ]
          ],
          "fontSizeTitle" => [
            "name" => "fontSizeTitle",
            "type" => "input",
            "props" => [
              "label" => "Tamaño de fuente Titulo Principal",
              "type" => "number"
            ]
          ],
          "colorTitle" => [
            "name" => "colorTitle",
            "type" => "inputColor",
            "props" => [
              "label" => "Color Titulo Principal"
            ]
          ],
          "colorTitleByClass" => [
            "name" => "colorTitleByClass",
            "value" => "text-primary",
            "type" => "select",
            "props" => [
              "label" => "Color del Titulo",
              "options" => [
                ["label" => "Texto en Color Primario", "value" => "text-primary"],
                ["label" => "Texto en Color Secundario", "value" => "text-secondary"],
                ["label" => "Texto en Color Negro", "value" => "text-dark"],
                ["label" => "Texto en Color Blanco", "value" => "text-white"],
              ]
            ]
          ],
        ]
      ]
    ]
  ],
  "lists" => [
    "title" => "Listas",
    "systemName" => "isite::lists",
    "nameSpace" => "Modules\Isite\View\Components\Lists",
    "content" => [
      [
        "label" => "Post",
        "value" => "Modules\Iblog\Repositories\PostRepository"
      ],
      [
        "label" => "Categoria de Post",
        "value" => "Modules\Iblog\Repositories\CategoryRepository"
      ],
      [
        "label" => "Categoria de Productos",
        "value" => "Modules\Icommerce\Repositories\CategoryRepository"
      ],
      [
        "label" => "Productos",
        "value" => "Modules\Icommerce\Repositories\ProductRepository"
      ],
      [
        "label" => "Slider::Slider",
        "value" => "Modules\Slider\Repositories\SlideRepository"
      ],
      [
        "label" => "Paginas",
        "value" => "Modules\Page\Repositories\PageRepository"
      ],
    ],
    "childBlocks" => [
      "itemComponentAttributes" => "isite::item-list",
      "productItemComponentAttributes" => "icommerce::components.product-list-item"
    ],
    "contentFields" => [
        "title" => [
            "name" => "title",
            "type" => "input",
            "columns" => "col-12",
            "isTranslatable" => true,
            "props" => [
                "label" => "Titulo",
            ]
        ],
        "subtitle" => [
            "name" => "subtitle",
            "type" => "html",
            "columns" => "col-12",
            "isTranslatable" => true,
            "props" => [
                "label" => "Subtitulo",
            ]
        ],
    ],
    "attributes" => [
      "general" => [
        "title" => "General",
        "fields" => [
          "id" => [
            "name" => "id",
            "type" => "input",
            "props" => [
              "label" => "Identificador",
            ]
          ],
          "layout" => [
            "name" => "layout",
            "value" => "lists-layout-5",
            "type" => "select",
            "props" => [
              "label" => "layout",
              "options" => [
                ["label" => "lists-layout-5", "value" => "lists-layout-5"],
              ]
            ]
          ],
          "class" => [
            "name" => "class",
            "value" => "",
            "type" => "input",
            "columns" => "col-12",
            "props" => [
              "label" => "Clases General",
            ]
          ],
          "columns" => [
            "name" => "columns",
            "value" => "",
            "type" => "input",
            "columns" => "col-12",
            "props" => [
              "label" => "Columnas",
            ]
          ],
        ]
      ],
      "texto" => [
        "title" => "Texto (Titulo y Subtitulo)",
        "fields" => [
          "textPosition" => [
            "name" => "textPosition",
            "value" => "2",
            "columns" => "col-12",
            "type" => "select",
            "props" => [
              "label" => "Posición",
              "options" => [
                ["label" => "Solo título", "value" => "1"],
                ["label" => "Título con descripción abajo", "value" => "2"],
                ["label" => "Título abajo con descripción arriba", "value" => "3"]
              ]
            ]
          ],
          "textAlign" => [
            "name" => "textAlign",
            "value" => "text-left",
            "type" => "select",
            "props" => [
              "label" => "Alineación",
              "options" => $vAttributes["align"]
            ]
          ],
          "titleLineMarginY" => [
            "name" => "titleLineMarginY",
            "value" => "d-none",
            "type" => "input",
            "props" => [
              "label" => "Linea debajo del texto",
            ]
          ],
          "titleClasses" => [
            "name" => "titleClasses",
            "value" => "",
            "type" => "input",
            "columns" => "col-12",
            "props" => [
              "label" => "Clases (Titulo)",
            ]
          ],
          "titleSize" => [
            "name" => "titleSize",
            "type" => "input",
            "props" => [
              "label" => "Tamaño Fuente (Titulo)",
              "type" => "number"
            ]
          ],
          "titleTransform" => [
            "name" => "titleTransform",
            "type" => "select",
            "props" => [
              "label" => "Transformar (Titulo)",
              "options" => $vAttributes["textTransform"]
            ]
          ],
          "titleColor" => [
            "name" => "titleColor",
            "type" => "select",
            "props" => [
              "label" => "Color (Titulo)",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "titleWeight" => [
            "name" => "titleWeight",
            "value" => "font-weight-normal",
            "type" => "select",
            "props" => [
              "label" => "Negrita (Titulo)",
              "options" => $vAttributes["textWeight"]
            ]
          ],
          "titleLetterSpacing" => [
            "name" => "titleLetterSpacing",
            "type" => "input",
            "props" => [
              "label" => "Espacio entre letras (Titulo)",
              "type" => "number"
            ]
          ],
          "titleVineta" => [
            "name" => "titleVineta",
            "type" => "input",
            "props" => [
              "label" => "Icon (Titulo)"
            ]
          ],
          "titleUrl" => [
            "name" => "titleUrl",
            "type" => "input",
            "props" => [
              "label" => "Url (Titulo)"
            ]
          ],
          "titleTarget" => [
            "name" => "titleTarget",
            "value" => "_self",
            "type" => "select",
            "props" => [
              "label" => "Target (Titulo)",
              "options" => $vAttributes["target"]
            ]
          ],
          "titleVinetaColor" => [
            "name" => "titleVinetaColor",
            "type" => "select",
            "props" => [
              "label" => "Color icon (Titulo)",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "subtitleClasses" => [
            "name" => "subtitleClasses",
            "value" => "",
            "type" => "input",
            "columns" => "col-12",
            "props" => [
              "label" => "Clases (Subtitulo)",
            ]
          ],
          "subtitleSize" => [
            "name" => "subtitleSize",
            "type" => "input",
            "props" => [
              "label" => "Tamaño Fuente (Subtitulo)",
              "type" => "number"
            ]
          ],
          "subtitleColor" => [
            "name" => "subtitleColor",
            "type" => "select",
            "props" => [
              "label" => "Color (Subtitulo)",
              "options" => $vAttributes["textColors"]
            ]
          ],
          "subtitleTransform" => [
            "name" => "subtitleTransform",
            "type" => "select",
            "props" => [
              "label" => "Transformar (Subtitulo)",
              "options" => $vAttributes["textTransform"]
            ]
          ],
          "subtitleWeight" => [
            "name" => "subtitleWeight",
            "type" => "select",
            "props" => [
              "label" => "Negrita (Subtitulo)",
              "options" => $vAttributes["textWeight"]
            ]
          ],
          "subtitleLetterSpacing" => [
            "name" => "subtitleLetterSpacing",
            "type" => "input",
            "props" => [
              "label" => "Espacio entre letras (Subtitulo)",
              "type" => "number"
            ]
          ],
          "withLineTitle" => [
            "name" => "withLineTitle",
            "value" => "0",
            "type" => "select",
            "columns" => "col-12",
            "props" => [
                "label" => "Linea",
                "options" => $vAttributes["titleLine"]
            ]
          ],
          "lineTitleConfig" => [
            "name" => "lineTitleConfig",
            "value" => ['background' => 'var(--primary)','height' => '2px','width' => '10%','margin' => '0 auto'],
            "type" => "json",
            "columns" => "col-12",
            "props" => [
                "label" => "Configuración de Línea",
            ]
          ],
        ]
      ]
    ]
  ],
  "whatsapp" => [
        "title" => "Whatsapp",
        "systemName" => "isite::whatsapp",
        "nameSpace" => "Modules\Isite\View\Components\Whatsapp",
        "contentFields" => [
            "title" => [
                "name" => "title",
                "type" => "input",
                "columns" => "col-12",
                "isTranslatable" => true,
                "props" => [
                    "label" => "Titulo",
                ]
            ],
            "titleInternal" => [
                "name" => "titleInternal",
                "type" => "input",
                "columns" => "col-12",
                "isTranslatable" => true,
                "props" => [
                    "label" => "Titulo Interno",
                ]
            ],
            "summayInternal" => [
                "name" => "summayInternal",
                "type" => "input",
                "columns" => "col-12",
                "isTranslatable" => true,
                "props" => [
                    "label" => "SubTitulo Interno",
                ]
            ],
        ],
        "attributes" => [
            "general" => [
                "title" => "General",
                "fields" => [
                    "layout" => [
                        "name" => "layout",
                        "value" => "whatsapp-layout-5",
                        "type" => "select",
                        "columns" => "col-12",
                        "props" => [
                            "label" => "Layout",
                            "options" => [
                                ["label" => "Layout 1", "value" => "whatsapp-layout-1"],
                                ["label" => "Layout 3", "value" => "whatsapp-layout-3"],
                                ["label" => "Layout 4", "value" => "whatsapp-layout-4"],
                                ["label" => "Layout 5", "value" => "whatsapp-layout-5"]
                            ]
                        ]
                    ],
                    "top" => [
                        "name" => "top",
                        "type" => "input",
                        "props" => [
                            "label" => "Top",
                        ]
                    ],
                    "bottom" => [
                        "name" => "bottom",
                        "type" => "input",
                        "props" => [
                            "label" => "Bottom",
                        ]
                    ],
                    "right" => [
                        "name" => "right",
                        "type" => "input",
                        "props" => [
                            "label" => "Right",
                        ]
                    ],
                    "left" => [
                        "name" => "left",
                        "type" => "input",
                        "props" => [
                            "label" => "Left",
                        ]
                    ],
                ]
            ],
            "dropdown" => [
                "title" => "Desplegable",
                "fields" => [
                    "alignment" => [
                        "name" => "alignment",
                        "value" => "dropleft",
                        "type" => "select",
                        "props" => [
                            "label" => "Alineación del dropdown",
                            "options" => [
                                ["label" => "Izquierda", "value" => "dropleft"],
                                ["label" => "Derecha", "value" => "dropright"],
                            ]
                        ]
                    ],
                    "dropdownTextAlign" => [
                        "name" => "dropdownTextAlign",
                        "value" => "text-center",
                        "type" => "select",
                        "props" => [
                            "label" => "Alineación del Texto dentro del dropdown",
                            "options" => $vAttributes["textAlign"]
                        ]
                    ],
                    "infoTitleColor" => [
                        "name" => "infoTitleColor",
                        "type" => "input",
                        "props" => [
                            "label" => "Color de la etiqueta",
                        ]
                    ],
                    "infoSubtitleColor" => [
                        "name" => "infoSubtitleColor",
                        "type" => "input",
                        "props" => [
                            "label" => "Color del numero",
                        ]
                    ],
                    "alignmentMsn" => [
                        "name" => "alignmentMsn",
                        "value" => "",
                        "type" => "select",
                        "props" => [
                            "label" => "(layout 5) Alineación del Mensaje",
                            "options" => [
                                ["label" => "Izquierda", "value" => ""],
                                ["label" => "Derecha", "value" => "right"],
                                ["label" => "Ocultar", "value" => "no-text"],
                            ]
                        ]
                    ],
                    "alignmentWin" => [
                        "name" => "alignmentWin",
                        "value" => "",
                        "type" => "select",
                        "props" => [
                            "label" => "(layout 5) Alineación de la ventana",
                            "options" => [
                                ["label" => "Izquierda", "value" => ""],
                                ["label" => "Derecha", "value" => "right"],
                            ]
                        ]
                    ],
                ]
            ],
        ]
    ],
  "social" => [
    "title" => "Social",
    "systemName" => "isite::social",
    "nameSpace" => "Modules\Isite\View\Components\Social",
    "attributes" => [
        "general" => [
            "title" => "General",
            "fields" => [
                "idSocial" => [
                    "name" => "idSocial",
                    "value" => "socialComponent",
                    "type" => "input",
                    "props" => [
                        "label" => "Identificador",
                    ]
                ],
                "iconDisplay" => [
                    "name" => "iconDisplay",
                    "value" => "flex",
                    "type" => "select",
                    "props" => [
                        "label" => "Display",
                        "options" => $vAttributes["display"]
                    ]
                ],
                "iconMargin" => [
                    "name" => "iconMargin",
                    "type" => "input",
                    "props" => [
                        "label" => "Margin",
                    ]
                ],
                "iconStyle" => [
                    "name" => "iconStyle",
                    "value" => "1",
                    "type" => "select",
                    "props" => [
                        "label" => "Estilo Base",
                        "options" => [
                            ["label" => "Estilo 1", "value" => "1"],
                            ["label" => "Estilo 2", "value" => "2"],
                            ["label" => "Estilo 3", "value" => "3"],
                            ["label" => "Estilo 4", "value" => "4"],
                        ]
                    ]
                ],
                "iconSize" => [
                    "name" => "iconSize",
                    "value" => "16px",
                    "type" => "input",
                    "props" => [
                        "label" => "Tamaño de icono",
                    ]
                ],
                "iconBackgroundSize" => [
                    "name" => "iconBackgroundSize",
                    "value" => "40px",
                    "type" => "input",
                    "props" => [
                        "label" => "Tamaño del fondo",
                    ]
                ],
                "iconColor1" => [
                    "name" => "iconColor1",
                    "type" => "input",
                    "props" => [
                        "label" => "Color 1",
                    ]
                ],
                "iconColor2" => [
                    "name" => "iconColor2",
                    "type" => "input",
                    "props" => [
                        "label" => "Color 2",
                    ]
                ],
                "iconBorderWidth" => [
                    "name" => "iconBorderWidth",
                    "value" => "0",
                    "type" => "input",
                    "props" => [
                        "label" => "Tamaño del borde",
                        "type" => "number",
                    ]
                ],
                "iconBorderRadius" => [
                    "name" => "iconBorderRadius",
                    "value" => "0",
                    "type" => "input",
                    "props" => [
                        "label" => "Radio de borde",
                    ]
                ],
                "iconBorderRadiusType" => [
                    "name" => "iconBorderRadiusType",
                    "value" => "1",
                    "type" => "select",
                    "props" => [
                        "label" => "Tipo del borde",
                        "options" => $vAttributes["contentBorderRoundedType"]
                    ]
                ],
                "iconAnimate" => [
                    "name" => "iconAnimate",
                    "value" => "",
                    "type" => "select",
                    "props" => [
                        "label" => "Animacion",
                        "options" => $vAttributes["animateSocial"]
                    ]
                ],
                "iconBoxShadow" => [
                    "name" => "iconBoxShadow",
                    "type" => "input",
                    "props" => [
                        "label" => "Sombra del Fondo",
                    ]
                ],
                "iconTextShadow" => [
                    "name" => "iconTextShadow",
                    "type" => "input",
                    "props" => [
                        "label" => "Sombra del Texto",
                    ]
                ],
            ]
        ],
    ]
  ]
];
