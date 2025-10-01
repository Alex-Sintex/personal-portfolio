<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CSV Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('export') }}">Export CSV</a></li>
            </ul>
        </nav>
        <form method="POST" action="{{ route('import') }}" enctype="multipart/form-data">
            <h3>Import CSV</h3>
            @csrf
            <input type="file" name="document_csv" />
            <input type="submit" value="Import CSV" />
        </form>
    </header>
    <main>
        <h3>Products</h3>
        <ul>
            @forelse ($products as $product)
                <li>
                    {{ $product->name }} {{ $product->description }} ${{ $product->price }}
                </li>
            @empty
                <p>No data.</p>
            @endforelse
        </ul>
    </main>
</body>

</html>
