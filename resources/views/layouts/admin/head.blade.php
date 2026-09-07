<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
    rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
<!-- Font Awesome CDN -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
/>
  <style>
    :root {
      --nsn-primary: #FABC4D;
      --nsn-primary-ink: #7A5308;
      --nsn-secondary: #3B71B8;
      --nsn-secondary-deep: #274E85;
      --nsn-navy: #101B33;
      --nsn-navy-2: #16233F;
      --nsn-bg: #F3F6FB;
      --nsn-card: #FFFFFF;
      --nsn-ink: #1B2338;
      --nsn-muted: #6B7690;
      --nsn-border: #E5EAF2;
      --nsn-success: #2FBF71;
      --nsn-danger: #E5484D;
      --nsn-radius: 14px;
      --sidebar-w: 264px;
      --sidebar-w-collapsed: 82px;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', system-ui, sans-serif;
      background: var(--nsn-bg);
      color: var(--nsn-ink);
      overflow-x: hidden;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    .font-display {
      font-family: 'Space Grotesk', sans-serif;
      letter-spacing: -.01em;
    }

    .font-mono {
      font-family: 'JetBrains Mono', monospace;
    }

    /* ===== Scrollbar ===== */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-thumb {
      background: #c9d3e4;
      border-radius: 8px;
    }

    /* ===== Sidebar ===== */
    .nsn-sidebar {
      width: var(--sidebar-w);
      min-height: 100vh;
      background: linear-gradient(180deg, var(--nsn-navy) 0%, var(--nsn-navy-2) 100%);
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1030;
      transition: width .25s ease;
      display: flex;
      flex-direction: column;
      border-right: 1px solid rgba(255, 255, 255, .05);
    }

    body.collapsed .nsn-sidebar {
      width: var(--sidebar-w-collapsed);
    }

    body.collapsed .nsn-main {
      margin-left: var(--sidebar-w-collapsed);
    }

    body.collapsed .nsn-label,
    body.collapsed .nsn-brand-text,
    body.collapsed .nsn-sec-title {
      display: none;
    }

    body.collapsed .nsn-nav-link {
      justify-content: center;
    }

    .nsn-brand {
      padding: 1.35rem 1.25rem;
      display: flex;
      align-items: center;
      gap: .65rem;
      border-bottom: 1px solid rgba(255, 255, 255, .06);
    }

    .nsn-brand-mark {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: linear-gradient(135deg, var(--nsn-primary), var(--nsn-secondary));
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Space Grotesk';
      font-weight: 700;
      color: #12193000;
      color: #111;
      font-size: 1rem;
      flex: none;
    }

    .nsn-brand-text {
      color: #fff;
      line-height: 1.1;
    }

    .nsn-brand-text small {
      color: #8DA2CB;
      font-size: .72rem;
      letter-spacing: .06em;
      text-transform: uppercase;
    }

    .nsn-nav {
      padding: 1rem .75rem;
      flex: 1;
      overflow-y: auto;
    }

    .nsn-nav-section {
      margin-bottom: 1.1rem;
    }

    .nsn-sec-title {
      color: #5C709E;
      font-size: .68rem;
      text-transform: uppercase;
      letter-spacing: .09em;
      padding: .4rem .75rem;
      font-weight: 600;
    }

    .nsn-nav-link {
      display: flex;
      align-items: center;
      gap: .85rem;
      padding: .62rem .85rem;
      border-radius: 10px;
      color: #B8C4DE;
      text-decoration: none;
      font-size: .9rem;
      font-weight: 500;
      transition: background .15s ease, color .15s ease;
      position: relative;
    }

    .nsn-nav-link i {
      font-size: 1.05rem;
      width: 20px;
      text-align: center;
      flex: none;
    }

    .nsn-nav-link:hover {
      background: rgba(255, 255, 255, .06);
      color: #fff;
    }

    .nsn-nav-link.active {
      background: rgba(250, 188, 77, .12);
      color: var(--nsn-primary);
    }

    .nsn-nav-link.active::before {
      content: "";
      position: absolute;
      left: -.75rem;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 20px;
      border-radius: 0 4px 4px 0;
      background: var(--nsn-primary);
    }

    .nsn-nav-link .badge {
      margin-left: auto;
      font-weight: 600;
      font-size: .65rem;
    }

    .nsn-sidebar-foot {
      padding: 1rem;
      border-top: 1px solid rgba(255, 255, 255, .06);
    }

    .nsn-mini-status {
      display: flex;
      align-items: center;
      gap: .6rem;
      background: rgba(255, 255, 255, .04);
      border-radius: 10px;
      padding: .6rem .7rem;
      color: #AEBBD9;
      font-size: .78rem;
    }

    .nsn-dot-live {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--nsn-success);
      box-shadow: 0 0 0 3px rgba(47, 191, 113, .2);
      flex: none;
    }

    /* ===== Main ===== */
    .nsn-main {
      margin-left: var(--sidebar-w);
      transition: margin-left .25s ease;
      min-height: 100vh;
    }

    .nsn-topbar {
      position: sticky;
      top: 0;
      z-index: 1020;
      background: rgba(243, 246, 251, .85);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid var(--nsn-border);
      padding: .75rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .nsn-toggle-btn {
      border: 1px solid var(--nsn-border);
      background: #fff;
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--nsn-ink);
      flex: none;
    }

    .nsn-search {
      max-width: 380px;
    }

    .nsn-search .form-control {
      border-radius: 10px 0 0 10px;
      border-right: 0;
      background: #fff;
    }

    .nsn-search .input-group-text {
      background: #fff;
      border-left: 0;
      border-radius: 0 10px 10px 0;
      color: var(--nsn-muted);
    }

    .nsn-icon-btn {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      border: 1px solid var(--nsn-border);
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      color: var(--nsn-ink);
    }

    .nsn-icon-btn .ping {
      position: absolute;
      top: 6px;
      right: 6px;
      width: 8px;
      height: 8px;
      background: var(--nsn-danger);
      border-radius: 50%;
      border: 2px solid #fff;
    }

    .nsn-avatar {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: linear-gradient(135deg, var(--nsn-secondary), var(--nsn-secondary-deep));
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-family: 'Space Grotesk';
    }

    .nsn-content {
      padding: 1.75rem;
    }

    /* ===== Hero / signature network graphic ===== */
    .nsn-hero {
      border-radius: 20px;
      background: linear-gradient(120deg, var(--nsn-navy) 0%, var(--nsn-secondary-deep) 100%);
      color: #fff;
      padding: 1.9rem 2rem;
      position: relative;
      overflow: hidden;
      margin-bottom: 1.5rem;
    }

    .nsn-hero .eyebrow {
      color: var(--nsn-primary);
      font-size: .75rem;
      letter-spacing: .12em;
      text-transform: uppercase;
      font-weight: 600;
    }

    .nsn-hero h1 {
      font-size: 1.65rem;
      margin-bottom: .35rem;
    }

    .nsn-hero p {
      color: #C4CFE6;
      font-size: .9rem;
      max-width: 480px;
      margin-bottom: 0;
    }

    .nsn-hero-graph {
      position: absolute;
      right: 0;
      top: 0;
      height: 100%;
      width: 44%;
      opacity: .9;
    }

    @media (max-width:991px) {
      .nsn-hero-graph {
        display: none;
      }
    }

    .node-pulse {
      animation: nodePulse 2.6s ease-in-out infinite;
    }

    @keyframes nodePulse {

      0%,
      100% {
        opacity: .55;
      }

      50% {
        opacity: 1;
      }
    }

    /* ===== Stat cards ===== */
    .nsn-stat-card {
      border: 1px solid var(--nsn-border);
      border-radius: var(--nsn-radius);
      background: var(--nsn-card);
      padding: 1.15rem 1.25rem;
      height: 100%;
      transition: transform .15s ease, box-shadow .15s ease;
    }

    .nsn-stat-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 24px -12px rgba(20, 30, 60, .18);
    }

    .nsn-stat-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
    }

    .nsn-stat-value {
      font-family: 'Space Grotesk';
      font-size: 1.6rem;
      font-weight: 700;
    }

    .trend-up {
      color: var(--nsn-success);
    }

    .trend-down {
      color: var(--nsn-danger);
    }

    /* ===== Cards ===== */
    .nsn-card {
      border: 1px solid var(--nsn-border);
      border-radius: var(--nsn-radius);
      background: var(--nsn-card);
    }

    .nsn-card .card-header {
      background: transparent;
      border-bottom: 1px solid var(--nsn-border);
      padding: 1.05rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: between;
    }

    /* Table */
    .nsn-table thead th {
      font-size: .72rem;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: var(--nsn-muted);
      border-bottom: 1px solid var(--nsn-border);
      font-weight: 600;
      background: #FAFBFD;
    }

    .nsn-table td {
      vertical-align: middle;
      font-size: .87rem;
    }

    .file-icon {
      width: 34px;
      height: 34px;
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(59, 113, 184, .1);
      color: var(--nsn-secondary);
      flex: none;
    }

    .avatar-sm {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: var(--nsn-secondary);
      color: #fff;
      font-size: .68rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      border: 2px solid #fff;
      margin-left: -8px;
    }

    .avatar-sm:first-child {
      margin-left: 0;
    }

    /* Security panel */
    .sec-item {
      display: flex;
      align-items: center;
      gap: .85rem;
      padding: .75rem 0;
      border-bottom: 1px dashed var(--nsn-border);
    }

    .sec-item:last-child {
      border-bottom: 0;
    }

    .sec-icon {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex: none;
    }

    /* Accordion custom */
    .accordion-button {
      font-size: .87rem;
      font-weight: 600;
    }

    .accordion-button:not(.collapsed) {
      background: rgba(250, 188, 77, .1);
      color: var(--nsn-primary-ink);
      box-shadow: none;
    }

    .accordion-button:focus {
      box-shadow: none;
      border-color: var(--nsn-border);
    }

    /* progress */
    .progress {
      background: #EEF1F7;
      border-radius: 8px;
    }

    /* badges */
    .badge-soft-success {
      background: rgba(47, 191, 113, .12);
      color: #1E8F55;
    }

    .badge-soft-warning {
      background: rgba(250, 188, 77, .18);
      color: var(--nsn-primary-ink);
    }

    .badge-soft-info {
      background: rgba(59, 113, 184, .12);
      color: var(--nsn-secondary-deep);
    }

    .badge-soft-danger {
      background: rgba(229, 72, 77, .12);
      color: #B5292D;
    }

    .btn-nsn-primary {
      background: var(--nsn-primary);
      border-color: var(--nsn-primary);
      color: #3B2A05;
      font-weight: 600;
    }

    .btn-nsn-primary:hover {
      background: #E9A82F;
      border-color: #E9A82F;
      color: #2C1F03;
    }

    .btn-nsn-outline-secondary {
      border-color: var(--nsn-secondary);
      color: var(--nsn-secondary);
      font-weight: 600;
    }

    .btn-nsn-outline-secondary:hover {
      background: var(--nsn-secondary);
      color: #fff;
    }

    .quick-action {
      border: 1px solid var(--nsn-border);
      border-radius: 12px;
      padding: 1rem;
      text-align: left;
      background: #fff;
      transition: border-color .15s ease, box-shadow .15s ease;
      width: 100%;
    }

    .quick-action:hover {
      border-color: var(--nsn-secondary);
      box-shadow: 0 8px 18px -12px rgba(59, 113, 184, .35);
    }

    .quick-action i {
      font-size: 1.2rem;
    }

    @media (max-width:991.98px) {
      .nsn-sidebar {
        transform: translateX(-100%);
        width: var(--sidebar-w);
      }

      body.sidebar-mobile-open .nsn-sidebar {
        transform: translateX(0);
      }

      .nsn-main {
        margin-left: 0;
      }
    }
  </style>
</head>
