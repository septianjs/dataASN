<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login WEB Data ASN</title>

    <!-- Mempertahankan CSS Bawaan Anda -->
    <link href="<?= base_url('Assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <!-- Font Modern: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS Kustom untuk Tampilan Modern -->
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Container Utama */
        .login-container {
            display: flex;
            width: 100%;
            max-width: 950px;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /* Bagian Kiri (Gambar & Branding) */
        .login-banner {
            flex: 1.2;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.85) 0%, rgba(58, 12, 163, 0.85) 100%), 
                        url('https://images.unsplash.com/photo-1556761175-5972d9314cd8?auto=format&fit=crop&w=800&q=80') center/cover;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #ffffff;
            position: relative;
        }

        .login-banner h2 {
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }

        .login-banner p {
            font-size: 15px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.85);
        }

        /* Bagian Kanan (Form) */
        .login-form-wrapper {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .login-header {
            margin-bottom: 35px;
        }

        .login-header h3 {
            font-weight: 700;
            color: #1f2937;
            font-size: 26px;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
        }

        /* Styling Input Kustom */
        .input-group-custom {
            position: relative;
            margin-bottom: 22px;
        }

        .input-group-custom i.icon-left {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        /* Styling Ikon Mata (Show/Hide Password) */
        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #4361ee;
        }

        /* Tambahan padding kanan agar teks tidak menabrak ikon mata */
        .input-custom {
            width: 100%;
            padding: 14px 45px 14px 45px; 
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: #374151;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background-color: #f9fafb;
        }

        .input-custom:focus {
            border-color: #4361ee;
            background-color: #ffffff;
            outline: none;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .input-custom:focus + i.icon-left, 
        .input-group-custom:focus-within i.icon-left {
            color: #4361ee;
        }

        /* Checkbox Modern */
        .checkbox-custom {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .checkbox-custom input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: #4361ee;
        }

        .checkbox-custom label {
            color: #4b5563;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin: 0;
        }

        /* Tombol Login */
        .btn-modern {
            width: 100%;
            background: linear-gradient(to right, #4361ee, #3f37c9);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
            background: linear-gradient(to right, #3f37c9, #3a0ca3);
        }

        /* Alert Styling */
        .alert-custom {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }
        
        .alert-custom i {
            margin-right: 10px;
            font-size: 16px;
        }

        /* Responsivitas (Untuk HP) */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 400px;
            }
            .login-banner {
                padding: 40px 30px;
                text-align: center;
                flex: none;
            }
            .login-form-wrapper {
                padding: 40px 30px;
            }
        }
    </style>
</head>

<body>
    
    <div class="login-container">
        <!-- Bagian Kiri: Banner Info -->
        <div class="login-banner">
            <h2>Data ASN</h2>
            <p>Sistem Informasi Manajemen Data ASN. Kelola data dengan mudah, cepat, dan aman.</p>
        </div>

        <!-- Bagian Kanan: Form Login -->
        <div class="login-form-wrapper">
            <div class="login-header">
                <h3>Selamat Datang 👋</h3>
                <p>Silakan masuk ke akun Anda</p>
            </div>
            
            <!-- Alert Login Gagal dari CI4 -->
            <?php if(session()->getFlashdata('error')) :?>
                <div class="alert-custom" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <div><?= session()->getFlashdata("error") ?></div>
                </div>
            <?php endif;?>

            <form role="form" action="<?= base_url('admin/autentikasi-login');?>" method="post">
                <div class="input-group-custom">
                    <input class="input-custom" placeholder="Username" name="username" type="text" autofocus required autocomplete="off">
                    <i class="fas fa-user icon-left"></i>
                </div>
                
                <div class="input-group-custom">
                    <!-- Tambahan ID 'password-field' untuk JS -->
                    <input class="input-custom" id="password-field" placeholder="Password" name="password" type="password" required>
                    <i class="fas fa-lock icon-left"></i>
                    <!-- Ikon Mata -->
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
                
                <div class="checkbox-custom">
                    <label>
                        <input name="remember" type="checkbox" value="Remember Me"> Ingat Saya
                    </label>
                </div>
                
                <button type="submit" class="btn-modern">Masuk Sekarang</button>
            </form>
        </div>
    </div>

    <!-- Script Esensial -->
    <script src="<?= base_url('Assets/js/jquery-1.11.1.min.js'); ?>"></script>
    <script src="<?= base_url('Assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('Assets/js/sweetalert2.min.js'); ?>"></script>
    
    <!-- Script Tampilkan/Sembunyikan Password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#password-field');

        togglePassword.addEventListener('click', function (e) {
            // Mengubah tipe input dari 'password' ke 'text' (dan sebaliknya)
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Mengubah ikon (mata terbuka ke mata tertutup)
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    </script>

    <!-- Script SweetAlert CI4 -->
    <?php if (session()->getFlashdata('success')) : ?>
        <script type="text/javascript">
            $(document).ready(function () {
                swal("Berhasil!", "<?= session()->getFlashdata('success'); ?>", "success");
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('warning')) : ?>
        <script type="text/javascript">
            $(document).ready(function() {
                swal("Peringatan!", "<?= session()->getFlashdata('warning'); ?>", "warning");
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('info')) : ?>
        <script type="text/javascript">
            $(document).ready(function() {
                swal("Info!", "<?= session()->getFlashdata('info'); ?>", "info");
            });
        </script>
    <?php endif; ?>

</body>
</html>