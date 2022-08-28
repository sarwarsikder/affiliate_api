@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <button type="button" class="btn btn-secondary filter-shop" onclick="pagination_url('{{url('/api/auth/shops/?filter[recent_added]=1')}}')">Recently Added</button>
                <button type="button" class="btn btn-secondary" onclick="pagination_url('{{url('/api/auth/shops/?filter[follow]=1')}}')">Following</button>
                <br>
                <br>
                <div class="card">
                    <div class="card-header">{{ __('Shop List') }}</div>

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
                url: "{{ url('/api/auth/shops/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': "Bearer " + "{{$token}}"
                },
                success: function (response) {
                    var html = '';
                    $.each(response.data, function (i, val) {
                        html += '<div class="card-body">'
                        html += ' <div class="card">'
                        html += '<div class="card-body">'
                        html += '<a href="shop-details/' + val.id + '"><h5 class="card-title">' + val.shop_name + '</h5></a>'
                        html += '<span class="badge badge-primary" style="background: #0a53be">' + val.shop_category.name + '</span>'
                        html += '<p class="card-title">' + val.shop_benefits + '</p>'


                        html += '<span class="glyphicon glyphicon-map-marker">Penang</span>'
                        if (val.shop_following) {
                            html += '<div class="float-left"><a href="" class="btn btn-primary pull-right">Following</a></div>'
                        } else {
                            html += '<div class="float-left"><a href="" class="btn btn-primary pull-right">Follow</a></div>'
                        }
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
                        html += '<a href="shop-details/' + val.id + '"><h5 class="card-title">' + val.shop_name + '</h5></a>'
                        html += '<span class="badge badge-primary" style="background: #0a53be">' + val.shop_category.name + '</span>'
                        html += '<p class="card-title">' + val.shop_benefits + '</p>'
                        html += '<span class="glyphicon glyphicon-map-marker">Penang</span>'

                        if (val.shop_following) {
                            html += '<div class="float-left"><a href="" class="btn btn-primary pull-right">Following</a></div>'
                        } else {
                            html += '<div class="float-left"><a href="" class="btn btn-primary pull-right">Follow</a></div>'
                        }
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
