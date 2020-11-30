
    <h1>video uploader</h1>
    <form action="{{route('videoUploader')}}" role="form" id="postForm" name="postForm" method="POST" enctype="multipart/form-data">
        @csrf
    <input type="file" name="files[]" multiple ><br/>
        <input  name="type" type="text">
        <input type="submit"  value="upload">
    </form>


<p>{{$data ??""}}</p>

{{-- {{dd($imageArray ??"")}} --}}
@if (!empty($imageArray))
@foreach ($imageArray as $image)
{{-- <img src="{{ asset('storage/images/'.$image) }}" alt="image"> --}}
<iframe src="{{ asset('storage/videos/'.$image) }}" frameborder="0" width="250" height="200" allowfullscreen></iframe>
@endforeach
@endif