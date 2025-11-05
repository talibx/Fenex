<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Amazon')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="shortcut icon" href="{{ asset('public/photos/Fenex square.png') }}">
    <style>
        :root {
            --nav-bg: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            --nav-hover: rgba(255, 255, 255, 0.1);
            --accent-color: #0f9d58;
            --accent-glow: rgba(15, 157, 88, 0.3);
        }

        nav {
            background: var(--nav-bg) !important;
            border-bottom-right-radius: 12px;
            border-bottom-left-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            padding: 0.75rem 0;
        }

        .navbar-brand {
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand img {
            filter: drop-shadow(0 2px 8px rgba(255, 255, 255, 0.2));
        }

        .nav-item {
            position: relative;
            margin: 0 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .nav-link:hover {
            background: var(--nav-hover);
            color: #fff !important;
            transform: translateY(-2px);
        }

        .nav-link:hover i {
            transform: scale(1.2);
        }

        .nav-item.border-bottom {
            border-bottom: none !important;
        }

        .nav-item.active .nav-link {
            background: var(--accent-color);
            color: #fff !important;
            box-shadow: 0 4px 15px var(--accent-glow);
        }

        .nav-item.active .nav-link::before {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 40%;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        /* User Dropdown Button */
        .user-dropdown-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 0.5rem 1.25rem;
            color: #fff;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-dropdown-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .user-dropdown-btn i {
            font-size: 1rem;
        }

        /* Dropdown Menu Styling */
        .dropdown-menu {
            background: rgba(26, 26, 46, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.5rem;
            margin-top: 0.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }

        .dropdown-item {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.6rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 400;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            color: var(--accent-color);
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .dropdown-item.active {
            background: var(--accent-color);
            color: #fff;
        }

        .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 0;
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            .navbar-nav {
                padding: 1rem 0;
            }

            .nav-item {
                margin: 0.25rem 0;
            }

            .nav-link {
                padding: 0.75rem 1rem !important;
            }
        }

        /* Additional Styles */
        .active {
            color: var(--bs-dropdown-link-active-color);
            text-decoration: none;
            background-color: var(--bs-dropdown-link-active-bg);
        }

        .read-more-toggle {
            cursor: pointer;
            color: #0d6efd;
            font-size: 0.9em;
        }

        .read-more-toggle:hover {
            text-decoration: underline;
        }

        .text-success-row td {
            color: #198754 !important;
        }

        .text-danger-row td {
            color: #dc3545 !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('analytics') }}">
            <img src="{{ asset('public/photos/Fenex.png') }}" alt="Your Store Logo" height="40">
        </a>

        <!-- Toggler button for mobile [I have commment it cause i don't need it] -->
        {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> --}}

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                <li class="nav-item {{ request()->routeIs('analytics') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('analytics') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Analytics</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('products.index') }}">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('inventories.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('inventories.index') }}">
                        <i class="fas fa-warehouse"></i>
                        <span>Inventories</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('sales.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Sales</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('deductions.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('deductions.index') }}">
                        <i class="fas fa-calculator"></i>
                        <span>Deductions</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('transactions.index') }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Transactions</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('notes.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('notes.index') }}">
                        <i class="fas fa-sticky-note"></i>
                        <span>Notes</span>
                    </a>
                </li>
                
            </ul>
        </div>

        <!-- Authentication Links -->
        <div class="dropdown ms-2">
            <button class="btn user-dropdown-btn dropdown-toggle" type="button" id="authDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle"></i>
                <span>{{ Auth::user() ? Auth::user()->name : 'Guest' }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="authDropdown">
                @auth
                    <li><a class="dropdown-item {{ request()->routeIs('analytics') ? 'active' : '' }}" href="{{ route('analytics') }}">
                        <i class="fas fa-chart-line"></i> Analytics
                    </a></li>

                    <li><a class="dropdown-item {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="fas fa-box"></i> Products
                    </a></li>

                    <li><a class="dropdown-item {{ request()->routeIs('inventories.index') ? 'active' : '' }}" href="{{ route('inventories.index') }}">
                        <i class="fas fa-warehouse"></i> Inventories
                    </a></li>

                    <li><a class="dropdown-item {{ request()->routeIs('sales.index') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                        <i class="fas fa-shopping-cart"></i> Sales
                    </a></li>

                    <li><a class="dropdown-item {{ request()->routeIs('deductions.index') ? 'active' : '' }}" href="{{ route('deductions.index') }}">
                        <i class="fas fa-calculator"></i> Deductions
                    </a></li>

                    <li><a class="dropdown-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                        <i class="fas fa-exchange-alt"></i> Transactions
                    </a></li>

                    <li><a class="dropdown-item {{ request()->routeIs('notes.index') ? 'active' : '' }}" href="{{ route('notes.index') }}">
                        <i class="fas fa-sticky-note"></i> Notes
                    </a></li>

                    <li><hr class="dropdown-divider"></li>
                    
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-cog"></i> Profile
                    </a></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Log Out
                            </a>
                        </form>
                    </li>
                    
                @else
                    <li><a class="dropdown-item" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Log In
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i> Register
                    </a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<br><br>
@yield('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    /**
     * Global character limit for truncation
     * and layout configuration
     */
    const GLOBAL_READMORE_LIMIT = 80;
    const READMORE_BREAK_TYPE = 'br'; // 'space' or 'br'

    function toggleReadMore(link) {
        const target = link.previousElementSibling?.tagName === 'SPAN'
            ? link.previousElementSibling
            : link.closest('p, div, td')?.querySelector('span[data-fulltext]');
        if (!target) return;

        const fullText = target.dataset.fulltext;
        const limit = parseInt(target.dataset.limit) || GLOBAL_READMORE_LIMIT;

        if (!target.dataset.truncatedText) {
            target.dataset.truncatedText = fullText.substring(0, limit) + '...';
        }

        const isExpanded = link.dataset.expanded === "true";
        target.innerText = isExpanded ? target.dataset.truncatedText : fullText;
        link.innerText = isExpanded ? "Read More" : "Read Less";
        link.dataset.expanded = (!isExpanded).toString();
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('span[data-fulltext]').forEach(el => {
            const fullText = el.dataset.fulltext?.trim() || '';
            const limit = parseInt(el.dataset.limit) || GLOBAL_READMORE_LIMIT;

            if (fullText.length > limit) {
                el.dataset.truncatedText = fullText.substring(0, limit) + '...';
                el.innerText = el.dataset.truncatedText;

                // Create spacing element
                let spacer;
                if (READMORE_BREAK_TYPE === 'br') {
                    spacer = document.createElement('br');
                } else {
                    spacer = document.createTextNode(' '); // single space
                }

                // Create the Read More link
                const link = document.createElement('a');
                link.href = 'javascript:void(0);';
                link.className = 'read-more-toggle text-primary text-decoration-none';
                link.innerText = 'Read More';
                link.onclick = function() { toggleReadMore(this); };

                // Insert space + link after the span
                el.insertAdjacentElement('afterend', link);
                el.insertAdjacentElement('afterend', spacer);
            } else {
                el.innerText = fullText;
            }
        });

        // Year-Month filter dependency
        const yearFilter = document.getElementById('yearFilter');
        const monthFilter = document.getElementById('monthFilter');

        // Function to update month filter state
        function updateMonthFilterState() {
            const yearValue = yearFilter.value;
            
            if (!yearValue || yearValue === '') {
                // Disable month filter if year is not selected
                monthFilter.disabled = true;
                monthFilter.value = ''; // Reset month selection
                monthFilter.classList.add('text-muted');
            } else {
                // Enable month filter if year is selected
                monthFilter.disabled = false;
                monthFilter.classList.remove('text-muted');
            }
        }

        // Initialize on page load
        updateMonthFilterState();

        // Update when year changes
        yearFilter.addEventListener('change', function() {
            updateMonthFilterState();
        });
    });


</script>


</body>
</html>

