</div> <footer class="bg-dark text-white text-center py-4 mt-auto border-top border-warning border-4">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-md-6 text-md-start mb-3 mb-md-0">
                <h5 class="fw-bold text-uppercase mb-1 text-warning">LMS Project</h5>
                <p class="small text-white-50 mb-0">High quality online learning platform.</p>
            </div>

            <div class="col-md-6 text-md-end">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="#" class="text-white-50 text-decoration-none hover-white">Privacy Policy</a></li>
                    <li class="list-inline-item text-white-50">|</li>
                    <li class="list-inline-item"><a href="#" class="text-white-50 text-decoration-none hover-white">Terms of Service</a></li>
                    <li class="list-inline-item text-white-50">|</li>
                    <li class="list-inline-item"><a href="/LMS_Project/public/support/index" class="text-warning text-decoration-none fw-bold">Support</a></li>
                </ul>
                <p class="small text-white-50 mt-2 mb-0">&copy; <?= date('Y') ?> Developed by <strong>YourName</strong>. All Rights Reserved.</p>
            </div>
            
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Kích hoạt tất cả tooltip của Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

</body>
</html>