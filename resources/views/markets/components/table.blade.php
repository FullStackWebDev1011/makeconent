@foreach($activeSells as $key=>$sell)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $sell->category->title }}</td>
        <td class="text-capitalize">{{ $sell->status }}</td>
        <td>{{ $sell->nChars }}</td>
        <td>{{ $sell->rate }}</td>
        <td>{{ $sell->budget }}</td>
        <td>{{ $sell->keyword }}</td>
        <td>
            <a class="btn btn-primary" href="{{ url('/sells/buy/'.$sell->id)}}">
                Buy It
            </a>
        </td>
    </tr>
@endforeach