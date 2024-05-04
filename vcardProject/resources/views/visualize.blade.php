{{-- resources/views/contacts/index.blade.php --}}

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #343a40;
        }
        table {
            background-color: #ffffff;
            border-collapse: collapse;
        }
        .head {
            display: flex;
            justify-content: space-between;
        }
        th {
            color: black;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #dee2e6;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        button, .button-link {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none; 
            display: inline-block;
        }

        button:hover, .button-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="head">
            <h1>Lista de Contatos</h1>
            <a href="http://127.0.0.1:8000/contacts" class="button-link">Importar Contatos</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome Completo</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Organização</th>
                    <th>Título</th>
                    <th>URL</th>
                    <th>Endereço</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                    <tr>
                        <td>{{ $contact->full_name }}</td>
                        <td>{{ $contact->telephone }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->organization }}</td>
                        <td>{{ $contact->title }}</td>
                        <td>{{ $contact->url }}</td>
                        <td>{{ $contact->address }}</td>
                        <td>{{ $contact->note }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
