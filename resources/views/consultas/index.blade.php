@extends('landing') 

@section('content')

<div class="row row-sm">
   <div class="col-sm-12 col-md-12">
      <div class="card custom-card ">
         <div class="card-header border-bottom-0 custom-card-header">
            <div class="col-sm-12 col-md-10">
                <h3 class="main-content-label mb-0">Index Consultas</h3>
            </div>
        </div>
      </div>  


      <h4>Seleccione archivo de su computadora</h4>
       <form action="{{ route('servicios.consultas.store') }}" method="post" enctype="multipart/form-data" id="js-upload-form">
         @csrf
         <div class="form-inline">
           
            <span class="btn btn-success fileinput-button">
                 <i class="glyphicon glyphicon-plus"></i>
                 <span>Add files</span>
                 <input type="file" name="file" id="file" multiple>
            </span>
            
            <button type="submit" class="btn btn-primary start">
                 <i class="glyphicon glyphicon-upload"></i>
                 <span>Iniciar carga</span>
            </button>
            <button type="reset" class="btn btn-warning cancel">
                 <i class="glyphicon glyphicon-ban-circle"></i>
                 <span>Limpiar upload</span>
            </button>
          
         </div>
       </form>
          
   </div>
</div>



@endsection