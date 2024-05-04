<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="file"] {
            font-size: 16px;
            margin-bottom: 10px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
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
            text-decoration: none; /* Remove underline from links */
            display: inline-block; /* Allows padding and width to affect the link */
        }

        button:hover, .button-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Cadastrar Contatos</h1>  
    <form action="{{ route('vcards.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <p>Por favor, anexe um arquivo .vcf para upload.</p>
        <input type="file" name="vcard" accept=".vcf" required>
        <button type="submit">Importar contatos</button>
    </form>

    <a href="http://127.0.0.1:8000/contacts/view" class="button-link">Visualizar Contatos</a>

    @if (session('success'))
        <script>alert('{{ session('success') }}');</script>
    @endif

    @if (session('error'))
        <script>alert('{{ session('error') }}');</script>
    @endif
</body>
</html>
