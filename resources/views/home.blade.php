@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form id="product_add_form" action="#" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="serial_no">Serial No.</label>
                        <input type="text" class="form-control" id="serial_no" name="serial_no">
                    </div>
                    <div class="form-group">
                        <label for="image1">Image 1 File</label>
                        <input type="file" id="image1" name="image1" class="d-block">
                    </div>
                    <div class="form-group">
                        <label for="image2">Image 2 File</label>
                        <input type="file" id="image2" name="image2" class="d-block">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="sendproduct" class="btn btn-primary">Save Product</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered table-striped" id="products_table">
                    <thead>
                    <tr>
                        <th>Image 1</th>
                        <th>Image 2</th>
                        <th>Title</th>
                        <th>Serial No</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('custom-scripts')
    <script>

        function loadTable() {
            $.get('{{ route('products-list') }}', function (res) {
                let rows = '';
                $.each(res, function (i, x) {
                    let tm = `<tr>
                        <td>
                        <a href="{{ url('/') }}/storage/uploads/${x.image1}" target="_blank">
                        <img width="24" src="{{ url('/') }}/storage/uploads/${x.image1}" alt="Image 1 for ${x.title}">
                        </a>
                        </td>
                        <td>
                        <a href="{{ url('/') }}/storage/uploads/${x.image2}" target="_blank">
                        <img width="24" src="{{ url('/') }}/storage/uploads/${x.image2}" alt="Image 2 for ${x.title}">
                        </a>
                        </td>
                        <td>${x.title}</td>
                        <td>${x.serial_no}</td>
                    </tr>`;
                    rows += tm;
                });
                $('#products_table tbody').html(rows);
            }, 'json');
        }

        function sendFormData() {
            let formData = new FormData();
            // populate fields
            let title = $('#title').val();
            let serial_no = $('#serial_no').val();
            let image1 = $('#image1')[0].files[0];// file
            let image2 = $('#image2')[0].files[0];// file
            formData.append('title', title);
            formData.append('serial_no', serial_no);
            formData.append('image1', image1);
            formData.append('image2', image2);

            // send form data
            $.ajax({
                type: 'POST',
                url: '{{ route('create-product') }}',
                data: formData,
                contentType: false,
                processData: false
            }).done(function (response) {
                // if done
                loadTable();
            }).fail(function (data) {
                // if failed
                alert('Failed.');
            });
        }

        $('#product_add_form').submit(function (e) {
            e.stopPropagation();
            e.preventDefault();
            sendFormData();
        });

        $(function () {
            loadTable();
        });
    </script>
@endsection
