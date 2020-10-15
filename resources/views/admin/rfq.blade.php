@extends('layouts.backend')

@section('content')
    <div class="container">
        <table class="table table-bordered data-table-rfq">
            <thead>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Company</th>
                <th>Description</th>
                <th width="100px">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="rfqViewModal" tabindex="-1" role="dialog" aria-labelledby="imageEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">RFQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">Name: </div>
                        <div class="col-md-9" id="rfq_name"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Email: </div>
                        <div class="col-md-9" id="rfq_email"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Company: </div>
                        <div class="col-md-9" id="rfq_company"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Description: </div>
                        <div class="col-md-9" id="rfq_description"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
