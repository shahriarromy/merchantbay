@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="img-container">
                    @empty($headings->headings_image)
                        <img src="https://dummyimage.com/250x250/83e077/0011ff.jpg&text=250x250" class="img-thumbnail" alt="">
                    @else
                        <img src="{{$headings->headings_image}}" class="img-thumbnail" alt="">
                    @endempty
                </div>
            </div>
            <div class="col-md-8">
                <h5 class="color-green fs-18 mb10 fwb">Heading ID: <span
                        class="badge badge-success fs-18">{{$headings->id}}</span></h5>
                <h5 class="color-green fs-18 mb10 fwb">Heading Title: <span
                        class="font-weight-normal">{{$headings->headings_title}}</span></h5>
                <h5 class="color-green fs-18 mb10 fwb">Heading Chapter: <span
                        class="font-weight-normal">{{$headings->hs_category['chapter']}}</span></h5>
                <h5 class="color-green fs-18 mb10 fwb">Heading Section: <span
                        class="font-weight-normal">{{$headings->hs_category['section']}}</span></h5>
                <h5 class="color-green fs-18 mb10 fwb">Exported to: <span
                        class="font-weight-normal">{{$country_count}} Countries <span class="fs-11">(FY {{array_key_first($usd)}} to FY {{array_key_last($usd)}})</span></span></h5>
                <h5 class="color-green fs-18 fwb">Export value earned: <span
                        class="font-weight-normal"><strong>&#36;{{$totalUSD['amount']}}</strong> {{$totalUSD['currencyFormat']}} <span class="fs-11">(FY {{array_key_first($usd)}} to FY {{array_key_last($usd)}})</span></span></h5>
            </div>
        </div>

        @if(!empty($usd))
            <div class="chartOuter">
                <div class="row chart_before">
                    <div class="col-md-12">
                        <div class="country count">
                            <label for="">See the fiscal year-wise export scenario: Bangladesh to </label>
                            <select class="form-control m-bot15" id="changeCountry" onchange="myFunction()">
                                <option value="0">All Countries</option>
                                @foreach($country as $val)
                                    <option value="{{$val['id']}}">{{$val['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="abc" style="height: 100%; width: 100%;">
                            {{--                        {!! $chart->render() !!}--}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="aligncenter"><button class="btn-green btn-big" onclick="window.open('https://www.merchantbay.com/create-rfq')">Send RFQ</button></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{url('post-rfq')}}" method="post" class="form-horizontal"><br><br>
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <h4>Ask for Merchant Assistance</h4><br>
                    <div class="form-group">
                        <label for="rfq_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="rfq_name" name="rfq_name" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rfq_email" class="col-sm-2 control-label">E-mail</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="rfq_email" name="rfq_email" placeholder="E-mail" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rfq_company" class="col-sm-2 control-label">Company name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="rfq_company" name="rfq_company" placeholder="Company name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rfq_description" class="col-sm-2 control-label">Describe what you looking for</label>
                        <div class="col-sm-10">
                            <textarea name="rfq_description" class="form-control" rows="8" required placeholder="Describe what you looking for"></textarea>
                        </div>
                    </div>
                    <div class="aligncenter"><button class="btn-green btn-big">SUBMIT</button></div>
                </form>
            </div>

        </div>

        <script>
            //load_data();
            myFunction()
            function apply_changes(response) {
                $(function () {
                    new Highcharts.Chart({
                        chart: {
                            renderTo: "abc",
                            backgroundColor: 'rgba(204,204,204,0.1)',
                            type: 'line'
                        },
                        title: {
                            text: "Export Chart",
                            x: -20 //center
                        },
                        credits: {
                            enabled: false
                        },
                        xAxis: {
                            title: {
                                text: "Fiscal Years"
                            },
                            categories: response.labels,
                        },
                        yAxis: {
                            title: {
                                text: response.yaxis
                            },
                            plotLines: [{
                                value: 0,
                                height: response.max,
                                width: 1,
                                color: '#808080'
                            }]
                        },
                        plotOptions: {
                            series: {
                                color: "#55A860"
                            },
                        },
                        legend: {},
                        series: [{
                            name: "Export data for heading {{$headings->id}}",
                            data: response.value
                        }]
                    });
                });
                $('.highcharts-background').attr('fill','rgba(204,204,204,0.1)');
            }

            function myFunction() {
                let changeCountry = document.getElementById("changeCountry");
                let _token = $('meta[name="csrf-token"]').attr('content');
                let url;
                if (changeCountry.value > 0) {
                    url = '/ajaxchart';
                } else {
                    url = '/ajaxchartinit';
                }
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: 'json',
                    data: {
                        heading_id: {{$headings->id}},
                        country_id: changeCountry.value,
                        _token: _token,
                    },
                    success: function (response) {
                        apply_changes(response);
                    },
                });
            }
            function load_data(id="") {
                let _token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "/loadmore",
                    type: "post",
                    async: false,
                    cache: false,
                    data: {
                        id: id,
                        _token: _token,
                    },
                    success: function (response) {
                        //console.log(response);
                        $('#load_more').remove();
                        $('#suppliers').append(response);
                    },
                });
            }

            $(document).ready(function () {

                $(document).on('click', '#load_more_button', function(){
                    let id = $(this).data('id');
                    $('#load_more_button').html('<strong>Loading...</strong>');
                    load_data(id);
                });
                $('.highcharts-background').attr('fill','rgba(204,204,204,0.1)');
            });
        </script>
    </div>
@endsection
