<h1>Panel del Jefe de Cocina</h1>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ordenes as $orden)
        <tr>
            <td>{{ $orden->id }}</td>
            <td>{{ $orden->estado }}</td>
            <td>
                <form action="{{ route('cocina.marcarLista', $orden->id) }}" method="POST">
                    @csrf
                    <button type="submit">Marcar como Lista</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>