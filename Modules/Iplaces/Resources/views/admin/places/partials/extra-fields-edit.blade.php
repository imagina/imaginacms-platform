<div class="col-xs-12">
    <div class="box box-primary">

        <div class="box-header">
            
            <h3 class="box-title">{{trans("iplaces::places.title.extra-fields")}}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                    
            </div>
            
        </div>

        <div class="box-body ">

            <div class="row">

                {{-- GAMAS --}}
                <div class="col-xs-4">
                    <div class="box">
                        <div class="box-header">     
                            <div class="form-group">
                                <label>{{trans('iplaces::places.form.gama')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <select class="form-control" name="gama" id="gama">
                                @foreach ($gamas as $index => $gama)
                                    <option value="{{$index}}" {{ old('gama',$place->gama) == $index ? 'selected' : '' }}>{{$gama}}</option>
                                @endforeach
                            </select><br>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="box">
                        <div class="box-header">
                            <div class="form-group">
                                <label>{{trans('iplaces::places.form.rating')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class='form-group{{ $errors->has("rating") ? ' has-error' : '' }}'>
                                <?php $old = $place->rating; ?>
                                {!! Form::number("rating", old("rating",$old), ['step'=>'0.01','class' => 'form-control', 'placeholder' => trans('iplaces::places.form.rating')]) !!}
                                {!! $errors->first("rating", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Quantity Person--}}
                <div class="col-xs-4">
                    <div class="box">
                        <div class="box-header">
                            <div class="form-group">
                                <label>{{trans('iplaces::places.form.person')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class='form-group{{ $errors->has("quantity_person") ? ' has-error' : '' }}'>
                                <?php $old = $place->quantity_person; ?>
                                {!! Form::number("quantity_person", old("quantity_person",$old), ['class' => 'form-control', 'placeholder' => trans('iplaces::places.form.person')]) !!}
                                {!! $errors->first("quantity_person", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
           
            <div class="row">
                {{-- Weather--}}
                <div class="col-xs-4">
                    <div class="box">
                        <div class="box-header">     
                            <div class="form-group">
                                <label>{{trans('iplaces::places.form.weather')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <select class="form-control" name="weather" id="weather">
                                @foreach ($weathers as $index => $weather)
                                    <option value="{{$index}}" {{ old('weather',$place->weather) == $index ? 'selected' : '' }}>{{$weather}}</option>
                                @endforeach
                            </select><br>
                        </div>
                    </div>
                </div>
                
                {{-- Housing--}}
                <div class="col-xs-4">
                    <div class="box">
                        <div class="box-header">     
                            <div class="form-group">
                                <label>{{trans('iplaces::places.form.housing')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <select class="form-control" name="housing" id="housing">
                                @foreach ($statusesyn as $index => $statusyn)
                                    <option value="{{$index}}" {{ old('housing',$place->housing) == $index ? 'selected' : '' }}>{{$statusyn}}</option>
                                @endforeach
                            </select><br>
                        </div>
                    </div>
                </div>

                {{-- Transport--}}
                <div class="col-xs-4">
                    <div class="box">
                        <div class="box-header">     
                            <div class="form-group">
                                <label>{{trans('iplaces::places.form.transport')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <select class="form-control" name="transport" id="transport">
                                @foreach ($statusesyn as $index => $statusyn)
                                    <option value="{{$index}}" {{ old('transport',$place->transport) == $index ? 'selected' : '' }}>{{$statusyn}}</option>
                                @endforeach
                            </select><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <div class="box">
                        <div class="box-header">
                            <div class="form-group">
                                <label>{{trans('iplaces::places.form.order')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class='form-group{{ $errors->has("order") ? ' has-error' : '' }}'>
                                <?php $old = $place->order; ?>
                                {!! Form::number("order", old("order",$old), ['class' => 'form-control', 'placeholder' => trans('iplaces::places.form.order')]) !!}
                                {!! $errors->first("order", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>