@extends('layouts.backend')

@section('content')
    <div class="container">
        <table class="table table-bordered data-table">
            <thead>
            <tr>
                <th>id</th>
                <th>headings_title</th>
                <th>headings_image</th>
                <th width="100px">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="modal fade bd-example-modal-sm" id="imageEditModal" tabindex="-1" role="dialog" aria-labelledby="imageEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="imageUploadForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="" name="headings_id" id="headings_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="custom-file">
                                    <strong class="image_name_display"></strong>
                                    <input type="file" class="custom-file-input" name="headings_image" id="headings_image" required>
                                    <label class="custom-file-label" for="headings_image">Choose file...</label>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success headings_image_ac">Upload Image</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
