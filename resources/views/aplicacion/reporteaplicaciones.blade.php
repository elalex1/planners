@extends('app')

@section('title', 'Reporte Aplicaciones')


@section('content')

	<table class="display nowrap" id="tableReporteAplicaciones">
		<thead>
			<tr>
				@foreach ($content['reporteaplicacion'][0] as $key=>$value)
				<th>{{ htmlspecialchars($key) }}</th>
				@endforeach
			</tr>
		</thead>

		<tbody>
			@foreach ($content['reporteaplicacion'] as $key=>$value)
			<tr>
				@foreach ($value as $value2)
				<td>{{$value2}}</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>

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
