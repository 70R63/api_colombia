@extends('landing') 

@section('content')

<div class="row row-sm">
   <div class="col-sm-12 col-md-12">
      <div class="card custom-card ">
         <div class="card-header border-bottom-0 custom-card-header">
            <div class="col-sm-12 col-md-10">
                <h3 class="main-content-label mb-0">Index</h3>
            </div>
        </div>
      </div>  

      <div class="card custom-card ">
         <a href="{{ route('PacServicio.create') }}" class="btn badge-dark" >Crear</a>
      </div>
   </div>
</div>
   
@endsection