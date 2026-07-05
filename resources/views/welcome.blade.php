<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
  <title>PANTAS · Pangan Tanpa Sisa</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    /* ===== RESET ===== */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', 'Manrope', sans-serif;
      background: #F8FAFC;
      color: #0F172A;
      overflow-x: hidden;
      line-height: 1.6;
    }

    /* ===== SPLASH SCREEN ===== */
    #splash {
      position: fixed;
      inset: 0;
      z-index: 99999;
      background: linear-gradient(145deg, #0a2e1a 0%, #15803D 40%, #22C55E 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      transition: opacity 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      will-change: opacity, transform;
      pointer-events: none;
      overflow: hidden;
    }
    #splash.hide { opacity: 0; transform: scale(1.05); pointer-events: none; }
    #splash::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.05) 0%, transparent 50%),
                  radial-gradient(circle at 80% 70%, rgba(255,255,255,0.08) 0%, transparent 40%);
      animation: splashBgPulse 4s ease-in-out infinite;
    }
    @keyframes splashBgPulse {
      0%, 100% { opacity: 0.5; }
      50% { opacity: 1; }
    }
    .splash-shapes {
      position: absolute;
      inset: 0;
      overflow: hidden;
      pointer-events: none;
    }
    .splash-shapes div {
      position: absolute;
      border-radius: 50%;
      background: rgba(255,255,255,0.03);
      animation: shapeFloat 20s ease-in-out infinite;
    }
    .splash-shapes div:nth-child(1) { width: 300px; height: 300px; top: -100px; right: -100px; animation-delay: 0s; }
    .splash-shapes div:nth-child(2) { width: 200px; height: 200px; bottom: -50px; left: -50px; animation-delay: -5s; }
    .splash-shapes div:nth-child(3) { width: 150px; height: 150px; top: 40%; right: 10%; animation-delay: -10s; background: rgba(255,255,255,0.05); }
    .splash-shapes div:nth-child(4) { width: 100px; height: 100px; bottom: 30%; left: 15%; animation-delay: -15s; background: rgba(255,255,255,0.04); }
    @keyframes shapeFloat {
      0%, 100% { transform: translate(0, 0) scale(1) rotate(0deg); }
      33% { transform: translate(30px, -40px) scale(1.1) rotate(120deg); }
      66% { transform: translate(-20px, 30px) scale(0.9) rotate(240deg); }
    }
    .splash-content {
      position: relative;
      z-index: 2;
      text-align: center;
      animation: splashIn 1.6s cubic-bezier(0.23, 1, 0.32, 1) forwards;
    }
    @keyframes splashIn {
      0% { opacity: 0; transform: scale(0.8) translateY(30px); }
      100% { opacity: 1; transform: scale(1) translateY(0); }
    }
    .splash-logo {
      position: relative;
      animation: floatGlow 4s ease-in-out infinite;
      filter: drop-shadow(0 20px 60px rgba(34,197,94,0.3));
    }
    .splash-logo svg { display: block; width: 200px; height: auto; margin: 0 auto; }
    @keyframes floatGlow {
      0% { transform: translateY(0px) scale(1); }
      50% { transform: translateY(-10px) scale(1.02); }
      100% { transform: translateY(0px) scale(1); }
    }
    .splash-name {
      font-size: 2.8rem;
      font-weight: 800;
      color: white;
      letter-spacing: 4px;
      margin-top: 16px;
      text-shadow: 0 4px 30px rgba(0,0,0,0.1);
    }
    .splash-name span { color: #F59E0B; }
    .splash-tagline {
      color: rgba(255,255,255,0.6);
      font-size: 0.9rem;
      font-weight: 400;
      letter-spacing: 6px;
      margin-top: 8px;
      text-transform: uppercase;
    }
    .splash-sub {
      color: rgba(255,255,255,0.4);
      font-size: 0.75rem;
      letter-spacing: 3px;
      margin-top: 12px;
      font-weight: 300;
    }
    .splash-loader {
      margin-top: 30px;
      display: flex;
      gap: 8px;
      justify-content: center;
    }
    .splash-loader span {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: rgba(255,255,255,0.2);
      animation: loaderBounce 1.4s ease-in-out infinite;
    }
    .splash-loader span:nth-child(2) { animation-delay: 0.2s; }
    .splash-loader span:nth-child(3) { animation-delay: 0.4s; }
    .splash-loader span:nth-child(4) { animation-delay: 0.6s; }
    .splash-loader span:nth-child(5) { animation-delay: 0.8s; }
    @keyframes loaderBounce {
      0%, 80%, 100% { transform: scale(0.6); background: rgba(255,255,255,0.2); }
      40% { transform: scale(1.2); background: rgba(255,255,255,0.8); }
    }

    /* ===== MAIN ===== */
    #main-content {
      opacity: 0;
      transition: opacity 1.4s cubic-bezier(0.23,1,0.32,1);
    }
    #main-content.visible { opacity: 1; }

    .container { max-width: 1280px; margin: 0 auto; padding: 0 40px; }
    .section { 
      padding: 80px 0; 
      position: relative; 
      scroll-margin-top: 90px;
    }
    .section-tag {
      display: inline-block;
      background: rgba(34,197,94,0.1);
      color: #15803D;
      font-weight: 600;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
      padding: 6px 18px;
      border-radius: 100px;
      text-transform: uppercase;
      margin-bottom: 16px;
    }
    h1, h2, h3 { font-weight: 700; letter-spacing: -0.02em; }
    h2 { font-size: 2.5rem; line-height: 1.1; }

    /* ===== BUTTONS ===== */
    .btn-primary {
      background: #22C55E;
      color: white;
      font-weight: 600;
      padding: 14px 32px;
      border-radius: 100px;
      border: none;
      font-size: 1rem;
      cursor: pointer;
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      box-shadow: 0 8px 24px -8px rgba(34,197,94,0.3);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }
    .btn-primary:hover { background: #15803D; transform: scale(1.05) translateY(-2px); }
    .btn-outline {
      background: transparent;
      color: #0F172A;
      font-weight: 600;
      padding: 14px 32px;
      border-radius: 100px;
      border: 1px solid rgba(15,23,42,0.12);
      font-size: 1rem;
      cursor: pointer;
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }
    .btn-outline:hover { background: rgba(0,0,0,0.02); border-color: #0F172A; transform: translateY(-2px); }
    .btn-outline-light {
      background: transparent;
      color: white;
      font-weight: 600;
      padding: 14px 32px;
      border-radius: 100px;
      border: 1px solid rgba(255,255,255,0.15);
      font-size: 1rem;
      cursor: pointer;
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }
    .btn-outline-light:hover { background: rgba(255,255,255,0.05); border-color: white; transform: translateY(-2px); }

    /* ===== NAVBAR ===== */
    nav {
      position: fixed;
      top: 16px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 1000;
      padding: 8px 24px;
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-radius: 100px;
      border: 1px solid rgba(255,255,255,0.6);
      box-shadow: 0 8px 40px -12px rgba(0,0,0,0.08);
      display: flex;
      align-items: center;
      gap: 20px;
      width: fit-content;
      max-width: 95%;
      transition: all 0.3s ease;
    }
    nav .logo {
      font-weight: 800;
      font-size: 1.1rem;
      color: #0F172A;
      display: flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
    }
    nav .logo span {
      background: linear-gradient(135deg, #0F172A, #15803D);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    nav .links {
      display: flex;
      gap: 16px;
      font-weight: 500;
      font-size: 0.85rem;
      align-items: center;
    }
    nav .links a {
      color: #475569;
      text-decoration: none;
      transition: 0.2s;
      position: relative;
      white-space: nowrap;
      cursor: pointer;
      padding: 4px 0;
    }
    nav .links a::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: #22C55E;
      transition: width 0.3s ease;
    }
    nav .links a:hover::after { width: 100%; }
    nav .links a:hover { color: #0F172A; }
    nav .nav-buttons {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    nav .nav-btn {
      font-size: 0.8rem;
      padding: 6px 18px;
      border-radius: 100px;
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
      text-decoration: none;
    }
    nav .nav-btn-outline {
      background: transparent;
      color: #0F172A;
      border: 1px solid rgba(15,23,42,0.12);
    }
    nav .nav-btn-outline:hover {
      background: rgba(0,0,0,0.02);
      border-color: #0F172A;
      transform: translateY(-2px);
    }
    nav .nav-btn-primary {
      background: #22C55E;
      color: white;
      box-shadow: 0 4px 12px -4px rgba(34,197,94,0.3);
    }
    nav .nav-btn-primary:hover {
      background: #15803D;
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -4px rgba(34,197,94,0.4);
    }
    .nav-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 1.4rem;
      color: #0F172A;
      cursor: pointer;
      padding: 4px 8px;
    }

    /* ===== PAGE SYSTEM ===== */
    .page { display: none; min-height: 100vh; }
    .page.active { display: block; }

    /* ===== ROLE SELECTOR ===== */
    .role-selector {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    .role-selector .role-option {
      flex: 1;
      min-width: 80px;
      padding: 12px 14px;
      border-radius: 12px;
      border: 2px solid rgba(0,0,0,0.06);
      background: rgba(255,255,255,0.5);
      cursor: pointer;
      text-align: center;
      transition: all 0.3s ease;
    }
    .role-selector .role-option:hover {
      border-color: rgba(34,197,94,0.3);
      background: rgba(255,255,255,0.8);
      transform: translateY(-2px);
    }
    .role-selector .role-option.active {
      border-color: #22C55E;
      background: rgba(34,197,94,0.1);
      box-shadow: 0 0 0 3px rgba(34,197,94,0.08);
    }
    .role-selector .role-option .role-icon {
      font-size: 1.4rem;
      display: block;
      margin-bottom: 2px;
    }
    .role-selector .role-option .role-name {
      font-size: 0.7rem;
      font-weight: 700;
      color: #0F172A;
    }
    .role-selector .role-option .role-desc {
      font-size: 0.55rem;
      color: #94A3B8;
    }

    /* ===== HERO ===== */
    .hero { 
      padding: 120px 0 60px; 
      position: relative; 
      overflow: hidden; 
      scroll-margin-top: 80px;
    }
    .hero::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -20%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(34,197,94,0.06) 0%, transparent 70%);
      border-radius: 50%;
      animation: pulseGlow 6s ease-in-out infinite;
    }
    @keyframes pulseGlow {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.2); opacity: 1; }
    }
    .hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; position: relative; z-index: 1; }
    .hero-left h1 { font-size: 3.5rem; line-height: 1.1; margin-bottom: 20px; }
    .hero-left h1 span { background: linear-gradient(135deg, #22C55E, #10B981); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .hero-left p { font-size: 1.1rem; color: #475569; max-width: 90%; margin-bottom: 28px; }
    .hero-buttons { display: flex; gap: 16px; flex-wrap: wrap; }

    .dashboard-3d { perspective: 1000px; transform-style: preserve-3d; }
    .dash-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      transform: rotateY(-5deg) rotateX(5deg);
      transition: transform 0.6s ease;
    }
    .dash-grid:hover { transform: rotateY(0deg) rotateX(0deg); }
    .dash-card {
      background: rgba(255,255,255,0.7);
      backdrop-filter: blur(8px);
      border-radius: 20px;
      padding: 16px;
      border: 1px solid rgba(255,255,255,0.6);
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      cursor: pointer;
    }
    .dash-card:hover { transform: translateZ(20px) scale(1.02); box-shadow: 0 20px 40px -12px rgba(34,197,94,0.2); }
    .dash-card i { color: #22C55E; font-size: 1.4rem; }
    .dash-card .label { font-size: 0.65rem; text-transform: uppercase; color: #64748B; font-weight: 600; letter-spacing: 0.3px; }
    .dash-card .value { font-size: 1.3rem; font-weight: 700; }
    .dash-card .progress {
      width: 100%;
      height: 4px;
      background: rgba(0,0,0,0.05);
      border-radius: 4px;
      margin-top: 6px;
      overflow: hidden;
    }
    .dash-card .progress .bar {
      height: 100%;
      background: linear-gradient(90deg, #22C55E, #10B981);
      border-radius: 4px;
      animation: progressAnim 2s ease-in-out;
    }
    @keyframes progressAnim { 0% { width: 0; } 100% { width: var(--target); } }

    /* ===== STATS ===== */
    .stats-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; margin-top: 30px; }
    .stat-card {
      padding: 28px 24px;
      background: white;
      border-radius: 28px;
      box-shadow: 0 4px 20px -8px rgba(0,0,0,0.02);
      border: 1px solid rgba(0,0,0,0.02);
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .stat-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08); }
    .stat-card .number { font-size: 2.4rem; font-weight: 800; }
    .stat-card .desc { color: #475569; font-weight: 500; margin-top: 4px; }

    /* ===== STAKEHOLDERS ===== */
    .stake-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; margin-top: 30px; }
    .stake-card {
      padding: 28px 20px;
      text-align: center;
      background: rgba(255,255,255,0.5);
      backdrop-filter: blur(6px);
      border-radius: 32px;
      border: 1px solid rgba(255,255,255,0.7);
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .stake-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px -12px rgba(34,197,94,0.15); }
    .stake-card i { font-size: 2.2rem; color: #22C55E; margin-bottom: 12px; }

    /* ===== TIMELINE ===== */
    .timeline { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; margin-top: 30px; position: relative; }
    .timeline::before { content: ''; position: absolute; top: 40px; left: 10%; right: 10%; height: 2px; background: linear-gradient(90deg, #22C55E, #10B981); opacity: 0.2; }
    .step { text-align: center; opacity: 0; transform: translateY(30px); animation: stepIn 0.8s ease forwards; }
    .step:nth-child(1) { animation-delay: 0.1s; }
    .step:nth-child(2) { animation-delay: 0.3s; }
    .step:nth-child(3) { animation-delay: 0.5s; }
    .step:nth-child(4) { animation-delay: 0.7s; }
    @keyframes stepIn { to { opacity: 1; transform: translateY(0); } }
    .step .icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: rgba(34,197,94,0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 12px;
      font-size: 1.8rem;
      color: #22C55E;
      transition: 0.3s;
    }
    .step:hover .icon { transform: scale(1.1) rotate(10deg); background: rgba(34,197,94,0.2); }

    /* ===== AI SECTION ===== */
    .ai-section { background: #0F172A; color: white; position: relative; overflow: hidden; }
    .ai-section::before {
      content: '';
      position: absolute;
      top: -30%;
      left: -20%;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(34,197,94,0.05) 0%, transparent 70%);
      border-radius: 50%;
      animation: pulseGlow 8s ease-in-out infinite;
    }
    .ai-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; margin-top: 30px; position: relative; z-index: 1; }
    .ai-card {
      padding: 28px 24px;
      background: rgba(255,255,255,0.04);
      border-radius: 28px;
      border: 1px solid rgba(255,255,255,0.04);
      backdrop-filter: blur(4px);
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .ai-card:hover { transform: translateY(-8px); background: rgba(255,255,255,0.08); border-color: rgba(34,197,94,0.2); }
    .ai-card i { font-size: 2rem; color: #22C55E; margin-bottom: 12px; }

    /* ===== ESG ===== */
    .esg-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-top: 30px; }
    .esg-kpi {
      padding: 20px;
      background: white;
      border-radius: 24px;
      text-align: center;
      box-shadow: 0 4px 12px -4px rgba(0,0,0,0.02);
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .esg-kpi:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 20px 40px -12px rgba(34,197,94,0.1); }
    .esg-kpi .num { font-size: 1.8rem; font-weight: 800; color: #22C55E; }
    .esg-kpi .label { font-size: 0.8rem; color: #64748B; font-weight: 500; margin-top: 4px; }

    /* ===== CIRCULAR FLOW ===== */
    .flow-container { perspective: 1000px; margin: 30px 0; }
    .flow {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
      gap: 6px 12px;
      font-weight: 500;
      transform: rotateX(2deg);
    }
    .flow-item {
      background: white;
      padding: 8px 18px;
      border-radius: 100px;
      box-shadow: 0 4px 12px -4px rgba(0,0,0,0.02);
      border: 1px solid rgba(0,0,0,0.02);
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      font-size: 0.85rem;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .flow-item:hover { transform: translateZ(20px) scale(1.05); box-shadow: 0 12px 24px -8px rgba(34,197,94,0.15); }
    .flow-arrow { color: #22C55E; font-size: 1.1rem; animation: arrowPulse 1.5s ease-in-out infinite; }
    @keyframes arrowPulse {
      0%, 100% { transform: translateX(0); opacity: 0.6; }
      50% { transform: translateX(4px); opacity: 1; }
    }

    /* ===== MARKET ===== */
    .market-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-top: 30px; }
    .market-card {
      padding: 24px 16px;
      text-align: center;
      background: white;
      border-radius: 28px;
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      cursor: pointer;
    }
    .market-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08); }
    .market-card .pct {
      font-size: 2.5rem;
      font-weight: 800;
      color: #22C55E;
      animation: countUp 2s ease-out;
    }
    @keyframes countUp {
      0% { opacity: 0; transform: scale(0.5); }
      100% { opacity: 1; transform: scale(1); }
    }

    /* ===== BUSINESS ===== */
    .biz-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-top: 30px; }
    .biz-card {
      padding: 20px;
      background: white;
      border-radius: 24px;
      text-align: center;
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .biz-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -12px rgba(0,0,0,0.08); }
    .biz-card .num { font-size: 1.8rem; font-weight: 800; }
    .biz-card .label { font-size: 0.8rem; color: #64748B; margin-top: 4px; }

    /* ===== SDG ===== */
    .sdg-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-top: 30px; }
    .sdg-card {
      padding: 24px 16px;
      border-radius: 28px;
      text-align: center;
      color: white;
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      cursor: pointer;
    }
    .sdg-card:hover { transform: translateY(-10px); box-shadow: 0 30px 60px -16px rgba(0,0,0,0.2); }
    .sdg-card i { font-size: 2rem; margin-bottom: 8px; }
    .sdg-card:nth-child(1) { background: linear-gradient(135deg, #E63946, #D62828); }
    .sdg-card:nth-child(2) { background: linear-gradient(135deg, #2A9D8F, #264653); }
    .sdg-card:nth-child(3) { background: linear-gradient(135deg, #E9C46A, #F4A261); }
    .sdg-card:nth-child(4) { background: linear-gradient(135deg, #2A9D8F, #1A535C); }

    /* ===== ROADMAP ===== */
    .roadmap {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
      position: relative;
      flex-wrap: wrap;
    }
    .roadmap::before { content: ''; position: absolute; top: 20px; left: 5%; right: 5%; height: 2px; background: rgba(255,255,255,0.1); }
    .milestone {
      text-align: center;
      color: white;
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      flex: 1;
      min-width: 80px;
      padding: 0 10px;
    }
    .milestone:hover { transform: translateY(-8px); }
    .milestone .year { font-size: 1.8rem; font-weight: 800; color: #22C55E; }
    .milestone .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #22C55E;
      margin: 8px auto;
      box-shadow: 0 0 20px rgba(34,197,94,0.3);
      animation: dotPulse 2s ease-in-out infinite;
    }
    @keyframes dotPulse {
      0%, 100% { box-shadow: 0 0 20px rgba(34,197,94,0.3); }
      50% { box-shadow: 0 0 40px rgba(34,197,94,0.6); }
    }

    /* ===== CTA FINAL ===== */
    .cta-final {
      text-align: center;
      padding: 80px 0;
      background: linear-gradient(135deg, #0F172A 0%, #1a2a3a 100%);
      color: white;
      position: relative;
      overflow: hidden;
    }
    .cta-final h2 { font-size: 2.8rem; margin-bottom: 16px; }
    .cta-final .sub { font-size: 1.1rem; opacity: 0.8; margin-bottom: 28px; }
    .cta-final .btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }

    /* ===== FOOTER ===== */
    footer {
      background: #0F172A;
      color: white;
      padding: 50px 0 30px;
      border-top: 1px solid rgba(255,255,255,0.04);
    }
    footer .flex {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 30px;
    }
    footer .col {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    footer .col h3 {
      font-size: 1.1rem;
      margin-bottom: 4px;
    }
    footer .col p {
      color: #94A3B8;
      font-size: 0.85rem;
    }
    footer a {
      color: #94A3B8;
      text-decoration: none;
      font-size: 0.85rem;
      transition: 0.2s;
      cursor: pointer;
    }
    footer a:hover {
      color: white;
      transform: translateX(4px);
    }
    footer .social-links {
      display: flex;
      gap: 12px;
      margin-top: 4px;
    }
    footer .social-links a {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255,255,255,0.04);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: 0.3s;
    }
    footer .social-links a:hover {
      background: rgba(34,197,94,0.15);
      transform: translateY(-2px);
    }
    footer .social-links a i {
      font-size: 1rem;
    }
    footer .footer-bottom {
      margin-top: 28px;
      padding-top: 16px;
      border-top: 1px solid rgba(255,255,255,0.04);
      text-align: center;
      color: #475569;
      font-size: 0.8rem;
    }

    /* ============================================================ */
    /* ===== AUTH PAGES ===== */
    /* ============================================================ */
    .auth-page {
      display: flex;
      min-height: 100vh;
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 40%, #bbf7d0 70%, #f0fdf4 100%);
      position: relative;
      overflow-y: auto;
      overflow-x: hidden;
    }
    .auth-page .bg-shapes {
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 0;
    }
    .auth-page .bg-shapes div {
      position: absolute;
      border-radius: 50%;
      opacity: 0.04;
    }
    .auth-page .bg-shapes div:nth-child(1) {
      width: 600px;
      height: 600px;
      top: -200px;
      right: -100px;
      background: #22C55E;
    }
    .auth-page .bg-shapes div:nth-child(2) {
      width: 400px;
      height: 400px;
      bottom: -150px;
      left: -100px;
      background: #15803D;
    }
    .auth-page .bg-shapes div:nth-child(3) {
      width: 300px;
      height: 300px;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #10B981;
      opacity: 0.03;
    }

    .auth-brand {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 50px 70px;
      position: relative;
      z-index: 1;
      background: linear-gradient(135deg, rgba(15,23,42,0.02) 0%, rgba(15,23,42,0.01) 100%);
      min-height: 100vh;
    }
    .auth-brand .brand-icon {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      font-size: 2rem;
      font-weight: 800;
      color: #0F172A;
      margin-bottom: 16px;
    }
    .auth-brand .brand-icon i {
      color: #22C55E;
      font-size: 2.4rem;
    }
    .auth-brand h1 {
      font-size: 2.8rem;
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 12px;
      letter-spacing: -0.03em;
    }
    .auth-brand h1 span {
      background: linear-gradient(135deg, #22C55E, #15803D);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .auth-brand p {
      font-size: 1.1rem;
      color: #475569;
      max-width: 400px;
      line-height: 1.7;
    }
    .auth-brand .brand-features {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 24px;
    }
    .auth-brand .brand-features .feature {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 0.9rem;
      color: #334155;
    }
    .auth-brand .brand-features .feature i {
      color: #22C55E;
      font-size: 1rem;
      width: 24px;
      text-align: center;
    }

    .auth-form-side {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
      position: relative;
      z-index: 1;
      background: rgba(255,255,255,0.5);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-left: 1px solid rgba(255,255,255,0.3);
      min-height: 100vh;
      overflow-y: auto;
    }
    .auth-form {
      width: 100%;
      max-width: 400px;
      padding: 16px 0;
    }
    .auth-form .back-home {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: #64748B;
      font-size: 0.85rem;
      font-weight: 500;
      cursor: pointer;
      text-decoration: none;
      transition: 0.2s;
      margin-bottom: 16px;
      padding: 6px 14px;
      border-radius: 8px;
      background: rgba(255,255,255,0.3);
    }
    .auth-form .back-home:hover {
      color: #0F172A;
      background: rgba(255,255,255,0.6);
      transform: translateX(-4px);
    }
    .auth-form .auth-badge {
      display: inline-block;
      background: rgba(34,197,94,0.08);
      color: #15803D;
      font-size: 0.65rem;
      font-weight: 600;
      padding: 4px 14px;
      border-radius: 100px;
      margin-bottom: 8px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }
    .auth-form .auth-title {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 4px;
      color: #0F172A;
    }
    .auth-form .auth-sub {
      color: #64748B;
      font-size: 0.9rem;
      margin-bottom: 16px;
    }

    .auth-form .form-group {
      margin-bottom: 14px;
    }
    .auth-form .form-group label {
      display: block;
      font-weight: 600;
      font-size: 0.8rem;
      color: #0F172A;
      margin-bottom: 4px;
    }
    .auth-form .form-group .input-wrapper {
      position: relative;
    }
    .auth-form .form-group .input-wrapper i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #94A3B8;
      font-size: 0.95rem;
      transition: 0.2s;
    }
    .auth-form .form-group .input-wrapper input {
      width: 100%;
      padding: 12px 16px 12px 44px;
      border-radius: 12px;
      border: 2px solid rgba(0,0,0,0.04);
      background: rgba(255,255,255,0.8);
      font-size: 0.95rem;
      font-family: inherit;
      transition: 0.3s ease;
      outline: none;
      color: #0F172A;
    }
    .auth-form .form-group .input-wrapper input::placeholder {
      color: #94A3B8;
    }
    .auth-form .form-group .input-wrapper input:focus {
      border-color: #22C55E;
      background: rgba(255,255,255,0.95);
      box-shadow: 0 0 0 4px rgba(34,197,94,0.06);
    }
    .auth-form .form-group .input-wrapper input:focus ~ i,
    .auth-form .form-group .input-wrapper input:focus + i {
      color: #22C55E;
    }
    .auth-form .form-group .input-wrapper .toggle-pass {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #94A3B8;
      cursor: pointer;
      font-size: 0.95rem;
      padding: 4px;
    }
    .auth-form .form-group .input-wrapper .toggle-pass:hover {
      color: #0F172A;
    }

    .auth-form .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
      font-size: 0.85rem;
    }
    .auth-form .form-options label {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      color: #475569;
    }
    .auth-form .form-options label input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: #22C55E;
      cursor: pointer;
    }
    .auth-form .form-options a {
      color: #22C55E;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
    }
    .auth-form .form-options a:hover {
      text-decoration: underline;
    }

    .auth-form .auth-btn {
      width: 100%;
      padding: 14px;
      border-radius: 12px;
      border: none;
      background: linear-gradient(135deg, #22C55E, #15803D);
      color: white;
      font-weight: 700;
      font-size: 1rem;
      cursor: pointer;
      transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      box-shadow: 0 8px 32px -8px rgba(34,197,94,0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    .auth-form .auth-btn:hover {
      transform: scale(1.02) translateY(-2px);
      box-shadow: 0 16px 48px -8px rgba(34,197,94,0.4);
    }
    .auth-form .auth-btn:active {
      transform: scale(0.98);
    }

    .auth-form .auth-divider {
      display: flex;
      align-items: center;
      gap: 16px;
      margin: 16px 0;
    }
    .auth-form .auth-divider::before,
    .auth-form .auth-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: rgba(0,0,0,0.06);
    }
    .auth-form .auth-divider span {
      font-size: 0.75rem;
      color: #94A3B8;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 1px;
      white-space: nowrap;
    }

    .auth-form .social-btns {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .auth-form .social-btns button {
      width: 100%;
      padding: 12px;
      border-radius: 12px;
      border: 2px solid rgba(0,0,0,0.04);
      background: rgba(255,255,255,0.5);
      cursor: pointer;
      transition: 0.3s ease;
      font-size: 0.95rem;
      color: #0F172A;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      font-weight: 600;
    }
    .auth-form .social-btns button:hover {
      background: rgba(255,255,255,0.9);
      border-color: rgba(0,0,0,0.08);
      transform: translateY(-2px);
      box-shadow: 0 8px 24px -8px rgba(0,0,0,0.06);
    }
    .auth-form .social-btns button .fab {
      font-size: 1.2rem;
    }
    .auth-form .social-btns button.google:hover {
      border-color: #EA4335;
      color: #EA4335;
      background: rgba(234,67,53,0.05);
    }
    .auth-form .social-btns button.google .fab {
      color: #EA4335;
    }
    .auth-form .social-btns button.facebook:hover {
      border-color: #1877F2;
      color: #1877F2;
      background: rgba(24,119,242,0.05);
    }
    .auth-form .social-btns button.facebook .fab {
      color: #1877F2;
    }

    .auth-form .auth-footer {
      text-align: center;
      margin-top: 16px;
      font-size: 0.9rem;
      color: #64748B;
    }
    .auth-form .auth-footer a {
      color: #22C55E;
      font-weight: 700;
      text-decoration: none;
      cursor: pointer;
    }
    .auth-form .auth-footer a:hover {
      text-decoration: underline;
    }

    /* ===== USER PROFILE ===== */
    .user-profile {
      display: none;
      align-items: center;
      gap: 12px;
    }
    .user-profile.show {
      display: flex;
    }
    .user-profile .avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: linear-gradient(135deg, #22C55E, #15803D);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 700;
      font-size: 0.8rem;
    }
    .user-profile .user-name {
      font-size: 0.85rem;
      font-weight: 600;
      color: #0F172A;
    }
    .user-profile .user-role {
      font-size: 0.65rem;
      color: #64748B;
      padding: 2px 10px;
      border-radius: 100px;
      background: rgba(34,197,94,0.1);
    }
    .user-profile .logout-btn {
      background: none;
      border: none;
      color: #EF4444;
      cursor: pointer;
      font-size: 0.8rem;
      padding: 4px 8px;
      border-radius: 6px;
      transition: 0.2s;
    }
    .user-profile .logout-btn:hover {
      background: rgba(239,68,68,0.1);
    }

    /* ============================================================ */
    /* ===== RESPONSIVE ===== */
    /* ============================================================ */
    @media (max-width: 1024px) {
      .hero-grid { grid-template-columns: 1fr; gap: 40px; }
      .hero-left p { max-width: 100%; }
      .stats-grid, .stake-grid, .ai-grid, .esg-grid, .market-grid, .biz-grid, .sdg-grid {
        grid-template-columns: 1fr 1fr;
      }
      .timeline { grid-template-columns: 1fr 1fr; }
      .timeline::before { display: none; }
      .roadmap { gap: 16px; justify-content: center; }
      .roadmap::before { display: none; }
      
      nav .links { display: none; }
      nav .nav-buttons { display: none; }
      .nav-toggle { display: block; }
      
      nav.mobile-open {
        width: 90%;
        border-radius: 20px;
        padding: 14px 18px;
        flex-wrap: wrap;
        background: rgba(255,255,255,0.98);
      }
      nav.mobile-open .links {
        display: flex;
        flex-direction: column;
        width: 100%;
        gap: 6px;
        padding: 10px 0;
        border-top: 1px solid rgba(0,0,0,0.04);
        margin-top: 6px;
      }
      nav.mobile-open .links a {
        padding: 6px 12px;
        width: 100%;
        text-align: center;
        border-radius: 8px;
        transition: 0.2s;
      }
      nav.mobile-open .links a:hover {
        background: rgba(34,197,94,0.06);
      }
      nav.mobile-open .nav-buttons {
        display: flex;
        width: 100%;
        gap: 8px;
        border-top: 1px solid rgba(0,0,0,0.04);
        padding-top: 10px;
      }
      nav.mobile-open .nav-buttons .nav-btn {
        flex: 1;
        justify-content: center;
        padding: 8px;
        font-size: 0.8rem;
      }
      nav.mobile-open .logo {
        flex: 1;
      }
      
      .section { padding: 50px 0; }
      h2 { font-size: 2rem; }
      
      .auth-brand { padding: 30px 40px; }
      .auth-brand h1 { font-size: 2.2rem; }
      .role-selector .role-option { min-width: 70px; padding: 8px 10px; }
    }

    @media (max-width: 768px) {
      .auth-page { flex-direction: column; }
      .auth-brand {
        padding: 24px 24px 16px;
        flex: 0 0 auto;
        background: rgba(255,255,255,0.3);
        min-height: auto;
      }
      .auth-brand h1 { font-size: 1.8rem; }
      .auth-brand p { font-size: 1rem; max-width: 100%; }
      .auth-brand .brand-features { display: none; }
      .auth-form-side {
        flex: 1;
        padding: 16px 24px 30px;
        border-left: none;
        border-top: 1px solid rgba(255,255,255,0.3);
        align-items: flex-start;
        min-height: auto;
        overflow-y: visible;
      }
      .auth-form { padding: 8px 0; }
      .auth-form .back-home { margin-bottom: 12px; }
      .auth-form .auth-title { font-size: 1.5rem; }
      .auth-form .auth-sub { font-size: 0.85rem; margin-bottom: 14px; }
      .auth-form .form-group { margin-bottom: 12px; }
      .auth-form .form-group .input-wrapper input { padding: 10px 12px 10px 40px; font-size: 0.9rem; }
      .role-selector { gap: 6px; }
      .role-selector .role-option { min-width: 60px; padding: 6px 8px; }
      .role-selector .role-option .role-icon { font-size: 1.2rem; }
      .role-selector .role-option .role-name { font-size: 0.6rem; }
      .role-selector .role-option .role-desc { display: none; }
    }

    @media (max-width: 640px) {
      .container { padding: 0 16px; }
      .hero { padding: 100px 0 30px; }
      .hero-left h1 { font-size: 1.8rem; }
      .hero-left p { font-size: 0.95rem; }
      .hero-buttons { flex-direction: column; align-items: stretch; }
      .hero-buttons button { justify-content: center; }
      
      .stats-grid, .stake-grid, .ai-grid, .esg-grid, .market-grid, .biz-grid, .sdg-grid {
        grid-template-columns: 1fr;
        gap: 12px;
      }
      .timeline { grid-template-columns: 1fr; gap: 20px; }
      .timeline::before { display: none; }
      .dash-grid { grid-template-columns: 1fr; }
      .dash-card { padding: 12px; }
      
      .flow { gap: 4px 8px; }
      .flow-item { font-size: 0.7rem; padding: 4px 10px; }
      .flow-arrow { font-size: 0.8rem; }
      
      .section { padding: 30px 0; }
      h2 { font-size: 1.6rem; }
      .cta-final h2 { font-size: 1.8rem; }
      .cta-final .btns { flex-direction: column; align-items: center; }
      .cta-final .btns button { width: 100%; justify-content: center; }
      
      .splash-name { font-size: 2rem; }
      .splash-logo svg { width: 140px; }
      .roadmap { gap: 12px; }
      .milestone { min-width: 50px; }
      .milestone .year { font-size: 1.2rem; }
      
      .btn-primary, .btn-outline, .btn-outline-light { padding: 10px 20px; font-size: 0.85rem; }
      
      nav { padding: 4px 12px; gap: 10px; top: 10px; }
      nav .logo { font-size: 0.9rem; }
      nav.mobile-open { padding: 10px 14px; }
      nav.mobile-open .nav-buttons .nav-btn { font-size: 0.7rem; padding: 6px; }
      
      footer .flex {
        flex-direction: column;
        gap: 20px;
        align-items: center;
        text-align: center;
      }
      footer .col { align-items: center; }
      footer .social-links { justify-content: center; }
      
      .auth-brand { padding: 16px 16px 10px; }
      .auth-brand .brand-icon { font-size: 1.4rem; }
      .auth-brand .brand-icon i { font-size: 1.8rem; }
      .auth-brand h1 { font-size: 1.5rem; }
      .auth-form-side { padding: 12px 16px 24px; }
      .auth-form .auth-title { font-size: 1.3rem; }
      .auth-form .auth-sub { font-size: 0.75rem; }
      .auth-form .form-group .input-wrapper input { padding: 8px 10px 8px 36px; font-size: 0.85rem; }
      .auth-form .auth-btn { padding: 12px; font-size: 0.85rem; }
    }
  </style>
</head>
<body>

<!-- ===== SPLASH SCREEN ===== -->
<div id="splash">
  <div class="splash-shapes"><div></div><div></div><div></div><div></div></div>
  <div class="splash-content">
    <div class="splash-logo">
      <svg viewBox="0 0 200 56" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs><linearGradient id="logoGrad" x1="0" y1="0" x2="80" y2="56" gradientUnits="userSpaceOnUse">
          <stop offset="0%" stop-color="#FFFFFF"/><stop offset="60%" stop-color="#F8FAFC"/><stop offset="100%" stop-color="#F59E0B"/>
        </linearGradient></defs>
        <path d="M28 12 L28 44 L12 44 L12 12 L28 12 Z M32 12 L44 12 L44 44 L32 44 L32 12 Z" fill="#F59E0B" opacity="0.9"/>
        <rect x="48" y="16" width="6" height="28" rx="3" fill="#F8FAFC"/>
        <rect x="60" y="8" width="6" height="36" rx="3" fill="#FFFFFF"/>
        <rect x="72" y="20" width="6" height="24" rx="3" fill="#F8FAFC"/>
        <path d="M86 28 L100 8 L114 28 L100 48 L86 28Z" fill="url(#logoGrad)" opacity="0.9"/>
        <circle cx="100" cy="28" r="4" fill="#22C55E" opacity="0.6"/>
        <path d="M132 12 L132 44 L146 44 L146 28 L132 12Z" fill="#F8FAFC" opacity="0.7"/>
        <path d="M152 12 L168 12 L168 20 L152 20 L152 12Z" fill="#F59E0B"/>
        <path d="M152 24 L168 24 L168 32 L152 32 L152 24Z" fill="#F8FAFC"/>
        <path d="M152 36 L168 36 L168 44 L152 44 L152 36Z" fill="#FFFFFF"/>
      </svg>
    </div>
    <div class="splash-name">PANTAS</div>
    <div class="splash-tagline">Pangan Tanpa Sisa</div>
    <div class="splash-sub">Transforming Food Surplus into Sustainable Value</div>
    <div class="splash-loader"><span></span><span></span><span></span><span></span><span></span></div>
  </div>
</div>

<!-- ===== MAIN CONTENT ===== -->
<div id="main-content">

<!-- ============================================================ -->
<!-- PAGE 1: LANDING PAGE -->
<!-- ============================================================ -->
<div class="page active" id="page-landing">

<!-- NAVBAR -->
<nav id="navbar">
  <div class="logo"><i class="fas fa-leaf" style="color:#22C55E;"></i><span>PANTAS</span></div>
  <div class="links">
    <a onclick="scrollToSection('hero')">Home</a>
    <a onclick="scrollToSection('tech')">Technology</a>
    <a onclick="scrollToSection('impact')">Impact</a>
    <a onclick="scrollToSection('esg')">ESG</a>
    <a onclick="scrollToSection('partners')">Partners</a>
    <a onclick="scrollToSection('roadmap')">Roadmap</a>
  </div>
  <div class="nav-buttons" id="navButtons">
    <!-- Akan diisi oleh JavaScript -->
  </div>
  <button class="nav-toggle" id="navToggle" aria-label="Menu">
    <i class="fas fa-bars"></i>
  </button>
</nav>

<!-- HERO -->
<section class="hero" id="hero">
  <div class="container">
    <div class="hero-grid">
      <div class="hero-left">
        <h1>PANTAS <br><span>Pangan Tanpa Sisa</span></h1>
        <p>AI-powered Circular Economy platform transforming food surplus into economic, social, and environmental value through intelligent distribution, waste recovery, and automated ESG reporting.</p>
        <div class="hero-buttons">
          <button class="btn-primary" onclick="navigateTo('register')"><i class="fas fa-rocket"></i> Get Started</button>
          <button class="btn-outline" onclick="scrollToSection('tech')"><i class="fas fa-arrow-right"></i> Learn More</button>
        </div>
      </div>
      <div class="hero-right dashboard-3d">
        <div class="dash-grid">
          <div class="dash-card">
            <i class="fas fa-brain"></i>
            <div class="label">AI Surplus Prediction</div>
            <div class="value">94%</div>
            <div class="progress"><div class="bar" style="--target:94%;width:94%;"></div></div>
          </div>
          <div class="dash-card">
            <i class="fas fa-chart-pie"></i>
            <div class="label">ESG Analytics</div>
            <div class="value">A+</div>
            <div class="progress"><div class="bar" style="--target:92%;width:92%;"></div></div>
          </div>
          <div class="dash-card">
            <i class="fas fa-utensils"></i>
            <div class="label">Food Rescue</div>
            <div class="value">2.4K ton</div>
            <div class="progress"><div class="bar" style="--target:78%;width:78%;"></div></div>
          </div>
          <div class="dash-card">
            <i class="fas fa-leaf"></i>
            <div class="label">CO₂ Prevented</div>
            <div class="value">8.2K t</div>
            <div class="progress"><div class="bar" style="--target:85%;width:85%;"></div></div>
          </div>
          <div class="dash-card" style="grid-column: span 2;">
            <i class="fas fa-recycle"></i>
            <div class="label">Circular Economy Network</div>
            <div class="value">128 partners</div>
            <div class="progress"><div class="bar" style="--target:64%;width:64%;"></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FOOD WASTE CRISIS -->
<section class="section" style="background:white;">
  <div class="container">
    <span class="section-tag"><i class="fas fa-triangle-exclamation"></i> The Crisis</span>
    <h2>Food Waste Crisis</h2>
    <div class="stats-grid">
      <div class="stat-card"><div class="number">23–48M Tons</div><div class="desc">Food Loss & Waste Every Year</div></div>
      <div class="stat-card"><div class="number">Rp551 T</div><div class="desc">Economic Loss</div></div>
      <div class="stat-card"><div class="number">Thousands</div><div class="desc">HOREKA Businesses Lack Integrated Waste Management</div></div>
    </div>
  </div>
</section>

<!-- STAKEHOLDERS -->
<section class="section" id="partners">
  <div class="container">
    <span class="section-tag"><i class="fas fa-people-group"></i> Ecosystem</span>
    <h2>One Platform. Three Stakeholders.</h2>
    <div class="stake-grid">
      <div class="stake-card"><i class="fas fa-user"></i><h3>Consumers</h3><p>Affordable quality food · Real-time alerts · Easy ordering</p></div>
      <div class="stake-card"><i class="fas fa-hotel"></i><h3>HOREKA Partners</h3><p>Reduce waste · Increase revenue · Automated reporting</p></div>
      <div class="stake-card"><i class="fas fa-seedling"></i><h3>Organic Processors</h3><p>Stable supply · Digital logistics · Operational analytics</p></div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="section" style="background:white;">
  <div class="container">
    <span class="section-tag"><i class="fas fa-route"></i> How it works</span>
    <h2>From Surplus to Impact</h2>
    <div class="timeline">
      <div class="step"><div class="icon"><i class="fas fa-upload"></i></div><h4>Upload Surplus</h4><p style="font-size:0.85rem;color:#475569;">List excess food from HOREKA</p></div>
      <div class="step"><div class="icon"><i class="fas fa-robot"></i></div><h4>AI Classification</h4><p style="font-size:0.85rem;color:#475569;">Edible · Immediate · Organic</p></div>
      <div class="step"><div class="icon"><i class="fas fa-exchange-alt"></i></div><h4>Smart Distribution</h4><p style="font-size:0.85rem;color:#475569;">Match with consumers & processors</p></div>
      <div class="step"><div class="icon"><i class="fas fa-chart-line"></i></div><h4>Impact Tracking</h4><p style="font-size:0.85rem;color:#475569;">Automated ESG & carbon analytics</p></div>
    </div>
  </div>
</section>

<!-- AI TECHNOLOGY -->
<section class="section ai-section" id="tech">
  <div class="container">
    <span class="section-tag" style="background:rgba(34,197,94,0.15);color:#22C55E;"><i class="fas fa-microchip"></i> AI Technology</span>
    <h2>Powered by Artificial Intelligence</h2>
    <div class="ai-grid">
      <div class="ai-card"><i class="fas fa-brain"></i><h3>AI Surplus Prediction</h3><p style="opacity:0.7;">Forecast surplus before it happens with 94% accuracy</p></div>
      <div class="ai-card"><i class="fas fa-bolt"></i><h3>AI Impact Tracker</h3><p style="opacity:0.7;">Real-time environmental & social impact measurement</p></div>
      <div class="ai-card"><i class="fas fa-file-alt"></i><h3>Automated ESG Reporting</h3><p style="opacity:0.7;">Generate investor-grade ESG reports instantly</p></div>
    </div>
  </div>
</section>

<!-- ESG DASHBOARD -->
<section class="section" id="esg">
  <div class="container">
    <span class="section-tag"><i class="fas fa-chart-bar"></i> ESG Dashboard</span>
    <h2>Enterprise Sustainability Analytics</h2>
    <div class="esg-grid">
      <div class="esg-kpi"><div class="num">12,340</div><div class="label"><i class="fas fa-utensils" style="color:#22C55E;"></i> Food Saved (kg)</div></div>
      <div class="esg-kpi"><div class="num">8.2K</div><div class="label"><i class="fas fa-leaf" style="color:#22C55E;"></i> CO₂ Prevented (t)</div></div>
      <div class="esg-kpi"><div class="num">6.8K</div><div class="label"><i class="fas fa-recycle" style="color:#22C55E;"></i> Waste Recycled (kg)</div></div>
      <div class="esg-kpi"><div class="num">87</div><div class="label"><i class="fas fa-star" style="color:#F59E0B;"></i> ESG Score</div></div>
    </div>
  </div>
</section>

<!-- CIRCULAR ECONOMY FLOW -->
<section class="section" style="background:white;">
  <div class="container">
    <span class="section-tag"><i class="fas fa-sync-alt"></i> Circular Economy</span>
    <h2>Full Cycle Flow</h2>
    <div class="flow-container">
      <div class="flow">
        <span class="flow-item"><i class="fas fa-hotel"></i> Hotels</span><span class="flow-arrow">→</span>
        <span class="flow-item"><i class="fas fa-utensils"></i> Restaurants</span><span class="flow-arrow">→</span>
        <span class="flow-item"><i class="fas fa-coffee"></i> Cafés</span><span class="flow-arrow">→</span>
        <span class="flow-item" style="background:#22C55E;color:white;"><i class="fas fa-leaf"></i> PANTAS</span><span class="flow-arrow">→</span>
        <span class="flow-item"><i class="fas fa-user"></i> Consumers</span><span class="flow-arrow">→</span>
        <span class="flow-item"><i class="fas fa-trash-alt"></i> Organic Waste</span><span class="flow-arrow">→</span>
        <span class="flow-item"><i class="fas fa-bug"></i> Maggot Farms</span><span class="flow-arrow">→</span>
        <span class="flow-item"><i class="fas fa-seedling"></i> Compost</span><span class="flow-arrow">→</span>
        <span class="flow-item"><i class="fas fa-tractor"></i> Agriculture</span>
      </div>
    </div>
  </div>
</section>

<!-- MARKET VALIDATION -->
<section class="section">
  <div class="container">
    <span class="section-tag"><i class="fas fa-check-circle"></i> Market Validation</span>
    <h2>Real Demand, Real Impact</h2>
    <div class="market-grid">
      <div class="market-card"><div class="pct">93%</div><p>Interested in buying surplus food</p></div>
      <div class="market-card"><div class="pct">86%</div><p>Want real-time notifications</p></div>
      <div class="market-card"><div class="pct">60%</div><p>HOREKA experience daily surplus</p></div>
      <div class="market-card"><div class="pct">100%</div><p>Processors need stable supply</p></div>
    </div>
  </div>
</section>

<!-- BUSINESS IMPACT -->
<section class="section" style="background:white;" id="impact">
  <div class="container">
    <span class="section-tag"><i class="fas fa-chart-line"></i> Investor Metrics</span>
    <h2>Business Impact</h2>
    <div class="biz-grid">
      <div class="biz-card"><div class="num" style="color:#22C55E;">27.31%</div><div class="label">ROI</div></div>
      <div class="biz-card"><div class="num" style="color:#10B981;">112 Days</div><div class="label">Payback Period</div></div>
      <div class="biz-card"><div class="num" style="color:#15803D;">Rp28M</div><div class="label">Initial Investment</div></div>
      <div class="biz-card"><div class="num" style="color:#22C55E;">Rp7.6M</div><div class="label">Monthly Net Profit</div></div>
    </div>
  </div>
</section>

<!-- SDG -->
<section class="section">
  <div class="container">
    <span class="section-tag"><i class="fas fa-globe"></i> Sustainable Development</span>
    <h2>Aligning with SDGs</h2>
    <div class="sdg-grid">
      <div class="sdg-card"><i class="fas fa-utensils"></i><h3>SDG 2</h3><p>Zero Hunger</p></div>
      <div class="sdg-card"><i class="fas fa-briefcase"></i><h3>SDG 8</h3><p>Decent Work & Growth</p></div>
      <div class="sdg-card"><i class="fas fa-recycle"></i><h3>SDG 12</h3><p>Responsible Consumption</p></div>
      <div class="sdg-card"><i class="fas fa-globe-asia"></i><h3>SDG 13</h3><p>Climate Action</p></div>
    </div>
  </div>
</section>

<!-- FUTURE VISION -->
<section class="section ai-section" id="roadmap">
  <div class="container">
    <span class="section-tag" style="background:rgba(34,197,94,0.15);color:#22C55E;"><i class="fas fa-road"></i> Vision</span>
    <h2>Building Indonesia's Largest AI-Powered Circular Food Ecosystem</h2>
    <div class="roadmap">
      <div class="milestone"><div class="year">2026</div><div class="dot"></div><p>Solo Raya</p></div>
      <div class="milestone"><div class="year">2027</div><div class="dot"></div><p>Central Java</p></div>
      <div class="milestone"><div class="year">2028</div><div class="dot"></div><p>Java Island</p></div>
      <div class="milestone"><div class="year">2030</div><div class="dot"></div><p>Nationwide</p></div>
    </div>
  </div>
</section>

<!-- FINAL CTA -->
<section class="cta-final">
  <div class="container">
    <h2>PANTAS <span style="color:#22C55E;">Pangan Tanpa Sisa</span></h2>
    <p class="sub">"Save Food. Create Value. Build Sustainability."</p>
    <div class="btns">
      <button class="btn-primary" onclick="navigateTo('register')"><i class="fas fa-handshake"></i> Join as HOREKA Partner</button>
      <button class="btn-outline-light" onclick="navigateTo('register')"><i class="fas fa-recycle"></i> Become Waste Processing Partner</button>
      <button class="btn-outline-light" onclick="navigateTo('register')"><i class="fas fa-download"></i> Download Proposal</button>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="flex">
      <div class="col">
        <h3><i class="fas fa-leaf" style="color:#22C55E;"></i> PANTAS</h3>
        <p>AI-powered Circular Economy Platform</p>
      </div>
      <div class="col">
        <a onclick="scrollToSection('tech')">Technology</a>
        <a onclick="scrollToSection('impact')">Impact</a>
        <a onclick="scrollToSection('esg')">ESG</a>
        <a onclick="scrollToSection('partners')">Partners</a>
      </div>
      <div class="col">
        <div class="social-links">
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        <a href="#"><i class="fas fa-envelope"></i> hello@pantas.id</a>
      </div>
    </div>
    <div class="footer-bottom">
      © 2026 PANTAS · Transforming Food Surplus into Sustainable Value.
    </div>
  </div>
</footer>

</div><!-- end page-landing -->


<!-- ============================================================ -->
<!-- PAGE 2: LOGIN -->
<!-- ============================================================ -->
<div class="page" id="page-login">
  <div class="auth-page">
    <div class="bg-shapes">
      <div></div><div></div><div></div>
    </div>

    <div class="auth-brand">
      <div class="brand-icon">
        <i class="fas fa-leaf"></i> PANTAS
      </div>
      <h1>Welcome<br><span>Back to PANTAS</span></h1>
      <p>AI-powered Circular Economy platform transforming food surplus into sustainable value.</p>
      <div class="brand-features">
        <div class="feature"><i class="fas fa-brain"></i> AI Surplus Prediction</div>
        <div class="feature"><i class="fas fa-chart-pie"></i> Automated ESG Reporting</div>
        <div class="feature"><i class="fas fa-recycle"></i> Circular Economy Network</div>
      </div>
    </div>

    <div class="auth-form-side">
      <div class="auth-form">
        <span class="back-home" onclick="navigateTo('landing')">
          <i class="fas fa-arrow-left"></i> Back to Home
        </span>
        
        <span class="auth-badge"><i class="fas fa-shield-alt"></i> Secure Login</span>
        <div class="auth-title">Welcome Back</div>
        <div class="auth-sub">Sign in to continue your sustainability journey</div>

        <!-- ROLE SELECTOR -->
        <div class="role-selector" id="roleSelector">
          <div class="role-option active" data-role="customer" onclick="selectRole('customer')">
            <span class="role-icon">👤</span>
            <div class="role-name">Customer</div>
            <div class="role-desc">Buy surplus food</div>
          </div>
          <div class="role-option" data-role="horeka" onclick="selectRole('horeka')">
            <span class="role-icon">🏨</span>
            <div class="role-name">Mitra HOREKA</div>
            <div class="role-desc">Sell surplus food</div>
          </div>
          <div class="role-option" data-role="driver" onclick="selectRole('driver')">
            <span class="role-icon">🚚</span>
            <div class="role-name">Mitra Driver</div>
            <div class="role-desc">Deliver food</div>
          </div>
        </div>

        <form onsubmit="handleLogin(event)">
          <div class="form-group">
            <label>Email Address</label>
            <div class="input-wrapper">
              <i class="fas fa-envelope"></i>
              <input type="email" id="loginEmail" placeholder="you@example.com" required />
            </div>
          </div>

          <div class="form-group">
            <label>Password</label>
            <div class="input-wrapper">
              <i class="fas fa-lock"></i>
              <input type="password" id="loginPass" placeholder="Enter your password" required />
              <button type="button" class="toggle-pass" onclick="togglePass('loginPass')">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>

          <div class="form-options">
            <label><input type="checkbox" /> Remember me</label>
            <a onclick="alert('Reset link sent to your email!')">Forgot password?</a>
          </div>

          <button type="submit" class="auth-btn">
            <i class="fas fa-sign-in-alt"></i> Sign In as <span id="selectedRoleLabel">Customer</span>
          </button>
        </form>

        <div class="auth-divider"><span>or continue with</span></div>

        <div class="social-btns">
          <button class="google" onclick="signInWithGoogle()">
            <i class="fab fa-google"></i> Continue with Google
          </button>
          <button class="facebook" onclick="signInWithFacebook()">
            <i class="fab fa-facebook"></i> Continue with Facebook
          </button>
        </div>

        <div class="auth-footer">
          Don't have an account? <a onclick="navigateTo('register')">Create one now</a>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- ============================================================ -->
<!-- PAGE 3: REGISTER -->
<!-- ============================================================ -->
<div class="page" id="page-register">
  <div class="auth-page">
    <div class="bg-shapes">
      <div></div><div></div><div></div>
    </div>

    <div class="auth-brand">
      <div class="brand-icon">
        <i class="fas fa-leaf"></i> PANTAS
      </div>
      <h1>Join the<br><span>Circular Economy</span></h1>
      <p>Be part of Indonesia's largest AI-powered food sustainability platform.</p>
      <div class="brand-features">
        <div class="feature"><i class="fas fa-users"></i> 128+ Partners Connected</div>
        <div class="feature"><i class="fas fa-utensils"></i> 2.4K Ton Food Rescued</div>
        <div class="feature"><i class="fas fa-leaf"></i> 8.2K Ton CO₂ Prevented</div>
      </div>
    </div>

    <div class="auth-form-side">
      <div class="auth-form">
        <span class="back-home" onclick="navigateTo('landing')">
          <i class="fas fa-arrow-left"></i> Back to Home
        </span>
        
        <span class="auth-badge"><i class="fas fa-sparkles"></i> Join the Movement</span>
        <div class="auth-title">Create Account</div>
        <div class="auth-sub">Start your journey toward sustainable food management</div>

        <!-- ROLE SELECTOR untuk Register -->
        <div class="role-selector" id="roleSelectorRegister">
          <div class="role-option active" data-role="customer" onclick="selectRoleRegister('customer')">
            <span class="role-icon">👤</span>
            <div class="role-name">Customer</div>
            <div class="role-desc">Buy surplus food</div>
          </div>
          <div class="role-option" data-role="horeka" onclick="selectRoleRegister('horeka')">
            <span class="role-icon">🏨</span>
            <div class="role-name">Mitra HOREKA</div>
            <div class="role-desc">Sell surplus food</div>
          </div>
          <div class="role-option" data-role="driver" onclick="selectRoleRegister('driver')">
            <span class="role-icon">🚚</span>
            <div class="role-name">Mitra Driver</div>
            <div class="role-desc">Deliver food</div>
          </div>
        </div>

        <form onsubmit="handleRegister(event)">
          <div class="form-group">
            <label>Full Name</label>
            <div class="input-wrapper">
              <i class="fas fa-user"></i>
              <input type="text" id="regName" placeholder="John Doe" required />
            </div>
          </div>

          <div class="form-group">
            <label>Email Address</label>
            <div class="input-wrapper">
              <i class="fas fa-envelope"></i>
              <input type="email" id="regEmail" placeholder="you@example.com" required />
            </div>
          </div>

          <div class="form-group">
            <label>Password</label>
            <div class="input-wrapper">
              <i class="fas fa-lock"></i>
              <input type="password" id="registerPass" placeholder="Min 8 characters" required minlength="8" />
              <button type="button" class="toggle-pass" onclick="togglePass('registerPass')">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>

          <div class="form-group">
            <label>Confirm Password</label>
            <div class="input-wrapper">
              <i class="fas fa-check-circle"></i>
              <input type="password" id="confirmPass" placeholder="Confirm your password" required />
            </div>
          </div>

          <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:16px;font-size:0.85rem;color:#64748B;">
            <input type="checkbox" required style="margin-top:2px;width:16px;height:16px;accent-color:#22C55E;flex-shrink:0;" />
            <span>I agree to the <a style="color:#22C55E;font-weight:600;cursor:pointer;text-decoration:none;">Terms of Service</a> &amp; <a style="color:#22C55E;font-weight:600;cursor:pointer;text-decoration:none;">Privacy Policy</a></span>
          </div>

          <button type="submit" class="auth-btn">
            <i class="fas fa-user-plus"></i> Create Account as <span id="selectedRoleLabelRegister">Customer</span>
          </button>
        </form>

        <div class="auth-divider"><span>or continue with</span></div>

        <div class="social-btns">
          <button class="google" onclick="signInWithGoogle()">
            <i class="fab fa-google"></i> Continue with Google
          </button>
          <button class="facebook" onclick="signInWithFacebook()">
            <i class="fab fa-facebook"></i> Continue with Facebook
          </button>
        </div>

        <div class="auth-footer">
          Already have an account? <a onclick="navigateTo('login')">Sign In</a>
        </div>
      </div>
    </div>
  </div>
</div>

</div><!-- end main-content -->


<script>
  // ================================================================
  // ===== KONFIGURASI API =====
  // ================================================================
  const API_URL = 'http://127.0.0.1:8000/api';

  // ================================================================
  // ===== DATABASE (localStorage) =====
  // ================================================================
  const DB = {
    getToken: function() {
      return localStorage.getItem('pantas_token');
    },
    setToken: function(token) {
      localStorage.setItem('pantas_token', token);
    },
    getUser: function() {
      try {
        return JSON.parse(localStorage.getItem('pantas_user'));
      } catch {
        return null;
      }
    },
    setUser: function(user) {
      localStorage.setItem('pantas_user', JSON.stringify(user));
    },
    getRole: function() {
      return localStorage.getItem('pantas_role');
    },
    setRole: function(role) {
      localStorage.setItem('pantas_role', role);
    },
    logout: function() {
      localStorage.removeItem('pantas_token');
      localStorage.removeItem('pantas_user');
      localStorage.removeItem('pantas_role');
      updateNavbar();
    },
    isLoggedIn: function() {
      return !!this.getToken();
    }
  };

  // ================================================================
  // ===== VARIABLES =====
  // ================================================================
  let selectedRole = 'customer';
  let selectedRoleRegister = 'customer';

  // ================================================================
  // ===== ROLE SELECTOR =====
  // ================================================================
  function selectRole(role) {
    selectedRole = role;
    const options = document.querySelectorAll('#roleSelector .role-option');
    options.forEach(opt => {
      opt.classList.toggle('active', opt.dataset.role === role);
    });
    const labels = {
      'customer': 'Customer',
      'horeka': 'Mitra HOREKA',
      'driver': 'Mitra Driver'
    };
    const label = document.getElementById('selectedRoleLabel');
    if (label) label.textContent = labels[role] || 'Customer';
  }

  function selectRoleRegister(role) {
    selectedRoleRegister = role;
    const options = document.querySelectorAll('#roleSelectorRegister .role-option');
    options.forEach(opt => {
      opt.classList.toggle('active', opt.dataset.role === role);
    });
    const labels = {
      'customer': 'Customer',
      'horeka': 'Mitra HOREKA',
      'driver': 'Mitra Driver'
    };
    const label = document.getElementById('selectedRoleLabelRegister');
    if (label) label.textContent = labels[role] || 'Customer';
  }

  // ================================================================
  // ===== NAVBAR UPDATE =====
  // ================================================================
  function updateNavbar() {
    const navButtons = document.getElementById('navButtons');
    const token = DB.getToken();
    const user = DB.getUser();
    const role = DB.getRole();
    
    if (token && user) {
      const roleLabels = {
        'customer': 'Customer',
        'horeka': 'Mitra HOREKA',
        'driver': 'Mitra Driver'
      };
      const initials = user.name ? user.name.charAt(0).toUpperCase() : 'U';
      
      navButtons.innerHTML = `
        <div class="user-profile show" style="display:flex;align-items:center;gap:12px;">
          <div class="avatar">${initials}</div>
          <div>
            <div class="user-name">${user.name || 'User'}</div>
            <div class="user-role">${roleLabels[role] || role || 'Customer'}</div>
          </div>
          <button class="logout-btn" onclick="handleLogout()">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </div>
      `;
    } else {
      navButtons.innerHTML = `
        <button class="nav-btn nav-btn-outline" onclick="navigateTo('login')">
          <i class="fas fa-sign-in-alt"></i> Login
        </button>
        <button class="nav-btn nav-btn-primary" onclick="navigateTo('register')">
          <i class="fas fa-user-plus"></i> Register
        </button>
      `;
    }
  }

  // ================================================================
  // ===== FUNGSI NAVIGASI =====
  // ================================================================
  function navigateTo(page) {
    document.querySelectorAll('.page').forEach(function(p) {
      p.classList.remove('active');
    });
    var target = document.getElementById('page-' + page);
    if (target) target.classList.add('active');
    
    var navbar = document.getElementById('navbar');
    if (navbar) navbar.classList.remove('mobile-open');
    var navToggle = document.getElementById('navToggle');
    if (navToggle) navToggle.innerHTML = '<i class="fas fa-bars"></i>';
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function scrollToSection(sectionId) {
    var landingPage = document.getElementById('page-landing');
    var allPages = document.querySelectorAll('.page');
    
    if (!landingPage.classList.contains('active')) {
      allPages.forEach(function(p) {
        p.classList.remove('active');
      });
      landingPage.classList.add('active');
    }
    
    var navbar = document.getElementById('navbar');
    if (navbar) navbar.classList.remove('mobile-open');
    var navToggle = document.getElementById('navToggle');
    if (navToggle) navToggle.innerHTML = '<i class="fas fa-bars"></i>';
    
    var target = document.getElementById(sectionId);
    if (target) {
      setTimeout(function() {
        var offset = 90;
        var targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
        window.scrollTo({ top: targetPosition, behavior: 'smooth' });
      }, 100);
    }
  }

  // ================================================================
  // ===== TOGGLE PASSWORD =====
  // ================================================================
  function togglePass(id) {
    var input = document.getElementById(id);
    var btn = input.parentElement.querySelector('.toggle-pass');
    if (input.type === 'password') {
      input.type = 'text';
      btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
      input.type = 'password';
      btn.innerHTML = '<i class="fas fa-eye"></i>';
    }
  }

  // ================================================================
  // ===== SPLASH SCREEN =====
  // ================================================================
  (function() {
    var splash = document.getElementById('splash');
    var main = document.getElementById('main-content');
    setTimeout(function() {
      splash.classList.add('hide');
      setTimeout(function() {
        main.classList.add('visible');
        splash.style.display = 'none';
        updateNavbar();
        
        document.querySelectorAll('.pct').forEach(function(el) {
          var text = el.textContent;
          el.textContent = '0%';
          var target = parseInt(text);
          var current = 0;
          var step = target / 40;
          var interval = setInterval(function() {
            current += step;
            if (current >= target) {
              current = target;
              clearInterval(interval);
            }
            el.textContent = Math.round(current) + '%';
          }, 30);
        });
      }, 400);
    }, 2800);
  })();

  // ================================================================
  // ===== MOBILE NAV =====
  // ================================================================
  var navToggle = document.getElementById('navToggle');
  var navbar = document.getElementById('navbar');
  if (navToggle) {
    navToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      navbar.classList.toggle('mobile-open');
      this.innerHTML = navbar.classList.contains('mobile-open') ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    });
  }

  document.addEventListener('click', function(e) {
    if (navbar && navbar.classList.contains('mobile-open')) {
      if (!navbar.contains(e.target)) {
        navbar.classList.remove('mobile-open');
        if (navToggle) navToggle.innerHTML = '<i class="fas fa-bars"></i>';
      }
    }
  });

  // ================================================================
  // ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== =====
  // ================================================================
  // ===== AUTH HANDLERS (TERINTEGRASI DENGAN LARAVEL API) =====
  // ================================================================
  // ================================================================
  
  // ===== LOGIN =====
  async function handleLogin(e) {
    e.preventDefault();
    
    var email = document.getElementById('loginEmail').value.trim();
    var password = document.getElementById('loginPass').value;
    
    // Tampilkan loading
    const btn = document.querySelector('#page-login .auth-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    btn.disabled = true;
    
    try {
      const response = await fetch(`${API_URL}/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          email: email,
          password: password
        })
      });
      
      const data = await response.json();
      
      if (response.ok && data.success) {
        // Simpan data ke localStorage
        DB.setToken(data.token);
        DB.setUser(data.user);
        DB.setRole(data.role);
        
        updateNavbar();
        alert('✅ ' + data.message + ' Welcome ' + data.user.name + '!');
        navigateTo('landing');
      } else {
        alert('❌ Login failed: ' + (data.message || 'Invalid credentials'));
      }
    } catch (error) {
      alert('❌ Connection error: ' + error.message + '\n\nPastikan server Laravel berjalan di http://127.0.0.1:8000');
    } finally {
      btn.innerHTML = originalText;
      btn.disabled = false;
    }
  }

  // ===== REGISTER =====
  async function handleRegister(e) {
    e.preventDefault();
    
    var name = document.getElementById('regName').value.trim();
    var email = document.getElementById('regEmail').value.trim();
    var password = document.getElementById('registerPass').value;
    var confirm = document.getElementById('confirmPass').value;
    
    if (password !== confirm) {
      alert('❌ Passwords do not match!');
      return;
    }
    
    if (password.length < 8) {
      alert('❌ Password must be at least 8 characters!');
      return;
    }
    
    // Tampilkan loading
    const btn = document.querySelector('#page-register .auth-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    btn.disabled = true;
    
    try {
      const response = await fetch(`${API_URL}/register`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          name: name,
          email: email,
          password: password,
          password_confirmation: confirm,
          role: selectedRoleRegister
        })
      });
      
      const data = await response.json();
      
      if (response.ok && data.success) {
        alert('🎉 ' + data.message + ' Welcome ' + data.user.name + '!\nRole: ' + data.role);
        navigateTo('login');
      } else {
        // Tampilkan error detail
        let errorMsg = data.message || 'Registration failed';
        if (data.errors) {
          const errors = Object.values(data.errors).flat();
          errorMsg = errors.join('\n');
        }
        alert('❌ Registration failed:\n' + errorMsg);
      }
    } catch (error) {
      alert('❌ Connection error: ' + error.message + '\n\nPastikan server Laravel berjalan di http://127.0.0.1:8000');
    } finally {
      btn.innerHTML = originalText;
      btn.disabled = false;
    }
  }

  // ===== LOGOUT =====
  async function handleLogout() {
    if (!confirm('Are you sure you want to logout?')) return;
    
    const token = DB.getToken();
    
    if (token) {
      try {
        await fetch(`${API_URL}/logout`, {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
          }
        });
      } catch (error) {
        console.log('Logout API error:', error);
      }
    }
    
    DB.logout();
    updateNavbar();
    alert('👋 Logged out successfully!');
    navigateTo('landing');
  }

  // ================================================================
  // ===== SOCIAL LOGIN (Redirect ke Laravel) =====
  // ================================================================
  function signInWithGoogle() {
    window.location.href = `${API_URL}/auth/google/redirect`;
  }

  function signInWithFacebook() {
    window.location.href = `${API_URL}/auth/facebook/redirect`;
  }

  // ================================================================
  // ===== PARALLAX DASHBOARD =====
  // ================================================================
  document.addEventListener('mousemove', function(e) {
    var dash = document.querySelector('.dash-grid');
    if (!dash || window.innerWidth < 768) return;
    var x = (e.clientX / window.innerWidth - 0.5) * 6;
    var y = (e.clientY / window.innerHeight - 0.5) * -6;
    dash.style.transform = 'rotateY(' + x + 'deg) rotateX(' + y + 'deg)';
  });

  // ================================================================
  // ===== INTERSECTION OBSERVER =====
  // ================================================================
  var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.step, .stake-card, .ai-card, .esg-kpi, .market-card, .biz-card, .sdg-card, .milestone').forEach(function(el) {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
    observer.observe(el);
  });

  console.log('🔥 PANTAS App is ready!');
  console.log('📌 API URL:', API_URL);
  console.log('📌 Role-based login: Customer | Mitra HOREKA | Mitra Driver');
</script>

</body>
</html>