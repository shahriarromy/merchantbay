@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row boxWrap">
        @foreach ($headings as $key=>$heading)
            <div class="col-md-3">
                <div class="box">
                    <div class="imgContainer">
                        @empty($heading->headings_image)
                            <td><img src="https://dummyimage.com/250x250/83e077/0011ff.jpg&text=250x250" class="img-thumbnail" alt=""></td>
                        @else
                            <td><img src="{{$heading->headings_image}}" class="img-thumbnail" alt=""></td>
                        @endempty
                    </div>
                    <div class="headings_chapter">{{$heading->hs_category['chapter']}}</div>
                    <div class="headings_title">{{$heading->headings_title}}</div>
                    <a class="custom-green rfq" href="https://www.merchantbay.com/create-rfq" target="_blank">Send Query</a>
                    <button class="custom-white-button">
                        View Details
                    </button>
                    <a href="{{ url('/heading_desc/'.$heading->id) }}" class="stretched-link full-anchor"></a>
                </div>
            </div>
            @if(($key+1) % 4 == 0)
    </div><div class="row boxWrap">
            @endif
        @endforeach
    </div>
    {{ $headings->render() }}
</div>
@endsection
