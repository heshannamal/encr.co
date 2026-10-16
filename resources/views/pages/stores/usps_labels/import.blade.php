@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('content')
<div class="container">
    <h3>Import USPS Label XLSX</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('import_errors'))
        <div class="alert alert-danger">
            <strong>Import Errors:</strong>
            <ul>
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.usps-labels.import.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label>USPS XLSX File</label>
            <input type="file" name="xlsx_file" class="form-control" accept=".xlsx,.xls,.csv" required>

            @error('xlsx_file')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Import USPS Labels
        </button>
    </form>
</div>
@endsection
