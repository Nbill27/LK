<footer class="footer py-3">
    <div class="container-fluid text-center">
        <span class="footer-text">© 2025 Sistem LK. All Rights Reserved.</span>
        <div class="mt-2">
            <a href="#" class="footer-link mx-2">Privacy Policy</a> | 
            <a href="#" class="footer-link mx-2">Terms of Service</a> | 
            <a href="#" class="footer-link mx-2">Contact Us</a>
        </div>
    </div>
</footer>

<style>
    .footer {
        width: 100%;
        background-color: #ffffff;
        color: #28A745;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: margin-left 0.3s ease;
    }

    body:not(.sidebar-collapsed) .footer {
        margin-left: 250px;
    }

    body.sidebar-collapsed .footer {
        margin-left: 60px;
    }

    .footer .footer-text {
        color: #28A745;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .footer .footer-link {
        color: #4CAF50 !important;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s;
    }

    .footer .footer-link:hover {
        color: #2E7D32 !important;
    }

    @media (max-width: 767px) {
        body:not(.sidebar-collapsed) .footer,
        body.sidebar-collapsed .footer {
            margin-left: 0 !important;
        }
        .footer .footer-link {
            font-size: 0.85rem;
        }
    }
</style>