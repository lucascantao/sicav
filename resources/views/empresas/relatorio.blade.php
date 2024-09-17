<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Empresas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .btn-print {
            background-color: #ffffff;
            color: #000000;
            border: 1px solid #000000;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            text-align: center;
            display: inline-block;
            text-decoration: none;
        }

        .btn-print:hover {
            background-color: #f0f0f0;
        }

        .print-header, .print-footer {
            text-align: center;
            background: #ffffff;
            color: #000000;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 20px 0;
            padding: 0;
            box-shadow: none;
            background: #f9f9f9;
        }

        h5 {
            margin: 0 0 10px 0;
            font-size: 16pt;
            color: #000000;
        }

        hr {
            border: 0;
            border-top: 2px solid #000000;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
            color: #333;
            font-size: 10pt;
        }

        th {
            background-color: #ffffff;
            color: #000000;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12pt;
                color: #333;
                background: #fff;
            }

            .print-header, .print-footer {
                width: 100%;
                text-align: center;
                background: #ffffff;
                color: #000000;
                padding: 10px;
            }

            .print-header {
                top: 0;
            }

            .print-footer {
                bottom: 0;
            }

            .no-print {
                display: none;
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            width: 60px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="print-header">
        <div class="logo">
            <img src="{{ asset('images/brasao-pa.png') }}" alt="Brasão do Pará">
        </div>
        <h3>GOVERNO DO ESTADO DO PARÁ</h3>
        <h3>SECRETARIA DE MEIO AMBIENTE E SUSTENTABILIDADE</h3>
    </div>

    <div class="container">
        <div class="text-center no-print">
            <a href="javascript:window.print();" class="btn-print">Imprimir Relatório</a>
        </div>
        <div class="card-body">
            <h3 class="card-title text-center">Relatório de Empresas</h3>
            <hr>
            @if($empresas->isEmpty())
                <p class="card-text">Nenhuma empresa encontrada com os critérios informados.</p>
            @else
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col" class="text-center">CNPJ</th>
                            <th scope="col" class="text-center">Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empresas as $empresa)
                            <tr>
                                <td>{{ $empresa->nome }}</td>
                                <td class="text-center">{{ $empresa->cnpj }}</td>
                                <td class="text-center telefone">{{ $empresa->tel_contato }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="print-footer">
        <p>DTI/GESIS © 2024 Secretaria de Meio Ambiente e Sustentabilidade.</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.telefone').forEach(function(element) {
                var telefone = element.textContent.trim();
                telefone = telefone.replace(/\D/g, '');
                if (telefone.length === 11) {
                    telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                } else if (telefone.length === 10) {
                    telefone = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                }
                element.textContent = telefone;
            });
        });
    </script>
</body>
</html>
