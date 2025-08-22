 @extends('frontend.layouts.main')
 @section('main-section')
     @push('title')
         <title> Durga Provision Store</title>
     @endpush


     <head>
         <meta name="csrf-token" content="{{ csrf_token() }}">
         @viteReactRefresh
         @vite('resources/js/app.jsx')
     </head>

     <style>
.main-category-item {
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 20px;
    transition: 0.3s;
}

.main-category-item.active {
    background-color: #ffcc80;
    font-weight: bold;
    color: #000;
}



     </style>

     <section class=" pt-0 overflow-hidden" style="height: 10vh;">

     </section>

     <section class="wow fadeInUp">
         <div class="container-fluid-lg">
             <div class="row">
                 <div class="col-12">
                     <div class="category-wrapper">
                         <button id="category-prev" class="category-nav">&#8592;</button>

                         <div class="main-category-slider" id="main-category-slider">
                             @foreach ($categories as $category)
                                 <div class="main-category-item {{ request('category_id') == $category->id ? 'active' : '' }} category-link"
                                     data-category-id="{{ $category->id }}" style="cursor: pointer;">
                                     {{ $category->name }}
                                 </div>
                             @endforeach

                         </div>

                         <button id="category-next" class="category-nav">&#8594;</button>
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <!-- Category Section End -->

     <!-- Shop Section Start -->
     <section class="section-b-space shop-section">
         <div class="container-fluid-lg">
             <div class="">
                 

       

                     <div id="app"></div>

                    
                 </div>
             </div>
         </div>
     </section>


     <style>
         .category-wrapper {
             display: flex;
             align-items: center;
             gap: 10px;
             position: relative;
             padding: 10px;
             max-width: 100%;
             overflow: hidden;
         }

         .main-category-slider {
             display: flex;
             overflow-x: auto;
             scroll-behavior: smooth;
             gap: 12px;
             scrollbar-width: none;
             flex: 1;
         }

         .main-category-slider::-webkit-scrollbar {
             display: none;
         }

         .main-category-item {
             padding: 8px 16px;
             border-radius: 20px;
             background-color: #f1f1f1;
             color: #333;
             font-size: 14px;
             white-space: nowrap;
             cursor: pointer;
             flex-shrink: 0;
             transition: background-color 0.3s ease;
         }

         .main-category-item:hover,
         .main-category-item.active {
             background-color: #ff5a5f;
             color: white;
         }

         .category-nav {
             background: #ff5a5f;
             color: white;
             border: none;
             border-radius: 50%;
             width: 32px;
             height: 32px;
             font-size: 18px;
             cursor: pointer;
         }

         .main-category-slider {
             padding: 0 20px;
         }
     </style>



     <script>
         document.addEventListener('DOMContentLoaded', function() {
             const slider = document.getElementById('main-category-slider');
             const prevBtn = document.getElementById('category-prev');
             const nextBtn = document.getElementById('category-next');

             prevBtn.addEventListener('click', () => {
                 slider.scrollBy({
                     left: -200,
                     behavior: 'smooth'
                 });
             });

             nextBtn.addEventListener('click', () => {
                 slider.scrollBy({
                     left: 200,
                     behavior: 'smooth'
                 });
             });

             // Scroll to active category on load
             const activeCategory = document.querySelector('.main-category-item.active');
             if (activeCategory) {
                 activeCategory.scrollIntoView({
                     behavior: 'smooth',
                     inline: 'center',
                     block: 'nearest',
                 });
             }
         });
     </script>

     <script>
         document.querySelectorAll('.qty-input').forEach(function(input) {
             input.addEventListener('change', function() {

                 const form = this.closest('form');



                 form.submit(); // Auto-submit form on input change
             });
         });
     </script>
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             function waitForReactReadyAndBind() {
                 if (typeof window.filterByCategory === 'function') {
                     document.querySelectorAll('.category-link').forEach(link => {
                         link.addEventListener('click', function() {
                             const categoryId = this.dataset.categoryId;
                             document.querySelectorAll('.category-link').forEach(el => el.classList
                                 .remove('active'));
                             this.classList.add('active');
                             window.filterByCategory(categoryId);
                         });
                     });
                 } else {
                     // Retry after short delay if React hasn't mounted yet
                     setTimeout(waitForReactReadyAndBind, 200);
                 }
             }

             waitForReactReadyAndBind();
         });
     </script>
 @endsection
