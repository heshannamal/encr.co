<table>
    <thead>
        <tr>
            <th>Date & Time</th>
            <th>User</th>
            <th>Event</th>
            <th>Module</th>
            <th>ID</th>
            <th>Source</th>
            <th>Updates</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($audits as $audit)
            @if ($audit->user_id && $audit->getModified())
                <tr>
                    <td>{{ \Carbon\Carbon::parse($audit->created_at)->format('m/d/Y - H:i') }}
                    </td>
                    <td>{{ $audit->user->name ?? '' }}</td>
                    <td>{{ ucfirst($audit->event) }}</td>
                    <td>
                        @php
                            $str = $audit->auditable_type;
                            $newstr = explode('\\', $str);
                        @endphp
                        {{ end($newstr) }}
                    </td>
                    <td>{{ $audit->auditable_id ?? '' }}</td>
                    <td>
                        @php
                            $sourceArr = [];
                            $sources = $audit->source;
                            if($sources){
                                $sourceArr = json_decode($sources);
                            }
                        @endphp
                        <ul>
                            @foreach ($sourceArr as $key=>$sr)
                                <li>{{ $key.' - '.$sr }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @if ($audit->event == 'updated')
                            <ul>
                                @foreach ($audit->getModified() as $key => $auditUpdate)
                                    <li>{{ ucfirst(str_replace('_', ' ', $key)) }}</li>
                                @endforeach
                            </ul>
                        @elseif ($audit->event == 'created')
                            @foreach ($audit->getModified() as $key => $auditUpdate)
                                @if ($key == 'name' || $key == 'title' || $key == 'task_name')
                                    {{ $auditUpdate['new'] }}
                                @endif
                            @endforeach
                        @elseif ($audit->event == 'deleted')
                            @foreach ($audit->getModified() as $key => $auditUpdate)
                                @if ($key == 'name' || $key == 'title' || $key == 'task_name')
                                    {{ $auditUpdate['old'] }}
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>
                        {{-- @if ($audit->event == 'updated')
                            @if (array_key_exists('password', $audit->getModified()) || array_key_exists('remember_token', $audit->getModified()))
                                <button type="button"
                                    class="btn  btn-sm" disabled><i
                                        class="fas fa-eye-slash"></i></button>
                            @else
                                <button type="button"
                                    class="btn  btn-sm view"
                                    value="{{ $audit->id }}"><i
                                        class="fas fa-eye"></i></button>
                            @endif
                        @elseif ($audit->event == 'created')
                        <button type="button"
                                    class="btn  btn-sm view_creted"
                                    value="{{ $audit->id }}"><i
                                        class="fas fa-eye"></i></button> --}}
                            {{-- @php
                                $str = $audit->auditable_type;
                                $newstr = explode('\\', $str);
                            @endphp
                            @if (end($newstr) == 'DivisionPost')
                                <a href="{{ url('division-inner', $audit->auditable_id) }}"
                                    target="_blank"
                                    class="btn  btn-sm view"><i
                                        class="fas fa-eye"></i></a>
                            @else
                                <a href="{{ $audit->url }}" target="_blank"
                                    class="btn btn-sm view"><i
                                        class="fas fa-eye"></i></a>
                            @endif --}}
                        {{-- @endif --}}
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
