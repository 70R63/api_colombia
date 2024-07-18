@extends('landing') 

@section('content')

<div class="row row-sm">
   <div class="col-sm-12 col-md-12">
      <div class="card custom-card ">
         <div class="card-header border-bottom-0 custom-card-header">
            <div class="col-sm-12 col-md-10">
                <h3 class="main-content-label mb-0">Crear nuevo CFDI</h3>
            </div>
        </div>
      </div>

      <div class="card custom-card ">

         <form action="{{ route('PacServicio.store') }}" method="post">
            @csrf
            <label for="fname">First name:</label>
            <input type="text" id="fname" name="fname"><br><br>
            <label for="lname">Last name:</label>
            <input type="text" id="lname" name="lname"><br><br>
            <input type="submit" value="Submit">
         </form>

      <div/>  
   </div>
</div>
   
@endsection