<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem MA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background-color: #f5f7fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
        }
        .login-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 2rem;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            color: #1a1a1a;
        }
        .login-logo p {
            font-size: 0.85rem;
            color: #666;
            margin: 0.25rem 0 0 0;
        }
        .form-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #333;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 0.6rem 0.9rem;
            font-size: 0.95rem;
            height: auto;
        }
        .form-control:focus {
            border-color: #333;
            box-shadow: none;
            outline: none;
        }
        .btn-login {
            background-color: #333;
            border: none;
            color: white;
            padding: 0.7rem 1rem;
            font-weight: 500;
            border-radius: 6px;
            width: 100%;
            cursor: pointer;
        }
        .btn-login:hover {
            background-color: #555;
        }
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #999;
            font-size: 0.85rem;
        }
        .test-credentials {
            background: #fafafa;
            border: 1px solid #e0e0e0;
            padding: 1rem;
            border-radius: 6px;
            margin-top: 1.5rem;
            font-size: 0.85rem;
        }
        .test-credentials strong {
            color: #333;
        }
        .test-cred-item {
            margin: 0.5rem 0;
            color: #555;
        }
        .test-cred-item code {
            background: #f0f0f0;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-size: 0.8rem;
        }
        .role-label {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
            color: #666;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <div class="login-logo">
            <h1>Sistem MA</h1>
            <p>IT Asset Management System</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Login failed!</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" 
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Remember me on this device
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-login">Login</button>
        </form>

        <div class="test-credentials">
            <strong>Test Accounts:</strong>
            <div class="test-cred-item">
                <code>admin@test.local</code> <span class="role-label">(Admin)</span>
            </div>
            <div class="test-cred-item">
                <code>technician@test.local</code> <span class="role-label">(Technician)</span>
            </div>
            <div class="test-cred-item">
                <code>viewer@test.local</code> <span class="role-label">(Viewer)</span>
            </div>
            <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #ddd;">
                Password: <code>password</code>
            </div>
        </div>

        <div class="login-footer">
            Version 1.0 — Global Putra International Group
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
