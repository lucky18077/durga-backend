


</main>
       <script src="/backend/js/libs.min.js"></script>
       <!-- Plugin Scripts -->
       <!-- Tour plugin Start -->
       <script src="/backend/js/sheperd.min.js"></script>
       <script src="/backend/js/tour.js" defer=""></script>


       <!-- Flatpickr Script -->
       <script src="/backend/js/flatpickr.min.js"></script>
       <script src="/backend/js/flatpickr.js" defer=""></script>



       <!-- Select2 Script -->
       <script src="/backend/js/select2.js" defer=""></script>




       <!-- Slider-tab Script -->
       <script src="/backend/js/slider-tabs.js"></script>





       <!-- SwiperSlider Script -->
       <script src="/backend/js/swiper-bundle.min.js"></script>
       <script src="/backend/js/swiper-slider.js" defer=""></script>
       <!-- Lodash Utility -->
       <script src="/backend/js/lodash.min.js"></script>
       <!-- Utilities Functions -->
       <script src="/backend/js/utility.min.js"></script>
       <!-- Settings Script -->
       <script src="/backend/js/setting.min.js"></script>
       <!-- Settings Init Script -->
       <script src="/backend/js/setting-init.js"></script>
       <!-- External Library Bundle Script -->
       <script src="/backend/js/external.min.js"></script>
       <!-- Widgetchart Script -->
       <script src="/backend/js/widgetcharts.js" defer=""></script>
       <!-- Dashboard Script -->
       <script src="/backend/js/dashboard.js" defer=""></script>
       <!-- qompacui Script -->
       <script src="/backend/js/qompac-ui.js" defer=""></script>
       <script src="/backend/js/sidebar.js" defer=""></script>



   </body>

   </html>
 <style>
     #loader {
         display: none;
         /* Initially hidden */
         position: fixed;
         /* Stays in the same position while scrolling */
         top: 0;
         left: 0;
         width: 100vw;
         /* Full width */
         height: 100vh;
         /* Full height */
         display: flex;
         /* Flexbox to center */
         justify-content: center;
         /* Horizontal centering */
         align-items: center;
         /* Vertical centering */
         background-color: rgba(255, 255, 255, 0.7);
         /* Optional: translucent background */
         z-index: 9999;
         /* Ensure it appears on top of other elements */
     }
 </style>
 <!-- /Main Wrapper -->
 <div id="loader" style="display:none;">
     <img src="/logo/">
 </div>




 <script src="/dataTables/datatables.min.js"></script>




 <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
 <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist//backend/js/select2.min.js"></script>
 


 <style>
     .custom-tooltip {
         --bs-tooltip-bg: #4087d4;
         --bs-tooltip-color: var(--bs-white);
     }
 </style>
 <script>
     (() => {
         'use strict'

         // Fetch all the forms we want to apply custom Bootstrap validation styles to
         const forms = document.querySelectorAll('.needs-validation')

         // Loop over them and prevent submission
         Array.from(forms).forEach(form => {
             form.addEventListener('submit', event => {
                 if (!form.checkValidity()) {
                     event.preventDefault()
                     event.stopPropagation()
                 }

                 form.classList.add('was-validated')
             }, false)
         })
     })()
     $(".dataTable").DataTable({
         "responsive": true,
         "lengthChange": true,
         "autoWidth": false,
         "ordering": true,
         "buttons": ["excel", 'csv'],
         "pageLength": 10,
         "lengthMenu": [
             [10, 25, 50, -1],
             [10, 25, 50, "All"]
         ],
     }).buttons().container().appendTo('.col-md-6:eq()');


     $("#dataTable").DataTable({
         "responsive": true,
         "lengthChange": true,
         "autoWidth": false,
         "ordering": true,
         "buttons": ["excel", 'csv'],
         "pageLength": 10,
         "lengthMenu": [
             [10, 25, 50, -1],
             [10, 25, 50, "All"]
         ],
         "paging": false,
         "searching": false,
     }).buttons().container().appendTo('.col-md-6:eq()');



     $("#state").on("change", function() {
   
         $.ajax({
             url: "/GetCity",
             type: "POST",
             data: {
                 state: $(this).val(),
             },
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             beforeSend: function() {
                 $("#loader").show();
             },
             success: function(result) {
                 var html = "";
                 html += '<option value="">----Select city----</option>';
                 result.forEach(element => {

                     html += '<option value="' + element.city + '" >' + element.city +
                         '</option>';
                 });
                 $("#city").html(html)
             },
             complete: function() {
                 $("#loader").hide();
             },
             error: function(result) {
                 toastr.error(result.responseJSON.message);
             }
         });

     });

 </script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 <script>
     async function generatePDF() {
         const element = document.getElementById('printorder');
         const canvas = await html2canvas(element);
         const imgData = canvas.toDataURL('image/png');
         const {
             jsPDF
         } = window.jspdf;
         const pdf = new jsPDF();
         const imgProps = pdf.getImageProperties(imgData);
         const pdfWidth = pdf.internal.pageSize.getWidth();
         const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
         pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
         pdf.save('generated-po-list.pdf');
     }
 </script>

 <style>
     @media print {
         .noPrint {
             display: none;
             margin-top: 0px;
         }
     }

     body {
         margin-top: 10px;
         color: #484b51;
     }

     .text-secondary-d1 {
         color: #728299 !important;
     }

     .page-header {
         margin: 0 0 1rem;
         padding-bottom: 1rem;
         padding-top: .5rem;
         border-bottom: 1px dotted #e2e2e2;
         display: -ms-flexbox;
         display: flex;
         -ms-flex-pack: justify;
         justify-content: space-between;
         -ms-flex-align: center;
         align-items: center;
     }

     .page-title {
         padding: 0;
         margin: 0;
         font-size: 1.75rem;
         font-weight: 300;
     }

     .brc-default-l1 {
         border-color: #dce9f0 !important;
     }

     .ml-n1,
     .mx-n1 {
         margin-left: -.25rem !important;
     }

     .mr-n1,
     .mx-n1 {
         margin-right: -.25rem !important;
     }

     .mb-4,
     .my-4 {
         margin-bottom: 1.5rem !important;
     }

     hr {
         margin-top: 1rem;
         margin-bottom: 1rem;
         border: 0;
         border-top: 1px solid rgba(0, 0, 0, .1);
     }

     .text-grey-m2 {
         color: #888a8d !important;
     }

     .text-success-m2 {
         color: #86bd68 !important;
     }

     .font-bolder,
     .text-600 {
         font-weight: 600 !important;
     }

     .text-110 {
         font-size: 100% !important;
     }

     .text-blue {
         color: #478fcc !important;
     }

     .pb-25,
     .py-25 {
         padding-bottom: .75rem !important;
     }

     .pt-25,
     .py-25 {
         padding-top: .75rem !important;
     }

     .bgc-default-tp1 {
         background-color: rgba(121, 169, 197, .92) !important;
     }

     .bgc-default-l4,
     .bgc-h-default-l4:hover {
         background-color: #f3f8fa !important;
     }

     .page-header .page-tools {
         -ms-flex-item-align: end;
         align-self: flex-end;
     }

     .btn-light {
         color: #757984;
         background-color: #f5f6f9;
         border-color: #dddfe4;
     }

     .w-2 {
         width: 1rem;
     }

     .text-120 {
         font-size: 110% !important;
     }

     .text-primary-m1 {
         color: #4087d4 !important;
     }

     .text-danger-m1 {
         color: #dd4949 !important;
     }

     .text-blue-m2 {
         color: #68a3d5 !important;
     }

     .text-150 {
         font-size: 150% !important;
     }

     .text-60 {
         font-size: 60% !important;
     }

     .text-grey-m1 {
         color: #7b7d81 !important;
     }

     .align-bottom {
         vertical-align: bottom !important;
     }

     #itemlist td {
         padding: 6px 15px;
     }
 </style>
 <script>
     function printcontent() {
         $(".buttons").hide()
         var printContents = document.getElementById('PrintOrder').innerHTML;
         var originalContents = document.body.innerHTML;

         document.body.innerHTML = printContents;

         window.print();

         document.body.innerHTML = originalContents;
     }
 </script>



<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<script>
    

toastr.options = {
         "closeButton": true,
         "debug": false,
         "newestOnTop": false,
         "progressBar": true,
         "positionClass": "toast-top-right",
         "preventDuplicates": false,
         "onclick": null,
         "showDuration": "300",
         "hideDuration": "1000",
         "timeOut": "5000",
         "extendedTimeOut": "1000",
         "showEasing": "swing",
         "hideEasing": "linear",
         "showMethod": "fadeIn",
         "hideMethod": "fadeOut"
     }
  
    
 
     @if (Session::has('error'))
         toastr.error('{{ Session::get('error') }}');
     @elseif (Session::has('success'))
         toastr.success('{{ Session::get('success') }}');
     @elseif (Session::has('warning'))
         toastr.warning('{{ Session::get('warning') }}');
     @endif
</script>