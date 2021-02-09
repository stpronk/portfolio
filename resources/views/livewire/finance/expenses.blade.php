
<thead>
    <tr>
        <th>Name</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Category</th>
        <th>Notes</th>
        <th>Options</th>
    </tr>
</thead>
<tbody>
    @forelse( $expenses as $expense )
        <tr style="background-color: {{ $expense['category']['color'] ?? '' }}">
            <td>{{ $expense['name'] }}</td>
            <td>{{ $expense['amount'] }}</td>
            <td>{{ $expense['type'] }}</td>
            <td>{{ $expense['category']['name'] ?? '' }}</td>
            <td>{{ $expense['notes'] ?? '' }}</td>
            <td>

            </td>
        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="6">There are no expenses yet!</td>
        </tr>
    @endforelse

    <tr>
        <td colspan="6">
            <button class="btn btn-success">Add <i class="fa fa-plus"></i></button>
        </td>
    </tr>
</tbody>
