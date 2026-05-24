<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .card-subtitle {
            color: #6c757d;
        }

        .card-text {
            color: #495057;
        }

        .qr-code {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-4">User Profile</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">{{ $user->full_name }}</h2>
                <h6 class="card-subtitle mb-2 text-muted">{{ $user->email }}</h6>
                <h6 class="card-subtitle mb-2 text-muted">{{ $user->phone_number  }}</h6>
            </div>
        </div>

        <h2 class="mt-4">Sessions</h2>
        @if ($sessions->count() > 0)
            @foreach ($sessions as $session)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $session->translations->first()->title }}</h5>
                        @if ($session->track && $session->track->translations->count() > 0)
                            <h6 class="card-subtitle mb-2 text-muted">
                                Track: {{ $session->track->translations->first()->title }}
                            </h6>
                        @endif
                        @if ($session->translations->count() > 0)
                            <p class="card-text">
                                {{ $session->translations->first()->description }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p>No sessions found.</p>
        @endif
    </div>
</body>

</html>
