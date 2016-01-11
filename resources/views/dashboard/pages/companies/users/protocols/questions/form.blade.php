@extends('dashboard.pages.form-layouts.horizontal')
@section('title_page')
  <i class="fa fa-file-text"></i> {{ $protocol->name }} -
  @if($question->exists) Editar Pregunta
  @else Nueva Pregunta @endif
@stop
@section('breadcrumbs') {!! Breadcrumbs::render('protocols.protocol.question', $protocol, $question) !!} @stop
@section('title_form') Datos de la Pregunta @stop
@section('form')
  {!! Form::model($question, $form_data) !!}

    <div class="row">
      <div class="form-group">
        <label class="col-md-3 control-label" for="text">Pregunta <span class="text-danger">*</span></label>
        <div class="col-md-6">
            <div class="input-group">
                {!! Form::text('text', null, array('class' => 'form-control', 'placeholder' => 'Pregunta', 'required' => 'required')) !!}
                <span class="input-group-addon"><i class="fa fa-bars"></i></span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <label class="switch switch-info"><input type="checkbox" name="aviable" value="1" @if($question->aviable) checked @endif ><span></span></label>
            </div>
        </div>
      </div>

      <div class="form-group"> 
        <h4 style="margin-left:10%;">
          Respuestas
          <a href="javascript:void(0)" class="btn btn-sm btn-effect-ripple btn-info" data-toggle="tooltip" data-original-title="Nueva Respuesta">
            <i class="fa fa-plus"></i>
          </a>
        </h4>
            
      </div>
      @if(!$question->exists)
        @for($i=1; $i <= $number_answers; $i++ )
          <div class="form-group">
            <label class="col-md-3 control-label" for="answers[{{$i}}][text]">Respuesta {{$i}} <span class="text-danger">*</span></label> 
            <div class="col-md-6">      
              {!! Form::text('answers['.$i.'][text]', null, array('required' => 'required', 
                'placeholder' => 'Respuesta '.$i, 'class' => 'form-control')) !!}
            </div>
            <div class="col-md-3">
              <div class="radio">
                <label>
                    <input type="radio" name="answers_correct" value="{{$i}}"/>
                    Verdadera 
                </label>
              </div>
            </div>
          </div>
        @endfor
      @else
        @foreach($question->answers as $answer)
            <div class="form-group">
              <label class="col-md-3 control-label" for="answers[{{$answer->id}}][text]">Respuesta <span class="text-danger">*</span></label>     
              <div class="col-md-6">      
                {!! Form::text('answers['.$answer->id.'][text]', $answer->text, ['required', 
                  'placeholder' => 'Respuesta ', 'class' => 'form-control']) !!}
              </div>
              <div class="col-md-3">
                <div class="radio">
                  <label>
                      <input type="radio" name="answers_correct" value="{{$answer->id}}" @if($answer->correct) checked @endif/>
                      Verdadera 
                  </label>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
      <div class="form-group form-actions">
          <div class="col-md-9 col-md-offset-3">
              <button type="submit" class="btn btn-effect-ripple btn-primary">Guardar Pregunta</button>
          </div>
      </div>
    </div>
  {!! Form::close() !!}
@stop