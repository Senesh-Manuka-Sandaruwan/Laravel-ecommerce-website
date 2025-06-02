@extends('layouts.master-without-nav')

@section('title', 'Sign Up')
@section('body-class', 'bg-light')

@section('content')
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-2">
                                <div class="text-center mt-2">
                                    <a href="{{ route('welcome') }}" class="text-decoration-none">
                                        <div class="logo-wrapper">
                                            <img src="{{ asset('assets/img/favicon.png') }}" alt="Crunchy Sweets Logo"
                                                class="me-2 mb-2" style="height: 30px; width: 30px;">
                                            <h2 class="mt-3 mb-0 d-inline-block"
                                                style="font-family: 'Lora', serif; color: var(--primary-dark);">Crunchy
                                                Sweets</h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="card shadow-lg border-0 rounded-lg mt-4"
                                style="border-radius: 15px; overflow: hidden;">
                                <div class="card-header bg-gradient-primary py-3">
                                    <h3 class="text-center font-weight-light my-2"
                                        style="font-family: 'Lora', serif; color: var(--dark-color);">
                                        <i class="fas fa-cookie-bite me-2"></i>Create Your Account
                                    </h3>
                                </div>
                                <div class="card-body p-4 p-md-5">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('signup.submit') }}">
                                        @csrf
                                        <div class="form-floating mb-4">
                                            <input class="form-control custom-input" id="inputName" name="name" type="text"
                                                placeholder="Your Name" required value="{{ old('name') }}" />
                                            <label for="inputName"><i class="fas fa-user me-2"></i>Full Name</label>
                                        </div>
                                        <div class="form-floating mb-4">
                                            <input class="form-control custom-input" id="inputEmail" name="email"
                                                type="email" placeholder="name@example.com" required
                                                value="{{ old('email') }}" />
                                            <label for="inputEmail"><i class="fas fa-envelope me-2"></i>Email
                                                Address</label>
                                        </div>
                                        <div class="form-floating mb-4">
                                            <input class="form-control custom-input" id="inputPassword" name="password"
                                                type="password" placeholder="Password" required />
                                            <label for="inputPassword"><i class="fas fa-lock me-2"></i>Password</label>
                                            <div id="togglePassword"
                                                class="position-absolute end-0 top-50 translate-middle-y me-3"
                                                style="cursor: pointer;">
                                                <i class="fas fa-eye-slash text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-4">
                                            <input class="form-control custom-input" id="inputPasswordConfirmation"
                                                name="password_confirmation" type="password" placeholder="Confirm Password"
                                                required />
                                            <label for="inputPasswordConfirmation"><i class="fas fa-lock me-2"></i>Confirm
                                                Password</label>
                                        </div>
                                        <div class="d-grid gap-2 mb-4">
                                            <button type="submit"
                                                class="btn btn-primary btn-lg py-3 rounded-pill shadow-sm">
                                                <i class="fas fa-user-plus me-2"></i>Create Account
                                            </button>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-muted small">By signing up, you agree to our <a href="#"
                                                    class="text-decoration-none">Terms of Service</a> and <a href="#"
                                                    class="text-decoration-none">Privacy Policy</a></p>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-4 bg-light">
                                    <div class="small">
                                        <span class="text-muted">Already have an account?</span>
                                        <a href="{{ route('login') }}"
                                            class="text-decoration-none ms-2 text-primary fw-bold">
                                            Sign in now <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4 mb-5">
                                <p class="small" style="color: var(--primary-dark);">© 2025 Crunchy Sweets. All rights
                                    reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --primary-color: #FFECB3;
            --primary-dark: #FFD54F;
            --primary-light: #FFF8E1;
            --secondary-color: #D81B60;
            --secondary-dark: #880E4F;
            --accent-color: #7CB342;
            --dark-color: #5D4037;
            --light-color: #F5F5F5;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--primary-light);
            background-image: url('https://images.pexels.com/photos/1028714/pexels-photo-1028714.jpeg?auto=compress&cs=tinysrgb&w=1920');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .logo-wrapper {
            position: relative;
            display: inline-block;
            padding: 1rem;
        }

        .logo-wrapper::before,
        .logo-wrapper::after {
            content: '🧁';
            position: absolute;
            font-size: 1.5rem;
            opacity: 0.7;
            animation: float 3s ease-in-out infinite;
            color: var(--secondary-color);
        }

        .logo-wrapper::before {
            left: -30px;
            top: 50%;
            transform: translateY(-50%);
        }

        .logo-wrapper::after {
            right: -30px;
            top: 50%;
            transform: translateY(-50%);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(-50%) translateX(0);
            }

            50% {
                transform: translateY(-50%) translateX(5px);
            }
        }

        .form-group label {
            color: var(--dark-color);
            font-weight: 500;
        }

        .form-check-input:checked {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Lora', serif;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--dark-color);
            color: var(--dark-color);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 213, 79, 0.4);
        }

        .btn-primary:active {
            background-color: var(--dark-color) !important;
            border-color: var(--primary-light) !important;
            color: white !important;
        }

        .text-primary {
            color: var(--dark-color);
        }

        .text-primary:hover {
            color: var(--secondary-color);
        }

        .custom-input {
            border-radius: 10px;
            padding-left: 15px;
            height: 58px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .custom-input:focus {
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 0.25rem rgba(255, 213, 79, 0.25);
        }

        .custom-checkbox:checked {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
        }

        .card {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .alert-danger {
            background-color: #FFEBEE;
            border-color: #EF9A9A;
            color: #C62828;
        }

        @media (max-width: 768px) {
            .col-lg-6 {
                padding: 0 15px;
            }

            .logo-wrapper::before,
            .logo-wrapper::after {
                display: none;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('inputPassword');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    const eyeIcon = togglePassword.querySelector('i');
                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                });
            }

            // Animation for form elements
            const formElements = document.querySelectorAll('.form-floating, .form-group, .d-grid, .text-center');
            let delay = 0;

            formElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, delay);

                delay += 100;
            });
        });
    </script>
@endpush