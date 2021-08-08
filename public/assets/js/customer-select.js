
$(document).ready(function() {

    // // Select2
    // const select2Component = document.getElementsByClassName("select2-component");
    // $(select2Component).select2();

     // Tampilkan kota saat provinsi dipilih
     $('.select-provinsi').on('change', function () { 
        var token = $('meta[name="csrf-token"]').attr('content');
        const id_provinsi = jQuery(this).val();

            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: '/petani/data-kota',
                data: {id : id_provinsi},
                dataType: 'json',
                success: function(data){
                    $('.select-kota').empty();
                    $.each(data, function (key, name) {
                        $('.select-kota').append(new Option(name, key));
                    });
                }
            });
    });

       // Tampilkan kecamatan saat kota dipilih
       $('.select-kota').on('change', function () { 
        var token = $('meta[name="csrf-token"]').attr('content');
        const id_kota = jQuery(this).val();

            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: '/petani/data-kecamatan',
                data: {id : id_kota},
                dataType: 'json',
                success: function(data){
                    $('.select-kecamatan').empty();
                    $.each(data, function (key, name) {
                        $('.select-kecamatan').append(new Option(name, key));
                    });
                }
            });
    });

     // Tampilkan kelurahan saat kecamatan dipilih
     $('.select-kecamatan').on('change', function () { 
        var token = $('meta[name="csrf-token"]').attr('content');
        const id_kecamatan = jQuery(this).val();

            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: '/petani/data-kelurahan',
                data: {id : id_kecamatan},
                dataType: 'json',
                success: function(data){
                    $('.select-kelurahan').empty();
                    $.each(data, function (key, name) {
                        $('.select-kelurahan').append(new Option(name, key));
                    });
                }
            });
    });

});