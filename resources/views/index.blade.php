
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Users list</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Header Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg bg-white navbar-light p-0">
                    <a href="" class="navbar-brand d-block d-lg-none">
                        <h1 class="m-0 display-4 text-primary">Klean</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            
                        </div>
                        @auth
                        <div style="font-weight: bold; color: #333; margin: 10px;">
                            {{ auth()->user()->name }}
                        </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-dark mr-1 d-none d-lg-block">Log out</button>
                            </form>
                        @endauth
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        
        <form method="POST" action="{{ route('users.action') }}">
            @csrf
            <div class="form-check col-lg-5">
                <input class="form-check-input" type="checkbox" id="select-all">
                <label class="form-check-label" for="select-all">Select All</label>
                <button type="submit" name="action" value="delete" class="btn btn-primary">Delete</button>
                <button type="submit" name="action" value="block" class="btn btn-primary">Block</button>
                <button type="submit" name="action" value="unblock" class="btn btn-primary">Unblock</button>
            </div>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Last login</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->last_login_at }}</td>
                        <td>{{ $user->status }}</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="selected_users[]" value="{{ $user->id }}">
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="selected_users[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = event.target.checked;
            });
        });
    </script>
</body>

</html>
