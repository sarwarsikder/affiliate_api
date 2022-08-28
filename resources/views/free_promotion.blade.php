@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="table-responsive" id="table_data">


                    </div>
                </div>
                <br>
                <div class="table-responsive" id="pagination">


                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('/api/auth/products/?filter[claim]=1') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': "Bearer " + "{{$token}}"
                    },
                    success: function (response) {
                        $('#table_data').html(response.data);
                        var html = '';
                        $.each(response.data, function (i, val) {
                            html += '<div class="card-body">'
                            html += ' <div class="card">'
                            html += '<div class="card-body">'
                            html += '<h5 class="card-title">' + val.product_name + '</h5>'
                            html += '<img class="img-thumbnail" src="https://fakeimg.pl/250x100/"><br>'
                            html += '<div class="float-left"><a href="" class="btn btn-primary pull-right">Follow</a></div>'
                            html += '</div>'
                            html += '</div>'
                            html += '</div>';

                            $('#table_data').html(html);

                        });

                        var pagination = '<ul class="pagination">'
                        pagination += '<li class="page-item"><a class="page-link pagination_page"  p_href="' + response.links.prev + '">Previous</a></li>'
                        pagination += '<li class="page-item"><a class="page-link pagination_page" p_href="' + response.links.next + '">Next</a></li>'
                        pagination += '</ul>';

                        $('#pagination').html(pagination);

                        $('.pagination_page').unbind().bind('click', function () {
                            var href = $(this).attr('p_href')
                            alert("TEST");
                            console.log(href);
                            if (href != null) {
                                pagination_url(href);
                            }

                        });
                    }
                });

        });

        function pagination_url(url) {
            $.ajax({
                type: 'GET',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': "Bearer " + "{{$token}}"
                },
                success: function (response) {
                    $('#table_data').html(response.data);
                    var html = '';
                    $.each(response.data, function (i, val) {
                        html += '<div class="card-body">'
                        html += ' <div class="card">'
                        html += '<div class="card-body">'
                        html += '<h5 class="card-title">Card title</h5>'
                        html += '<p class="card-text">Some quick example text to build on the card title and make up the bulk of</p>'
                        html += '<a href="#" class="btn btn-primary">Go somewhere</a>'
                        html += '</div>'
                        html += '</div>'
                        html += '</div>';

                        $('#table_data').html(html);

                    });

                    var pagination = '<ul class="pagination">'
                    pagination += '<li class="page-item"><a class="page-link pagination_page"  p_href="' + response.links.prev + '">Previous</a></li>'
                    pagination += '<li class="page-item"><a class="page-link pagination_page" p_href="' + response.links.next + '">Next</a></li>'
                    pagination += '</ul>';

                    $('#pagination').html(pagination);

                    $('.pagination_page').unbind().bind('click', function () {
                        var href = $(this).attr('p_href')

                        if (href != null) {
                            pagination_url(href);
                        }

                    });
                }
            });
        }

    </script>
@endpush
