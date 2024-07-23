@if(Session::has('success'))
<div class="alert alert-block alert-success">
	<button type="button" class="close" data-dismiss="alert">
		<i class="ace-icon fa fa-times"></i>
	</button>
	@foreach(Session::get('success') as $key => $msj)
		<p></p>
		<strong><i class="ace-icon fa fa-check green"></i>{{  $key }} - {{  $msj }} </strong> 
	@endforeach

	<div class="card custom-card ">
         <a href="{{ asset('cufe/0fd636ef-6f0b-4701-9ecf-a568183d95ef.pdf') }}" class="btn badge-dark" >PDF</a>
      </div>
</div>

@endif