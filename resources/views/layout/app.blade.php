<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}">
    <title>Primaacademie - @yield('title')</title>
    <style>
        .btn-airbnb {
            background-color: #ff385c;
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            transition: 0.3s;
        }

        .btn-airbnb:hover {
            background-color: #fff;
            color: #ff385c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 56, 92, 0.3);
        }

        input.form-control:focus {
            border-color: #ff385c;
            box-shadow: 0 0 0 0.2rem rgba(255,56,92,0.25);
        }
        
        .hover-bg-light:hover {
            background-color: #f8f9fa;
        }

        .bg-rose {
            background-color: #ff385c;
            color: #fff;
        }

        .text-rose {
            color: #ff385c;
        }

    </style>
</head>
<body>
    <div>
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
