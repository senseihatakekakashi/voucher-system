@props(['data'])

@if (isset($data))
    <table class="table table-hover">
        <thead>
            <tr>
                @foreach($data['columns'] as $column)
                    <th scope="col">{{ $column }}</th>
                @endforeach
                @if(isset($data['options']) && count($data['options']) > 0)
                    <th scope="col">Options</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data['rows'] as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                    @if(isset($data['options']) && count($data['options']) > 0)
                        <td>
                            @foreach($data['options'] as $option)
                                @php $key = $row[$option['idColumn']]; @endphp 
                                @if ($option['label'] === 'Delete')
                                    {{-- route('name.destroy', $key) --}}
                                    <form id="deleteForm{{ $key }}" method="POST" action="{{ $option['route'] . $key }}" class="d-inline">
                                        @csrf
                                        @method('delete')
                                    
                                        <button type="button" class="btn btn-link text-decoration-none delete-button" data-id="{{ $key }}">
                                            {{ $option['label'] }}
                                        </button>
                                    </form>        
                                @else
                                    <a href="{{ $option['route'] . $key }}" class="mx-2">{{ $option['label'] }}</a>
                                @endif                                
                            @endforeach
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Unable to Create a Table without a Data.</p>
@endif
