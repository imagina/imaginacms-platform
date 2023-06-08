
<div id="multilanglayout1" class="multilang">

  
  @foreach($locales as $locale)
    @if($showImage)
      <?php
      $hash = sha1($imageComponentNamespace);
      if (isset($component)) {
        $__componentOriginal{$hash} = $component;
      }
      $component = $__env->getContainer()->make($imageComponentNamespace, array_merge([
        'src' => url('modules/isite/img/locales/' . $locale . '.jpg'),
        'imgStyles' => 'width: 50px; height: 27px;',
        'url' => $locale,
      ], $imageComponentAtributtes ?? []));
      $component->withName($imageComponent);
      if ($component->shouldRender()):
        $__env->startComponent($component->resolveView(), $component->data());
        if (isset($__componentOriginal{$hash})):
          $component = $__componentOriginal{$hash};
          unset($__componentOriginal{$hash});
        endif;
        echo $__env->renderComponent();
      endif;
      ?>
    @endif
    
    @if($showButton)
      <?php
      $hash = sha1($butonComponentNamespace);
      if (isset($component)) {
        $__componentOriginal{$hash} = $component;
      }
      $component = $__env->getContainer()->make($butonComponentNamespace, array_merge([
        'label' => $locale,
        'href' => setLocaleInUrl($locale),
        'withLabel' => true,
        'buttonClasses' => 'btn px-2 border-0 text-capitalize',
      ], $buttonComponentAtributtes ?? []));
      $component->withName($butonComponent);
      if ($component->shouldRender()):
        $__env->startComponent($component->resolveView(), $component->data());
        if (isset($__componentOriginal{$hash})):
          $component = $__componentOriginal{$hash};
          unset($__componentOriginal{$hash});
        endif;
        echo $__env->renderComponent();
      endif;
      ?>
    @endif
  @endforeach
    </div>
