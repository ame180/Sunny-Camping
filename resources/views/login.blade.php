<html>
<head>
    <title>@yield('title', 'Słoneczny Camping - Wicie')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @vite('resources/scss/app.scss')
</head>
<body class="login-page bg-body-secondary">
<div class="login-box">
    <div class="login-logo">
        Login
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <form method="post">
                @csrf
                <div class="input-group mb-3">
                    <input name="email" type="email" class="form-control" placeholder="Email">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control" placeholder="Password">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="form-check">
                            <input type="checkbox" id="remember" name="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">
                                Remember Me
                            </label>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>

    </div>
</div>
</body>
</html>
