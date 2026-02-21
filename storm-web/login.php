<?php
session_start();
include "config.php";
include "./assets/components/login-arc.php";



if(isset($_COOKIE['logindata']) && $_COOKIE['logindata'] == $key['token'] && $key['expired'] == "no"){
    $_SESSION['IAm-logined'] = 'yes';
	header("location: panel.php");
}


elseif(isset($_SESSION['IAm-logined'])){
	header('location: panel.php');
	exit;
}


else{ 
	
	?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Storm&thinsp;Breaker &mdash; Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html, body {
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
      background: #07070f;
      color: #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    body {
      background:
        radial-gradient(ellipse at 15% 60%, rgba(124,58,237,.22) 0%, transparent 55%),
        radial-gradient(ellipse at 85% 20%, rgba(56,189,248,.18) 0%, transparent 50%),
        #07070f;
    }

    /* ── Card ── */
    .card {
      width: 100%;
      max-width: 400px;
      margin: 24px;
      background: rgba(13,13,26,.80);
      border: 1px solid rgba(255,255,255,.07);
      border-radius: 20px;
      padding: 44px 40px;
      backdrop-filter: blur(16px);
      box-shadow: 0 32px 80px rgba(0,0,0,.55);
    }

    /* ── Logo ── */
    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 32px;
    }

    .logo svg { width: 36px; height: 36px; flex-shrink: 0; }

    .logo-text {
      font-size: 1.25rem;
      font-weight: 700;
      background: linear-gradient(135deg, #a78bfa, #38bdf8);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -.3px;
    }

    /* ── Heading ── */
    h1 { font-size: 1.5rem; font-weight: 700; margin-bottom: 4px; }
    .sub { font-size: .85rem; color: #64748b; margin-bottom: 28px; }

    /* ── Form ── */
    .field { margin-bottom: 16px; }

    label {
      display: block;
      font-size: .78rem;
      font-weight: 500;
      color: #94a3b8;
      margin-bottom: 6px;
      letter-spacing: .3px;
      text-transform: uppercase;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,255,255,.1);
      border-radius: 10px;
      color: #f1f5f9;
      font-family: inherit;
      font-size: .95rem;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #7c3aed;
      box-shadow: 0 0 0 3px rgba(124,58,237,.18);
    }

    input::placeholder { color: #475569; }

    /* ── Button ── */
    .btn {
      width: 100%;
      margin-top: 8px;
      padding: 13px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, #7c3aed, #0ea5e9);
      color: #fff;
      font-family: inherit;
      font-size: .95rem;
      font-weight: 600;
      letter-spacing: .3px;
      cursor: pointer;
      transition: opacity .2s, transform .15s;
    }

    .btn:hover  { opacity: .88; transform: translateY(-1px); }
    .btn:active { transform: translateY(0); }

    /* ── Error message ── */
    .error-msg {
      margin-top: 14px;
      padding: 10px 14px;
      background: rgba(239,68,68,.12);
      border: 1px solid rgba(239,68,68,.25);
      border-radius: 8px;
      color: #f87171;
      font-size: .83rem;
      text-align: center;
    }

    /* ── Footer ── */
    .footer {
      margin-top: 28px;
      text-align: center;
      font-size: .72rem;
      color: #334155;
    }
  </style>
</head>
<body>

<div class="card">

  <!-- Logo -->
  <div class="logo">
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M13 2L4.09 12.11a1 1 0 0 0 .74 1.67H11l-1 8.22 8.91-10.11a1 1 0 0 0-.74-1.67H13l1-8.22z"
            stroke="url(#lg)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
      <defs>
        <linearGradient id="lg" x1="4" y1="2" x2="20" y2="22" gradientUnits="userSpaceOnUse">
          <stop stop-color="#a78bfa"/>
          <stop offset="1" stop-color="#38bdf8"/>
        </linearGradient>
      </defs>
    </svg>
    <span class="logo-text">StormBreaker</span>
  </div>

  <h1>Welcome back</h1>
  <p class="sub">Sign in to access the control panel</p>

  <form action="" method="POST">
    <div class="field">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus>
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <button class="btn" type="submit">Sign In</button>

    <?php
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['username']) && isset($_POST['password'])){
          $username = $_POST['username'];
          $password = $_POST['password'];
          if(isset($CONFIG[$username]) && $CONFIG[$username]['password'] == $password){
            $_SESSION['IAm-logined'] = $username;
            echo '<script>location.href="panel.php"</script>';
          } else {
            echo '<div class="error-msg">Invalid username or password.</div>';
          }
        }
      }
    ?>
  </form>

  <div class="footer">Storm&thinsp;Breaker &mdash; Authorized access only</div>
</div>

</body>
</html>



	<?php
}

?>