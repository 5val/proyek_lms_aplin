@extends('layouts.admin_app')

@section('admin_content')
    <div>
        <a href="/admin/listsiswa" class="btn btn-danger">
            Back
        </a>
        <h1>Import Siswa Excel Data</h1>
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="container mt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('uploadSiswa.excel') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file-upload" class="file-upload-label" id="file-upload-field">
                                <i class="fas fa-plus fa-3x"></i> <br>
                                <span id="file-upload-text">Drag File Here</span>
                            </label>
                            <input type="file" id="file-upload" name="file" class="form-control-file"
                                style="display: none;">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3" style="width: 100%">Send</button>
                    </form>
                    <button id="download-template" class="btn btn-secondary mt-3">Download Excel Template</button>
                </div>
            </div>
        </div>

        <!-- <form action="{{ route('uploadSiswa.excel') }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="file" class="form-label">Choose Excel File</label>
                                                                    <input class="form-control" type="file" id="file" name="file">
                                                                    @error('file')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Import Data</button>
                                                            </form> -->
    </div>
    <script>
        document.getElementById('file-upload').addEventListener('change', function () {
            console.log(this.files[0].name);

            const fileUploadField = document.getElementById('file-upload-field');
            if (this.files.length > 0) {

                fileUploadField.innerHTML = `
                        <i class="fas fa-file fa-3x"></i> <br>
                        <span id="file-upload-text">${this.files[0].name}</span>
                        `;
            } else {

                fileUploadField.innerHTML = `
                        <i class="fas fa-plus fa-3x"></i> <br>
                        <span id="file-upload-text">Drag File Here</span>
                        `;
            }
        });

        document.getElementById('file-upload').addEventListener('click', function () {
            this.value = ''; // Clear previous selection
        });
        document.getElementById('download-template').addEventListener('click', function () {
            //  window.location.href = '/download/template'; // Simple download trigger
            // Use a fetch request if you need more control (e.g., error handling)
            fetch('/admin/downloadTempSiswa')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.blob();
                })
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'template_siswa.xlsx'; //  filename
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Download failed:', error);
                    alert('Failed to download the template. Please check your network connection and try again.'); // User-friendly error message
                });

        });
    </script>
@endsection