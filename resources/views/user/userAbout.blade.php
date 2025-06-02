
@extends('userLayouts.master-contact')

@section('title', 'Crunchy Sweets Shop')

@section('content')

    <div class="container py-5 mt-3" style="color: #5D4037;">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="display-4 mb-4">Our Sweet Story</h1>
                <p class="lead mb-4">Founded in 2010, Crunchy Sweets began as a small family-owned bakery with a passion for
                    creating delicious, handcrafted sweets.</p>

                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary-color p-3 rounded-circle me-4">
                        <i class="fas fa-heart text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Made with Love</h4>
                        <p class="mb-0">Every sweet is crafted with care using family recipes passed down through
                            generations.</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary-color p-3 rounded-circle me-4">
                        <i class="fas fa-leaf text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Quality Ingredients</h4>
                        <p class="mb-0">We source only the finest natural ingredients for all our products.</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="bg-primary-color p-3 rounded-circle me-4">
                        <i class="fas fa-award text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Award Winning</h4>
                        <p class="mb-0">Recognized as "Best Local Sweet Shop" for 5 consecutive years.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <img src="https://images.pexels.com/photos/1070945/pexels-photo-1070945.jpeg" alt="Our Bakery"
                    class="img-fluid rounded-lg shadow-lg" style="border: 5px solid var(--primary-color);">
            </div>
        </div>
    </div>
@endsection