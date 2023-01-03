@if (count($data) > 0)
                        <table id="example3" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Reported By</th>
                                    <th class="no-sort">Post</th>
                                    <th class="no-sort">Reason</th>
                                    <th class="no-sort">Comment</th>
                                    <th class="no-sort">Reported At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $val)
                                <?php
                                $reason = array();
                                $reason[] = (isset($val->incorrect) && !empty($val->incorrect)) ? "Incorrect Post" : '';
                                $reason[] = (isset($val->inappropriate) && !empty($val->inappropriate)) ? "Inappropriate Post" : '';
                                $reason[] = (isset($val->tolls) && !empty($val->tolls)) ? "Tolls" : '';
                                $reason = implode(', ', array_filter($reason));
                                ?>
                                <tr>
                                    <td>{{ $key + 1  }}</td>
                                    <td>{{ $val->user->user_name }}</td>
                                    @if(isset($val->post))
                                    <td>{{ $val->post->post_text }}</td>
                                    @else
                                    <td>--</td>
                                    @endif
                                    <td>{{ (isset($reason) && !empty($reason))?$reason:'' }}</td>
                                    <td>{{ $val->comments }}</td>                        
                                    <td>{{ $val->created_at }}</td>                        
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                    <div class="requests"><div class=""><div class="userInfo mt-2 mb-2 text-center">{{$common['NO_RECORDS']}}</div></div>
                    </div>
                @endif