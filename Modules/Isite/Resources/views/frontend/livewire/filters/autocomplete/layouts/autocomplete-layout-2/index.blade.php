<div id="autocompleteLayout2">
  <div id="autocomplete-box">
    <div class="search-product row no-gutters">
      <div class="col">
        <div id="content_searcher">
          <!-- input -->
          <div id="dropdownSearch"
               aria-haspopup="false"
               aria-expanded="false"
               role="button"
               class="input-group dropdown-toggle">
            <div class="input-group">
              <input type="text" id="input_search" wire:model.debounce.500ms="search"
                     wire:keydown.enter="goToIndex"
                     wire:click="autocompleteChangeCollapsable('show')"
                     autocomplete="off"
                     list="listOptions"
                     class="form-control  rounded-right"
                     placeholder="{{ $placeholder }}"
                     aria-label="{{ $placeholder }}" aria-describedby="button-addon2">
              @if($buttonSearch)
                <div class="input-group-append">
                  <button class="btn btn-primary px-3 " wire:click="goToIndex" type="submit" id="button-addon2">
                    <i class="{{ $icon }}"></i>
                  </button>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <a id="tagHelper" data-toggle="collapse" href="#entityS" role="button" aria-expanded="false" aria-controls="entityS"
     class="collapsed d-none"></a>
  <div class=" collapse {{$collapsable}} multi-collapse position-absolute bg-white" id="entityS" style="     top: 110%;
    left: 0;
    min-width: 100%;
    width: 58vw !important;">
    <div class="container">
      <div class="row">
        @php($count=1)
        @foreach($results as $key => $word)
          @if($key%43 ==0)
            @if($count==$key/43)</div> @php($count++) @endif
      <div class="col-12 col-md-6 col-lg-3">
        @endif
        <input type="radio" class="d-none" id="item{{$word}}" value="{{$word}}"
               wire:click="collapsableInputClick('{{$word}}')">
        <label for="item{{$word}}" id="word"
               class="@if(in_array($word,$featuredOptions))font-weight-bold @endif">{{$word}}</label>
        @endforeach
      </div>
    </div>
  </div>
</div>
@if(!empty($results))
</div>
@endif

@section('scripts')
  @parent
  <style>
    #autocompleteLayout2 .row {
      align-items: start !important;
    }
    #autocompleteLayout2 .collapse {
      width: 49vw !important;
      position: absolute;
      max-height: 20em;
      border: 0 none;
      overflow-x: hidden;
      overflow-y: scroll;
      scroll-behavior: inherit;
    }
    #autocompleteLayout2 .collapse::-webkit-scrollbar {
      width: 8px;
    }
    #autocompleteLayout2 .collapse::-webkit-scrollbar-thumb {
      background: #5a5a5a4f;
    }
    #autocompleteLayout2 .collapse #word {
      font-size: 0.8em;
      padding: 0.3em 1em;
      background-color: #ffffff;
      cursor: pointer;
      width: 100%;
      /* option active styles */
    }
    #autocompleteLayout2 .collapse #word:hover, #autocompleteLayout2 .collapse #word:focus {
      color: #ffffff;
      background-color: var(--primary);
      outline: 0 none;
    }

  </style>
  <script>

    $(document).ready(function () {

      $('#input_search').on('click', function () {
        $('#tagHelper').click();

      });

      $(document).on("click", function (e) {
        var container = $('div.collapse.show');

        if (!container.is(e.target) && container.has(e.target).length === 0) {
          $('div.collapse.show').removeClass('show');

        }
      });
    });

  </script>
@stop