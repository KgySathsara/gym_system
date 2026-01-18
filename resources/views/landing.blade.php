<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitLife Pro | Transform Your Body & Mind</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background: #000;
            color: #fff;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            width: 100%;
            z-index: 1000;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }

        .navbar.scrolled {
            padding: 15px 5%;
            background: rgba(0, 0, 0, 0.95);
        }

        .logo {
            font-size: 28px;
            font-weight: 900;
            background: linear-gradient(135deg, #ff0844, #ffb199);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
        }

        .nav-links {
            display: flex;
            gap: 40px;
            align-items: center;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #ff0844;
            transition: width 0.3s;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .cta-btn {
            padding: 12px 30px;
            background: linear-gradient(135deg, #ff0844, #f70772);
            border: none;
            border-radius: 50px;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 30px rgba(255, 8, 68, 0.4);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 8, 68, 0.6);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1600') center/cover;
            filter: brightness(0.4);
            animation: zoomIn 20s infinite alternate;
        }

        @keyframes zoomIn {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 8, 68, 0.3), rgba(0, 0, 0, 0.7));
        }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 0 20px;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-content h1 {
            font-size: 80px;
            font-weight: 900;
            margin-bottom: 20px;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .gradient-text {
            background: linear-gradient(135deg, #ff0844, #ffb199);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-content p {
            font-size: 22px;
            margin-bottom: 40px;
            opacity: 0.9;
            font-weight: 300;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .btn-primary, .btn-secondary {
            padding: 18px 45px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff0844, #f70772);
            color: #fff;
            border: none;
            box-shadow: 0 15px 40px rgba(255, 8, 68, 0.5);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(255, 8, 68, 0.7);
        }

        .btn-secondary {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
        }

        .btn-secondary:hover {
            background: #fff;
            color: #000;
            transform: translateY(-5px);
        }

        /* Features Section */
        .features {
            padding: 120px 5%;
            background: linear-gradient(180deg, #000, #0a0a0a);
        }

        .section-title {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-title h2 {
            font-size: 50px;
            font-weight: 900;
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 18px;
            opacity: 0.7;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .feature-card {
            background: linear-gradient(135deg, rgba(255, 8, 68, 0.1), rgba(0, 0, 0, 0.5));
            padding: 50px 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 8, 68, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-card:hover {
            transform: translateY(-15px);
            border-color: #ff0844;
            box-shadow: 0 20px 60px rgba(255, 8, 68, 0.3);
        }

        .feature-icon {
            font-size: 60px;
            margin-bottom: 25px;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .feature-card h3 {
            font-size: 26px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .feature-card p {
            opacity: 0.8;
            line-height: 1.6;
        }

        /* Pricing Section */
        .pricing {
            padding: 120px 5%;
            background: #000;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .pricing-card {
            background: linear-gradient(135deg, rgba(255, 8, 68, 0.05), rgba(0, 0, 0, 0.8));
            padding: 50px;
            border-radius: 25px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            transition: all 0.4s;
            position: relative;
        }

        .pricing-card.featured {
            border-color: #ff0844;
            transform: scale(1.05);
            box-shadow: 0 20px 60px rgba(255, 8, 68, 0.4);
        }

        .pricing-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: #ff0844;
        }

        .pricing-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #ff0844;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        .pricing-card h3 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .price {
            font-size: 60px;
            font-weight: 900;
            color: #ff0844;
            margin-bottom: 10px;
        }

        .price span {
            font-size: 20px;
            opacity: 0.7;
        }

        .pricing-features {
            list-style: none;
            margin: 40px 0;
            text-align: left;
        }

        .pricing-features li {
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.8;
        }

        .pricing-features li:before {
            content: '✓';
            color: #ff0844;
            font-weight: bold;
            margin-right: 10px;
        }

        /* Stats Section */
        .stats {
            padding: 100px 5%;
            background: linear-gradient(135deg, #ff0844, #f70772);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 60px;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 60px;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .stat-item p {
            font-size: 18px;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            padding: 60px 5%;
            background: #000;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        footer p {
            opacity: 0.6;
            margin-top: 20px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 45px;
            }

            .hero-content p {
                font-size: 18px;
            }

            .nav-links {
                display: none;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .section-title h2 {
                font-size: 35px;
            }
        }

        /* Scroll animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s;
        }

        .fade-in.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar" id="navbar">
    <div class="logo">FITLIFE PRO</div>
    <div class="nav-links">
        <a href="#features">Features</a>
        <a href="#pricing">Pricing</a>
        <a href="#contact">Contact</a>
        @guest
            <a href="{{ route('login') }}" class="cta-btn" style="text-decoration: none;">Login</a>
            {{-- <a href="{{ route('register') }}" class="btn-secondary" style="text-decoration: none; padding: 12px 30px; font-size: 14px;">Sign Up</a> --}}
        @else
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="cta-btn">Logout</button>
            </form>
        @endguest
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>TRANSFORM YOUR<br><span class="gradient-text">BODY & MIND</span></h1>
        <p>Experience elite fitness training with world-class facilities and expert trainers</p>
        <div class="hero-buttons">
            <a href="{{ route('register') }}" class="btn-primary">Start Your Journey</a>
            <a href="#features" class="btn-secondary">Explore More</a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats">
    <div class="stats-grid">
        <div class="stat-item">
            <h3>5000+</h3>
            <p>Active Members</p>
        </div>
        <div class="stat-item">
            <h3>50+</h3>
            <p>Expert Trainers</p>
        </div>
        <div class="stat-item">
            <h3>98%</h3>
            <p>Success Rate</p>
        </div>
        <div class="stat-item">
            <h3>24/7</h3>
            <p>Gym Access</p>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features" id="features">
    <div class="section-title fade-in">
        <h2>World-Class <span class="gradient-text">Facilities</span></h2>
        <p>Everything you need to achieve your fitness goals</p>
    </div>
    <div class="features-grid">
        <div class="feature-card fade-in">
            <div class="feature-icon">💪</div>
            <h3>Strength Training</h3>
            <p>State-of-the-art equipment and personalized strength programs designed for maximum results.</p>
        </div>
        <div class="feature-card fade-in">
            <div class="feature-icon">🏃</div>
            <h3>Cardio Zones</h3>
            <p>Premium cardio equipment with entertainment systems and heart rate monitoring.</p>
        </div>
        <div class="feature-card fade-in">
            <div class="feature-icon">🧘</div>
            <h3>Yoga & Wellness</h3>
            <p>Dedicated studios for yoga, pilates, and meditation with expert instructors.</p>
        </div>
        <div class="feature-card fade-in">
            <div class="feature-icon">👨‍🏫</div>
            <h3>Personal Training</h3>
            <p>One-on-one sessions with certified trainers tailored to your unique goals.</p>
        </div>
        <div class="feature-card fade-in">
            <div class="feature-icon">🏊</div>
            <h3>Swimming Pool</h3>
            <p>Olympic-sized pool with aqua fitness classes and swim coaching available.</p>
        </div>
        <div class="feature-card fade-in">
            <div class="feature-icon">🥗</div>
            <h3>Nutrition Planning</h3>
            <p>Custom meal plans and nutritional guidance from certified dietitians.</p>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="pricing" id="pricing">
    <div class="section-title fade-in">
        <h2>Choose Your <span class="gradient-text">Plan</span></h2>
        <p>Flexible memberships designed for your lifestyle</p>
    </div>
    <div class="pricing-grid">
        <div class="pricing-card fade-in">
            <h3>Starter</h3>
            <div class="price">$29<span>/mo</span></div>
            <ul class="pricing-features">
                <li>Gym Access (6am-10pm)</li>
                <li>Basic Equipment</li>
                <li>Group Classes</li>
                <li>Locker Room</li>
                <li>Mobile App Access</li>
            </ul>
            <button class="cta-btn" onclick="window.location.href='{{ route('register') }}'">Choose Plan</button>
        </div>
        <div class="pricing-card featured fade-in">
            <div class="pricing-badge">POPULAR</div>
            <h3>Pro</h3>
            <div class="price">$59<span>/mo</span></div>
            <ul class="pricing-features">
                <li>24/7 Gym Access</li>
                <li>All Equipment</li>
                <li>Unlimited Classes</li>
                <li>Personal Trainer (2x/mo)</li>
                <li>Nutrition Consultation</li>
                <li>Pool & Sauna Access</li>
            </ul>
            <button class="cta-btn">Choose Plan</button>
        </div>
        <div class="pricing-card fade-in">
            <h3>Elite</h3>
            <div class="price">$99<span>/mo</span></div>
            <ul class="pricing-features">
                <li>Everything in Pro</li>
                <li>Personal Trainer (8x/mo)</li>
                <li>Custom Meal Plans</li>
                <li>Priority Booking</li>
                <li>Guest Passes (5/mo)</li>
                <li>Recovery & Massage</li>
            </ul>
            <button class="cta-btn">Choose Plan</button>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="logo">FITLIFE PRO</div>
    <p>&copy; 2024 FitLife Pro. Transform Your Life Today.</p>
</footer>

<script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Scroll animations
    const observerOptions = {
        threshold: 0.2,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });

    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>

</body>
</html>
