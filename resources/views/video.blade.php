<form role="form" name="uploader" method="POST" action="{{ route('trimmer') }}"
enctype="multipart/form-data">
    @csrf 
    <input type="text" name='text'>
    <input type="file" name='files[]' multiple>
    <input type="submit" value="upload">
</form>


@if($media??"")
    <p>{{$text}}</p>
    
    <video width="200" height="150" controls="true">
    <source src="{{ asset('storage/videos/'.$media) }}" type="" />
    </video>
        
    
@endif