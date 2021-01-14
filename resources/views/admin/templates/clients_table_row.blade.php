<tr v-for="client in clients">
    <th scope="row">@{{ client.id }}</th>
    <td>@{{ /* client.first_name */ }} + @{{ /*client.last_name */ }}</td>
    <td>@{{ /* client.arrival_date */ }}</td>
    <td>@{{ /* client.departure_date */ }}</td>
    <td>@{{ /* client.sector */ }}</td>
    <td>@{{ /* client.adults */ }} + @{{ client.children }}</td>
    <td>@{{ /* client.electricity */ }}</td>
    <td>@{{ /* client.small_places */ }} + @{{ /* client.big_places */ }}</td>
    <td>@{{ /* client.discount */ }}%</td>
    <td>@{{ /* client.price */ }}</td>
    <td>@{{ /* client.comment */ }}</td>
    <td class="button-column">
        <div class="button-container">
            <div class="button-wrapper">
                <a class="btn btn-primary rounded-0"
                   href="clients/edit/@{{ client.id }}">
                    <i class="far fa-sticky-note"></i>
                </a>
            </div>
            <form class="button-wrapper" method="POST"
                  action="clients/delete/@{{ client.id }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger rounded-0">
                    <i class="far fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
