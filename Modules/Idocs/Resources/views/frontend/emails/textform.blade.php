{{$document->title }}


{!!strip_tags(Setting::get('idocs::msg-email'))!!}
@if(count($document->users))
@else
  {{trans('idocs::documents.form.document')}}: {{$document->user_identification}}
  {{trans('idocs::documents.form.key')}}: {{$document->key}}
@endif
