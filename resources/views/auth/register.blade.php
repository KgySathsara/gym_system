<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - FitLife Pro</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      overflow-x: hidden;
    }

    .register-container {
      display: flex;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(20px);
      border-radius: 25px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      max-width: 1000px;
      width: 100%;
    }

    .register-left {
      flex: 1;
      background: url('https://images.unsplash.com/photo-1598970434795-0c54fe7c0643?auto=format&fit=crop&w=1000&q=80')
        center/cover no-repeat;
      position: relative;
    }

    .register-left::before {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.4);
    }

    .register-left-content {
      position: absolute;
      bottom: 2rem;
      left: 2rem;
      color: #fff;
    }

    .register-left-content h2 {
      font-weight: 700;
      font-size: 2rem;
    }

    .register-left-content p {
      opacity: 0.85;
      font-size: 0.95rem;
    }

    .register-right {
      flex: 1.2;
      padding: 3rem;
      background: rgba(255, 255, 255, 0.95);
    }

    .register-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .register-header .icon {
      font-size: 2.5rem;
      color: #10b981;
      background: rgba(16, 185, 129, 0.1);
      border-radius: 50%;
      padding: 1rem;
      margin-bottom: 1rem;
    }

    .register-header h2 {
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .form-control {
      border-radius: 10px;
      padding: 0.75rem 1rem;
      background: #f8fafc;
      border: 2px solid #e2e8f0;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #10b981;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
      background: #fff;
    }

    .input-group-text {
      background-color: #f1f5f9;
      border: 2px solid #e2e8f0;
      border-right: none;
      color: #475569;
    }

    .btn-success {
      background: linear-gradient(135deg, #10b981, #059669);
      border: none;
      border-radius: 12px;
      font-weight: 600;
      padding: 0.8rem;
      transition: all 0.3s ease;
    }

    .btn-success:hover {
      box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
      transform: translateY(-2px);
    }

    .text-link {
      color: #10b981;
      font-weight: 600;
      text-decoration: none;
    }

    .text-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 992px) {
      .register-container {
        flex-direction: column;
      }
      .register-left {
        height: 250px;
      }
      .register-right {
        padding: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="register-left">
      <div class="register-left-content">
        <h2>Welcome to FitLife Pro</h2>
        <p>Join our fitness community and start your transformation journey today!</p>
      </div>
    </div>

    <div class="register-right">
      <div class="register-header">
        <div class="icon">
          <i class="fas fa-user-plus"></i>
        </div>
        <h2>Create Your Account</h2>
        <p class="text-muted">Fill in the details below to get started</p>
      </div>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Full Name</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name" />
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email" />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" id="password" name="password" required placeholder="Create a password" />
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Confirm password" />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-phone"></i></span>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" />
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
              <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" />
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="address" class="form-label">Address</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-home"></i></span>
            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter your address"></textarea>
          </div>
        </div>

        <div class="mb-4">
          <label for="role" class="form-label">Register as</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
            <select class="form-select" id="role" name="role">
              <option value="member">Member</option>
              <option value="trainer">Trainer</option>
            </select>
          </div>
        </div>

        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-success btn-lg">
            <i class="fas fa-user-plus me-2"></i> Create Account
          </button>
        </div>

        <div class="text-center mt-3">
          <p>
            Already have an account?
            <a href="{{ route('login') }}" class="text-link">Login here</a>
          </p>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
