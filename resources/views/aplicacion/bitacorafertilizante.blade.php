@extends('app')

@section('title', 'Aplicaciones Fertilizantes')


@section('content')


<div class="card">
	<div class="card-content">
		<div class=" col s12">
			<label>Lote</label>
		<select id="slclotebitacora" class="js-data-example-ajax browser-default" name="slclotebitacora">
		</select>
	</div>
	<br>

@if($content['countfertilizante'] > 0)


	<table class="display nowrap" id="tableBitacoraFertilizante">
		<thead>
			<tr>
				@foreach ($content['bitacorafertilizante'][0] as $key=>$value)
				<th>{{ htmlspecialchars($key) }}</th>
				@endforeach
			</tr>
		</thead>

		<tbody>
			@foreach ($content['bitacorafertilizante'] as $key=>$value)
			<tr>
				@foreach ($value as $value2)
				<td>{{$value2}}</td>
				@endforeach
			</tr>
			@endforeach


		</tbody>
	</table>
	@endif



</div>
</div>
</div>



</form>

@endsection


@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
@endpush
