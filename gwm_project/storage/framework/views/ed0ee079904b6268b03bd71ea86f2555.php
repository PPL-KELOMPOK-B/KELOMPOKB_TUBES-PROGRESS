<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GWM Monitor - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Inter font for clean, modern look similar to the design -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #033a7b;
            --light-blue: #6392c9;
            --bg-left: #689bd4;
            --text-dark: #000000;
            --text-gray: #6b7280;
            --border-color: #e5e7eb;
            --input-border: #d1d5db;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: var(--text-dark);
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Split screen layout */
        .split-layout {
            display: flex;
            width: 100%;
            height: 100%;
        }

        /* Left Side: Branding / Info */
        .left-side {
            flex: 1;
            /* Simple wavy background using linear gradients and a solid tone simulating the water */
            background-color: var(--bg-left);
            background-image:
                radial-gradient(ellipse at center, rgba(255, 255, 255, 0.1) 0%, transparent 70%),
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255, 255, 255, 0.03) 10px, rgba(255, 255, 255, 0.03) 20px);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem 2rem;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        /* Simulate the fluid waves with absolute elements */
        .left-side::before,
        .left-side::after {
            content: '';
            position: absolute;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            animation: moveWaves 15s ease-in-out infinite alternate;
        }

        .left-side::before {
            top: -10%;
            left: -10%;
            width: 120%;
            height: 120%;
        }

        .left-side::after {
            bottom: -20%;
            right: -20%;
            width: 150%;
            height: 150%;
            animation-direction: alternate-reverse;
            background: linear-gradient(to top right, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        }

        @keyframes moveWaves {
            0% {
                transform: scale(1) rotate(0deg);
            }

            100% {
                transform: scale(1.1) rotate(10deg);
            }
        }

        .left-content {
            position: relative;
            z-index: 10;
            max-width: 450px;
        }

        .left-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .left-content p {
            font-size: 1.15rem;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            font-weight: 400;
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 2.5rem;
        }

        .feature {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }

        .feature svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .feature span {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        /* Right Side: Form */
        .right-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background-color: #ffffff;
        }

        .login-container {
            width: 100%;
            max-width: 460px;
        }

        .login-container h2 {
            font-size: 2rem;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .subtitle {
            color: var(--text-gray);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .tab {
            padding: 0.75rem 0;
            margin-right: 2rem;
            background: none;
            border: none;
            font-size: 0.95rem;
            font-weight: 600;
            color: #9ca3af;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            font-family: inherit;
            transition: all 0.2s;
        }

        .tab.active {
            color: var(--primary-blue);
            border-bottom-color: var(--primary-blue);
        }

        .tab:hover:not(.active) {
            color: var(--text-gray);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 0.5rem;
        }

        label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #374151;
            letter-spacing: 0.5px;
        }

        .forgot-pwd {
            font-size: 0.8rem;
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper>svg {
            position: absolute;
            left: 1rem;
            color: #9ca3af;
            z-index: 10;
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 1px solid var(--input-border);
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--text-dark);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-wrapper input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--light-blue);
            box-shadow: 0 0 0 3px rgba(99, 146, 201, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            cursor: pointer;
            color: #9ca3af;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
            z-index: 10;
        }

        .toggle-password:hover {
            color: var(--primary-blue);
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 1rem;
            font-family: inherit;
        }

        .btn-submit:hover {
            background-color: #022b5e;
        }

        .footer {
            margin-top: 4rem;
            text-align: center;
            font-size: 0.8rem;
            color: #9ca3af;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .split-layout {
                flex-direction: column;
            }

            .left-side {
                display: none;
                /* Hide branding on very small screens or make it smaller */
            }

            .right-side {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>

    <div class="split-layout">
        <!-- Left Branding Side -->
        <div class="left-side">
            <div class="left-content">
                <h1>GWM</h1>
                <p>The Fluid Authority. Empowering village officers with real-time water data insights.</p>

                <div class="features">
                    <div class="feature">
                        <!-- Chart Graphic Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                            <polyline points="2 12 6 8 12 14 22 4"></polyline>
                        </svg>
                        <span>REAL-TIME</span>
                    </div>

                    <div class="feature">
                        <!-- Accurate/Rosette Graphic Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M12 2l3.09 3.09L19.46 3.8l-1.28 4.29L22 12l-3.82 3.91 1.28 4.29-4.37-1.29L12 22l-3.09-3.09-4.37 1.29 1.28-4.29L2 12l3.82-3.91-1.28-4.29 4.37 1.29L12 2z" />
                            <polyline points="9 12 11 14 15 10" />
                        </svg>
                        <span>ACCURATE</span>
                    </div>

                    <div class="feature">
                        <!-- Sustainable/Globe Graphic Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path
                                d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                            </path>
                        </svg>
                        <span>SUSTAINABLE</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Form Side -->
        <div class="right-side">
            <div class="login-container">
                <h2>Selamat Datang</h2>
                <p class="subtitle">Masuk ke dashboard untuk memantau otoritas air.</p>

                <div class="tabs">
                    <button class="tab active" type="button" data-role="petugas">Login Petugas</button>
                    <button class="tab" type="button" data-role="admin">Login Admin</button>
                </div>

                <?php if($errors->has('roleError')): ?>
                    <div
                        style="background: #fef2f2; color: #ef4444; border: 1px solid #fca5a5; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500; text-align: center;">
                        <?php echo e($errors->first('roleError')); ?>

                    </div>
                <?php endif; ?>

                <?php if($errors->has('email') && !$errors->has('roleError')): ?>
                    <div
                        style="background: #fef2f2; color: #ef4444; border: 1px solid #fca5a5; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500; text-align: center;">
                        <?php echo e($errors->first('email')); ?>

                    </div>
                <?php endif; ?>

                <form action="/login" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="login_type" id="login_type" value="petugas">
                    <!-- Email Field -->
                    <div class="form-group">
                        <div class="label-row">
                            <label for="email">EMAIL</label>
                        </div>
                        <div class="input-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <input type="text" id="email" name="email" placeholder="petugas(kecamatan)@gmail.com"
                                required>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <div class="label-row">
                            <label for="password">PASSWORD</label>
                            <a href="#" class="forgot-pwd">Lupa Password?</a>
                        </div>
                        <div class="input-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input type="password" id="password" name="password" placeholder="••••••••" required
                                style="padding-right: 3rem;">
                            <button type="button" id="togglePassword" class="toggle-password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="eye-icon">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        Masuk
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </form>

                <div class="footer">
                    © 2026 Gunungkidul Water Monitor.<br>The Fluid Authority.
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching logic for visual purposes
        const tabs = document.querySelectorAll('.tab');
        const loginTypeInput = document.getElementById('login_type');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Set explicit hidden role
                loginTypeInput.value = tab.getAttribute('data-role');
            });
        });

        // Toggle Password Visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // toggle the eye slash icon
            this.innerHTML = type === 'password' ?
                `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>` :
                `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>`;
        });
    </script>
</body>

</html><?php /**PATH C:\Users\TEGAR\Documents\KELOMPOKB_TUBES-PROGRESS\gwm_project\resources\views/welcome.blade.php ENDPATH**/ ?>