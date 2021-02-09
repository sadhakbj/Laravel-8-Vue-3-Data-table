@extends('layouts.app')

@section('content')
	<div class="container" id="app">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">Users</div>
					
					<div class="card-body">
						<data-table
								url="{{ route('api.users') }}"
								:columns="['name', 'email', 'address', 'created_at']"
						></data-table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
