<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gym Management System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Navbar */
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Hero */
        .hero {
            background: url('https://images.unsplash.com/photo-1571019613913-7c19d4b9e7df?auto=format&fit=crop&w=1470&q=80') center/cover no-repeat;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            position: relative;
        }
        .hero::after {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
        }
        .hero .container {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }
        .hero p {
            font-size: 1.2rem;
        }

        /* Features */
        .feature-icon {
            font-size: 50px;
            color: #dc3545;
        }

        /* Pricing */
        .card-pricing {
            border: none;
            border-radius: 10px;
            transition: 0.3s;
        }
        .card-pricing:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* Testimonials */
        .testimonial {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 10px;
        }

        /* Footer */
        footer {
            background: #111;
            color: #fff;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">FitLife Pro</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                @guest
                    <li class="nav-item"><a class="btn btn-danger ms-3" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-outline-light ms-2" href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger ms-2">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>


<!-- Hero Section with Cover Image -->
<section class="hero d-flex align-items-center text-center"
         style="background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPUk93bnX6pUYwLWnn4m5SgAwKPMfSth8v-A&s') no-repeat center center; background-size: cover; position: relative; height: 100vh;">
    <!-- Overlay for better text readability -->
    <div style="position: absolute; top:0; left:0; right:0; bottom:0; background-color: rgba(0,0,0,0.6);"></div>

    <div class="container position-relative" style="z-index: 2;">
        <h1 class="text-white display-4 fw-bold">Manage Your Gym Effortlessly</h1>
        <p class="text-white lead mt-3">Track members, trainers, payments, and attendance all in one system.</p>
        <a href="{{ route('register') }}" class="btn btn-danger btn-lg me-2">Get Started</a>
        <a href="#features" class="btn btn-outline-light btn-lg">Learn More</a>
    </div>
</section>


<!-- Features -->
<section id="features" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Key Features</h2>
            <p class="text-muted">Everything you need to run your gym efficiently</p>
        </div>
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="feature-icon mb-3">🏋️</div>
                <h5>Member Management</h5>
                <p class="text-muted">Add, update and manage gym members easily.</p>
            </div>
            <div class="col-md-4">
                <div class="feature-icon mb-3">👨‍🏫</div>
                <h5>Trainer Management</h5>
                <p class="text-muted">Assign trainers and manage schedules effectively.</p>
            </div>
            <div class="col-md-4">
                <div class="feature-icon mb-3">💳</div>
                <h5>Payments & Plans</h5>
                <p class="text-muted">Track memberships, plans and payments easily.</p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing -->
<section id="pricing" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Pricing Plans</h2>
            <p class="text-muted">Choose a plan that suits your gym</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card card-pricing text-center p-4 shadow-sm">
                    <h5 class="fw-bold">Basic</h5>
                    <h3 class="text-danger">$19 <small>/mo</small></h3>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Up to 50 Members</li>
                        <li>1 Trainer</li>
                        <li>Basic Support</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-danger">Choose Plan</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-pricing text-center p-4 shadow-sm border-danger">
                    <h5 class="fw-bold">Pro</h5>
                    <h3 class="text-danger">$49 <small>/mo</small></h3>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Up to 200 Members</li>
                        <li>5 Trainers</li>
                        <li>Priority Support</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-danger">Choose Plan</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-pricing text-center p-4 shadow-sm">
                    <h5 class="fw-bold">Enterprise</h5>
                    <h3 class="text-danger">$99 <small>/mo</small></h3>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Unlimited Members</li>
                        <li>All Trainers</li>
                        <li>24/7 Support</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-danger">Choose Plan</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About -->
<section id="about" class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <h2 class="fw-bold">About Our Gym System</h2>
                <p class="text-muted">
                    Our Gym Management System helps gym owners manage daily operations, members, trainers, attendance, and payments in one simple platform.
                    Built with Laravel for performance, security, and scalability.
                </p>
                <a href="{{ route('register') }}" class="btn btn-danger">Get Started</a>
            </div>
            <div class="col-md-6">
                <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07c" class="img-fluid rounded shadow" alt="Gym">
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section id="testimonials" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">What Our Users Say</h2>
            <p class="text-muted">Testimonials from gym owners using our system</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial text-center p-4 shadow-sm">
                    <p>"This system has streamlined our gym operations completely!"</p>
                    <h6 class="fw-bold mt-3">John Doe</h6>
                    <small class="text-muted">Gym Owner</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial text-center p-4 shadow-sm">
                    <p>"Managing members and payments has never been easier."</p>
                    <h6 class="fw-bold mt-3">Sarah Lee</h6>
                    <small class="text-muted">Gym Manager</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial text-center p-4 shadow-sm">
                    <p>"The best gym management software I’ve ever used."</p>
                    <h6 class="fw-bold mt-3">Mike Smith</h6>
                    <small class="text-muted">Trainer</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-4 text-center text-white">
    <div class="container">
        <p class="mb-1">&copy; {{ date('Y') }} Gym Management System</p>
        <small>Developed with Laravel & Bootstrap 5</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
