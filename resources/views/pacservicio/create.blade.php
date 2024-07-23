@extends('landing') 

@section('content')

<div class="row row-sm">
   <div class="col-sm-12 col-md-12">
      <div class="card custom-card ">
         <div class="card-header border-bottom-0 custom-card-header">
            <div class="col-sm-12 col-md-10">
                <h3 class="main-content-label mb-0">Crear nueva Factura Electronica</h3>
            </div>
        </div>
      </div>

      <div class="card custom-card ">

         <form action="{{ route('pac.store') }}" method="post">
            @csrf
            
            <label for="fname">Razón social:</label>
            <input type="text" id="fname" name="receptor[nombre]"><br><br>

            <label for="fname">NIT:</label>
            <input type="text" id="fname" name="receptor[numeroIdentificacion]"><br><br>

            <label for="fname">Receptor email:</label>
            <input type="text" id="fname" name="receptor[correoElectronico]"><br><br>


            
            <input type="submit" value="Submit">
         </form>

      <div/>  
   </div>
</div>
   
@endsection