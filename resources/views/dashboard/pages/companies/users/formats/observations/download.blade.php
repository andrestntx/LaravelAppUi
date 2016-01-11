@extends('layout')

@section('meta')
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
@endsection

@section('css_files')
  <style type="text/css">
  
  .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 18cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: left;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 10px 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
  font-size: 1.2em;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

main {
  margin-top:80px; 
  display:block;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}

  </style>

@endsection

@section('content_body')
  <header class="clearfix">
      <div id="logo">
        <img src="{{ URL::to($observation->user->company->logo) }}">
      </div>
      <h1>{{ $format->name }}</h1>
      <div id="company" class="clearfix">
        <div>{{ $observation->user->company->name }}</div>
        <div>{{ $observation->user->company->address }}</div>
        <div>{{ $observation->user->company->tel }}</div>
        <div><a href="mailto:{{ $observation->user->company->email }}">{{ $observation->user->company->email }}</a></div>
      </div>
      <div id="project">
        <div><span>APLICADA</span> {{ $observation->applied }} </div>
        <div><span>FECHA</span> {{ $observation->created_at }}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">#</th>
            <th class="service">PREGUNTA</th>
            <th class="desc">RESPUESTA</th>
            <th class="desc">OBSERVACIÓN</th>
          </tr>
        </thead>
        <tbody>
          @foreach($observation->answers as $answer)
        <tr>
          <td class="service"> {{ $answer->question->order }} </td>
          <td class="service">{{ $answer->question->text }}</td>
          <td class="desc">{{ $answer->text }}</td>
          <td class="desc">{{ $answer->observation }}</td>
        </tr>
      @endforeach
        </tbody>
      </table>
      <div id="notices">
        <div>OBSERVACIÓN:</div>
        <div class="notice"> {{ $observation->observation }} </div><br><br>
      </div>

      <div id="project">
        <div><span>USUARIO</span> {{ $observation->user->name }}</div>
        <div><span>EMAIL</span> <a href="mailto:{{ $observation->user->email }}">{{ $observation->user->email }}</a></div>
        <div><span>TELEFONO</span> {{ $observation->user->tel }}</div>
      </div>

    </main>
    <footer>
      Lista de chequeo creada por HistoWeb Calidad
    </footer>


@endsection