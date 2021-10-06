<h3> Hello <strong style="color: brown"> Admin </strong></h3>
<br>
<p>Post has been reported by the {{ $data['name'] }} user.</p>
<p><b>Issue :-</b> {{ implode(', ', $data['type']) }}</p>
<p><b>Comment :-</b> {{ $data['comment'] }}</p>
<p><b>Link :- </b> <a href="{{ url('/')."/postData/".$data['post_id'] }}" target="_blank">Click Here</a></p>
<br>
<p>Thanks</p>
<p>Surf Hub Team</p>



