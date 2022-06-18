<div class="tag">
  @if(!$item->tags->isEmpty())
    <br>
    <p class="title-tag {{$titleClass}}">{{trans('tag::tag.list')}}</p>
    <span class="tags-links">
      @foreach($item->tags as $tag)
        <x-isite::button buttonClasses="{{$buttonClasses}}"
                         href="{{route(locale(). '.tag.slug',['slug' => $tag->slug])}}" label="{{$tag->name}}"
                         sizeLabel="{{$buttonSizeLabel}}"
                         withLabel="{{$buttonWithLabel}}"
                         color="{{$buttonColor}}"
                         style="{{$buttonStyle}}"
                         onclick="{{$buttonOnclick}}"
                         withIcon="{{$buttonWithIcon}}"
                         iconClass="{{$buttonIconClass}}"
                         target="{{$buttonTarget}}"
                         iconPosition="{{$buttonIconPosition}}"
                         iconColor="{{$buttonIconColor}}"
        />
      @endforeach
    </span>
  @endif
</div>