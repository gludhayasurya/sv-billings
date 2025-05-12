<x-layouts.main :title="'Settings'" :contentHeader="'Manage Settings'">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 60vh;">
        <div class="row g-4">
            <!-- Materials Card -->
            <div class="col-md-6">
                <a href="{{ route('materials.index') }}" class="text-decoration-none">
                    <div class="card shadow h-100 animated-card text-center">
                        <div class="card-body">
                            <i class="fas fa-box fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Materials</h5>
                            <p class="card-text text-muted">Manage all building materials.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Workers Card -->
            <div class="col-md-6">
                <a href="{{ route('workers.index') }}" class="text-decoration-none">
                    <div class="card shadow h-100 animated-card text-center">
                        <div class="card-body">
                            <i class="fas fa-users-cog fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Workers</h5>
                            <p class="card-text text-muted">Manage workers and their teams.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @section('css')
    <style>
        .animated-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .animated-card:hover {
            transform: scale(1.05);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.2);
        }
    </style>
    @endsection

    @section('js')
    <script>
        console.log('Settings page loaded');
    </script>
    @endsection
</x-layouts.main>
