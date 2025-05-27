<?php
session_start();
include('includes/db.php');

// Check if shop is closed
$shutdown = $conn->query("SELECT value FROM settings WHERE name='shutdown'")->fetch_assoc()['value'];
if ($shutdown == 1) {
    header("Location: closed.php");
    exit;
}

// Get all products with their customizable options
$products = $conn->query("
    SELECT p.*, 
           GROUP_CONCAT(DISTINCT IF(co.option_name='Size', co.option_value, NULL) SEPARATOR ', ') as sizes,
           GROUP_CONCAT(DISTINCT IF(co.option_name='Flavor', co.option_value, NULL) SEPARATOR ', ') as flavors,
           GROUP_CONCAT(DISTINCT IF(co.option_name='Add-on', 
                          CONCAT(co.option_value, '(+₱', co.price, ')'), NULL) SEPARATOR ', ') as addons
    FROM products p
    LEFT JOIN customizable_options co ON p.id = co.product_id
    GROUP BY p.id
");

// Check ingredient availability for each product
$productAvailability = [];
while ($product = $products->fetch_assoc()) {
    $productId = $product['id'];
    
    // Check if product uses ingredients
    $stmt = $conn->prepare("
        SELECT i.id, i.name, i.quantity as available, pi.quantity as required 
        FROM product_ingredients pi
        JOIN ingredients i ON pi.ingredient_id = i.id
        WHERE pi.product_id = ?
    ");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Product uses ingredients - calculate availability based on dynamic QOH
        $canMake = PHP_INT_MAX;
        $limitingIngredient = '';
        
        while ($ingredient = $result->fetch_assoc()) {
            // Calculate dynamic QOH for this ingredient
            $qoh_stmt = $conn->prepare("
                SELECT 
                    GREATEST(0, COALESCE(SUM(restock_quantity), 0) - COALESCE(SUM(sales_quantity), 0)) as current_qoh
                FROM ingredient_movements 
                WHERE ingredient_id = ?
            ");
            $qoh_stmt->bind_param("i", $ingredient['id']);
            $qoh_stmt->execute();
            $qoh_result = $qoh_stmt->get_result();
            $qoh_row = $qoh_result->fetch_assoc();
            $current_qoh = $qoh_row['current_qoh'] ?? 0;
            $qoh_stmt->close();
            
            $possible = floor($current_qoh / $ingredient['required']);
            if ($possible < $canMake) {
                $canMake = $possible;
                $limitingIngredient = $ingredient['name'];
            }
        }
        
        $productAvailability[$productId] = [
            'can_make' => $canMake,
            'limiting_ingredient' => $limitingIngredient,
            'is_ingredient_based' => true
        ];
    } else {
        // Product uses direct stock
        $productAvailability[$productId] = [
            'can_make' => $product['stock'],
            'limiting_ingredient' => null,
            'is_ingredient_based' => false
        ];
    }
    
    $stmt->close();
}

$isLoggedIn = isset($_SESSION['user_id']);

// Get cart count for logged in users
$cartCount = 0;
if ($isLoggedIn) {
    $cartStmt = $conn->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
    $cartStmt->bind_param("i", $_SESSION['user_id']);
    $cartStmt->execute();
    $cartResult = $cartStmt->get_result();
    $cartRow = $cartResult->fetch_assoc();
    $cartCount = $cartRow['total'] ?? 0;
    $cartStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/FavLogo.jpg" alt="brand-logo">
    <title>Shop - AIZCAmble | Fresh Ice Scramble & Mini Donuts</title>
    
    <!-- Meta Tags -->
    <meta name="description" content="Shop fresh ice scramble and mini donuts at AIZCAmble. Customize your order with various sizes, flavors, and add-ons. Made fresh daily in Angat, Bulacan.">
    <meta name="keywords" content="ice scramble, mini donuts, AIZCAmble shop, Angat Bulacan, fresh desserts, customizable treats">
    <meta name="author" content="AIZCAmble Team">
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-pink: #EC4899;
            --primary-pink-dark: #DB2777;
            --primary-pink-light: #F472B6;
            --secondary-pink: #F9A8D4;
            --accent-purple: #8B5CF6;
            --accent-purple-light: #A78BFA;
            --accent-gold: #F59E0B;
            --accent-gold-light: #FCD34D;
            --background-gradient-start: #FDF2F8;
            --background-gradient-end: #FCE7F3;
            --background-deep-start: #831843;
            --background-deep-end: #BE185D;
            --surface-white: rgba(255, 255, 255, 0.95);
            --surface-glass: rgba(255, 255, 255, 0.1);
            --text-primary: #1F2937;
            --text-secondary: #6B7280;
            --text-light: #9CA3AF;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --error-color: #EF4444;
            --shadow-pink: rgba(236, 72, 153, 0.3);
            --shadow-strong: rgba(0, 0, 0, 0.25);
            --border-light: rgba(236, 72, 153, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--background-deep-start) 0%, var(--background-deep-end) 50%, var(--primary-pink-dark) 100%);
            color: var(--text-primary);
            overflow-x: hidden;
            position: relative;
            min-height: 100vh;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--primary-pink) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: backgroundMove 20s linear infinite;
            opacity: 0.1;
            z-index: -2;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, var(--primary-pink) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, var(--accent-purple) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, var(--secondary-pink) 0%, transparent 50%);
            opacity: 0.15;
            animation: gradientShift 15s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes backgroundMove {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(50px, 50px) rotate(360deg); }
        }

        @keyframes gradientShift {
            0%, 100% { opacity: 0.15; }
            50% { opacity: 0.25; }
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: var(--surface-white);
            backdrop-filter: blur(25px);
            border-bottom: 1px solid var(--border-light);
            box-shadow: 0 8px 32px var(--shadow-pink);
            z-index: 1000;
            padding: 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 12px 48px var(--shadow-pink);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 32px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
            color: var(--text-primary);
        }

        .nav-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid var(--primary-pink);
            object-fit: cover;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-logo::before {
            content: '';
            position: absolute;
            top: -6px;
            left: -6px;
            right: -6px;
            bottom: -6px;
            background: linear-gradient(45deg, var(--primary-pink), var(--accent-purple), var(--secondary-pink));
            border-radius: 50%;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .nav-brand:hover .nav-logo::before {
            opacity: 1;
        }

        .nav-brand:hover .nav-logo {
            transform: scale(1.1) rotate(5deg);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-name {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        .brand-tagline {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(236, 72, 153, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            color: var(--primary-pink);
            background: rgba(236, 72, 153, 0.1);
            transform: translateY(-2px);
        }

        .cart-badge {
            background: linear-gradient(135deg, var(--primary-pink), var(--primary-pink-dark));
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 700;
            min-width: 20px;
            text-align: center;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Mobile Menu Toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--primary-pink);
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            background: rgba(236, 72, 153, 0.1);
        }

        /* Hero Section */
        .hero-section {
            padding: 120px 32px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--surface-white);
            backdrop-filter: blur(20px);
            padding: 12px 20px;
            border-radius: 50px;
            border: 1px solid var(--border-light);
            box-shadow: 0 8px 32px var(--shadow-pink);
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            color: var(--primary-pink);
            animation: slideInDown 1s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hero-badge i {
            animation: sparkle 2s ease-in-out infinite;
        }

        @keyframes sparkle {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.2) rotate(180deg); }
        }

        .hero-title {
            font-size: 48px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 16px;
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple), var(--secondary-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: slideInUp 1s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hero-subtitle {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 32px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            animation: slideInUp 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.2s both;
        }

        @keyframes slideInDown {
            0% { opacity: 0; transform: translateY(-50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInUp {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Products Section */
        .products-section {
            padding: 40px 32px 80px;
            background: var(--surface-white);
            backdrop-filter: blur(20px);
            position: relative;
        }

        .products-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .section-title {
            font-size: 40px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .section-subtitle {
            font-size: 18px;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 32px;
        }

        .product-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 32px var(--shadow-pink);
            border: 1px solid var(--border-light);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            animation: slideInUp 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-pink), var(--accent-purple), var(--secondary-pink));
            background-size: 200% 100%;
            animation: gradientFlow 3s ease-in-out infinite;
        }

        @keyframes gradientFlow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .product-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 20px 60px var(--shadow-pink);
        }

        .product-card.disabled {
            opacity: 0.7;
            transform: none !important;
        }

        .product-card.disabled:hover {
            transform: none !important;
            box-shadow: 0 8px 32px var(--shadow-pink);
        }

        .product-image {
            height: 240px;
            overflow: hidden;
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-card.disabled .product-image img {
            filter: grayscale(50%);
            transform: none !important;
        }

        .stock-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            backdrop-filter: blur(10px);
        }

        .stock-badge.in-stock {
            background: rgba(16, 185, 129, 0.9);
            color: white;
        }

        .stock-badge.out-of-stock {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        .stock-badge.low-stock {
            background: rgba(245, 158, 11, 0.9);
            color: white;
        }

        .product-details {
            padding: 24px;
        }

        .product-name {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .product-price {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
        }

        .product-description {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .stock-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            font-size: 14px;
            font-weight: 600;
        }

        .stock-info.available {
            color: var(--success-color);
        }

        .stock-info.unavailable {
            color: var(--error-color);
        }

        .stock-info i {
            font-size: 16px;
        }

        .limiting-ingredient {
            font-size: 12px;
            color: var(--text-light);
            font-style: italic;
            margin-top: 4px;
        }

        /* Options Box */
        .options-box {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.05), rgba(139, 92, 246, 0.05));
            border: 1px solid var(--border-light);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .options-box h4 {
            color: var(--primary-pink);
            font-weight: 700;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .option-item {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .option-item:last-child {
            margin-bottom: 0;
        }

        .option-label {
            font-weight: 600;
            color: var(--text-primary);
            min-width: 60px;
        }

        .option-values {
            color: var(--text-secondary);
            line-height: 1.4;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 16px 24px;
            border-radius: 16px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            cursor: pointer;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-pink), var(--primary-pink-dark));
            color: white;
            box-shadow: 0 4px 15px var(--shadow-pink);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--shadow-pink);
        }

        .btn-customize {
            background: linear-gradient(135deg, var(--accent-purple), var(--accent-purple-light));
            color: white;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .btn-customize:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
        }

        .btn:disabled {
            background: linear-gradient(135deg, #9CA3AF, #6B7280);
            color: white;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        .btn:disabled::before {
            display: none;
        }

        /* Floating particles */
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-pink), var(--secondary-pink));
            animation: float 20s infinite linear;
            pointer-events: none;
            opacity: 0.6;
        }

        .floating-element.pink {
            background: linear-gradient(45deg, var(--secondary-pink), var(--primary-pink-light));
            animation: floatPink 25s infinite linear;
            opacity: 0.4;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
                transform: translateY(90vh) rotate(36deg) scale(1);
            }
            90% {
                opacity: 0.6;
                transform: translateY(-10vh) rotate(324deg) scale(1);
            }
            100% {
                transform: translateY(-100vh) rotate(360deg) scale(0);
                opacity: 0;
            }
        }

        @keyframes floatPink {
            0% {
                transform: translateY(100vh) rotate(0deg) scale(0);
                opacity: 0;
            }
            15% {
                opacity: 0.4;
                transform: translateY(85vh) rotate(54deg) scale(1);
            }
            85% {
                opacity: 0.4;
                transform: translateY(-15vh) rotate(306deg) scale(1);
            }
            100% {
                transform: translateY(-100vh) rotate(360deg) scale(0);
                opacity: 0;
            }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 24px;
            }
            
            .hero-title {
                font-size: 40px;
            }
        }

        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }
            
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--surface-white);
                backdrop-filter: blur(25px);
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 8px 32px var(--shadow-pink);
                border-top: 1px solid var(--border-light);
                gap: 8px;
            }
            
            .nav-links.open {
                display: flex;
            }
            
            .hero-title {
                font-size: 32px;
            }
            
            .hero-subtitle {
                font-size: 18px;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
            }
            
            .section-title {
                font-size: 32px;
            }
        }

        @media (max-width: 480px) {
            .nav-container {
                padding: 12px 20px;
            }
            
            .hero-section {
                padding: 100px 20px 30px;
            }
            
            .hero-title {
                font-size: 28px;
            }
            
            .products-section {
                padding: 30px 20px 60px;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(236, 72, 153, 0.1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-pink), var(--primary-pink-dark));
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-pink-dark), var(--primary-pink));
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            animation: fadeIn 0.6s ease forwards;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <!-- Floating Elements -->
    <div class="floating-element" style="left: 5%; width: 6px; height: 6px; animation-delay: 0s;"></div>
    <div class="floating-element pink" style="left: 15%; width: 4px; height: 4px; animation-delay: 3s;"></div>
    <div class="floating-element" style="left: 25%; width: 8px; height: 8px; animation-delay: 6s;"></div>
    <div class="floating-element pink" style="left: 35%; width: 5px; height: 5px; animation-delay: 9s;"></div>
    <div class="floating-element" style="left: 45%; width: 7px; height: 7px; animation-delay: 12s;"></div>
    <div class="floating-element pink" style="left: 55%; width: 4px; height: 4px; animation-delay: 15s;"></div>
    <div class="floating-element" style="left: 65%; width: 6px; height: 6px; animation-delay: 18s;"></div>
    <div class="floating-element pink" style="left: 75%; width: 5px; height: 5px; animation-delay: 21s;"></div>
    <div class="floating-element" style="left: 85%; width: 7px; height: 7px; animation-delay: 24s;"></div>
    <div class="floating-element pink" style="left: 95%; width: 4px; height: 4px; animation-delay: 27s;"></div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-brand">
                <img src="/assets/FavLogo.jpg" alt="AIZCAmble Logo" class="nav-logo">
                <div class="brand-text">
                    <div class="brand-name">AIZCAmble</div>
                    <div class="brand-tagline">Fresh Daily</div>
                </div>
            </a>
            
            <div class="nav-links" id="navLinks">
                <a href="index.php" class="nav-link">
                    <i class="fas fa-home"></i>
                    Home
                </a>
                <a href="About.php" class="nav-link">
                    <i class="fas fa-heart"></i>
                    About Us
                </a>
                <a href="Visit.php" class="nav-link">
                    <i class="fas fa-map-marker-alt"></i>
                    Visit Us
                </a>
                
                <?php if ($isLoggedIn): ?>
                    <a href="user/orders.php" class="nav-link">
                        <i class="fas fa-receipt"></i>
                        My Orders
                    </a>
                    <a href="user/cart.php" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        Cart
                        <?php if ($cartCount > 0): ?>
                            <span class="cart-badge"><?= $cartCount ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                <?php else: ?>
                    <a href="user/login.php" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                    <a href="user/register.php" class="nav-link">
                        <i class="fas fa-user-plus"></i>
                        Register
                    </a>
                <?php endif; ?>
            </div>
            
            <button class="mobile-toggle" id="mobileToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-badge">
                <i class="fas fa-ice-cream"></i>
                Fresh Made Daily
            </div>
            
            <h1 class="hero-title">AIZCAmble Shop</h1>
            <p class="hero-subtitle">
                Delicious ice scramble and mini donuts, made fresh with love in Angat, Bulacan
            </p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="products-container">
            <div class="section-header">
                <h2 class="section-title">Our Delicious Treats</h2>
                <p class="section-subtitle">
                    Choose from our selection of fresh ice scramble and mini donuts, 
                    each made with premium ingredients and customizable to your taste
                </p>
            </div>
            
            <div class="products-grid">
                <?php 
                // Reset products pointer
                $products->data_seek(0);
                $cardIndex = 0;
                while ($p = $products->fetch_assoc()): 
                    $productId = $p['id'];
                    $availability = $productAvailability[$productId];
                    $isAvailable = $availability['can_make'] > 0;
                    $isDisabled = !$isAvailable;
                    $isLowStock = $isAvailable && $availability['can_make'] <= 5;
                ?>
                    <div class="product-card <?= $isDisabled ? 'disabled' : '' ?> loading" style="animation-delay: <?= $cardIndex * 0.1 ?>s;">
                        <div class="product-image">
                            <?php if (!empty($p['image'])): ?>
                                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                            <?php else: ?>
                                <img src="/placeholder.svg?height=240&width=320&query=<?= urlencode($p['name'] . ' delicious treat') ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                            <?php endif; ?>
                            
                            <!-- Stock Badge -->
                            <?php if ($isAvailable): ?>
                                <?php if ($isLowStock): ?>
                                    <div class="stock-badge low-stock">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Low Stock
                                    </div>
                                <?php else: ?>
                                    <div class="stock-badge in-stock">
                                        <i class="fas fa-check"></i>
                                        Available
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="stock-badge out-of-stock">
                                    <i class="fas fa-times"></i>
                                    Out of Stock
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-details">
                            <h3 class="product-name"><?= htmlspecialchars($p['name']) ?></h3>
                            <div class="product-price">₱<?= number_format($p['price'], 2) ?></div>
                            
                            <?php if (!empty($p['description'])): ?>
                                <p class="product-description"><?= htmlspecialchars($p['description']) ?></p>
                            <?php endif; ?>
                            
                            <!-- Stock Information -->
                            <div class="stock-info <?= $isAvailable ? 'available' : 'unavailable' ?>">
                                <?php if ($isAvailable): ?>
                                    <i class="fas fa-check-circle"></i>
                                    <span>
                                        <?php if ($availability['is_ingredient_based']): ?>
                                            <?= $availability['can_make'] ?> available
                                        <?php else: ?>
                                            <?= $p['stock'] ?> in stock
                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    <i class="fas fa-times-circle"></i>
                                    <span>Currently unavailable</span>
                                    <?php if ($availability['limiting_ingredient']): ?>
                                        <div class="limiting-ingredient">
                                            Missing: <?= htmlspecialchars($availability['limiting_ingredient']) ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Customization Options -->
                            <?php if ($p['is_customizable'] == 1 && ($p['sizes'] || $p['flavors'] || $p['addons'])): ?>
                                <div class="options-box">
                                    <h4><i class="fas fa-palette"></i> Customization Options</h4>
                                    
                                    <?php if (!empty($p['sizes'])): ?>
                                        <div class="option-item">
                                            <span class="option-label">Sizes:</span>
                                            <span class="option-values"><?= htmlspecialchars($p['sizes']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($p['flavors'])): ?>
                                        <div class="option-item">
                                            <span class="option-label">Flavors:</span>
                                            <span class="option-values"><?= htmlspecialchars($p['flavors']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($p['addons'])): ?>
                                        <div class="option-item">
                                            <span class="option-label">Add-ons:</span>
                                            <span class="option-values"><?= htmlspecialchars($p['addons']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Action Buttons -->
                            <?php if ($isAvailable): ?>
                                <?php if ($p['is_customizable'] == 1): ?>
                                    <a href="user/customize.php?product_id=<?= $p['id'] ?>" class="btn btn-customize">
                                        <i class="fas fa-palette"></i>
                                        Customize & Add to Cart
                                    </a>
                                <?php else: ?>
                                    <form method="POST" action="user/add_to_cart.php" style="margin: 0;">
                                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-cart-plus"></i>
                                            Add to Cart
                                        </button>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <button class="btn" disabled>
                                    <i class="fas fa-ban"></i>
                                    Out of Stock
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php 
                    $cardIndex++;
                endwhile; 
                ?>
            </div>
        </div>
    </section>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const navLinks = document.getElementById('navLinks');

        mobileToggle.addEventListener('click', function() {
            navLinks.classList.toggle('open');
            const icon = this.querySelector('i');
            if (navLinks.classList.contains('open')) {
                icon.className = 'fas fa-times';
            } else {
                icon.className = 'fas fa-bars';
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!navLinks.contains(event.target) && !mobileToggle.contains(event.target)) {
                navLinks.classList.remove('open');
                mobileToggle.querySelector('i').className = 'fas fa-bars';
            }
        });

        // Parallax effect for floating elements
        document.addEventListener('mousemove', function(e) {
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;
            
            // Move floating elements based on mouse position
            document.querySelectorAll('.floating-element').forEach((element, index) => {
                const speed = (index % 3 + 1) * 0.5;
                const x = (mouseX - 0.5) * speed * 20;
                const y = (mouseY - 0.5) * speed * 20;
                element.style.transform = `translate(${x}px, ${y}px)`;
            });
        });

        // Product card hover effects
        document.querySelectorAll('.product-card:not(.disabled)').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-16px) scale(1.03)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(-12px) scale(1.02)';
            });
        });

        // Enhanced button interactions
        document.querySelectorAll('.btn:not(:disabled)').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Add ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.4);
                    transform: scale(0);
                    animation: rippleEffect 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes rippleEffect {
                0% {
                    transform: scale(0);
                    opacity: 1;
                }
                100% {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe product cards
        document.querySelectorAll('.product-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = `all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) ${index * 0.1}s`;
            observer.observe(card);
        });

        // Enhanced brand interaction
        document.querySelector('.nav-brand').addEventListener('mouseenter', function() {
            this.querySelector('.brand-name').style.transform = 'scale(1.05)';
            this.querySelector('.brand-tagline').style.color = 'var(--primary-pink)';
        });

        document.querySelector('.nav-brand').addEventListener('mouseleave', function() {
            this.querySelector('.brand-name').style.transform = 'scale(1)';
            this.querySelector('.brand-tagline').style.color = 'var(--text-light)';
        });

        // Smooth scrolling for anchor links
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

        // Loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            
            setTimeout(() => {
                document.body.style.opacity = '1';
                
                // Trigger loading animations for product cards
                document.querySelectorAll('.product-card.loading').forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.remove('loading');
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            }, 100);
        });

        // Dynamic background color shifts
        setInterval(() => {
            const hue = Math.random() * 30 + 320; // Pink to purple range
            document.documentElement.style.setProperty('--dynamic-bg', `hsl(${hue}, 70%, 15%)`);
        }, 5000);

        // Cart update animation
        document.querySelectorAll('form[action="user/add_to_cart.php"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button');
                const originalText = button.innerHTML;
                
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                button.disabled = true;
                
                // Re-enable after a short delay (you might want to handle this with actual response)
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-check"></i> Added!';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 1000);
                }, 500);
            });
        });

        // Stock status animations
        document.querySelectorAll('.stock-badge').forEach(badge => {
            if (badge.classList.contains('low-stock')) {
                badge.style.animation = 'pulse 2s infinite';
            }
        });

        // Enhanced product image loading
        document.querySelectorAll('.product-image img').forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '0';
                this.style.transition = 'opacity 0.3s ease';
                setTimeout(() => {
                    this.style.opacity = '1';
                }, 100);
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            // 'c' to focus on cart
            if (e.key === 'c' && !e.ctrlKey && !e.metaKey) {
                const activeElement = document.activeElement;
                if (activeElement.tagName !== 'INPUT' && activeElement.tagName !== 'TEXTAREA') {
                    const cartLink = document.querySelector('a[href="user/cart.php"]');
                    if (cartLink) {
                        e.preventDefault();
                        cartLink.focus();
                    }
                }
            }
        });
    </script>
</body>
</html>
