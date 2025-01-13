<footer class="footer mt-auto py-3 fixed-bottom mt-5 bg-dark">
    <div class="d-flex justify-content-center align-items-center">
        @if($version_first)
            <span class="text-light">
                Dashboard Akathospital Version : 
                <span type="button" class="" data-bs-toggle="modal" data-bs-target="#DetailUpdateVersionModal">
                    {{ $version_first->version_name }}
                </span>
            </span>
        @else
            <span class="text-light">
                ยังไม่มีการ Update Version
            </span>
        @endif
        
    </div>
</footer>
