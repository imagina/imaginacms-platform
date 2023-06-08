<div id="multilanglayout2" class="multilang">
  {{ LaravelLocalization::getCurrentLocale()}}

  <form>
    <select id="inputState" class="">
      @foreach($locales as $locale)
        <option href="/{{$locale}}"
                {{ LaravelLocalization::getCurrentLocale() == $locale ? "selected" : "" }} value="{{$locale}}">
          {{$locale}}
        </option>
      @endforeach
    </select>
  </form>
</div>